<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productionplan extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(inventory::class,'plan_product','plan_id','item_id')->withPivot('id','stage_id','unit','qty','pack_size','sort_order','is_mf')->withTimestamps();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'plan_id');
    }

    public function issuances()
    {
        return $this->hasMany(Issuance::class,'plan_id');
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class,'plan_id');
    }


    public function issued_items()
    {
        return $this->hasManyThrough(item_issuance::class, Issuance::class,'plan_id','issuance_id','id','id');
    }

    public function demand()
    {
        return $this->belongsTo(ProdDemand::class,'demand_id');
    }

    public function product()
    {
        return $this->belongsTo(inventory::class,'product_id');
    }

    public static function plans_with_short()
    {
        $plns=Productionplan::where('demand_id','<>',0)->orderBy('plan_no','desc')->get();
             $plans=[];
            foreach ($plns as $pn) {

              $plan_items=array();
        
        foreach ($pn['items'] as $key ) {
           
            
           
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
             
            $item=array('item_id'=>$item_id,'item_name'=>$item_name,'sort'=>$key['pivot']['sort_order'] ,'mf'=>$mf,'stage_id'=>$stage_id,'stage_name'=>$stage_name,'item_uom'=>$item_uom,'unit'=>$unit,'qty'=>$qty,'pack_size'=>$pack_size,'total'=>$total);

         
            array_push($plan_items, $item);
          

        }
              


              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'batch_start_date'=>$pn['batch_start_date'],'batch_due_date'=>$pn['batch_due_date'],'mrp'=>$pn['mrp'],'items'=>$plan_items];
              array_push($plans, $plan);
            }

            return $plans;
    }

    public static function plans_with_rem()
    {
        $plns=Productionplan::where('is_closed','0')->orderBy('plan_no','desc')->get();
             $plans=[];
            foreach ($plns as $pn) {

              $plan_items=array();
        
        foreach ($pn['items'] as $key ) {
             
          
           
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

             $pn_issued=$pn->issued_items()->where('item_id',$key['id'])->sum(\DB::raw('quantity * pack_size'));
             if($unit=='loose')
             {
                $qty=$qty-$pn_issued;
             }
             else
             {
                if($pn_issued!=0)
                {
                    $unit='loose'; $pack_size=1;
                    $qty=($qty*$pack_size)-$pn_issued;
                }
             }
              
             $mf=$key['pivot']['is_mf'];

            $total=$qty * $pack_size ;
             
             if($total<=0)
                continue;

            $item=array('item_id'=>$item_id,'item_name'=>$item_name,'sort'=>$key['pivot']['sort_order'] ,'mf'=>$mf,'stage_id'=>$stage_id,'stage_name'=>$stage_name,'item_uom'=>$item_uom,'unit'=>$unit,'qty'=>$qty,'pack_size'=>$pack_size,'total'=>$total);

         
            array_push($plan_items, $item);
          

        }
              


              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'batch_start_date'=>$pn['batch_start_date'],'batch_due_date'=>$pn['batch_due_date'],'mrp'=>$pn['mrp'],'items'=>$plan_items];
              array_push($plans, $plan);
            }

            return $plans;
    }

    public function transfer_note()
    {
      return $this->hasOne('App\Models\Goods_Yield','plan_id','id');
    }

    public function granulation()
    {

        return $this->hasOne('App\Models\Granulation','plan_id','id');
    }

    public function compression()
    {

        return $this->hasOne('App\Models\Compression','plan_id','id');
    }

    public function coating()
    {

        return $this->hasOne('App\Models\Coating','plan_id','id');
    }

    public function blistering()
    {

        return $this->hasOne('App\Models\Blistering','plan_id','id');
    }


    public function dispensing()
    {

        return $this->hasOne('App\Models\Dispensing','plan_id','id');
    }

    public function raw_items()
    {
        $plan_items=array();
        
        foreach ($this['items']->where('department_id','2') as $key ) {
           
            
           
            $item_id=$key['id'];
            $item_name=$key['item_name'];
    
            $stage_id=-1;
            
                $stage_name='';
            $item_uom='';
            if($key['unit']!='')
                $item_uom=$key['unit']['name'];
           

            $req_qty=$key['pivot']['qty'] * $key['pivot']['pack_size'];

            $pn_issued=$this->issued_items->where('item_id',$key['id']);
          
            $iss_qty=0; $grn=''; $qc=''; $n=count( $pn_issued); $i=0;
             foreach($pn_issued as $k ) {
               
                $iss_qty=($k['quantity'] * $k['pack_size'])+$iss_qty;

               if($k['grn_no']!='')
               {
                  $c='';
                   if($i!=$n-1)
                    $c=',';
               $grn=$grn.$k['grn_no'].$c;
               }

               if($k['qc_no']!='')
               {
                  $c='';
                   if($i!=$n-1)
                    $c=',';
               $qc=$qc.$k['qc_no'].$c;
               }
                   
                   $i++;
                
            }
             
            $item=array('item_id'=>$item_id,'item_name'=>$item_name,'stage_id'=>$stage_id,'stage_name'=>$stage_name,'item_uom'=>$item_uom,'req_qty'=>$req_qty,'iss_qty'=>$iss_qty,'grn'=>$grn,'qc'=>$qc);
            
         
            array_push($plan_items, $item);
          

        }

        return $plan_items;
    }

}
