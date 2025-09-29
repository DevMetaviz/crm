<?php

namespace App\Http\Controllers;

use App\Models\issuance_return;
use Illuminate\Http\Request;
use App\Models\Issuance;
use App\Models\Employee;
use App\Models\Ticket;
use App\Models\InventoryDepartment;
use App\Models\Department;
use App\Models\inventory;
use App\Models\issue_return;
use App\Models\Stock;
use App\Models\Transection;
use App\Models\issue_return_item;
use PDF;

class IssuanceReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $returns=issue_return::orderBy('created_at','desc')->get();
         return view('issue.returns',compact('returns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($issue_id='')
    {
         $doc_no="IR-".Date("y")."-";
        $num=1;

         $std=issue_return::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->first();
         if($std=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $std['doc_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

      
    
        $locations=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();

        

        if($issue_id!='')
        {
            $issue=Issuance::find($issue_id);
            $department_id=$issue['department_id'];
            $inventories=inventory::where('department_id',$department_id)->get();
        }

        $employees=Employee::with('designation')->where('activeness','active')->orderBy('name','asc')->get();
        $departments=Department::where('activeness','1')->orderBy('sort_order')->get();

           //$batches=Ticket::where('batch_close','0')->pluck('batch_no');

          if($issue_id=='')
        return view('issue.return',compact('employees','departments','locations','doc_no'));
         
         $issued_items=array();
             
             foreach ($issue['items'] as $item) {
                 
                // print_r(json_encode($item));die;
                 $issued_id=$item['pivot']['id'];
                 $stage_id=$item['pivot']['stage_id'];
               if($stage_id=='' || $stage_id==-1)
                { $stage_text=''; $stage_id=-1; }
                else
               $stage_text=Process::find($stage_id)->process_name;

                $grn_no=$item['pivot']['grn_no'];
                 $batch_no=$item['pivot']['batch_no']; 
                 $unit=$item['pivot']['unit'];
                 $issue_qty=$item['pivot']['quantity']; 
                 $return_qty=$item['pivot']['quantity'];
                  $pack_size=$item['pivot']['pack_size'];

                   $t=$pack_size * $return_qty;
                     
                    

                 $uom='';
                 if($item['unit']!='')
                    $uom=$item['unit']['name'];
                   
                   
                     $it=['item_id'=>$item['id'],'item_name'=>$item['item_name'],'item_code'=>$item['item_code'],'uom'=>$uom,'issued_id'=>$issued_id,'stage_text'=>$stage_text,'stage_id'=>$stage_id,'grn_no'=>$grn_no,'batch_no'=>$batch_no,'issue_qty'=>$issue_qty,'return_qty'=>$return_qty,'pack_size'=>$pack_size,'unit'=>$unit];
                    
                     array_push($issued_items, $it);  
                   
                 

                 
             }


       return view('issue.return',compact('issue','departments','employees','locations','inventories','department_id','doc_no','issued_items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chln=issue_return::where('doc_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->with('error','Doc no. already existed!');
           
          $items_id=$request->items_id;
        //$item_stages_id=$request->item_stage_ids;
       $units=$request->units;
       //$req_qtys=$request->req_qtys;

        $grn_nos=$request->grn_nos;
         //$qcs=$request->qc;
        //$batch_nos=$request->batch_nos;

        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;
         $stages=$request->stages;
          $issue_ids=$request->issue_ids;

            $issued=$request->returned;
            if($issued=='')
                $issued='0';

           $req=new issue_return;
           $req->doc_no=$request->get('doc_no');
           $req->doc_date=$request->get('doc_date');
           $req->department_id=$request->get('department_id');
           $req->plan_id=$request->get('plan_id');
          // $req->product_id=$request->get('product_id');
           $req->issuance_id=$request->get('issuance_id');
           //$req->batch_no=$request->get('batch_no');
           $req->remarks=$request->get('remarks');

           // $req->issued_by=$request->get('issued_by');
           // $req->received_by=$request->get('received_by');
           // $req->receiving_department=$request->get('receiving_department');

           $req->returned=$issued;
           //$req->status='close';
           //$req->plan_no=$request->get('plan_no');
           //$req->ticket_no=$request->get('ticket_no');
           $req->remarks=$request->get('remarks');

           $req->save();

           for($i=0;$i<count($items_id);$i++)
            {
         $req->items()->attach($items_id[$i] , ['issue_item_id' => $issue_ids[$i],'stage_id' => $stages[$i],'grn_no' => $grn_nos[$i],'unit' => $units[$i] , 'qty' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i]  ]);
           }

           //$requisition=Requisition::where('requisition_no','like',$req->requisition_no)->first();
           //$requisition->status='close';
           //$requisition->issued='1';

            //$requisition->save();
          //return redirect()->back()->with('success','Issuance saved!');
           foreach ($req->item_list as $item) {
           
           
          $rate=0;
               if($item['stock']!='' )
                { 
                  $s=Stock::find($item['stock']['id']);
                  if($s!='')
                    $rate=$s['rate'];
                 } 
               $qty=$item['pack_size'] * $item['qty'];
                $amount=$rate * $qty;
                
                $remarks=$item['item']['item_name'].' ('.$rate.'*'.$qty.')';

          $depart=InventoryDepartment::find($item['item']['department_id'])->account_id;
           
           $trans=new Transection;
           $trans->account_voucherable_id=$req->id;
           $trans->account_voucherable_type='App\Models\issue_return';
           $trans->account_id=$depart;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();

           $depart=InventoryDepartment::find($item['item']['department_id'])->cgs_account_id;
           
           $trans=new Transection;
           $trans->account_voucherable_id=$req->id;
           $trans->account_voucherable_type='App\Models\issue_return';
           $trans->account_id=$depart;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;
           $trans->save();


           }
             return redirect()->to('edit/issuance-return/'.$req->id)->with('success','Issuance Return saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\issuance_return  $issuance_return
     * @return \Illuminate\Http\Response
     */
    public function show(issuance_return $issuance_return)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\issuance_return  $issuance_return
     * @return \Illuminate\Http\Response
     */
    public function edit(issue_return $return)
    {
         $locations=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        
          $inventories=inventory::where('department_id',$return['department_id'])->get();
       

        $employees=Employee::with('designation')->where('activeness','active')->orderBy('name','asc')->get();
        $departments=Department::where('activeness','1')->orderBy('sort_order')->get();

        return view('issue.edit_return',compact('departments','employees','locations','inventories','return'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\issuance_return  $issuance_return
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $items_id=$request->items_id;
        //$item_stages_id=$request->item_stage_ids;
       $units=$request->units;
       $pivots_id=$request->pivot_ids;
       $grn_nos=$request->grn_nos;
        $issue_ids=$request->issue_ids;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;
            
            $issued=$request->returned;
            if($issued=='')
                $issued='0';

           $req=issue_return::find($request->return_id);
           $req->doc_no=$request->get('doc_no');
           $req->doc_date=$request->get('doc_date');
           $req->department_id=$request->get('department_id');
           $req->issuance_id=$request->get('issuance_id');
           $req->plan_id=$request->get('plan_id');
           //$req->batch_no=$request->get('batch_no');
           //$req->issued_by=$request->get('issued_by');
           //$req->received_by=$request->get('received_by');
           //$req->receiving_department=$request->get('receiving_department');

           $req->returned=$issued;
           //$req->status='close';
           $req->remarks=$request->get('remarks');

           $req->save();

          $items=issue_return_item::where('issue_return_id',$req['id'])->whereNotIn('id',$pivots_id)->get();

        foreach ($items as $tr) {
                $tr->delete();
        }

           for ($i=0;$i<count($items_id);$i++)
           {
                 if($pivots_id[$i]!=0)
                 $item=issue_return_item::find($pivots_id[$i]);
                  else
                  $item=new issue_return_item;

                $item->issue_return_id=$req['id'];
                $item->item_id=$items_id[$i];
                $item->grn_no=$grn_nos[$i];
                $item->issue_item_id=$issue_ids[$i];
                $item->unit=$units[$i];
                $item->qty=$qtys[$i];
                $item->pack_size=$pack_sizes[$i];
                
                  $item->save();
           }

          $transections=$req->transections;
            $no=0;

             foreach ($req->item_list as $item) {
               $rate=0;
               if($item['stock']!='')
              {
              $s=Stock::find($item['stock']['id']);

             if($s!='')
                    $rate=$s['rate'];
              } 
               $qty=$item['pack_size'] * $item['qty'];
                $amount=$rate * $qty;
                
                $remarks=$item['item']['item_name'].' ('.$rate.'*'.$qty.')';

                $depart=InventoryDepartment::find($item['item']['department_id'])->account_id;
            
            if($no < count($transections))
          {  $trans=$transections[$no];  }
          else
           $trans=new Transection;
          
           $trans->account_voucherable_id=$req->id;
           $trans->account_voucherable_type='App\Models\issue_return';
           $trans->account_id=$depart;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();
             $no++;

             $depart=InventoryDepartment::find($item['item']['department_id'])->cgs_account_id;
            
            if($no < count($transections))
          {  $trans=$transections[$no];  }
          else
           $trans=new Transection;
          
           $trans->account_voucherable_id=$req->id;
           $trans->account_voucherable_type='App\Models\issue_return';
           $trans->account_id=$depart;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;
            $trans->save();
             $no++;
           }

           for($i=$no; $i < count($transections); $i++ )
           {
               $transections[$i]->delete();
           }



           //$requisition=Requisition::where('requisition_no','like',$req->requisition_no)->first();
           //$requisition->status='close';
           //$requisition->issued='1';
            //$requisition->save();

           return redirect()->back()->with('success','Issuance Return updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\issuance_return  $issuance_return
     * @return \Illuminate\Http\Response
     */
    public function destroy(issue_return $return)
    {
        $return->items()->detach();


            foreach($return->transections as $trans )
           {
               $trans->delete();
           }


         $return->delete();

        return redirect(url('issuance-return'))->with('success','Issuance Return Deleted!');
    }

    public function print(issue_return $return)//for all genral request
    {
        
     $data = [
            
            'return'=>$return,
                
        ];
                
           view()->share('issue.return_report',$data);
        $pdf = PDF::loadView('issue.return_report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($return['doc_no'].'.pdf');
    }
}
