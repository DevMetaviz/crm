<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(inventory::class,'inventory_requisition','requisition_id','item_id')->withPivot('id','stage_id','unit','quantity','approved_qty','pack_size')->withTimestamps();
    }

    public function item_list()
    {
        return $this->hasMany(requisition_item::class,'requisition_id','id');
    }
    public function product()
    {
             return $this->belongsTo('App\Models\inventory','product_id');
    }


    public function department()
    {
             return $this->belongsTo('App\Models\InventoryDepartment','department_id');
    }

    public function plan()
    {
             return $this->belongsTo('App\Models\Productionplan','plan_id');
    }

    public function ticket()
    {
             return $this->belongsTo('App\Models\Ticket','batch_no','batch_no');
    }

    public function issuances()
    {
        return $this->hasMany(Issuance::class);
    }

    public static function getProductsForReq($type,$id='')
    {
              $batch_no=''; $product_id='';

              if($id!='')
              {
                  if($type=='request')
                  {
                     $let=Requisition::find($id);
                  }
                  elseif($type=='issue')
                  {
                      $let=Issuance::find($id);
                  }
                  $batch_no=$let['batch_no']; $product_id=$let['product_id'];
              }

        $products=array();

        $prods=inventory::with('product_tickets','product_tickets.estimated_material')->where('department_id','1')->where('activeness','like','active')->orWhere(function($q) use($product_id){
               if($product_id!='')
                $q->where('id',$product_id);
        })->orderBy('item_name')->get();

          foreach ($prods as $key ) {
            
            $batches=[];

        //     $ticks=$key['product_tickets']->where('batch_close','0')->orWhere(function($q) use($batch_no){
        //        if($batch_no!='')
        //         $q->where('batch_no',$batch_no);
        // });

            $ticks=Ticket::where('inventory_id',$key['id'])->where('batch_close','0')->orWhere(function($q) use($batch_no){
               if($batch_no!='')
                $q->where('batch_no',$batch_no);
        })->get();

            foreach ($ticks as $bt) {
                
                $batch_no=$bt['batch_no'];
                $batch_size=$bt['batch_size'];
                $mts=$bt['estimated_material'];
                 
                 $estimated_material=[];
                foreach ($mts as $mt) {
                  $uom='';
               if($mt['unit']!='')
                   $uom=$mt['unit']['name'];

                 $stage_text=Process::find($mt['pivot']['stage_id']);
                 if($stage_text!='')
                  $stage_text=$stage_text['process_name'];
                 else
                  $stage_text='';

                  $qty=$mt['pivot']['quantity']; $p_s=$mt['pivot']['pack_size'];
                  $t=$qty * $p_s;      
                  $issued=$bt->item_issued_qty($mt['id'],$mt['pivot']['stage_id']);
                  $rem=$t - $issued; 
                  if($rem<=0)
                    continue;
                  $rem_qty=$rem/$p_s;

                  $t=array('id'=>$mt['id'],'department_id'=>$mt['department_id'],'item_name'=>$mt['item_name'],'item_code'=>$mt['item_code'],'item_uom'=>$uom,'unit'=>$mt['pivot']['unit'],'pack_size'=>$p_s,'qty'=>$rem_qty,'stage_id'=>$mt['pivot']['stage_id'],'stage_text'=>$stage_text);
                  array_push($estimated_material, $t);
                }

                $batch=['batch_no'=>$batch_no,'batch_size'=>$batch_size,'estimated_material'=>$estimated_material,'procedure'=>$bt->getProcedure()];
              array_push($batches, $batch);
            }
               

        $let=array('id'=>$key['id'],'item_name'=>$key['item_name'],'batches'=>$batches);

            array_push($products, $let);
          }

          return $products;
    }

   


}
