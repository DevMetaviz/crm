<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sampling;
use App\Models\Stock;
use App\Models\InventoryDepartment;
use PDF;


class samplingController extends Controller
{

    public function create()
    {

        $doc_no="SM-".Date("y")."-";
        $num=1;

         $qc=sampling::select('id','sampling_no')->where('sampling_no','like',$doc_no.'%')->latest()->first();
         if($qc=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $qc['sampling_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
            $doc_no=$doc_no . $let;
         }

            
            //$departments=sampling::departments_with_items_with_qty();

            $departments=InventoryDepartment::departments_with_items();

          return view('qc.sampling.create',compact('doc_no','departments'));

      }

       public function store(Request $request)
    {
                 $chln=sampling::where('sampling_no',$request->sampling_no)->first();
            if($chln!='')
             return redirect()->back()->withErrors(['error'=>'Doc No. already existed!']);

                 $verified=0;
                 if($request->verified!='')
                    $verified=$request->verified;

                $qc_req=new sampling;
                $qc_req->sampling_no=$request->sampling_no;
               
               //$qc_req->samplable_id=$request->stock_id;
               //$qc_req->samplable_type='App\Models\Stock';
               $qc_req->intimation_date=$request->intimation_date;
               $qc_req->intimation_time=$request->intimation_time;
               $qc_req->type=$request->type;
               
                //$qc_req->item_id=$request->item_id;
                 $qc_req->grn_no=$request->grn_no;

                  //$qc_req->plan_id=$request->plan_batch_no;
                   //$qc_req->process=$request->plan_process;

               $qc_req->total_qty=$request->total_qty;
               $qc_req->sample_qty=$request->sample_qty;

               $qc_req->is_received=0;
               
               $qc_req->remarks=$request->remarks;
               $qc_req->verified=$verified;
               $qc_req->save();

        return redirect('/sampling/'.$qc_req->id)->with('success','QA sampling saved!');
    }

    public function edit($sampling_id)
    {
        $request=sampling::find($sampling_id);

        $departments=InventoryDepartment::departments_with_items();

        $stock=Stock::getStock($request['stock']['id']);

        return view('qc.sampling.edit',compact('departments','request','stock'));
    }

}