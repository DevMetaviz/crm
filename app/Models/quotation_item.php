<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quotation_item extends Model   //it is for delivery chall items (customer store)
{
    use HasFactory;
    protected $table = 'quotation_item';
    protected $appends = ['discount_value','total_qty','amount'];
 


    public function item()
    {

        return $this->belongsTo('App\Models\inventory','item_id');
    }


      public function quotation()
    {

        return $this->belongsTo('App\Models\Quotation','quotation_id');
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

           $rate=$this->rate;
           // $mrp=$this->mrp;
           // if($mrp=='' || $mrp==null)
           //  $mrp=0;
           // $tp = round( 0.85 * $mrp ,2);
           $discount_type=$this->discount_type ; 
           $discount_factor=$this->discount_factor;
           if($discount_factor=='' || $discount_factor==null)
            $discount_factor=0;
          $discount=0;

           if($discount_type=='percentage')
           {
              $discount=($discount_factor/100) * $rate ;
              //$rate=$tp-$discount;
           }
           elseif($discount_type=='flat') 
           {
              $discount=$discount_factor;
           }

         
           $discount=round($discount,2);


        return $discount;
    }

    // public function getRateAttribute()
    // {
    //   return $this->rate();
    // }

    public function rate()
    {  

           $rate=$this->rate;
           // $mrp=$this->mrp;
           // if($mrp=='' || $mrp==null)
           //  $mrp=0;
           // $tp = round( 0.85 * $mrp ,2);
           $discount_type=$this->discount_type ; 
           $discount_factor=$this->discount_factor;
           if($discount_factor=='' || $discount_factor==null)
            $discount_factor=0;

           if($discount_type=='percentage')
           {
              $discount=($discount_factor/100) * $rate ;
              $rate=$rate-$discount;
           }
           elseif($discount_type=='flat') 
           {
              $rate=$rate-$discount_factor;
           }
           else
           {
            $rate=$rate;
           }

          

            
           $rate=round($rate,2);


        return $rate;
    }

    public function getAmountAttribute()
    {
      return  $this->total_qty * $this->rate() ;
    }




}
