<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class outgoing_stock extends Model   //it is for delivery chall items (customer store)
{
    use HasFactory;
    protected $table = 'delivery_item';
    protected $appends = ['rate','discount_value','total_qty','amount'];
 


    public function item()
    {

        return $this->belongsTo('App\Models\inventory','item_id');
    }

     public function order_item()
    {

        return $this->belongsTo('App\Models\order_item','order_item_id');
    }

      public function challan()
    {

        return $this->belongsTo('App\Models\Deliverychallan','challan_id');
    }

    public function getTotalQtyAttribute()
    {
      return $this->total_qty();
    }

    public function total_qty()
    {
           
        return $this->qty * $this->pack_size;
    }


    public function getDiscountValueAttribute()
    {  

           $rate=0;
           $mrp=$this->mrp;
           if($mrp=='' || $mrp==null)
            $mrp=0;
           $tp = round( 0.85 * $mrp ,2);
           $discount_type=$this->discount_type ; 
           $discount_factor=$this->discount_factor;
           if($discount_factor=='' || $discount_factor==null)
            $discount_factor=0;
          $discount=0;

           if($discount_type=='percentage')
           {
              $discount=($discount_factor/100) * $tp ;
              //$rate=$tp-$discount;
           }
           elseif($discount_type=='flat') 
           {
              $discount=$discount_factor;
           }

         
           $discount=round($discount,2);


        return $discount;
    }

    public function getRateAttribute()
    {
      return $this->rate();
    }

    public function rate()
    {  

           $rate=0;
           $mrp=$this->mrp;
           if($mrp=='' || $mrp==null)
            $mrp=0;
           $tp = round( 0.85 * $mrp ,2);
           $discount_type=$this->discount_type ; 
           $discount_factor=$this->discount_factor;
           if($discount_factor=='' || $discount_factor==null)
            $discount_factor=0;

           if($discount_type=='percentage')
           {
              $discount=($discount_factor/100) * $tp ;
              $rate=$tp-$discount;
           }
           elseif($discount_type=='flat') 
           {
              $rate=$tp-$discount_factor;
           }
           else
           {
            $rate=$tp;
           }

           $tax=$this->tax;
           if($tax=='' || $tax==null)
            $tax=0;

            $tax_amount=($tax/100) * $rate ;
              $rate=$rate+$tax_amount;
           $rate=round($rate,2);


        return $rate;
    }

    public function getAmountAttribute()
    {
      return  $this->total_qty * $this->rate ;
    }




}
