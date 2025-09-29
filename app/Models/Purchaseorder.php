<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchaseorder extends Model
{
    use HasFactory;

    

    public function demand()
    {
        return $this->belongsTo(Purchasedemand::class,'purchasedemand_id');
    }
    public function booking()
    {
        return $this->belongsTo(Booking::class,'booking_id');
    }

    public function items()
    {
        return $this->belongsToMany(inventory::class,'inventory_purchaseorder','order_id','item_id')->withPivot('id','variant_id','unit','av_qty','qty','pack_size','rate','discount','unit_weight','unit_feet','pricing_by','unit_rate','pack_rate','tax')->withTimestamps();
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }

    public function grn()
    {
        return $this->hasOne(Grn::class,'order_id','id');
    }

    public function transport_via()
    {
        return $this->belongsTo('App\Models\Configuration','shipped_via','id');
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
     public function approved_by()
    {
        return $this->belongsTo('App\Models\Employee','approve_by','id');
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class,'po_expense','order_id','expense_id')->withPivot('amount')->withTimestamps();
    }

    public function rate_exclusive_tax($item_id,$pivot_id)
    {
              $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();
              
              $total_qty= $item['pivot']['qty'];// *$item['pivot']['pack_size'] ; 
                  
                 /* $current_rate=$item['pivot']['unit_rate'];
                  $pack_rate=$item['pivot']['pack_rate'];
                  $rate=0;
                  if($current_rate!=null && $pack_rate==null)
                    $rate=$current_rate;
                  elseif($current_rate==null && $pack_rate!=null)
                    $rate=$pack_rate/$item['pivot']['pack_size'] ;
                 elseif($current_rate==null && $pack_rate==null)
                    $rate=0;*/

                    $rate=$item['rate'];

               $d=($item['pivot']['discount'] / 100) *  $rate ;

                $rate=$rate + $d;

                
                     
                       //$rate=round( $rate ,2 );

                   return $rate;

    }

    public function rate_inclusive_tax($item_id,$pivot_id)
    {
               $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();
             

                $rate=$this->rate_exclusive_tax($item_id,$pivot_id);

                //$t= ($item['pivot']['tax'] / 100) * $rate ;
                //$rate=$rate  + $t;
                     
                       //$rate=round( $rate ,2 );

                   return $rate;

    }

    public function expenses_amount()
    {
        $amount=0;

                   foreach ($this->expenses as $exp ) {
                       
                  $amount  = $amount + $exp['pivot']['amount']    ;
                   }

                   
                     
                       $amount=round( $amount ,2 );

                   return $amount;

    }

    public function rate($item_id,$pivot_id)
    {
              $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();
              //$item_count=count( $this->items );
              $total_qty= $item['pivot']['qty'];  // *$item['pivot']['pack_size'] ; 

              //$unit_weight=$item['pivot']['unit_weight'];
              // $unit_feet=$item['pivot']['unit_feet'];

                //$pricing_by=$item['pivot']['pricing_by'];

                  
                     
                // $rate=$this->rate_inclusive_tax($item_id,$pivot_id);

              $rate=$item['pivot']['rate'] ?? 0;

              $discount=$item['pivot']['discount'] ?? 0 ;

               
                  
                   $discount=($discount / 100) *  $rate ;

                       $rate = $rate + $discount;

                         //$amount=$rate * $total_qty;

                   //$amount=round( $amount  ,2 );

                //    foreach ($this->expenses as $exp ) {
                       
                //        $amount  = $amount + ($exp['pivot']['debit'] / $item_count ) - ( $exp['pivot']['credit'] / $item_count ) ;
                //    }

                  
                     
                       $rate=round( $rate ,2 );

                   return $rate;

    }

    public function total_quantity()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
            $total += $item['pivot']['qty']  ;
           // $total += $item['pivot']['qty'] * $item['pivot']['pack_size'] ;
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

          $freight_charges=$this->freight_charges ?? 0;
          $loading_charges=$this->loading_charges ?? 0;
          $unloading_charges=$this->unloading_charges ?? 0;

          $total= $amount + $freight_charges + $loading_charges ;
           
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

    }


}
