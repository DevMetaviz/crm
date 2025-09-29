<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\inventory;
use App\Models\Vendor;
use App\Models\InventoryDepartment;
use App\Models\Parameter;
use App\Models\Process;
use App\Models\Procedure;
use App\Models\ProductionStandard;
use App\Models\Productionplan;
use App\Models\Ticket;
use App\Models\ticket_parameter;
use App\Models\ticket_process;
use App\Models\ticket_estimated;
use App\Models\standard_item;
use App\Models\std_parameter;
use App\Models\Table;
use App\Models\std_table_row;
use PDF;
use App\Models\ticket_table;
use App\Models\ticket_tbl_column;
use App\Models\ticket_tbl_row;
use App\Models\Transection;
use App\Models\yield_detail;
use App\Models\Goods_Yield;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        die;
         $productions=Production::get();

         $plan_no="PN-21-";
        $num=1;

         foreach ($productions as $prod) {

         //    if($prod['batch_qty']==0)
         //        $prod['batch_qty']=1;
         // $prod->save( ); 
             $plan=new Productionplan;
             $plan->plan_no=$plan_no.''.$num;
             $plan->demand_id=0;
             
             $plan->product_id=$prod['item_id'];
              
              if($prod['ticket']!='')
             { //print_r(json_encode($prod['ticket']['batch_size']));die;
                $plan->plan_date=$prod['ticket']['ticket_date'];
                $q=$prod['ticket']['product']['pack_size_qty'];
                if($q==0)
                    $q=1;
             $plan->batch_qty=$prod['ticket']['batch_size'] / $q;
             $plan->batch_size=$prod['ticket']['batch_size'];
             }
             else{
                $plan->plan_date=$prod['production_date'];
             $plan->batch_qty=$prod['qty'];
             $plan->batch_size=$prod['qty'];
             }

             $plan->batch_no=$prod['batch_no'];
             $plan->mfg_date=$prod['mfg_date'];
             $plan->exp_date=$prod['exp_date'];
             $plan->mrp=$prod['mrp'];
             $plan->save();

             $yield=new Goods_Yield;
         $yield->plan_id=$plan->id;
         $yield->qa_sample=0;
         $yield->qc_sample=0;
         $yield->cost_price=$prod['cost_price'];
        $yield->save();

   
             $dt=new yield_detail;
         $dt->yield_id=$yield->id;
         $dt->transfer_date=$prod['production_date'];
         $dt->unit='loose';
         $dt->qty=$prod['qty'];
         $dt->pack_size=1;
        $dt->save();
        
             $num++;

         }
    }

    
    public function process_parameters()
    {
        $parameters=Parameter::where('parameterable_type','App\Models\Process')->orderBy('sort_order','asc')->get();

        $processes=Process::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        
        return view('production.process_parameters',compact('processes','parameters'));
    }
    public function save_process_parameters(Request $request)
    {
       $activeness=$request->get('activeness');
        if($activeness=='')
            $activeness='inactive';
        $parameter=new Parameter;

        $parameter->name=$request->get('name');
        $parameter->identity=$request->get('identity');
        $parameter->parameterable_id=$request->get('process_id');
        $parameter->parameterable_type='App\Models\Process';
        $parameter->type=$request->get('type');
        $parameter->formula=$request->get('formula');
        $parameter->description=$request->get('description');
        $parameter->sort_order=$request->get('sort_order');

        $parameter->activeness=$activeness;
        $parameter->save();

        return redirect()->back()->with('success','Parameter Added!');
    }

     public function process_parameter_edit($parameter_id)
    {
        
         $parameter=Parameter::find($parameter_id);
        $processes=Process::where('activeness','like','active')->orderBy('sort_order','asc')->get();

        $parameters=Parameter::where('parameterable_id',$parameter['parameterable_id'])->where('parameterable_type','App\Models\Process')->orderBy('sort_order','asc')->get();
        
        return view('production.process_parameter_edit',compact('parameter','processes','parameters'));
    }
    public function update_process_parameters(Request $request)
    {
       $activeness=$request->get('activeness');
        if($activeness=='')
            $activeness='inactive';
        $parameter=Parameter::find($request->parameter_id);

        $parameter->name=$request->get('name');
        $parameter->identity=$request->get('identity');
        $parameter->parameterable_id=$request->get('process_id');
        $parameter->parameterable_type='App\Models\Process';
        $parameter->type=$request->get('type');
        $parameter->formula=$request->get('formula');
        $parameter->description=$request->get('description');
        $parameter->sort_order=$request->get('sort_order');

        $parameter->activeness=$activeness;
        $parameter->save();

        return redirect()->back()->with('success','Parameter Updated!');
    }

    public function delete_parameter(Parameter $parameter)
    {

        $std=std_parameter::where('parameter_id',$parameter['id'])->first();

            if($std!='')
             return redirect()->back()->withErrors(['error'=>'Remove parameter from standard, than delete!']);

         $tick=ticket_parameter::where('parameter_id',$parameter['id'])->first();

            if($tick!='')
             return redirect()->back()->withErrors(['error'=>'Remove parameter from batch, than delete!']);


        $parameter->delete();

        return redirect(url('configuration/production/process/parameters'))->with('success','Parameter Deleted!');
    }

    public function get_process_parameters(Request $request)
    {
        //$parameters=Processparameter::where('activeness','like','active')->orderBy('sort_order','asc')->get();
         $process=Process::find($request->process_id);
         //$parameters=Parameter::with('process')->where('parameterable_id',$request->process_id)->where('parameterable_type','App\Models\Process')->get();
         $parameters=$process->parameters;
              
              foreach ($parameters as $key ) {
                  $key->parameterable;
              }
               //$parameters[0]->parameterable;
        return response()->json($parameters, 200);
    }

    public function production_process()
    {
        //$parameters=Processparameter::where('activeness','like','active')->orderBy('sort_order','asc')->get();
         $processes=Process::where('activeness','like','active')->orderBy('sort_order','asc')->get();
         //$tables=Table::where('activeness',1)->get();
        return view('production.production_process',compact('processes'));
    }
    public function save_production_process(Request $request)
    {
        $stages_id=$request->get('stages_id');
         $stages_sort_order=$request->get('stages_sort_order');
         $qcs_required=$request->get('satges_qc');
         $stages_actives=$request->get('stages_actives');

        $activeness=$request->get('activeness');
        if($activeness=='')
            $activeness='inactive';
        $qc_required=$request->get('qc_required');
        if($qc_required=='')
            $qc_required='0';
        $process=new Process;

       //  $parameters_text=$request->parameters_text;
       // $parameters_id=$request->parameters_id;
       //  $parameter_sort_order=$request->parameter_sort_order;

        $process->process_name=$request->get('process');
        $process->identity=$request->get('identity');
       
        $process->remarks=$request->get('remarks');
        $process->sort_order=$request->get('sort_order');

        $process->activeness=$activeness;
        $process->qc_required=$qc_required;
        $process->save();

        // for($i=0;$i<count($parameters_id);$i++)
        //     {
        //  $process->parameters()->attach($parameters_id[$i] , ['sort_order' => $parameter_sort_order[$i]  ]);
        //    }
           if($stages_id!='')
           {
        for($i=0;$i<count($stages_id);$i++)
            {
                // $act=0;
                // if($stages_actives[$i]!='')
                //     $act=1;

         $process->sub_stages()->attach($stages_id[$i] , ['sort_order' => $stages_sort_order[$i] , 'qc_required' => $qcs_required[$i] ,'active'=>$stages_actives[$i]  ]);
           }
           }

        return redirect()->back()->with('success','Production Process Added Successfully!');

    }

    public function edit_production_process($id)
    {
        
        $process=Process::find($id);
        //$parameters=Parameter::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        //$sub_processes=$process->sub_processes();

         $sub_processes=$process->sub_stages;
    
        $processes=Process::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        //print_r(json_encode($sub_processes));die;
        return view('production.process_edit',compact('processes','process','sub_processes'));
    }
    public function update_production_process(Request $request)
    {
        $stages_id=$request->get('stages_id');
         $stages_sort_order=$request->get('stages_sort_order');
         $qcs_required=$request->get('satges_qc');
         $stages_actives=$request->get('stages_actives');

        $activeness=$request->get('activeness');
        if($activeness=='')
            $activeness='inactive';
        $qc_required=$request->get('qc_required');
        if($qc_required=='')
            $qc_required='0';
        $process=Process::find($request->get('id'));

        $parameters_text=$request->parameters_text;
       $parameters_id=$request->parameters_id;
        $parameter_sort_order=$request->parameter_sort_order;

        $process->process_name=$request->get('process');
        $process->identity=$request->get('identity');

        $process->remarks=$request->get('remarks');
        $process->sort_order=$request->get('sort_order');

        $process->activeness=$activeness;
        $process->qc_required=$qc_required;
        $process->save();

         $rel=array();
         if($stages_id!='')
           {
         for($i=0;$i<count($stages_id);$i++)
            {
                // $act=0;
                // if($stages_actives[$i]!='')
                //     $act=1;
                // $qc=0;
                // if($qcs_required[$i]!='')
                //     $qc=1;
//print_r($stages_actives);die;
                $pivot=array( 'sort_order' => $stages_sort_order[$i] , 'qc_required' => $qcs_required[$i] ,'active'=>$stages_actives[$i]  );

                $let=array( $stages_id[$i].'' =>$pivot );

                $rel=$rel+$let;
            }
           }


           $process->sub_stages()->sync($rel);
           

        return redirect()->back()->with('success','Production Process Updated Successfully!');

    }
    public function production_process_history()
    {
        $p_processes=Process::orderBy('sort_order','asc')->get();
        $processes=array();
         foreach ($p_processes as $key ) {
            $qc_required='Required';
            if($key['qc_required']==0)
               $qc_required='Not Required';
               $count=count($key->parameters); 
               //$sub_process_count=count($key->sub_processes()); 
               //here some problem
               $sub_process_count=1;

             $process=array('id'=>$key['id'],'process_name'=>$key['process_name'],'identity'=>$key['identity'],'activeness'=>$key['activeness'],'qc_required'=>$qc_required,'remarks'=>$key['remarks'],'parameters_count'=>$count,'sub_process_count'=>$sub_process_count);
             array_push($processes, $process);
         }

         return view('production.process_history',compact('processes'));
    }

    public function product_process()
    {
        $processes=Process::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        
        return view('production.product_process',compact('processes'));
    }

    public function get_product_procedure(Request $request)
    {
        $product_id=$request->get('product_id');

        //$procedure=Procedure::getProcedure($product_id);
        $procedure_id=inventory::find($product_id)->procedure_id;
        $procedure=Procedure::with('processes','processes.sub_stages')->whereHas('processes',function($q){

            //$q->orderBy('procedures_has_processes.sort_order');

        })->find($procedure_id);

       //print_r(json_encode($procedure));die;
        return response()->json($procedure, 200);
    }

    public function save_product_procedure(Request $request)
    {
         $stages_id=$request->get('stages_id');
         $stages_sort_order=$request->get('stages_sort_order');
         $qcs_required=$request->get('qcs');
          //print_r($qcs_required);die;
         $activeness=$request->get('activeness');
         if($activeness=='')
            $activeness='inactive';

         $procedure=new Procedure;

         $procedure->name=$request->get('name');
         //$procedure->product_id=$request->get('product_id');
         $procedure->remarks=$request->get('remarks');
         $procedure->activeness=$activeness;

         $procedure->save();

         for($i=0;$i<count($stages_id);$i++)
            {
         $procedure->processes()->attach($stages_id[$i] , ['sort_order' => $stages_sort_order[$i] , 'qc_required' => $qcs_required[$i]  ]);
           }

        return redirect()->back()->with('success','Production Procedure Successfully!');
        
    }

    public function list_product_process()
    {
        $procedures=Procedure::get();
        
        return view('production.list_product_process',compact('procedures'));
    }

    public function edit_product_process(Procedure $procedure)
    {
        $processes=Process::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        
        return view('production.edit_product_process',compact('processes','procedure'));
    }

    public function update_product_process(Request $request)
    {

        $stages_id=$request->get('stages_id');//print_r(json_encode($stages_id));die;
         $stages_sort_order=$request->get('stages_sort_order');
         $qcs_required=$request->get('qcs');
          //print_r($qcs_required);die;
         $activeness=$request->get('activeness');
         if($activeness=='')
            $activeness='inactive';

         $procedure=Procedure::find($request->id);

         $procedure->name=$request->get('name');
         //$procedure->product_id=$request->get('product_id');
         $procedure->remarks=$request->get('remarks');
         $procedure->activeness=$activeness;

         $procedure->save();

         
           

           $rel=array();
            for($i=0;$i<count($stages_id);$i++)
            {  
                $pivot=array( 'sort_order' => $stages_sort_order[$i] , 'qc_required' => $qcs_required[$i] );

                $let=array( $stages_id[$i].'' =>$pivot );

                $rel=$rel+$let;

         
           }

           $procedure->processes()->sync($rel);

        return redirect()->back()->with('success','Production Procedure Successfully Updated!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public function standard_stage($std_id,$process_id)
    {
         $std=ProductionStandard::find($std_id);
         $process=Process::find($process_id);
         
         return view('production.std_process',compact('std','process')); 
    }

     public function finish_goods_production_standard(Request $request)
    {  
        
        $std_no="STD-".Date("y")."-";
        $num=1;

         $std=ProductionStandard::select('id','std_no')->where('std_no','like',$std_no.'%')->latest()->first();
         if($std=='')
         {
              $let=sprintf('%05d', $num);
              $std_no=$std_no. $let;
         }
         else
         {
            $let=explode($std_no , $std['std_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%05d', $num);
              $std_no=$std_no. $let;
         }

        $depart=InventoryDepartment::find(1);
        
        //$products=$depart->inventories->where('activeness','like','active');
        $products=inventory::with('unit')->doesntHave('master_production_standards')->where('department_id','1')->where('status','1')->orderBy('item_name')->get();

       

        // $raw_items=inventory::with('department','category','color','unit','small_unit','type','size')->where('department_id','2')->where('activeness','like','active')->get();

        // $packing_items=inventory::with('department','category','color','unit','small_unit','type','size')->where('department_id','3')->where('activeness','like','active')->get();
    
       $departs=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->select('id','name')->get();
      $departments=[];
       foreach ($departs as $dpt) {
         
         
             
         $its=inventory::where('department_id',$dpt['id'])->where('status','1')->get();
            $items=[];
         foreach ($its as $key ) {
             
             $uom='';
             if(isset($key['unit']['name']))
                $uom=$key['unit']['name'];

        $it=['id'=>$key['id'],'item_name'=>$key['item_name'],'unit'=>$uom];

             array_push($items, $it);
         }

         $dt=['id'=>$dpt['id'],'name'=>$dpt['name'],'items'=>$items];

         array_push($departments, $dt);
       }
        

        return view('production.production_std',compact('departments','products','std_no'));
    }

    public function save_production_standard(Request $request)
    {
        $activeness=$request->get('activeness');
        if($activeness=='')
            $activeness='inactive';

        $items_id=$request->items_id;
        $types=$request->types;
        $item_stages_id=$request->item_stage_ids;
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;
        $sorts=$request->sort;
        $mfs=$request->mf;
//print_r($items_id);die;
        

        $std=new ProductionStandard;
        $std->std_no=$request->get('std_no');
        $std->std_name=$request->get('std_name');
        $std->master_article_id=$request->get('master_article');
        $std->batch_size=$request->get('batch_size');
        $std->activeness=$activeness;
        $std->remarks=$request->get('remarks');
        $std->procedure_id=$request->get('procedure_id');

          $std->save();

         for($i=0;$i<count($items_id);$i++)
            {
         $std->items()->attach($items_id[$i] , ['type'=>$types[$i],'is_mf'=>$mfs[$i],'stage_id'=>$item_stages_id[$i],'unit' => $units[$i] , 'quantity' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i] ,'sort_order'=>$sorts[$i]   ]);
           }

        


        return redirect()->back()->with('success','Finished Good Production Standard saved!');

    }

    public function finish_goods_production_standard_history()
    {
        $stds=ProductionStandard::orderBy('created_at','desc')->get();

        return view('production.fg_std_history',compact('stds'));
    }

    public function edit_fg_std($std_no)
    {
        $std=ProductionStandard::with('items')->where('std_no','like',$std_no)->first();
       //$depart=InventoryDepartment::where('name','like','Finished Goods')->first();
        
        //$products=$depart->inventories->where('activeness','like','active');
         $products=inventory::with('unit')->where('department_id','1')->where(function($q)use($std){
             $q->doesntHave('master_production_standards');
             $q->where('status','like','1');
             $q->orWhere('id',$std['master_article_id']);
         })->orderBy('item_name')->get();

        //$inventories=inventory::with('department','category','color','small_unit','unit','type','size')->where('activeness','like','active')->get();
    
        $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();

        //standard
        
        $items=array();
        //$std_packing_items=array();
        foreach ($std['items'] as $key ) {
            //$location_id=$key['department']['id'];
            //$location_text=$key['department']['name'];
            $item_id=$key['id'];
            $item_text=$key['item_name'];
    
            $stage_id=$key['pivot']['stage_id'];
            if($stage_id!='-1')
            {  $stage=Process::find($stage_id);
               $stage_name=$stage['process_name']; }
            else
                $stage_name='';
            $item_uom='';
            if($key['unit']!='')
                $item_uom=$key['unit']['name'];
           

            $unit=$key['pivot']['unit'];
            $qty=$key['pivot']['quantity'];
            $pack_size=$key['pivot']['pack_size'];

             $mf=$key['pivot']['is_mf'];

            $total=$qty * $pack_size ;
              //'location_id'=>$location_id,'location_text'=>$location_text,
            $item=array('pivot_id'=>$key['pivot']['id'],'item_id'=>$item_id,'item_name'=>$item_text,'sort'=>$key['pivot']['sort_order'],'type'=>$key['pivot']['type'] ,'mf'=>$mf,'stage_id'=>$stage_id,'stage_name'=>$stage_name,'item_uom'=>$item_uom,'unit'=>$unit,'qty'=>$qty,'pack_size'=>$pack_size,'total'=>$total);

            //if($key['pivot']['type']=='raw')
            array_push($items, $item);
          // elseif($key['pivot']['type']=='packing')
            //array_push($std_packing_items, $item);

        }

         $stages=array();
         //$procedure=Procedure::getProcedure($std['master_article_id']);

         $procedure_id=inventory::find($std['master_article_id'])->procedure_id;
        $procedure=Procedure::with('processes','processes.sub_stages')->find($procedure_id);
        if($procedure!='')
         $stages=$procedure['processes'];
                
      
                          $um_t='';
                          if(isset( $std['master_article']['unit'] ) )
                           $um_t=$std['master_article']['unit']['name'];
        //print_r($std['master_article']['unit']);die;
        $standard=array('std_id'=>$std['id'],'std_no'=>$std['std_no'],'std_name'=>$std['std_name'],'master_article_id'=>$std['master_article_id'],'procedure_id'=>$std['procedure_id'],'batch_size'=>$std['batch_size'],'std_unit'=>$um_t,'activeness'=>$std['activeness'],'remarks'=>$std['remarks'],'items'=>$items,'stages'=>$stages);

        // $raw_items=inventory::with('department','category','color','unit','small_unit','type','size')->where('department_id','2')->where('activeness','like','active')->get();

        // $packing_items=inventory::with('department','category','color','unit','small_unit','type','size')->where('department_id','3')->where('activeness','like','active')->get();

        $departs=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->select('id','name')->get();
          $ids=array_column($standard['items'] , 'item_id'); 
      $departments=[];
       foreach ($departs as $dpt) {
         
         
             
         $its=inventory::where('department_id',$dpt['id'])->where(function($q) use ($ids){
            $q->where('status','like','1');
            $q->orWhereIn('id',$ids); 
         })->get();

            $items=[];
         foreach ($its as $key ) {
             
             $uom='';
             if(isset($key['unit']['name']))
                $uom=$key['unit']['name'];

        $it=['id'=>$key['id'],'item_name'=>$key['item_name'],'unit'=>$uom];

             array_push($items, $it);
         }

         $dt=['id'=>$dpt['id'],'name'=>$dpt['name'],'items'=>$items];

         array_push($departments, $dt);
       }



        return view('production.edit_fg_std',compact('departments','products','departments','standard'));
    }

    public function update_fg_std(Request $request)
    {
        $activeness=$request->get('activeness');
        if($activeness=='')
            $activeness='inactive';

        $items_id=$request->items_id;
        $pivots_id=$request->get('pivot_ids');
        $types=$request->types;
        $item_stages_id=$request->item_stage_ids;
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;
        $sort=$request->sort;
        $mf=$request->mf;
//print_r($items_id);die;
       

        $std=ProductionStandard::find($request->std_id);
        $std->std_no=$request->get('std_no');
        $std->std_name=$request->get('std_name');
        $std->master_article_id=$request->get('master_article');
        $std->batch_size=$request->get('batch_size');
        $std->activeness=$activeness;
        $std->remarks=$request->get('remarks');
        $std->procedure_id=$request->get('procedure_id');

          $std->save();

          $lets=standard_item::where('std_id',$std['id'])->whereNotIn('id',$pivots_id)->get();

          foreach ($lets as $key ) {
              $key->delete();
          }
        //$rel=array();
            for($i=0;$i<count($items_id);$i++)
            {  

                
                if($pivots_id[$i] != '')
           $esti=standard_item::find($pivots_id[$i]);
           else
           $esti=new standard_item;

       $esti->item_id=$items_id[$i];
       $esti->std_id=$std['id'];
       $esti->type=$types[$i];
        $esti->is_mf=$mf[$i];
       $esti->stage_id=$item_stages_id[$i];
       $esti->unit=$units[$i];
       $esti->quantity=$qtys[$i];
       $esti->pack_size=$pack_sizes[$i];
       $esti->sort_order=$sort[$i];
       $esti->save();

               
           }

        return redirect()->back()->with('success','Finished Good Production Standard updated!');

    }

    public function get_production_std(Request $request)
    {
        
        $std=ProductionStandard::with('items')->where('master_article_id',$request->product_id)->first();
        $items=[];
        foreach ($std['items'] as $key ) {
            
            
            $item_id=$key['id'];
            $item_name=$key['item_name'];
    
            $stage_id=-1;
            $stage_name='';

            $item_uom='';
            if($key['unit']!='')
                $item_uom=$key['unit']['name'];
           

            $unit=$key['pivot']['unit'];
            $qty=$key['pivot']['quantity'];
              
            $pack_size=$key['pivot']['pack_size'];

             $mf=$key['pivot']['is_mf'];

            
              
            $item=array('item_id'=>$item_id,'item_name'=>$item_name,'sort'=>$key['pivot']['sort_order'] ,'mf'=>$mf,'stage_id'=>$stage_id,'stage_name'=>$stage_name,'item_uom'=>$item_uom,'unit'=>$unit,'qty'=>$qty,'pack_size'=>$pack_size);

          
            array_push($items, $item);

        }

        
        

        $standard=['batch_size'=>$std['batch_size'],'items'=>$items];

        return response()->json($standard, 200);
    }

    

    public function get_product_std(Request $request)
    {
        
    
        $item_id=$request->get('item_id');

        $standard=ProductionStandard::with(array('master_article'=>function($query){
    $query->select('id','item_name');
}))->where('master_article_id','like',$item_id)->select('id','std_no','std_name','master_article_id','batch_size')->where('activeness','like','active')->get();
        

        return response()->json($standard, 200);
    }

    public function create_plan_ticket()
    {
              $ticket_no="BMR-".Date("y")."-";
        $num=1;

         $plan=Ticket::select('id','ticket_no')->where('ticket_no','like',$ticket_no.'%')->orderBy('ticket_no','desc')->latest()->first();
         if($plan=='')
         {
              $let=sprintf('%05d', $num);
              $ticket_no=$ticket_no. $let;
         }
         else
         {
            $let=explode($ticket_no , $plan['ticket_no']); 
            $num=intval($let[1]) + 1;
            $let=sprintf('%05d', $num);
              $ticket_no=$ticket_no. $let;
         }

        $plans=Productionplan::orderBy('created_at','desc')->get();
        //$departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        //print_r(json_encode($standards));die;

        $raw_items=inventory::with('department','category','color','unit','small_unit','type','size')->where('department_id','2')->where('activeness','like','active')->get();

        $packing_items=inventory::with('department','category','color','unit','small_unit','type','size')->where('department_id','3')->where('activeness','like','active')->get();

        return view('production.plan_ticket',compact('plans','raw_items','packing_items','ticket_no'));
    }

    public function save_plan_ticket(Request $request)
    {
        

        $ticket=new Ticket;
         $ticket->ticket_no=$request->get('ticket_no');
        $ticket->ticket_date=$request->get('ticket_date');
        $ticket->batch_size=$request->get('batch_size');
        $ticket->batch_no=$request->get('batch_no');
       
        $ticket->remarks=$request->get('remarks');
        $ticket->plan_id=$request->get('plan_id');
        $item_combine=$request->get('product_item_code');
        $item_combine=explode('_', $item_combine);
        //print_r($item_combine);die;
        $ticket->inventory_id=$item_combine[11];
        $ticket->quantity=$request->get('product_qty');
       
        $ticket->unit=$request->get('product_unit');
        $ticket->pack_size=$request->get('product_pack_size');
         //$ticket->procedure_id=$request->get('procedure_id');

          $ticket->save();



          $items_id=$request->get('items_id');
          $types=$request->get('types');
          $stages_id=$request->get('item_stage_ids');
          $units=$request->get('units');
          $qtys=$request->get('qtys');
          $std_qtys=$request->get('std_qtys');

          $pack_sizes=$request->get('p_s');
          $sorts=$request->get('sort');
          $mfs=$request->get('mf');
          //print_r($items_id);die;
          if($items_id!='')
          {
         for($i=0;$i<count($items_id);$i++)
            {
         $ticket->estimated_material()->attach($items_id[$i] , ['type'=>$types[$i],'is_mf'=>$mfs[$i],'stage_id'=>$stages_id[$i],'unit' => $units[$i] , 'quantity' => $qtys[$i],'std_qty' => $std_qtys[$i] ,'pack_size'=>$pack_sizes[$i], 'sort_order'=>$sorts[$i]  ]);
           }
           }

             $stages=$request->get('stages');
              
               $processes=json_decode($stages);
             
               //$c=$processes[1]->sub_processes;
             //print_r(json_encode($c[0]->sub_processes));die;

             foreach ($processes as $process ) {

             $this->save_ticket_process1($ticket->id,$process,'super_process',0);

             }

          return redirect()->back()->with('success','Ticket Genrated!');
    }

    public function save_ticket_process1($ticket_id,$process,$type,$super_id)
    {
        
        $super_process = new ticket_process;
        $super_process->ticket_id=$ticket_id;
        $super_process->process_id=$process->id;
        $super_process->type=$type;
        $super_process->super_id=$super_id;
        $super_process->is_performed=0;
        $super_process->save();

          
          $std_id=Ticket::find($ticket_id)->get_std_id();
           
           $p_super_id=0;
           if($super_id!=0)
          $p_super_id=ticket_process::find($super_id)->process->id;
     
          if(count($process->parameters)!=0)
          {
            
            foreach ($process->parameters as $key ) {
            
                $ticket_parameter = new ticket_parameter;
              $ticket_parameter->ticket_process_id=$super_process->id;
             $ticket_parameter->parameter_id=$key->id;
                 
                $value=Parameter::find( $key->id); 
                $value=$value->default_value($std_id,$process->id,$p_super_id);  
             $ticket_parameter->value=$value;
              $ticket_parameter->save();

            }
          }

          //save ticket table
          //for table parameter
          $this->save_ticket_table1($ticket_id,$process->id,$p_super_id,$super_process->id);
            $c=$process->sub_processes;
          if(count($c)!=0)
          {
            foreach ($c as $key ) {
            
            $this->save_ticket_process1($ticket_id,$key,'sub_process',$super_process->id);

            }
          }
        
          
    }

    public function save_ticket_table1($ticket_id,$process_id,$super_id,$ticket_process_id)
    { 
        if($super_id==0)
            $super_id=$process_id;

        $tables=Process::find($process_id)->tables;
        
          $std_id=Ticket::find($ticket_id)->get_std_id();


        foreach ($tables as $tab ) {
            
                $table=new ticket_table;
                
                $table->table_id=$tab['id'];
                $table->ticket_id=$ticket_id;

               $table->ticket_process_id=$ticket_process_id;
         
               $table->save();

               foreach ($tab['columns'] as $loc) {

                   $col=new ticket_tbl_column;
                      $col->ticket_table_id=$table->id;
                      $col->table_col_id=$loc->id;
                       $col->save();
              $j=1;
              
                      $count=$tab->default_row_count($std_id,$super_id);
                   //print_r($tab['name'].' '.$count);die;
               for ($k=0;$k<$count;$k++) {

                $r=$loc->default_row_value($tab['id'],$std_id,$super_id,$j);

                $row=new ticket_tbl_row;
                $row->ticket_table_id=$table->id;
                $row->ticket_table_column_id=$col->id;
                $row->value=$r;
               $row->sort_order=$j;
               $row->save();
               $j++;
               }


               }


        }

    }


    public function save_ticket_process($ticket_id,$process,$type,$super_id,$request)
    {
        $k='perform_'.$process['id'];
        $super_process = new ticket_process;
        $super_process->ticket_id=$ticket_id;
        $super_process->process_id=$process->id;
        $super_process->type=$type;
        $super_process->super_id=$super_id;
        //$super_process->process_name=$process->process_name;
        //$super_process->identity=$process->identity;
        //$super_process->sort_order=$process->sort_order;
        //$super_process->qc_required=$process->qc_required;
        $super_process->is_performed=$request->$k;
        $super_process->save();

          
          $super_id=$super_process->id; //ticket_process_id

          
     
          if(count($process->parameters)!=0)
          {
            
            foreach ($process->parameters as $key ) {
              $point='parameter_'.$key['id'];
                $ticket_parameter = new ticket_parameter;
              $ticket_parameter->ticket_process_id=$super_id;
             $ticket_parameter->parameter_id=$key->id;
             //$ticket_parameter->parameter_name=$key->name;
             //$ticket_parameter->identity=$key->identity;
             //$ticket_parameter->type=$key->type;
             //$ticket_parameter->formula=$key->formula;
            //$ticket_parameter->sort_order=$process->sort_order;
            $value=$request->get($point); //print_r(json_encode($value));die;
            if($value==null)
                $value='';
             $ticket_parameter->value=$value;
              $ticket_parameter->save();

            }
          }

          //save ticket table

          $this->save_ticket_table($ticket_id,$process->id,$super_id,$request);

          if(count($process->sub_processes())!=0)
          {
            foreach ($process->sub_processes() as $key ) {
             $p=Process::find($key['id']);
            $this->save_ticket_process($ticket_id,$p,'sub_process',$super_id,$request);

            }
          }
          //else
          //{
            return $super_id;
          //}
    }

    public function save_ticket_table($ticket_id,$process_id,$ticket_process_id,$request)
    {

        $tables=Process::find($process_id)->tables;



        foreach ($tables as $tab ) {
            
          $table=new ticket_table;
                
                $table->table_id=$tab['id'];
                $table->ticket_id=$ticket_id;

              // $table->name=$tab['name'];
               
               //$table->identity=$tab['identity'];
               $table->ticket_process_id=$ticket_process_id;
               //$table->no_of_rows=$tab['no_of_rows'];
               //$table->sort_order=$tab['sort_order'];
         
        
               //$table->remarks=$tab['remarks'];
               //$table->activeness=$tab['activeness'];
               $table->save();

               foreach ($tab['columns'] as $loc) {
//print_r(json_encode($col.' '));die;
                   $col=new ticket_tbl_column;
                      $col->ticket_table_id=$table->id;
                      $col->table_col_id=$loc->id;
               //  $col->heading=$loc['heading'];
               // $col->type=$loc['type'];
               // $col->footer_type=$loc['footer_type'];
               // $col->footer_text=$loc['footer_text'];
               // $col->sort_order=$loc['sort_order'];
               $col->save();
              $j=1;
              $r=$request->get('values_'.$tab['id'].'_'.$loc['id']);

               for ($k=0;$k<count($r);$k++) {
                   $row=new ticket_tbl_row;
                      $row->ticket_table_id=$table->id;
                   $row->ticket_table_column_id=$col->id;
                $row->value=$r[$k];
               $row->sort_order=$j;
               $row->save();
               $j++;
               }


               }


        }

    }

    public function get_plan_items(Request $request)
    {
         
        $plan=Productionplan::find($request->get('plan_id'));
            
            $products=array();
            foreach ($plan->products as $key) {

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

                $std_id=$key['pivot']['std_id'];
                $unit=$key['pivot']['unit'];
                $total_available_qty=$key['pivot']['quantity'];
                $pack_size=$key['pivot']['pack_size'];

                $std_name=ProductionStandard::find($std_id)->std_name;

                $made_qty=Ticket::where('plan_id','like',$plan['id'])->where('inventory_id','like',$item_id)->sum('quantity');
                $rem_qty=$total_available_qty-$made_qty;

                //stages
          //$std_stages=ProductionStandard::find($std_id)->procedure->processes;

                //$pro_name=ProductionStandard::find($std_id)->procedure_id;

                //$procedure=Procedure::getProcedureWithId($pro_name);

                $std=ProductionStandard::find($std_id);

                //$procedure=Procedure::getProcedureWithId($std['procedure_id']);

                $procedure=Procedure::getProcedureForStd($key['procedure_id'],$std['id']);

                $stages=array();
                if(isset($procedure['processes']))
                $stages=$procedure['processes'];
                   //$stages=[];
        //         $stages=array();
        // foreach ($std_stages as $stg ) {

        //     $parameters=array();
        // foreach ($stg->parameters as $key) {
        //     $parameter=array('id'=>$key['id'],'name'=>$key['name'],'sort_order'=>$key['pivot']['sort_order']);
        //     array_push($parameters, $parameter);
        // }
        //   $sort_col  = array_column($parameters, 'sort_order');
        //   array_multisort($sort_col,SORT_ASC,$parameters);
        //   //$parameters->orderBy('sort_order');   
        // $stage=array('id'=>$stg['id'],'process_name'=>$stg['process_name'],'sort_order'=>$stg['pivot']['sort_order'],'qc_required'=>$stg['pivot']['qc_required'],'parameters'=>$parameters);
        //     array_push($stages, $stage);
        // }
        // //end stages


                $product=array('location_id'=>$location_id,'location_text'=>$location_text,'procedure_id'=>$std['procedure_id'],'item_id'=>$item_id,'item_name'=>$item_text,'item_code'=>$item_code,'type'=>$item_type,'category'=>$item_category,'uom'=>$item_uom,'color'=>$item_color,'size'=>$item_size,'std_id'=>$std_id,'std_name'=>$std_name,'unit'=>$unit,'total_available_qty'=>$rem_qty,'pack_size'=>$pack_size,'stages'=>$stages);

                array_push($products, $product);
                
            }

        //print_r(json_encode($standards));die;
             return response()->json($products, 200);
        
    }

    public function get_estimated_material(Request $request)
    {
        $std_id=$request->get('std_id');
        $required_qty=$request->get('qty');
        //plan material
         $std=ProductionStandard::find($std_id);
         $std_items=$std->items;
         $std_batch_size=$std->batch_size;

        $m_items=array();
        foreach ($std_items as $key1 ) {
            
            $m_item_id=$key1['id'];
            $m_item_text=$key1['item_name'];
    
            $m_stage_id=$key1['pivot']['stage_id'];
            if($m_stage_id!='-1')
            {  $m_stage=Process::find($m_stage_id);
               $m_stage_name=$m_stage['process_name']; }
            else
                $m_stage_name='';
            $m_item_uom='';
            if($key1['unit']!='')
                $m_item_uom=$key1['unit']['name'];
            $m_item_smal_uom='';
            if($key1['small_unit']!='')
                $m_item_smal_uom=$key1['small_unit']['name'];
            $m_item_uom_rate=1;
            if($key1['unit_rate']!='')
                $m_item_uom_rate=$key1['unit_rate'];
            

            $m_unit=$key1['pivot']['unit'];
            $s_qty=($key1['pivot']['quantity'] / $std_batch_size) * $m_item_uom_rate ;
            $m_qty=round( ( $key1['pivot']['quantity'] / $std_batch_size  ) * $required_qty , 3) ;
            $m_qty= ( $key1['pivot']['quantity'] / $std_batch_size  ) * $required_qty ;
            $m_pack_size=$key1['pivot']['pack_size'];

            $m_total= $m_qty * $m_pack_size ;

            $m_item=array('item_code'=>$key1['item_code'],'item_id'=>$m_item_id,'item_name'=>$m_item_text,'type'=>$key1['pivot']['type'],'mf'=>$key1['pivot']['is_mf'],'sort'=>$key1['pivot']['sort_order'],'stage_id'=>$m_stage_id,'stage_name'=>$m_stage_name,'item_uom'=>$m_item_uom,'unit'=>$m_unit,'small_qty'=>$s_qty,'qty'=>$m_qty,'pack_size'=>$m_pack_size,'total'=>$m_total);
            array_push($m_items, $m_item);
        }

        //end plan material
        return response()->json($m_items, 200);
    }

    public function plan_ticket_history()
    {
      $tickets=Ticket::orderBy('ticket_no','desc')->get();

      return view('production.plan_ticket_history',compact('tickets'));
    }

    public function edit_plan_ticket($ticket_no)
    {
      $ticket=Ticket::where('ticket_no','like',$ticket_no)->orderBy('created_at','desc')->first();

      $raw_items=inventory::with('department','category','color','unit','small_unit','type','size')->where('department_id','2')->where('activeness','like','active')->get();

        $packing_items=inventory::with('department','category','color','unit','small_unit','type','size')->where('department_id','3')->where('activeness','like','active')->get();
      

      return view('production.edit_plan_ticket',compact('raw_items','packing_items','ticket'));
     
       
    }


    public function update_plan_ticket(Request $request)
    {   
        $batch_close=$request->get('batch_close');
        if($batch_close=='')
            $batch_close=0;
        
        $ticket=Ticket::find($request->ticket_id);
         $ticket->ticket_no=$request->get('ticket_no');
        $ticket->ticket_date=$request->get('ticket_date');
        $ticket->batch_size=$request->get('batch_size');
        $ticket->batch_no=$request->get('batch_no');
       
        $ticket->remarks=$request->get('remarks');
        $ticket->batch_close=$batch_close;
        //$ticket->plan_id=$request->get('plan_id');
        //$item_combine=$request->get('product_item_code');
        //$item_combine=explode('_', $item_combine);
        //print_r($item_combine);die;
       // $ticket->inventory_id=$item_combine[11];
        $ticket->quantity=$request->get('product_qty');
       
        $ticket->unit=$request->get('product_unit');
        $ticket->pack_size=$request->get('product_pack_size');

        $ticket->mrp=$request->get('mrp');
       
        $ticket->mfg_date=$request->get('mfg_date');
        $ticket->exp_date=$request->get('exp_date');


          $ticket->save();



          $items_id=$request->get('items_id');
          $pivots_id=$request->get('pivot_ids');
          
          $stages_id=$request->get('item_stage_ids');
          $units=$request->get('units');
          $qtys=$request->get('qtys');
          $pack_sizes=$request->get('p_s');
         $std_qtys=$request->get('std_qtys');

          $types=$request->get('types');
          $sorts=$request->get('sort');
          $mfs=$request->get('mf');

          $its=ticket_estimated::where('ticket_id',$ticket['id'])->whereNotIn('id',$pivots_id)->get();
           //print_r(json_encode($its));die;
           foreach ($its as $it ) {
               $it->delete();
           }
          
          if($items_id!='')
          {
         
            

           //$rel=array();
            for($i=0;$i<count($items_id);$i++)
            {  
            
                if( $pivots_id[$i] != 0)
           $esti=ticket_estimated::find($pivots_id[$i]);
           else
           $esti=new ticket_estimated;

       $esti->item_id=$items_id[$i];
       $esti->ticket_id=$ticket['id'];
       $esti->stage_id=$stages_id[$i];
       $esti->is_mf=$mfs[$i];
       $esti->unit=$units[$i];
        $esti->std_qty=$std_qtys[$i];
       $esti->quantity=$qtys[$i];
       $esti->pack_size=$pack_sizes[$i];
       $esti->sort_order=$sorts[$i];
       $esti->type=$types[$i];
       
       $esti->save();

              
           }

           
           }
//print_r(json_encode($pivots_id));die;
           


          return redirect()->back()->with('success','Ticket Updated!');
    }

    public function ticket_costing($ticket_id)
    {
       $ticket=Ticket::find($ticket_id);

       return view('production.costing',compact('ticket'));
    }


    public function ticket_stage(Request $request,$ticket_id,$stage_id)
    {
        $ticket_id=$ticket_id;
        $process_id=$stage_id;


        $ticket_process=ticket_process::where('ticket_id',$ticket_id)->where('id',$process_id)->where('super_id',0)->first();
    
        return view('production.ticket_process',compact('ticket_process'));
    }

    public function ticket_stage_save(Request $request)
    {
        $ticket_process_id=$request->get('ticket_process_id');
        
        $k='perform_'.$ticket_process_id;
        $ticket_process=ticket_process::find($ticket_process_id);
        $ticket_process->is_performed=$request->$k;
        $ticket_process->save();

        //print_r($request->get('parameter_231'));die;
        foreach ($ticket_process['ticket_parameters'] as $key ) {
            $index='parameter_'.$key['id'];
            $parameter_value=$request->get($index);
            $parameter=ticket_parameter::find($key['id']);
            $parameter->value=$parameter_value;
            $parameter->save();
        }

        //table start

            /*foreach($ticket_process['tables'] as $tab)
            {
                     $cols=$tab->columns()->select('id')->get();
            $lets=ticket_tbl_row::where( 'ticket_table_id',$tab['id'] )->whereNotIn('ticket_table_column_id', $cols )->get();

            foreach ($lets as $key ) {
                  $key->delete();
              }

                foreach($tab['columns'] as $col)
                {

                    $txt='tbls_'.$tab['id'].'_'.$col['id'];
                 $txt1='cols_'.$tab['id'].'_'.$col['id'];
                  $txt2='sorts_'.$tab['id'].'_'.$col['id'];
                 $txt3='values_'.$tab['id'].'_'.$col['id'];

                $table_ids=$request->$txt;
                 $col_ids=$request->$txt1;
                  $sorts=$request->$txt2;
                 $row_values=$request->$txt3;

                $lets=ticket_tbl_row::where( 'ticket_table_id',$tab['id'] )->where('ticket_table_column_id',$col['id'])->whereNotIn('sort_order', $sorts )->get();
           
              foreach ($lets as $key ) {
                  $key->delete();
              }

              if($sorts!='')
           {
              for ($i=0; $i <count($sorts) ; $i++) { 
                  
                  
             
                 $tbl_id=$table_ids[$i];
                  $col_id=$col_ids[$i];
                  $sort=$sorts[$i];
                  $row_value=$row_values[$i];

            
                  $row=ticket_tbl_row::where('ticket_table_id',$tbl_id)->where('ticket_table_column_id',$col_id)->where('sort_order',$sort)->first();
                  if($row=='')
                     $row=new ticket_tbl_row;
                     $row->ticket_table_id=$tbl_id;
                     $row->ticket_table_column_id=$col_id;
                     $row->value=$row_value;
                     $row->sort_order=$sort;
                      $row->save();

                       }
           }

              // if($col['footer_type']=='sum')
              //  { $sum=$col->default_col_sum($tab['id']);
              //   print_r(json_encode($sum));die;}

                 }//end col
           }//end table foreach */

        foreach ($ticket_process->sub_processes as $proces ) {

            $k='perform_'.$proces['id'];
    
                $proces->is_performed=$request->$k;
                $proces->save();

            foreach ($proces['ticket_parameters'] as $key ) {
            $index='parameter_'.$key['id']; 
            $parameter_value=$request->get($index);
            $parameter=ticket_parameter::find($key['id']);
            $parameter->value=$parameter_value; //print_r($parameter);die;
            $parameter->save();
            }

            //table start

            /*foreach($proces['tables'] as $tab)
            {
                     $cols=$tab->columns()->select('id')->get();
            $lets=ticket_tbl_row::where( 'ticket_table_id',$tab['id'] )->whereNotIn('ticket_table_column_id', $cols )->get();

            foreach ($lets as $key ) {
                  $key->delete();
              }

                foreach($tab['columns'] as $col)
                {

                    $txt='tbls_'.$tab['id'].'_'.$col['id'];
                 $txt1='cols_'.$tab['id'].'_'.$col['id'];
                  $txt2='sorts_'.$tab['id'].'_'.$col['id'];
                 $txt3='values_'.$tab['id'].'_'.$col['id'];

                $table_ids=$request->$txt;
                 $col_ids=$request->$txt1;
                  $sorts=$request->$txt2;
                 $row_values=$request->$txt3;

                $lets=ticket_tbl_row::where( 'ticket_table_id',$tab['id'] )->where('ticket_table_column_id',$col['id'])->whereNotIn('sort_order', $sorts )->get();
           
              foreach ($lets as $key ) {
                  $key->delete();
              }

              if($sorts!='')
           {
              for ($i=0; $i <count($sorts) ; $i++) { 
                  
                  
             
                 $tbl_id=$table_ids[$i];
                  $col_id=$col_ids[$i];
                  $sort=$sorts[$i];
                  $row_value=$row_values[$i];

            
                  $row=ticket_tbl_row::where('ticket_table_id',$tbl_id)->where('ticket_table_column_id',$col_id)->where('sort_order',$sort)->first();
                  if($row=='')
                     $row=new ticket_tbl_row;
                     $row->ticket_table_id=$tbl_id;
                     $row->ticket_table_column_id=$col_id;
                     $row->value=$row_value;
                     $row->sort_order=$sort;
                      $row->save();

                       }
           }

              // if($col['footer_type']=='sum')
              //  { $sum=$col->default_col_sum($tab['id']);
              //   print_r(json_encode($sum));die;}

                 }//end col
           }//end table foreach */
        }
        //return view('production.ticket_process',compact('ticket_process'));
        return redirect()->back()->with('success','Saved Successfully!');
    }

    public function standard_table($std_id,$super_id,$table_id)
    {
            $std=ProductionStandard::find($std_id);
              $super=Process::find($super_id);
              $table=Table::find($table_id);

              return view('production.stages.std_table',compact('std','super','table'));
    }

    public function ticket_table($ticket_id,$super_id,$table_id)
    {
            $ticket=Ticket::find($ticket_id);
              $super=ticket_process::find($super_id);
              $ticket_table=ticket_table::find($table_id);

              return view('production.stages.ticket_table',compact('ticket','super','ticket_table'));
    }

    public function update_ticket_table(Request $request)
    {

        $table_id=$request->table_id;
         
//print_r(json_encode($table_id));die;
          $table=ticket_table::find($table_id);
            
        
                for ($i=0;$i<count($table['columns']);$i++ ) {
                  
                  $col=$table['columns'][$i];

                  $index='col_'.$col['id'];
                  $values=$request->$index;
                  //print_r($values);die;
                  for ($j=0;$j<count($values);$j++ ) {
                  
                  $order=$j+1;
                  $let=ticket_tbl_row::where( 'ticket_table_id',$table_id )->where('ticket_table_column_id',$col['id'])->where('sort_order',$order)->first();
                    if($let=='')
                        $let=new ticket_tbl_row;
                  $let->ticket_table_id=$table_id;
                  $let->ticket_table_column_id=$col['id'];
                   

                  $let->value=$values[$j];
                  $let->sort_order=$order;
                      $let->save();

                   }

                $let=ticket_tbl_row::where( 'ticket_table_id',$table_id )->where('ticket_table_column_id',$col['id'])->where('sort_order','>',count($values))->get();

                foreach ($let as $key ) {
                    $key->delete();
                }

            }

            

       return redirect()->back()->with('success','Table Updated!');
    }

     public function save_standard_table(Request $request)
    {

        $table_id=$request->table_id;
         $std_id=$request->std_id;
          $super_id=$request->super_id;

          $table=Table::find($table_id);
            
        
                for ($i=0;$i<count($table['columns']);$i++ ) {
                  
                  $col=$table['columns'][$i];

                  $index='col_'.$col['id'];
                  $values=$request->$index;
                  //print_r($values);die;
                  for ($j=0;$j<count($values);$j++ ) {
                  
                  $order=$j+1;
                  $let=std_table_row::where( 'table_id',$table_id )->where( 'std_id',$std_id )->where( 'super_id',$super_id )->where('table_column_id',$col['id'])->where('sort_order',$order)->first();
                    if($let=='')
                        $let=new std_table_row;
                  $let->table_id=$table_id;
                  $let->table_column_id=$col['id'];
                   $let->std_id=$std_id;
                  $let->super_id=$super_id;

                  $let->value=$values[$j];
                  $let->sort_order=$order;
                      $let->save();

                   }

                $let=std_table_row::where( 'table_id',$table_id )->where( 'std_id',$std_id )->where( 'super_id',$super_id )->where('table_column_id',$col['id'])->where('sort_order','>',count($values))->get();

                foreach ($let as $key ) {
                    $key->delete();
                }

            }

            

       return redirect()->back()->with('success','Table Updated!');
    }


    public function save_std_parameters(Request $request)
    {
        $std_id=$request->get('std_id');
        $process_id=$request->get('process_id');
        

        $process=Process::find($process_id);
        //print_r($request->get('parameter_33'));die;

        $all_p=array();

        foreach ($process['parameters'] as $key ) {

            $index='parameter_'.$key['id'];
            $parameter_value=$request->get($index);
              $t=Parameter::find($key['id'])->type;
            if($parameter_value=='' || $parameter_value==null || $t=='formula_text' || $t=='formula_show')
                continue;

            $parameter=std_parameter::where('std_id',$std_id)->where('process_id',$process_id)->where('super_id',0)->where('parameter_id',$key['id'])->first();
            if($parameter=='')
                $parameter=new std_parameter;
            
            $parameter->std_id=$std_id;
            $parameter->process_id=$process_id;
            $parameter->super_id=0;
            $parameter->parameter_id=$key['id'];
            $parameter->value=$parameter_value;
            $parameter->save();

            array_push( $all_p, $parameter['id'] );
        }

        $ps=std_parameter::where('std_id',$std_id)->where('process_id',$process_id)->where('super_id',0)->whereNotIn('id',$all_p)->get();
        foreach ($ps as $key ) {
            $key->delete();
        }

        //table start

            

        foreach ($process->sub_stages as $proces ) {
           
           $all_p=array();

            foreach ($proces['parameters'] as $key ) {


                $index='parameter_'.$key['id'];
            $parameter_value=$request->get($index);
             $t=Parameter::find($key['id'])->type;
            if($parameter_value=='' || $parameter_value==null|| $t=='formula_text' || $t=='formula_show')
                continue;

            $parameter=std_parameter::where('std_id',$std_id)->where('process_id',$proces['id'])->where('super_id',$process['id'])->where('parameter_id',$key['id'])->first();
            if($parameter=='')
                $parameter=new std_parameter;

            $parameter->std_id=$std_id;
            $parameter->process_id=$proces['id'];
            $parameter->super_id=$process['id'];
            $parameter->parameter_id=$key['id'];
            $parameter->value=$parameter_value;

            $parameter->save();

             array_push( $all_p, $parameter['id'] );

            } 

            $ps=std_parameter::where('std_id',$std_id)->where('process_id',$proces['id'])->where('super_id',$process['id'])->whereNotIn('id',$all_p)->get();
        foreach ($ps as $key ) {
            $key->delete();
        }

    

            
        }

           
        return redirect()->back()->with('success','Saved Successfully!');
    }

    public function production_entry($ticket_id='')
    {    
        $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        $code="PR-".Date("y")."-";
        $num=1;

         $plan=Production::select('id','code')->where('code','like',$code.'%')->latest()->first();
         if($plan=='')
         {
              $let=sprintf('%03d', $num);
              $code=$code. $let;
         }
         else
         {
            $let=explode($code , $plan['code']); 
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $code=$code. $let;
         }

        if($ticket_id=='')
        {
            //$ticket=Ticket::find($ticket_id);
           return view('production.production_entry',compact('departments','code'));
        }
        else
        {
            $ticket=Ticket::find($ticket_id);
        return view('production.production_entry',compact('ticket','departments','code'));
        }
    }

    public function edit_production_entry($production_id)
    {
        $production=Production::find($production_id);
        $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        return view('production.production_entry_edit',compact('production','departments'));
    }

    public function save_production_entry(Request $request)
    {   
        $active=$request->activeness;
        if($active=='')
            $active=0;

        $production_id=$request->production_id;
        if($production_id=='')
        $production=new Production;
        else
            $production=Production::find($production_id);
        
        if($request->ticket_id!='')
        $production->ticket_id=$request->ticket_id;

        $production->item_id=$request->item;
        $production->code=$request->code;
        $production->qty=$request->qty;
        $production->unit=$request->unit;
        $production->pack_size=$request->p_s;
        $production->production_date=$request->production_date;

        $production->batch_no=$request->batch_no;
        $production->mrp=$request->mrp;
        $production->mfg_date=$request->mfg_date;
        $production->exp_date=$request->exp_date;
        $production->cost_price=$request->cost_price;
        $production->activeness=$active;
        $production->save();

        $qty=$production->qty * $production->pack_size;
          $amount=$production->cost_price * $qty;
        
        $item=inventory::find($production->item_id);
        $depart=InventoryDepartment::find($item['department_id'])->account_id;

        $transections=$production->transections;
             $no=0;   
           if($no < count($transections))
            { $trans=$transections[$no]; }
                   else
                   $trans=new Transection;

          
           
          
           $trans->account_voucherable_id=$production->id;
           $trans->account_voucherable_type='App\Models\Production';
           $trans->account_id=$depart;
          // $trans->corporate_id=$item['id'];
           $trans->remarks='Production Entry '.$item['item_name'].' :( '.$qty.'x'.$production->cost_price.')';
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();

           $no++;
                  //print_r(json_encode(count($transections)));die;
           for($k=$no; $k < count($transections); $k++ )
           {
             
               $transections[$k]->delete();
           }



       return redirect(url('edit/production-entry/'.$production->id))->with('success','Saved Successfully!');
    }

    public function update_production_entry(Request $request)
    {
        $production_id=$request->production_id;
        if($production_id=='')
        $production=new Production;
        else
            $production=Production::find($production_id);

        $production->ticket_id=$request->ticket_id;
        $production->item_id=$request->item_id;
        $production->qty=$request->qty;
        $production->unit=$request->unit;
        $production->pack_size=$request->p_s;
        $production->production_date=$request->production_date;
         $production->cost_price=$request->cost_price;
        $production->batch_no=$request->batch_no;
        $production->mrp=$request->mrp;
        $production->mfg_date=$request->mfg_date;
        $production->exp_date=$request->exp_date;
        $production->save();

        $qty=$production->qty * $production->pack_size;
          $amount=$production->cost_price * $qty;
        
        $item=inventory::find($production->item_id);
        $depart=InventoryDepartment::find($item['department_id'])->account_id;
           
           $transections=$production->transections; print_r($transections);die;
             $no=0;
           if($no < count($transections))
            { $trans=$transections[$no]; }
                   else
                   $trans=new Transection;

           $trans->account_voucherable_id=$production->id;
           $trans->account_voucherable_type='App\Models\Production';
           $trans->account_id=$depart;
          // $trans->corporate_id=$item['id'];
           $trans->remarks='Production Entry '.$item['item_name'].' :( '.$qty.'x'.$production->cost_price.')';
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();
             
             $no++;

           for($k=$no; $k < count($transections); $k++ )
           {
             
               $transections[$k]->delete();
           }


       return redirect()->back()->with('success','Saved Successfully!');
        
    }

    public function production_history()
    {
        $productions=Production::orderBy('code','desc')->get();
        return view('production.production_history' ,compact('productions'));

    }

    public function production_entry_list($ticket_id)
    {
        $ticket=Ticket::find($ticket_id);
        $productions=Production::where('ticket_id',$ticket_id)->orderBy('code','desc')->get();
        return view('production.production_history' ,compact('productions','ticket'));

    }

    public function select_batch_stage()
    {
        $batches=Ticket::where('batch_close','0')->get();

         return view('production.stages.select_stage' ,compact('batches'));

    }

    public function get_ticket_stages(Request $request)
    {
        $ticket_id=$request->ticket_id;

         $ticket=Ticket::find($ticket_id);

         $processes=[];
         $pro=inventory::find($ticket['inventory_id'])->procedure;
         if($pro!='')
         $processes=$pro->processes;

         return response()->json($processes, 200);

    }

    public function selected_batch_stage(Request $request)
    {
        $ticket_id=$request->ticket_id;

        $stage_id=$request->stage_id;

        $ticket=Ticket::find($ticket_id);

        $process=Process::find($stage_id);
                  
        //print_r(json_encode($process['parameters']));  die;
         

         return view('production.stages.create_batch_stage',compact('ticket','process'));

    }

    public function save_initiate_stage(Request $request)
    {
        $ticket_id=$request->ticket_id;

        $stage_id=$request->process_id;

        $ticket=Ticket::find($ticket_id);

        $process=Process::find($stage_id);

        $super_id=$this->save_ticket_process($ticket_id,$process,'super_process',0,$request);
                //  die;
        //print_r(json_encode($request->parameter_61));  die;
         
         return redirect(url('plan-ticket/stage/'.$ticket_id.'/'.$super_id))->with('success','Process Genrated!');

         return view('production.stages.create_batch_stage',compact('ticket','process'));

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function show(Production $production)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Production $production)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Production $production)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        //
    }

        


    


}
