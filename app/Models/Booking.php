<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;




    public function categories()
    {
        return $this->belongsToMany(InventoryCategory::class,'booking_items','booking_id','category_id')->withPivot('id','weight','discount','remarks')->withTimestamps();
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }

     public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
     public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }
     public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Purchaseorder','booking_id');
    }

    public function received_weight()
    {
        $total=$this->orders()->sum('total_weight');

        return $total;
    }
     

     public function total_weight()
    {

        $total = $this->categories()->sum('booking_items.weight') ?? 0;

        return $total;
    }

    public function getPendingWeightAttribute()
    {
        return max(0, $this->total_weight() - $this->received_weight());
    }

    public function avg_discount()
    {
        

        $avg = $this->categories()->avg('booking_items.discount') ?? 0;
        
        return $avg;

        
    }

    public function scopeHasPendingItems($query)
   {
      return $query->whereHas('categories', function($query) {
        $query->whereRaw('weight > COALESCE((SELECT SUM(ip.qty * ip.unit_weight) 
                           FROM inventory_purchaseorder ip
                           JOIN purchaseorders po ON po.id = ip.order_id
                           JOIN inventories inv ON inv.id = ip.item_id
                           WHERE po.booking_id = booking_items.booking_id 
                           AND inv.category_id = booking_items.category_id), 0)');
        });
    }

    /*public function total_items_amount()
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

          $freight_charges=$this->freight_charges ?? 0;
          $loading_charges=$this->loading_charges ?? 0;
          $unloading_charges=$this->unloading_charges ?? 0;

          $total= $amount + $freight_charges + $loading_charges + $unloading_charges;
           
        return $total ;
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

        $pricing_by=$item['pivot']['pricing_by'];


        $total_weight=$unit_weight*$qty;
        $total_feet=$unit_feet*$qty;

        $amount=0;

        if($pricing_by=='weight')
            $amount= $total_weight * $rate;
        elseif($pricing_by=='feet')
            $amount= $total_feet * $rate;

       
            
                                      
                       $amount=round( $amount ,2 );

                   return $amount;

    }*/


}
