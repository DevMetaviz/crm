<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\inventory;
use App\Models\InventoryDepartment;
use App\Models\Ticket;
use App\Models\ProductionStandard;
use App\Models\Productionplan;
use App\Models\Process;
use App\Models\Issuance;
use App\Models\Stock;
use App\Models\Department;
use App\Models\Transection;
use App\Models\item_issuance;
use App\Models\requisition_item;
use App\Models\Employee;
use PDF;

class RequisitionController extends Controller
{
    public function request_material($ticket_no)
    {
        

        $doc_no="REQ-".Date("y")."-";
        $num=1;

         $std=Requisition::select('id','requisition_no')->where('requisition_no','like',$doc_no.'%')->latest()->first();
         if($std=='')
         {
              $let=sprintf('%05d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $std['requisition_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%05d', $num);
              $doc_no=$doc_no. $let;
         }

    $ticket=Ticket::where('ticket_no','like',$ticket_no)->first();
    $plan_no=$ticket->plan->plan_no;
    $items=$ticket->estimated_material;
    //start estimated material
            $request_material=array();
           
            foreach ($items as $key) {

                 $location_id=$key['department']['id'];
            $location_text=$key['department']['name'];
            $item_id=$key['id'];
            $item_text=$key['item_name'];
            $item_code=$key['item_code'];
            
            $item_uom='';
            if($key['unit']!='')
                $item_uom=$key['unit']['name'];
            $item_color='';
            if($key['color']!='')
                $item_color=$key['color']['name'];
            $item_size='';
            if($key['size']!='')
                $item_size=$key['size']['name'];
            $item_type='';
            if($key['type']!='')
                $item_type=$key['type']['name'];
            $item_category='';
            if($key['category']!='')
                $item_category=$key['category']['name'];

                
                $unit=$key['pivot']['unit'];
                $pack_size=$key['pivot']['pack_size'];
                $qty=$key['pivot']['quantity'];
                $total_qty=$qty * $pack_size;

               $stage_id=$key['pivot']['stage_id'];
               if($stage_id==-1)
                $stage_text='';
                else
               $stage_text=Process::find($stage_id)->process_name;


                $item=array('location_id'=>$location_id,'location_text'=>$location_text,'item_id'=>$item_id,'item_name'=>$item_text,'item_code'=>$item_code,'type'=>$item_type,'category'=>$item_category,'uom'=>$item_uom,'color'=>$item_color,'size'=>$item_size,'stage_id'=>$stage_id,'stage_text'=>$stage_text,'unit'=>$unit,'qty'=>$qty,'total_qty'=>$total_qty,'pack_size'=>$pack_size,);

              

                array_push($request_material, $item);
                
            }
            //end estimated material
          $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();
            $stages=$ticket->getTicketProcesses();
          //print_r(json_encode($request_material));die;

        return view('inventory.request_material',compact('doc_no','ticket_no','plan_no','request_material','departments','stages'));
    }

    public function requisition_save(Request $request)
    {
          $items_id=$request->items_id;
        $item_stages_id=$request->item_stage_ids;
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;


           $req=new Requisition;
           $req->requisition_no=$request->get('doc_no');
           $req->requisition_date=$request->get('doc_date');
           $req->issued='0';
           $req->status='open';
           $req->batch_no=$request->get('batch_no');
           //$req->ticket_no=$request->get('ticket_no');
           $req->remarks=$request->get('remarks');

           $req->save();

           for($i=0;$i<count($items_id);$i++)
            {
         $req->items()->attach($items_id[$i] , ['stage_id'=>$item_stages_id[$i],'unit' => $units[$i] , 'quantity' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i]  ]);
           }

           return redirect()->back()->with('success','Requisition genrated!');

    }

    public function requisition_requests()
    {

       //$requests=Requisition::where('issued','0')->where('status','like','open')->orderBy('created_at','desc')->get();
       $requests=Requisition::orderBy('created_at','desc')->get();

       return view('inventory.request',compact('requests'));

    }

