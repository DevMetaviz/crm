<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\ticket_process;
use App\Models\sampling;
use App\Models\qc_report;
use App\Models\qc_parameter;
use App\Models\Stock;
use App\Models\inventory;
use App\Models\Parameter;
use App\Models\Configuration;
use App\Models\InventoryDepartment;
use App\Models\Process;
use PDF;

class QcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

   

   

    public function lab_test_request(Request $request)
    {
        $ticket_id=$request->get('ticket_id');
        $process_id=$request->get('process_id');
        $super_id=$request->get('super_id');

        $ticket_process=ticket_process::where('ticket_id',$ticket_id)->where('process_id',$process_id)->where('super_id',$super_id)->first();
        //print_r($ticket_process['ticket_parameters']);die;
        $doc_no='LR-';
        return view('qc.request',compact('ticket_process','doc_no'));
    }

    public function pending_requests()
    {
        $requests=qa_sampling::where('is_received',0)->orderBy('sampling_no','desc')->get();
        // $requests=array();
            
        //     foreach ($reqs as $key ) {

        //         $request=qa_sampling::get_qa_sampling($key['id']);
        //       array_push($requests, $request);
        //     }
            
        return view('qc.pending_requests',compact('requests'));
    }

    public function all_qc_requests()
    {
        $requests=sampling::orderBy('sampling_no','desc')->get();
        // $requests=array();
            
        //     foreach ($reqs as $key ) {

        //         $request=qa_sampling::get_qa_sampling($key['id']);
        //       array_push($requests, $request);
        //     }
            
        return view('qc.all_requests',compact('requests'));
    }

    

    public function edit_qc_result($request_id)
    {
        $request=sampling::find($request_id);

         $loc="INP";

         if($request['type']=='item_base')
         {
          $stock=Stock::where('grn_no',$request['grn_no'])->first();
          $loc=strtoupper( $stock['item']['department']['code'] );
          }

        $doc_no="QC/".$loc."-".Date("y")."/";
        //$doc_no1="".$loc."-";
        $num=1;

         $stk=qc_report::select('id','qc_number')->where('qc_number','like',$doc_no.'%')->latest()->first();
         if($stk=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $stk['qc_number']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
        

         $parameters=Parameter::where('parameterable_id','like',$request['stock']['item_id'])->where('parameterable_type','App\Models\inventory')->orderBy('sort_order','asc')->where('activeness','like','active')->get();


        //print_r(json_encode($parameters));die;

        return view('qc.edit_result',compact('request','parameters','doc_no'));
    }

    public function update_qc_request(Request $request)
    {   
        $sampling_id=$request->sampling_id;

        //$stock_qc_req=stock_qc_request::find($request->qc_requestable_id);
               //$stock_qc_req->stock_id=$request->stock_id;
               //$stock_qc_req->sample_qty=$request->sample_qty;
               //$stock_qc_req->save();
                 
                 $verified=0;
                 if($request->verified!='')
                    $verified=$request->verified;
                $received=0;
                 if($request->received!='')
                    $received=$request->received;

                $qc_req=sampling::find($sampling_id);

                $qc_req->sampling_no=$request->sampling_no;
               
               //$qc_req->qa_samplable_id=$request->qa_samplable_id;
               //$qc_req->qa_samplable_type='App\Models\Stock';
                $qc_req->intimation_date=$request->intimation_date;
               $qc_req->intimation_time=$request->intimation_time;

               $qc_req->sampling_date=$request->sampling_date;
               $qc_req->sampling_time=$request->sampling_time;
                $qc_req->type=$request->type;

                $qc_req->item_id=$request->item_id;
                 $qc_req->grn_no=$request->grn_no;

                 $qc_req->plan_id=$request->plan_batch_no;
                   $qc_req->process=$request->plan_process;

               $qc_req->total_qty=$request->total_qty;
               $qc_req->sample_qty=$request->sample_qty;
               
                $qc_req->remarks=$request->remarks;
                $qc_req->qa_remarks=$request->qa_remarks;
                

                //$qc_req->released=$request->released;
               $qc_req->verified=$verified;
                $qc_req->is_received=$received;
               $qc_req->received_date=$request->rec_date;
               $qc_req->received_time=$request->rec_time;
               $qc_req->save();


               return redirect()->back()->with('success','Sampling Updated!');
    }

    public function print_sampling($sampling_id)
    {
        $request=sampling::with('item')->find($sampling_id);

        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

       if($request['type']=='item_base')
        {
          $data = [
            
            'request'=>$request,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];

        view()->share('qc.report.item_sampling',$data);
        $pdf = PDF::loadView('qc.report.item_sampling', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($request['sampling_no']);
       }
       elseif($request['type']=='production_base')
        {
          $data = [
            
            'plan'=>$request['plan'],
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];

        view()->share('qc.report.process_sampling',$data);
        $pdf = PDF::loadView('qc.report.process_sampling', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('plan.pdf');
       }
       
        
           


        return view('qc.edit_request',compact('departments','request'));
    }

    public function save_qc_result(Request $request)
    {
           $active=0;
                 if($request->active!='')
                    $active=$request->active;
                 
                 $result_id=$request->result_id;

                 if($result_id==null)
                {
                    $qc_req=new qc_report;
                    $qc_req->status=0;
                }
               else
                $qc_req=qc_report::find($result_id);


               $qc_req->sampling_id=$request->sampling_id;
               
               $qc_req->testing_specs=$request->testing_specs;
               $qc_req->qc_number=$request->qc_no;
               $qc_req->tested_date=$request->test_date;
               $qc_req->released_date=$request->released_date;
               $qc_req->released_time=$request->released_time;
               $qc_req->retest_date=$request->retest_date;
               $qc_req->approved_qty=$request->approved_qty;
               $qc_req->remarks=$request->remarks;
               $qc_req->is_active=$active;
               $qc_req->released=$request->released;
               $qc_req->save();

               $parameter_ids=$request->parameter_ids;
               $parameters=$request->parameters;
                $specifications=$request->specifications;
               $values=$request->observations;
                
                if($result_id==null && $parameters!='')
                {
               for($i=0;$i<count($parameters);$i++)
            {
               

               $p=new qc_parameter;
               $p->report_id=$qc_req->id;
               $p->name=$parameters[$i];
               $p->specification=$specifications[$i];
               $p->value=$values[$i];
               $p->save();

           }
            return redirect('edit/qc/result/'.$qc_req->id)->with('success','Result Saved!');
              }
              else
              {
                     
                     if( $parameters!='')
                {
               for($i=0;$i<count($parameters);$i++)
               {  
                
                   $p=qc_parameter::find($parameter_ids[$i]);
               $p->report_id=$qc_req->id;
               $p->name=$parameters[$i];
               $p->specification=$specifications[$i];
               $p->value=$values[$i];
               $p->save();
                 }

                
            }
           return redirect('edit/qc/result/'.$qc_req->id)->with('success','Result Saved!');
              }

                  

              

    }

    public function lab_test($req_no)
    {
        $ticket_id=25;
        $process_id=2;
        $super_id=27;

        $ticket_process=ticket_process::where('ticket_id',$ticket_id)->where('process_id',$process_id)->where('super_id',$super_id)->first();
        //print_r($ticket_process['ticket_parameters']);die;
        $doc_no='LR-';
        return view('qc.observe',compact('ticket_process','doc_no'));
        
    }

    public function qc_results()
    {
        $reqs=qc_report::orderBy('qc_number','desc')->get();
        $results=array();
            
            foreach ($reqs as $key ) {

                $result=qc_report::get_qc_report($key['id']);
              array_push($results, $result);
            }

            //print_r(json_encode($results));die;
            
        return view('qc.all_results',compact('results'));
    }

    public function new_qc_results()
    {
        $reqs=qc_report::whereHas('qa_sample',function($q){

            $q->where('qa_samplable_type','App\Models\Stock');

        })->where('status',0)->orderBy('qc_number','desc')->get();

        $results=array();
            
            foreach ($reqs as $key ) {

                $result=qc_report::get_qc_report($key['id']);
              array_push($results, $result);
            }

            //print_r(json_encode($results));die;
            
        return view('qc.results',compact('results'));
    }

    public function view_qc_result($result_id)
    {   
        $result=qc_report::get_qc_report($result_id);
        return view('qc.view_result',compact('result'));
        
    }

    public function view_qc_result_report($result_id)
    {
        $result=qc_report::get_qc_report($result_id);

        $data = [
            
            'result'=>$result,
        
        ];

        view()->share('qc.report.result_report',$data);
        $pdf = PDF::loadView('qc.report.result_report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('qc.report.result_report.pdf');

        //return view('qc.view_result',compact('result'));
        
    }


    public function qc_result()
    {
        
        return view('qc.result');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function product_parameters()
    {
        //$parameters=Parameter::where('parameterable_type','App\Models\inventory')->orderBy('sort_order','asc')->get();
        $parameters=Parameter::where('parameterable_type','App\Models\inventory')->orWhere(function($q){
                  $q->whereNotNull('process_id');
                  $q->whereNotNull('item_id');
        })->orderBy('sort_order','asc')->get();


        $items=inventory::where('activeness','like','active')->orderBy('created_at','desc')->get();
         $processes=Process::where('activeness','like','active')->orderBy('created_at','desc')->get();
        
        return view('qc.parameter',compact('processes','items','parameters'));
    }
    public function save_product_parameters(Request $request)
    {
       $activeness=$request->get('activeness');
        if($activeness=='')
            $activeness='inactive';
        $parameter=new Parameter;

        $parameter->name=$request->get('name');
          
          if($request->get('process_id')=='')
        {$parameter->parameterable_id=$request->get('item_id');
        $parameter->parameterable_type='App\Models\inventory';
         }
         else
        {$parameter->item_id=$request->get('item_id');
        $parameter->process_id=$request->get('process_id');
        }


        $parameter->description=$request->get('description');
        $parameter->sort_order=$request->get('sort_order');

        $parameter->activeness=$activeness;
        $parameter->save();

        return redirect()->back()->with('success','Parameter Added!');
    }

     public function process_parameter_edit($parameter_id)
    {
        
         $parameter=Parameter::find($parameter_id);
        
        $parameters=Parameter::where('parameterable_type','App\Models\inventory')->orWhere(function($q){
                  $q->whereNotNull('process_id');
                  $q->whereNotNull('item_id');
        })->orderBy('sort_order','asc')->get();

        $items=inventory::where('activeness','like','active')->orderBy('created_at','desc')->get();
        $processes=Process::where('activeness','like','active')->orWhere('id',$parameter['process_id'])->orderBy('created_at','desc')->get();
        
        return view('qc.parameter_edit',compact('processes','parameter','items','parameters'));
    }
    public function update_process_parameters(Request $request)
    {
       $activeness=$request->get('activeness');
        if($activeness=='')
            $activeness='inactive';
        $parameter=Parameter::find($request->parameter_id);

        $parameter->name=$request->get('name');
        
        if($request->get('process_id')=='')
        {$parameter->parameterable_id=$request->get('item_id');
        $parameter->parameterable_type='App\Models\inventory';
         }
         else
        {$parameter->item_id=$request->get('item_id');
        $parameter->process_id=$request->get('process_id');
        }

        $parameter->description=$request->get('description');
        $parameter->sort_order=$request->get('sort_order');

        $parameter->activeness=$activeness;
        $parameter->save();

        return redirect()->back()->with('success','Parameter Updated!');
    }


}
