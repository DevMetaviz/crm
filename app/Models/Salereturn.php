<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salereturn extends Model
{
    use HasFactory;

     


    public function items()
    {
        //return $this->belongsToMany(inventory::class,'sale_return_item','return_id','item_id')->withPivot('id','sale_stock_id','unit','qty','pack_size','mrp','business_type','batch_no','expiry_date','discount_type','discount_factor','tax')->withTimestamps();

        return $this->belongsToMany(inventory::class,'sale_return_item','return_id','item_id')->withPivot('id','qty','rate','discount','unit_weight','unit_feet','pricing_by','rack','rack_qty')->withTimestamps();

    }

    public function return_list()
    {
        return $this->hasMany('App\Models\salereturn_ledger','return_id','id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

     public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

     public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function transections()
    {
        return $this->morphMany(Transection::class, 'account_voucherable');
    }

     public function sale()
    {
        return $this->belongsTo('App\Models\Sale','invoice_id');
    }

    public function total_qty()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
            $total += $item['pivot']['qty']  ;
        }

        return $total ;
    }

     public function total_weight()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
         $total += $item['pivot']['qty'] * $item['pivot']['unit_weight'] ;
        }

        return $total ;
    }

    public function item_names()
    {
        $names = '';

        $i=1; $count= count($this->items);
        foreach ($this->items as $item ) {
            
            $names  = $names . $item['item_name'] ;
             
             if( $i!= $count )
               $names  = $names . ' , ' ;

            $i++;
        }

        return $names ;
    }

     public function total_items_amount()
    {
        $total = 0;

        foreach ($this->items as $item ) {
            

                $amount=$this->item_amount($item['id'],$item['pivot']['id']);
              

              
              $total= $total + $amount;

        }

        return $total ;
    }

    public function total_amount()
    {
        

        $amount=$this->total_items_amount();
        // $gst=$this->gst_amount();
        // $exp=$this->expense_amount();
        //$total=$amount+$gst+$exp;

         // $freight_charges=$this->freight_charges ?? 0;
          //$loading_charges=$this->loading_charges ?? 0;

          $total= $amount ; //+ $freight_charges + $loading_charges;
           
        return $total ;
    }




     public function rate($item_id,$pivot_id)
    {
              $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();
              $item_count=count( $this->items );

               $discount = $item['pivot']['discount'] ?? 0; 
               $rate = $item['pivot']['rate'] ?? 0; 

               $d=($discount / 100) *  $rate;

                $rate=$rate + $d ;

              
                                      
                       $rate=round( $rate ,2 );

                   return $rate;

    }

    public function item_amount($item_id,$pivot_id)
    {
        $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();
 
         $qty=$item['pivot']['qty'] ?? 0;

        $discount = $item['pivot']['discount'] ?? 0; 
        $rate = $item['pivot']['rate'] ?? 0; 

         $d=($discount / 100) *  $rate;

         $rate = $rate + $d;



        $unit_weight=$item['pivot']['unit_weight'] ?? 0;
        $unit_feet=$item['pivot']['unit_feet'] ?? 0;

        $pricing_by=$item['pivot']['pricing_by'] ?? '';
  


        $total_weight=$unit_weight*$qty;
        $total_feet=$unit_feet*$qty;

        $amount=0;

        if($pricing_by=='weight')
            $amount= $total_weight * $rate;
        elseif($pricing_by=='feet')
            $amount= $total_feet * $rate;

       
            
                                      
                       $amount=round( $amount ,2 );

                   return $amount;

    }

}
