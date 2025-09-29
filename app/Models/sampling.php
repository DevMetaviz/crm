<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sampling extends Model
{
    use HasFactory;



   public function qc_requestable()
    {
        return $this->morphTo();
    }

    public function qc_report()
    {
        return $this->belongsTo(qc_report::class,'id','qa_sample_id'); //sampling_id
    }

    // public function item()
    // {
    //     //return $this->belongsTo(inventory::class,'item_id');

    //     //return $this->hasOneThrough(inventory::class, Stock::class,'id','id','grn_no','item_id');
    //      //return $this->belongsToThrough(inventory::class, Stock::class);
    // }

    public function stock()
    {
        return $this->belongsTo(Stock::class,'grn_no','grn_no');
    }


    public function plan()
    {
        return $this->belongsTo(Productionplan::class,'plan_id');
    }

    public static function departments_with_items_with_qty($criteria='')
    {   
        $grs=[];  $plan_id=''; $process='';

        if(isset($criteria['grs']))
           { $grs=$criteria['grs'];   }

       if(isset($criteria['plan_id']))
           { $plan_id=$criteria['plan_id'];   }

       if(isset($criteria['process']))
           { $process=$criteria['process'];   }
            
        $departs=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->select('id','name')->get();

      $departments=[];
       foreach ($departs as $dpt) {
         
         
             
         $its=inventory::where('department_id',$dpt['id'])->where('activeness','like','active')->get();
            $items=[];
         foreach ($its as $key ) {
             
             $uom='';
             if(isset($key['unit']['name']))
                $uom=$key['unit']['name'];
                
               
                     $let_grns=$key->getCurrentGrnsExcept($grs);
                     $grns=[];
                     foreach ($let_grns as $k) {
                         $q=$k['qty'];
                         $g=$k['grn_no'];

                         $s=Stock::where('grn_no',$g)->first();
                          $o='';
                          if($s['origin']!='')
                          $o=$s['origin']['name'];

                          $v='';
                          if(isset($s['grn']['vendor']['name']))
                          $v=$s['grn']['vendor']['name'];

                         array_push($grns,['grn_no'=>$g,'qty'=>$q,'batch_no'=>$s['batch_no'],'mfg_date'=>$s['mfg_date'],'exp_date'=>$s['exp_date'],'origin'=>$o,'vendor'=>$v,'no_of_container'=>$s['no_of_container'],'type_of_container'=>$s['type_of_container'],'content_of_container'=>$key['item_name'],'total_qty'=>$q]);
                     }
                    
                    $pros=[];
                     if($key['procedure']!='')
                 $pros=$key['procedure']->get_processes();

             $let_plans=Productionplan::where('demand_id','<>','0')->where('product_id',$key['id'])->where('batch_no','<>',null)->orWhere('id',$plan_id)->get();
               $processes=[]; $plans=[];
             foreach ($let_plans as $plan) {
                 foreach ($pros as $p) {
                     $b='true';
                    //$b1=sampling::where('samplable_id',$plan['id'])->where('process',$p)->first();
                     $b1='';
                    if($b1!='')
                        $b='false';
                    if($process!='' && $process==$p)
                        $b='true';

                     if($plan[$p]!='' && $b=='true')
                       { 
                        array_push($processes, $p); 
                       }
                 }
                 array_push($plans, ['id'=>$plan['id'],'plan_no'=>$plan['plan_no'],'batch_no'=>$plan['batch_no'],'batch_size'=>$plan['batch_size'],'mfg_date'=>$plan['mfg_date'],'exp_date'=>$plan['exp_date'],'processes'=>$processes]);
             }
//print_r($grns);die;

        $it=['id'=>$key['id'],'item_name'=>$key['item_name'],'unit'=>$uom , 'grns'=>$grns ,'plans'=>$plans];

             array_push($items, $it);
         }

         $dt=['id'=>$dpt['id'],'name'=>$dpt['name'],'items'=>$items];

         array_push($departments, $dt);
       }

       return $departments;
    }


    public static function get_sampling($qc_request_id)
    {

    	$key=sampling::find($qc_request_id);

        $sample_qty=''; $stock_id=''; $stock='';
            //print_r(json_encode($key['stock']));die;
                    $qa_samplable_id=$key->qa_samplable_id;
                    $sample_qty=$key->sample_qty;
                    $stock_id=$key['stock']['id'];

                    $stock=Stock::getStock($stock_id);
                    $result=$key->qc_report;

                    //$result=array('id'=>1);
                
                $request=array('sampling_id'=>$key['id'] , 'qa_samplable_id'=>$qa_samplable_id ,'sampling_no'=>$key['sampling_no'],'type'=>$key['type'],'sampling_date'=>$key['sampling_date'],'sampling_time'=>$key['sampling_time'],'received_date'=>$key['received_date'],'received_time'=>$key['received_time'],'received'=>$key['is_received'],'verified'=>$key['verified'],'remarks'=>$key['remarks'],'total_qty'=>$key['total_qty'],'sample_qty'=>$sample_qty,'stock_id'=>$stock_id,'stock'=>$stock,'result'=>$result);

                return $request;
    }

    
}