    public function requisition_request(Request $request)//for all genral request
    {
          

        $doc_no="REQ-".Date("y")."-";
        $num=1;

         $std=Requisition::select('id','requisition_no')->where('requisition_no','like',$doc_no.'%')->orderBy('requisition_no','desc')->first();
         if($std=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $std['requisition_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

        $locations=InventoryDepartment::departments_with_items();
          
        $employees=Employee::with('designation')->where('activeness','active')->orderBy('name','asc')->get();
          
        $plans=Productionplan::plans_with_rem();

        return view('inventory.request.requisition_request',compact('plans','locations','employees','doc_no'));

        
    }

    public function requisition_request_save(Request $request)//for all genral request
    {
      $chln=Requisition::where('requisition_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->with('error','Doc no. already existed!');

        $items_id=$request->items_id;
        
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;
        $stages=$request->stages;

        $active=$request->get('active');
        if($request->get('active')!='')
            $active=$request->get('active');
          else
            $active=0;

          $approved=$request->get('is_approved');
        if($request->get('is_approved')!='')
            $approved=$request->get('is_approved');
          else
            $approved=0;

           $req=new Requisition;
           $req->requisition_no=$request->get('doc_no');
           $req->requisition_date=$request->get('doc_date');
           $req->department_id=$request->get('department_id');
           $req->plan_id=$request->get('plan_id');
           // $req->product_id=$request->get('product_id');
           // $req->batch_no=$request->get('batch_no');
            $req->request_by=$request->get('request_by');
            $req->approved_by=$request->get('approved_by');
           $req->activeness=$active;
           $req->is_approved=$approved;
           $req->issued='0';
           $req->status='open';
           
           $req->remarks=$request->get('remarks');

           $req->save();

           for($i=0;$i<count($items_id);$i++)
            {
         $req->items()->attach($items_id[$i] , ['stage_id' => $stages[$i] ,'unit' => $units[$i] , 'quantity' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i], 'approved_qty' => $qtys[$i]  ]);
           }
           
           if($req->plan_id!='' || $req->plan_id!=0)
           {
             $plan=Productionplan::find($req->plan_id);
             if($plan['batch_no']=='')
             {
             $plan->batch_no=$request->get('batch_no'); 
             $plan->mrp=$request->get('mrp'); 
             $plan->mfg_date=$request->get('mfg_date'); 
             $plan->exp_date=$request->get('exp_date'); 
             $plan->batch_due_date=$request->get('batch_due_date'); 
             $plan->save();
             } 
           }
           

           return redirect(url('requisition/request/edit/'.$req->id))->with('success','Requisition genrated!');
    }

    public function edit_requisition_request($requisition_id)//for all genral request
    {
        

         $request=Requisition::find($requisition_id);

      
         $locations=InventoryDepartment::departments_with_items();
        
          

         $employees=Employee::with('designation')->where('activeness','active')->orderBy('name','asc')->get();

         $plans=Productionplan::plans_with_rem();
            

        return view('inventory.request.edit_requisition_request',compact('plans','employees','locations','request'));
    }

    public function requisition_request_update(Request $request)//for all genral request
    {
        $items_id=$request->items_id;
        $pivot_ids=$request->pivot_ids;
       $units=$request->units;
        $qtys=$request->qtys;
        $app_qtys=$request->app_qtys;
        $pack_sizes=$request->p_s;
        $stages=$request->stages;

             $active='0';
        if($request->get('active')!='')
            $active=$request->get('active');

          $approved=$request->get('is_approved');
        if($request->get('is_approved')!='')
            $approved=$request->get('is_approved');
          else
            $approved=0;

           $req=Requisition::find($request->id);
           $req->requisition_no=$request->get('doc_no');
           $req->requisition_date=$request->get('doc_date');
           //$req->department_id=$request->get('department_id');
           $req->plan_id=$request->get('plan_id');
           //$req->product_id=$request->get('product_id');
           //$req->batch_no=$request->get('batch_no');
            $req->request_by=$request->get('request_by');
            $req->approved_by=$request->get('approved_by');
           $req->activeness=$active;
           $req->is_approved=$approved;
           $req->issued='0';
           $req->status='open';
           
           $req->remarks=$request->get('remarks');

           $req->save();

           

           // $rel=array();
           //  for($i=0;$i<count($items_id);$i++)
           //  {  
           //      $pivot=array('unit' => $units[$i] , 'quantity' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i] , 'approved_qty'=>$app_qtys[$i] );

           //      $let=array( $items_id[$i].'' =>$pivot );

           //      $rel=$rel+$let;

           // }

           // $req->items()->sync($rel);

           $items=requisition_item::where('requisition_id',$req['id'])->whereNotIn('id',$pivot_ids)->get();

        foreach ($items as $tr) {
          $tr->delete();
        }

           for ($i=0;$i<count($items_id);$i++)
           {
                 if($pivot_ids[$i]!=0)
                 $item=requisition_item::find($pivot_ids[$i]);
                  else
                  $item=new requisition_item;

                $item->requisition_id=$req['id'];
                $item->item_id=$items_id[$i];
                $item->stage_id=$stages[$i];
                $item->unit=$units[$i];
                $item->quantity=$qtys[$i];
                $item->pack_size=$pack_sizes[$i];
                $item->approved_qty=$app_qtys[$i];
                $item->save();
           }

           if($req->plan_id!='')
           {
             $plan=Productionplan::find($req->plan_id);
             if($plan['batch_no']=='')
             {
             $plan->batch_no=$request->get('batch_no'); 
             $plan->mrp=$request->get('mrp'); 
             $plan->mfg_date=$request->get('mfg_date'); 
             $plan->exp_date=$request->get('exp_date'); 
             $plan->batch_due_date=$request->get('batch_due_date'); 
             $plan->save();
             } 
           }

           return redirect()->back()->with('success','Requisition updated!');
    }

    public function print_requisition(Requisition $request)//for all genral request
    {
        $data = [
            
            'request'=>$request,
                
        ]; //print_r(json_encode($request));die;

           view()->share('inventory.report.request_report',$data);
        $pdf = PDF::loadView('inventory.report.request_report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($request['requisition_no'].'.pdf');
    }
    public function print_issuance(Issuance $issue)//for all genral request
    {
        
     $data = [
            
            'issue'=>$issue,
                
        ];
                
           view()->share('inventory.report.issue_report',$data);
        $pdf = PDF::loadView('inventory.report.issue_report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($issue['issuance_no'].'.pdf');
    }


    public function delete_requisition(Requisition $request)
    {

      $issue=Issuance::where('requisition_id',$request['id'])->first();


            if($issue!='')
             return redirect()->back()->withErrors(['error'=>'Delete issuance first, than requisition!']);

       $request->items()->detach();

         $request->delete();

        return redirect(url('requisition/request/create'))->with('success','Requisition Deleted!');


     }


    public function issue_items($requisition_no)
    {

        $doc_no="ISS-".Date("y")."-";
        $num=1;

         $std=Issuance::select('id','issuance_no')->where('issuance_no','like',$doc_no.'%')->latest()->first();
         if($std=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $std['issuance_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

       $let_req=Requisition::where('requisition_no','like',$requisition_no)->first();
        //$request='';
            $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();
            $ticket=Ticket::where('ticket_no','like',$let_req['ticket_no'])->first();
            $stages=$ticket->getTicketProcesses();

            $items=$let_req->items;

    //start request material
            $request_material=array();
           
            foreach ($items as $key) {

                 $location_id=$key['department']['id'];
            $location_text=$key['department']['name'];
            $item_id=$key['id'];
            $item_text=$key['item_name'];
            $item_code=$key['item_code'];
            
            $item_uom='';
            if($key['unit']!='')
                $item_uom=$key['unit']['name'];
            $item_color='';
            if($key['color']!='')
                $item_color=$key['color']['name'];
            $item_size='';
            if($key['size']!='')
                $item_size=$key['size']['name'];
            $item_type='';
            if($key['type']!='')
                $item_type=$key['type']['name'];
            $item_category='';
            if($key['category']!='')
                $item_category=$key['category']['name'];

                
                $unit=$key['pivot']['unit'];
                $pack_size=$key['pivot']['pack_size'];
                $qty=$key['pivot']['quantity'];
                $total_qty=$qty * $pack_size;

                $req_qty=$qty;
                $issued_qty=$qty;

               $stage_id=$key['pivot']['stage_id'];
               if($stage_id==-1)
                $stage_text='';
                else
               $stage_text=Process::find($stage_id)->process_name;


                $item=array('location_id'=>$location_id,'location_text'=>$location_text,'item_id'=>$item_id,'item_name'=>$item_text,'item_code'=>$item_code,'type'=>$item_type,'category'=>$item_category,'uom'=>$item_uom,'color'=>$item_color,'size'=>$item_size,'stage_id'=>$stage_id,'stage_text'=>$stage_text,'unit'=>$unit,'req_qty'=>$req_qty,'qty'=>$issued_qty,'total_qty'=>$total_qty,'pack_size'=>$pack_size,);

              

                array_push($request_material, $item);
                
            }
            //end request material

            $request=array('requisition_no'=>$let_req['requisition_no'],'requisition_date'=>$let_req['requisition_date'],'plan_no'=>$let_req['plan_no'],'ticket_no'=>$let_req['ticket_no'],'remarks'=>$let_req['remarks'],);

            $batches=Ticket::where('batch_close','0')->pluck('batch_no');

       return view('inventory.item_issue',compact('batches','request','departments','stages','request_material','doc_no'));

    }


    public function issuance_save(Request $request)
    {

      $chln=Issuance::where('issuance_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->with('error','Doc no. already existed!');
           
          $items_id=$request->items_id;
        //$item_stages_id=$request->item_stage_ids;
       $units=$request->units;
       //$req_qtys=$request->req_qtys;

        $grn_nos=$request->grn_nos;
         $qcs=$request->qc;
        $batch_nos=$request->batch_nos;

        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;
         $stages=$request->stages;
          $request_item_ids=$request->request_item_ids;

            $issued=$request->issued;
            if($issued=='')
                $issued='0';

           $req=new Issuance;
           $req->issuance_no=$request->get('doc_no');
           $req->issuance_date=$request->get('doc_date');
           $req->department_id=$request->get('department_id');
           $req->plan_id=$request->get('plan_id');
          // $req->product_id=$request->get('product_id');
           $req->requisition_id=$request->get('request_id');
           //$req->batch_no=$request->get('batch_no');
           $req->remarks=$request->get('remarks');

           $req->issued_by=$request->get('issued_by');
           $req->received_by=$request->get('received_by');
           $req->receiving_department=$request->get('receiving_department');

           $req->issued=$issued;
           $req->status='close';
           //$req->plan_no=$request->get('plan_no');
           //$req->ticket_no=$request->get('ticket_no');
           $req->remarks=$request->get('remarks');

           $req->save();

           for($i=0;$i<count($items_id);$i++)
            {
         $req->items()->attach($items_id[$i] , ['request_item_id' => $request_item_ids[$i],'stage_id' => $stages[$i],'grn_no' => $grn_nos[$i],'qc_no' => $qcs[$i],'batch_no' => $batch_nos[$i],'unit' => $units[$i] , 'quantity' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i]  ]);
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
               $qty=$item['pack_size'] * $item['quantity'];
                $amount=$rate * $qty;
                
                $remarks=$item['item']['item_name'].' ('.$rate.'*'.$qty.')';

          $depart=InventoryDepartment::find($item['item']['department_id'])->account_id;
           
           $trans=new Transection;
           $trans->account_voucherable_id=$req->id;
           $trans->account_voucherable_type='App\Models\Issuance';
           $trans->account_id=$depart;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;
           $trans->save();

           $depart=InventoryDepartment::find($item['item']['department_id'])->cgs_account_id;
           
           $trans=new Transection;
           $trans->account_voucherable_id=$req->id;
           $trans->account_voucherable_type='App\Models\Issuance';
           $trans->account_id=$depart;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();


           }
             return redirect()->to('edit/issuance/'.$req->issuance_no)->with('success','Issuance saved!');

    }//end issuance save

       public function issuance_history()
    {

       $issuances=Issuance::orderBy('created_at','desc')->get();

       return view('inventory.issuance_history',compact('issuances'));

    }

    public function edit_issuance($issuance_no)
    {

       $issue=Issuance::where('issuance_no','like',$issuance_no)->first();

       $items=$issue->items;

        $issuance_items=array();
           
            foreach ($items as $key) {

                 $pivot_id=$key['pivot']['id'];
                 $location_id=$key['department']['id'];
            $location_text=$key['department']['name'];
            $item_id=$key['id'];
            $item_text=$key['item_name'];
            
            
            $item_uom='';
            if($key['unit']!='')
                $item_uom=$key['unit']['name'];
           

                $unit=$key['pivot']['unit'];
                $pack_size=$key['pivot']['pack_size'];
                
                $issued_qty=$key['pivot']['quantity'];
                $total_qty=$issued_qty * $pack_size;

                $grn_no=$key['pivot']['grn_no'];
                $qc_no=$key['pivot']['qc_no'];
                $batch_no=$key['pivot']['batch_no'];


               $stage_id=$key['pivot']['stage_id'];
               if($stage_id=='' || $stage_id==-1)
                { $stage_text=''; $stage_id=-1; }
                else
               $stage_text=Process::find($stage_id)->process_name;

               $request_item_id=$key['pivot']['request_item_id'];
               $app=requisition_item::find($request_item_id );
               $app_qty='';
               if($app!='')
               $app_qty=$app['approved_qty'];

               $item=array('pivot_id'=>$pivot_id , 'location_id'=>$location_id,'location_text'=>$location_text,'item_id'=>$item_id,'item_name'=>$item_text,'grn_no'=>$grn_no,'qc_no'=>$qc_no,'batch_no'=>$batch_no,'uom'=>$item_uom ,'unit'=>$unit,'qty'=>$issued_qty ,'pack_size'=>$pack_size ,'total_qty'=>$total_qty,'stage_id'=>$stage_id,'stage_text'=>$stage_text,'request_item_id'=>$request_item_id,'app_qty'=>$app_qty);

              

                array_push($issuance_items, $item);
                
            }
            //end request material
            $proc='';
                  if(isset($issue['ticket']))
                 $proc=$issue['ticket']->getProcedure();

                $plan_no=''; $batch_size=''; $product=''; $batch_no='';

                if($issue['plan']!='')
                {
                   $plan_no=$issue['plan']['plan_no'];
                  $batch_size=$issue['plan']['batch_size']; 
                  $batch_no=$issue['plan']['batch_no']; 
              $product=$issue['plan']['product']['item_name'];}

            $issuance=array('id'=>$issue['id'],'issuance_no'=>$issue['issuance_no'],'issuance_date'=>$issue['issuance_date'],'department_id'=>$issue['department_id'],'plan_id'=>$issue['plan_id'],'issued'=>$issue['issued'],'remarks'=>$issue['remarks'], 'issued_by'=>$issue['issued_by'],'received_by'=>$issue['received_by'],'receiving_department'=>$issue['receiving_department'], 'items'=>$issuance_items ,'plan_no'=>$plan_no,'product'=>$product,'batch_size'=>$batch_size ,'batch_no'=>$batch_no ,'request'=>$issue['requisition']);

          
              $grs=[];

              foreach ($issuance_items as $key ) {
                 if($key['grn_no']!='')
                array_push($grs, $key['grn_no']);
              }
              
             $locations=InventoryDepartment::departments_with_items_with_qty(['grs'=>$grs]);
                
            
             $employees=Employee::with('designation')->where('activeness','active')->orderBy('name','asc')->get();
        $departments=Department::where('activeness','1')->orderBy('sort_order')->get();

        

       return view('inventory.edit_issuance',compact('employees','departments','locations','issuance'));

    }

     public function issuance_update(Request $request)
    {
          $items_id=$request->items_id;
        //$item_stages_id=$request->item_stage_ids;
       $units=$request->units;
       $pivots_id=$request->pivot_ids;
       $grn_nos=$request->grn_nos;
        $batch_nos=$request->batch_nos;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;
            
            $issued=$request->issued;
            if($issued=='')
                $issued='0';

           $req=Issuance::find($request->id);
           $req->issuance_no=$request->get('doc_no');
           $req->issuance_date=$request->get('doc_date');
           $req->department_id=$request->get('department_id');
           $req->requisition_id=$request->get('request_id');
           $req->plan_id=$request->get('plan_id');
           //$req->batch_no=$request->get('batch_no');
           $req->issued_by=$request->get('issued_by');
           $req->received_by=$request->get('received_by');
           $req->receiving_department=$request->get('receiving_department');

           $req->issued=$issued;
           $req->status='close';
           $req->remarks=$request->get('remarks');

           $req->save();

          $items=item_issuance::where('issuance_id',$req['id'])->whereNotIn('id',$pivots_id)->get();

        foreach ($items as $tr) {
                $tr->delete();
        }

           for ($i=0;$i<count($items_id);$i++)
           {
                 if($pivots_id[$i]!=0)
                 $item=item_issuance::find($pivots_id[$i]);
                  else
                  $item=new item_issuance;

                $item->issuance_id=$req['id'];
                $item->item_id=$items_id[$i];
                $item->grn_no=$grn_nos[$i];
                $item->batch_no=$batch_nos[$i];
                $item->unit=$units[$i];
                $item->quantity=$qtys[$i];
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
               $qty=$item['pack_size'] * $item['quantity'];
                $amount=$rate * $qty;
                
                $remarks=$item['item']['item_name'].' ('.$rate.'*'.$qty.')';

                $depart=InventoryDepartment::find($item['item']['department_id'])->account_id;
            
            if($no < count($transections))
          {  $trans=$transections[$no];  }
          else
           $trans=new Transection;
          
           $trans->account_voucherable_id=$req->id;
           $trans->account_voucherable_type='App\Models\Issuance';
           $trans->account_id=$depart;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;
           $trans->save();
             $no++;

             $depart=InventoryDepartment::find($item['item']['department_id'])->cgs_account_id;
            
            if($no < count($transections))
          {  $trans=$transections[$no];  }
          else
           $trans=new Transection;
          
           $trans->account_voucherable_id=$req->id;
           $trans->account_voucherable_type='App\Models\Issuance';
           $trans->account_id=$depart;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=$amount;
           $trans->credit=0;
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

           return redirect()->back()->with('success','Issuance updated!');

    }//end issuance update

    public function delete_issuance(Issuance $issuance)
    {
         if($issuance->returns!='')
         return redirect()->back()->with('error','Delete returns first!');

       $issuance->items()->detach();


            foreach($issuance->transections as $trans )
           {
               $trans->delete();
           }


         $issuance->delete();

        return redirect(url('store-issuance'))->with('success','Issuance Deleted!');


     }


}
