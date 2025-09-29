<?php

namespace App\Http\Controllers;

use App\Models\Compression;
use App\Models\Blistering;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\Productionplan;
use App\Models\container;
use PDF;

class BlisteringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $granules=Blistering::orderBy('created_at','desc')->get();

        return view('production.blistering.index',compact('granules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $plns=Productionplan::where('demand_id','<>','0')->doesntHave('blistering')->get();

             $plans=[];
            foreach ($plns as $pn) {


              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'pack_size'=>$pn['product']['pack_size']];

              array_push($plans, $plan);
            }
        
        return view('production.blistering.create',compact('plans'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $yield=new Blistering;
         $yield->plan_id=$request->plan_id;
         $yield->start_date=$request->start_date;
         $yield->comp_date=$request->comp_date;
         $yield->lead_time=$request->lead_time;
         $yield->temprature=$request->temprature;
         $yield->humidity=$request->humidity;
         $yield->empty_result=$request->empty_result;
         $yield->filled_result=$request->filled_result;
         $yield->machine=$request->machine;
         $yield->machine_id=$request->machine_id;
          $yield->embossing_date=$request->embossing_date;
          $yield->embossing_operator=$request->embossing_operator;

          $yield->embossing_stamp=$request->embossing_stamp;
         $yield->packaging_supervisor=$request->packaging_supervisor;
          $yield->qa_inspector=$request->qa_inspector;
          
           
        $yield->save();

        $no=$request->no;
        $gross=$request->gross;
        $net=$request->net;
        $tare=$request->tare;
        $performed_by=$request->performed_by;


        for ($i=0; $i < count($gross) ; $i++) { 
             $dt=new container;
          $dt->containerable_id=$yield->id;
        $dt->containerable_type='App\Models\Blistering';
         $dt->no=$no[$i];
         $dt->gross=$gross[$i];
         $dt->tare=$tare[$i];
         $dt->net=$net[$i];
         $dt->performed_by=$performed_by[$i];
        $dt->save();
        }
    return redirect(url('/edit/blistering/'.$yield['id']))->with('success','Blistering genrated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compression  $compression
     * @return \Illuminate\Http\Response
     */
    public function show(Compression $compression)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compression  $compression
     * @return \Illuminate\Http\Response
     */
    public function edit(Blistering $blistering)
    {
        $plns=Productionplan::where('demand_id','<>','0')->doesntHave('blistering')->orWhere('id',$blistering['plan_id'])->get();

             $plans=[];
            foreach ($plns as $pn) {


              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'pack_size'=>$pn['product']['pack_size']];

              array_push($plans, $plan);
            }
        
        return view('production.blistering.edit',compact('plans','blistering'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compression  $compression
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $yield= Blistering::find($request->id);

         $yield->plan_id=$request->plan_id;
         $yield->start_date=$request->start_date;
         $yield->comp_date=$request->comp_date;
         $yield->lead_time=$request->lead_time;
         $yield->temprature=$request->temprature;
         $yield->humidity=$request->humidity;
         $yield->empty_result=$request->empty_result;
         $yield->filled_result=$request->filled_result;
         $yield->machine=$request->machine;
         $yield->machine_id=$request->machine_id;
          $yield->embossing_date=$request->embossing_date;
          $yield->embossing_operator=$request->embossing_operator;

          $yield->embossing_stamp=$request->embossing_stamp;
         $yield->packaging_supervisor=$request->packaging_supervisor;
          $yield->qa_inspector=$request->qa_inspector;
         
        $yield->save();

        $no=$request->no;
        $gross=$request->gross;
        $net=$request->net;
        $tare=$request->tare;
        $performed_by=$request->performed_by;


        $items=$yield->containers;
       $num=0;

        for ($i=0; $i < count($gross) ; $i++) { 

             if($num < count($items))
          $dt=$items[$num];
          else
             $dt=new container;
             
          $dt->containerable_id=$yield->id;
        $dt->containerable_type='App\Models\Blistering';
         $dt->no=$no[$i];
         $dt->gross=$gross[$i];
         $dt->tare=$tare[$i];
         $dt->net=$net[$i];
         $dt->performed_by=$performed_by[$i];
        $dt->save();
        $num++;
        }

        for($i=$num; $i < count($items); $i++ )
           {
               $items[$i]->delete();
           }

    return redirect()->back()->with('success','Blistering updated!');
    }

    public function print(Blistering $blistering)
    {
          $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $data = [
            
            'plan'=>$blistering['plan'],
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.challan_pdf',compact('data'));
           view()->share('production.blistering.report',$data);
        $pdf = PDF::loadView('production.blistering.report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($blistering['id'].'.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compression  $compression
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compression $compression)
    {
        //
    }
}
