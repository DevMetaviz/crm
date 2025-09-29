<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salereturn_ledger extends Model
{
    use HasFactory;
    protected $table = 'sale_return_item';

    protected $appends = ['rate','amount','total_qty'];

    public function item()
    {

        return $this->belongsTo('App\Models\inventory','item_id');
    }

      public function sale_return()
    {

        return $this->belongsTo('App\Models\Salereturn','return_id');
    }

    public function sale_stock()
    {

        return $this->belongsTo('App\Models\sale_stock','sale_stock_id');
    }

    public function getTotalQtyAttribute()
    {
      return $this->total_qty();
    }

    public function total_qty()
    {
           
        return $this->qty * $this->pack_size;
    }

    public function tp()
    {
            $tp=round( 0.85 * $this->mrp ,2);
        return $tp;
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
