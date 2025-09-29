<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_transfer_ledger extends Model
{
    use HasFactory;
    protected $table = 'stock_transfer_item';

    protected $appends = ['tp','total_qty','from_discount','to_discount','from_discounted_rate','to_discounted_rate','from_total','to_total','from_tax_amount','to_tax_amount','from_net_amount','to_net_amount'];

    public function item()
    {

        return $this->belongsTo('App\Models\inventory','item_id');
    }

      public function transfer()
    {

        return $this->belongsTo('App\Models\stock_transfer','transfer_id');
    }

    public function challan()
    {

        return $this->belongsTo('App\Models\Deliverychallan','challan_id');
    }

    public function total_qty()
    {
           
        return $this->qty * $this->pack_size;
    }

    public function getTotalQtyAttribute()
    {
      return $this->total_qty();
    }


    public function getTpAttribute()
    {
      return $this->tp();
    }

    public function tp()
    {
          $mrp=$this->mrp;
           if($mrp=='' || $mrp==null)
            $mrp=0;
           $tp = round( 0.85 * $mrp ,2);
        return $tp;
    }

    public function getFromDiscountAttribute()
    {
      return $this->from_discount();
    }

    
    public function from_discount()
    {  

           $mrp=$this->mrp;
           if($mrp=='' || $mrp==null)
            $mrp=0;
           $tp = round( 0.85 * $mrp ,2);
           $discount_type=$this->from_discount_type ; 
           $discount_factor=$this->from_discount_factor;
           if($discount_factor=='' || $discount_factor==null)
            $discount_factor=0;
         $discount=0;
           if($discount_type=='percentage')
           {
              $discount=($discount_factor/100) * $tp ;
          
           }
           elseif($discount_type=='flat') 
           {
              $discount=$discount_factor;
           }

        return $discount;
    }

    public function getToDiscountAttribute()
    {
      return $this->to_discount();
    }

    public function to_discount()
    {  

           $mrp=$this->mrp;
           if($mrp=='' || $mrp==null)
            $mrp=0;
           $tp = round( 0.85 * $mrp ,2);
           $discount_type=$this->to_discount_type ; 
           $discount_factor=$this->to_discount_factor;
           if($discount_factor=='' || $discount_factor==null)
            $discount_factor=0;
         $discount=0;
           if($discount_type=='percentage')
           {
              $discount=($discount_factor/100) * $tp ;
          
           }
           elseif($discount_type=='flat') 
           {
              $discount=$discount_factor;
           }

        return $discount;
    }

    public function getFromDiscountedRateAttribute()
    {
      return $this->from_discounted_rate();
    }

    public function from_discounted_rate()
    {  

           $tp=$this->tp();
           $discount=$this->from_discount();

           return round(($tp - $discount),2);
           
    }

    public function getToDiscountedRateAttribute()
    {
           return $this->to_discounted_rate();
    }

    public function to_discounted_rate()
    {  
      
           $tp=$this->tp();
           $discount=$this->to_discount();

           return round(($tp - $discount),2);

           
    }

    public function getFromTotalAttribute()
    {
      return $this->from_total();
    }

    public function from_total()
    {  

           $to=$this->total_qty();
           $d=$this->from_discounted_rate();

           return round(($to * $d),2);
           
    }

    public function getToTotalAttribute()
    {
      return $this->to_total();
    }

    public function to_total()
    {  

           $to=$this->total_qty();
           $d=$this->to_discounted_rate();

           return round(($to * $d),2);
           
    }

    public function getFromTaxAmountAttribute()
    {
      return $this->from_tax_amount();
    }

    public function from_tax_amount()
    {  

           $to=$this->from_total();
           $t=$this->from_tax;

           return round(( ($t /100) * $to),2);
           
    }

    public function getToTaxAmountAttribute()
    {
      return $this->to_tax_amount();
    }

public function to_tax_amount()
    {  

           $to=$this->to_total();
           $t=$this->to_tax;

           return round(( ($t /100) * $to),2);
           
    }

    public function getFromNetAmountAttribute()
    {
      return $this->from_net_amount();
    }

    public function from_net_amount()
    {  

            $total=$this->from_total();
           $tax=$this->from_tax_amount();

           return round(( $total  + $tax),2);
           
    }

    public function getToNetAmountAttribute()
    {
      return $this->to_net_amount();
    }

    public function to_net_amount()
    {  

            $total=$this->to_total();
           $tax=$this->to_tax_amount();

           return round(( $total  + $tax),2);
           
    }



    public function getFromRateAttribute()
    {
      return $this->from_rate();
    }

    public function from_rate()
    {  

           $rate=0;

           $t=$this->total_qty();
           $a=$this->from_net_amount();

          
               return round(( $a  / $t),2);


           
    }

    public function getToRateAttribute()
    {
      return $this->to_rate();
    }


    public function to_rate()
    {  
      $rate=0;

           $t=$this->total_qty();
           $a=$this->to_net_amount();

          
               return round(( $a  / $t),2);
    }





}
