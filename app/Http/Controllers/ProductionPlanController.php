<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use App\Models\Productionplan;
use App\Models\inventory;
use App\Models\InventoryDepartment;
use App\Models\ProductionStandard;
use App\Models\ProdDemand;
use App\Models\plan_item;
use PDF;

class ProductionPlanController extends Controller
{
    


public function create()
    {
        
       $plan_no="PN-".Date("y")."-";
        $num=1;

         $plan=Productionplan::select('id','plan_no')->where('plan_no','like',$plan_no.'%')->latest()->first();
         if($plan=='')
         {
              $let=sprintf('%05d', $num);
              $plan_no=$plan_no. $let;
         }
         else
         {
            $let=explode($plan_no , $plan['plan_no']); 
            $num=intval($let[1]) + 1;
            $let=sprintf('%05d', $num);
              $plan_no=$plan_no. $let;
         }

        
           
           $demands=ProdDemand::doesnthave('plan')->get();

           // $demands=array();

           // foreach ($dmds as $dmd) {

           //  $p_q=$dmd['product']['pack_size_qty'];
           //  $d_qty=$dmd['qty'];
           //  $d_bs=$p_q * $d_qty;

           //  $std=ProductionStandard::with('items')->where('master_article_id',$dmd['product_id'])->first();
           //  $bs=$std['batch_size'];
            
           //  $items=[];

           //  foreach ($std['items'] as $key ) {

           //      $item_id=$key['id'];
           //  $item_name=$key['item_name'];
    
           //  $stage_id=-1;
           //  $stage_name='';

           //  $item_uom='';
           //  if($key['unit']!='')
           //      $item_uom=$key['unit']['name'];
           

           //  $unit=$key['pivot']['unit'];
           //  $qty=$key['pivot']['quantity'];
           //    $qty  =round( ($qty/$bs) * $d_bs ,4);
           //  $pack_size=$key['pivot']['pack_size'];

           //   $mf=$key['pivot']['is_mf'];

           //  $total=round( $qty * $pack_size, 4 );
              
           //  $item=array('item_id'=>$item_id,'item_name'=>$item_name,'sort'=>$key['pivot']['sort_order'] ,'mf'=>$mf,'stage_id'=>$stage_id,'stage_name'=>$stage_name,'item_uom'=>$item_uom,'unit'=>$unit,'qty'=>$qty,'pack_size'=>$pack_size,'total'=>$total);

          
           //  array_push($items, $item);

           //  }

           //  $std=['batch_size'=>$d_bs,'items'=>$items];

           //  $uom='';
           //  if(isset($dmd['product']['unit']['name']))
           //      $uom=$dmd['product']['unit']['name'];
               
           //     $demand=['id'=>$dmd['id'],'doc_no'=>$dmd['doc_no'],'item_id'=>$dmd['product_id'],'item_name'=>$dmd['product']['item_name'],'pack_size'=>$dmd['product']['pack_size'],'pack_size_qty'=>$dmd['product']['pack_size_qty'],'qty'=>$dmd['qty'],'uom'=>$uom , 'batch_size'=>$d_bs,'std'=>$std];

           //     array_push($demands, $demand);
           // }

           $departs=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->select('id','name')->get();

      $departments=[];
       foreach ($departs as $dpt) {
         
         
         $its=inventory::where('department_id',$dpt['id'])->where('activeness','like','active')->get();
            $items=[];
         foreach ($its as $key ) {
             
             $uom='';
             if(isset($key['unit']['name']))
                $uom=$key['unit']['name'];

        $it=['id'=>$key['id'],'item_name'=>$key['item_name'],'unit'=>$uom,'pack_size'=>$key['pack_size'],'pack_size_qty'=>$key['pack_size_qty']];

             array_push($items, $it);
         }

         $dt=['id'=>$dpt['id'],'name'=>$dpt['name'],'items'=>$items];

         array_push($departments, $dt);
       }

        return view('production.plan.create',compact('departments','plan_no','demands'));
    }


    public function store(Request $request)
    {
       

        $items_id=$request->items_id;

        $item_stages_id=$request->item_stage_ids;
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;
        $sorts=$request->sort;
        $mfs=$request->mf;
//print_r($items_id);die;
        
             $is_closed=$request->get('is_closed');
             if($is_closed=='')
              $is_closed=0;

        $std=new Productionplan;
        $std->plan_no=$request->get('plan_no');
        //$std->text=$request->get('text');
        $std->plan_date=$request->get('plan_date');
         $std->demand_id=$request->get('demand_id');
          $std->product_id=$request->get('product_id');
           $std->batch_qty=$request->get('batch_qty');
            $std->batch_size=$request->get('batch_size');
        //$std->start_date=$request->get('start_date');
       
        $std->remarks=$request->get('remarks');
        $std->is_closed=$is_closed;
        //$std->complete_date=$request->get('complete_date');

          $std->save();

         for($i=0;$i<count($items_id);$i++)
            {
         $std->items()->attach($items_id[$i] , ['is_mf'=>$mfs[$i],'stage_id'=>$item_stages_id[$i],'unit' => $units[$i] , 'qty' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i] ,'sort_order'=>$sorts[$i]   ]);
           }


           


                  return redirect()->back()->with('success','Plan saved!');

    }

    public function index(Request $request)
    {
        $mfg_from=$request->mfg_from;
        $mfg_to=$request->mfg_to;
         

        $plans=Productionplan::where(function($q)use ($mfg_from,$mfg_to){
          if($mfg_from!='')
            $q->where('mfg_date','>=',$mfg_from);
          if($mfg_to!='')
            $q->where('mfg_date','<=',$mfg_to);
        }
        )->orderBy('mfg_date','desc')->get();


          
        return view('production.plan.index',compact('plans','mfg_from','mfg_to'));
    }

    public function edit($plan_no)
    {
        
     $plan=Productionplan::where('plan_no','like',$plan_no)->first();

     $plan_items=array();
        
        foreach ($plan['items'] as $key ) {
           
            $item_id=$key['id'];
            $item_name=$key['item_name'];
    
            $stage_id=-1;
            
                $stage_name='';
            $item_uom='';
            if($key['unit']!='')
                $item_uom=$key['unit']['name'];
           

            $unit=$key['pivot']['unit'];
            $qty=$key['pivot']['qty'];
            $pack_size=$key['pivot']['pack_size'];

             $mf=$key['pivot']['is_mf'];

            $total=$qty * $pack_size ;
             
            $item=array('pivot_id'=>$key['pivot']['id'],'item_id'=>$item_id,'item_name'=>$item_name,'sort'=>$key['pivot']['sort_order'] ,'mf'=>$mf,'stage_id'=>$stage_id,'stage_name'=>$stage_name,'item_uom'=>$item_uom,'unit'=>$unit,'qty'=>$qty,'pack_size'=>$pack_size,'total'=>$total);

         
            array_push($plan_items, $item);
          

        }
         
          
         $demands=ProdDemand::doesnthave('plan')->orWhere('id',$plan['demand_id'])->get();


         $std=ProductionStandard::where('master_article_id',$plan['product_id'])->first();
           
            
            $items=[];
             $bs=0;

             if(isset($std['items']))
             {
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
             $bs=$std['batch_size'];
           }

               $std=['batch_size'=>$bs,'items'=>$items];

           
           $departs=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->select('id','name')->get();

      $departments=[];
       foreach ($departs as $dpt) {
         
         
             
         $its=inventory::where('department_id',$dpt['id'])->where('activeness','like','active')->get();
            $items=[];
         foreach ($its as $key ) {
             
             $uom='';
             if(isset($key['unit']['name']))
                $uom=$key['unit']['name'];

        $it=['id'=>$key['id'],'item_name'=>$key['item_name'],'unit'=>$uom,'pack_size'=>$key['pack_size'],'pack_size_qty'=>$key['pack_size_qty']];

             array_push($items, $it);
         }

         $dt=['id'=>$dpt['id'],'name'=>$dpt['name'],'items'=>$items];

         array_push($departments, $dt);
       }

        return view('production.plan.edit',compact('demands','departments','plan','plan_items','std'));
    }


    public function update(Request $request)
    {
       
         $items_id=$request->items_id;
        $pivots_id=$request->get('pivot_ids');
        
        $item_stages_id=$request->item_stage_ids;
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;
        $sort=$request->sort;
        $mf=$request->mf;

        $is_closed=$request->get('is_closed');
             if($is_closed=='')
              $is_closed=0;

        $std=Productionplan::find($request->get('id'));
        $std->plan_no=$request->get('plan_no');
        //$std->text=$request->get('text');
        $std->plan_date=$request->get('plan_date');
         $std->demand_id=$request->get('demand_id');
          $std->product_id=$request->get('product_id');
           $std->batch_qty=$request->get('batch_qty');
            $std->batch_size=$request->get('batch_size');

             $std->batch_no=$request->get('batch_no');
          $std->mfg_date=$request->get('mfg_date');
           $std->exp_date=$request->get('exp_date');
            $std->mrp=$request->get('mrp');
        //$std->start_date=$request->get('start_date');
        $std->is_closed=$is_closed;
        $std->remarks=$request->get('remarks');
        //$std->complete_date=$request->get('complete_date');

          $std->save();
          $lets=[];
          if($pivots_id!='')
         $lets=plan_item::where('plan_id',$std['id'])->whereNotIn('id',$pivots_id)->get();

          foreach ($lets as $key ) {
              $key->delete();
          }
        //$rel=array();
          if($items_id!='')
           {
            for($i=0;$i<count($items_id);$i++)
            {  

                
                if($pivots_id[$i] != 0)
           $esti=plan_item::find($pivots_id[$i]);
           else
           $esti=new plan_item;

       $esti->item_id=$items_id[$i];
       $esti->plan_id=$std['id'];
    
        $esti->is_mf=$mf[$i];
       $esti->stage_id=$item_stages_id[$i];
       $esti->unit=$units[$i];
       $esti->qty=$qtys[$i];
       $esti->pack_size=$pack_sizes[$i];
       $esti->sort_order=$sort[$i];
       $esti->save();

               
           }
            }
           


                  return redirect()->back()->with('success','Plan updated!');

    }



    public function print_plan(Productionplan $plan)
    {
        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

        $data = [
            
            'plan'=>$plan,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
       
        
           view()->share('production.plan.print_plan',$data);
        $pdf = PDF::loadView('production.plan.print_plan', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('plan.pdf');

    }


    public function print_plan_bmr(Productionplan $plan)
    {
        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

        $data = [
            
            'plan'=>$plan,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
       
        
           view()->share('production.plan.print_plan_bmr',$data);
        $pdf = PDF::loadView('production.plan.print_plan_bmr', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('plan.pdf');

    }



   public function select_batch_stage()
    {
      $plans=Productionplan::plans_with_short();

         return view('production.plan.stages.select' ,compact('plans'));

    }

      
      public function destroy(Productionplan $plan)
      {
        //$challan=Deliverychallan::where('order_id',$order['id'])->first();


        if($plan['transfer_note']!='')
        return redirect()->back()->withErrors(['error'=>'Delete Transfer Note first, than Plan!']);

      //print_r($plan['issuances']);die;

         if(count($plan['issuances'])!=0 || count($plan['requisitions'])!=0)
        return redirect()->back()->withErrors(['error'=>'Delete Requests / Issuances first, than Plan!']);


         $plan->items()->detach();
         $plan->delete();

        return redirect(url('production-plan'))->with('success','Plan Deleted!');
      }



}
