<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function items()
    {
        //return $this->belongsToMany(inventory::class,'inventory_purchase','purchase_id','item_id')->withPivot('id','variant_id','stock_id','unit','quantity','pack_size','unit_rate','pack_rate','discount','tax')->withTimestamps();

        return $this->belongsToMany(inventory::class,'inventory_purchase','purchase_id','item_id')->withPivot('id','av_qty','qty','rate','discount','unit_weight','unit_feet','pricing_by')->withTimestamps();

    }

    public function item_list()
    {
        return $this->hasMany(purchase_ledger::class,'purchase_id','id');
    }


    public function transections()
    {
        return $this->morphMany(Transection::class, 'account_voucherable');
    }


    public function expenses()
    {
        return $this->belongsToMany(Expense::class,'purchase_expense','purchase_id','expense_id')->withPivot('amount')->withTimestamps();
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }
    public function freight_voucher()
    {
        return $this->belongsTo('App\Models\Voucher','freight_voucher_id');
    }

     public function grn()
    {
        return $this->belongsTo(Grn::class,'grn_id');
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

    public function purchasereturn()
    {
        return $this->hasOne('App\Models\Purchasereturn','purchase_id');
    }

    public function rate_exclusive_tax($item_id,$pivot_id)
    {
              $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();
              
              $total_qty= $item['pivot']['quantity'] *$item['pivot']['pack_size'] ; 
                  
                  $unit_rate=$item['pivot']['unit_rate'];
                  $pack_rate=$item['pivot']['pack_rate'];
                  $rate=0;
                  if($unit_rate!=null && $pack_rate==null)
                    $rate=$unit_rate;
                  elseif($unit_rate==null && $pack_rate!=null)
                    $rate=$pack_rate/$item['pivot']['pack_size'];
                 elseif($unit_rate==null && $pack_rate==null)
                    $rate=0;

               $d=($item['pivot']['discount'] / 100) *  $rate ;

                $rate=$rate - $d;

                
                     
                       //$rate=round( $rate ,2 );

                   return $rate;

    }

    public function rate_inclusive_tax($item_id,$pivot_id)
    {
               $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();
             

                $rate=$this->rate_exclusive_tax($item_id,$pivot_id);

                $t=($item['pivot']['tax'] / 100) * $rate;
                $rate=$rate  + $t;
                     
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

    public function net_amount()
    {
      
          
          $gst=$this->gst_amount();
          $with=$this->with_hold_tax_amount();
          $net=$this->total_amount();
            $net=$net+$gst-$with;

      return $net;
    }

     /*public function total_amount()
    {
      $net=0;
      foreach ($this->items as $it) {
          
          $rate=$this->rate($it['id'],$it['pivot']['id']);
           $total_qty= $it['pivot']['quantity'] * $it['pivot']['pack_size'] ; 

           $amount=$rate * $total_qty;

           $net  =$net + $amount ;
      }

      return $net;
    }*/

    public function total_qty()
    {
      $net=0;
      foreach ($this->items as $it) {
          
        
           //$total_qty= $it['pivot']['quantity'] *$it['pivot']['pack_size'] ; 

        $total_qty= $it['pivot']['qty']  ; 

          

           $net  =$net + $total_qty ;
      }

      return $net;
    }

    public function total_weight()
    {
      $net=0;
      foreach ($this->items as $it) {
          
        
           $total_qty= $it['pivot']['qty'] *$it['pivot']['unit_weight'] ; 

      

          

           $net  =$net + $total_qty ;
      }

      return $net;
    }

    public function gst_amount()
    {
      $amount=$this->total_amount();
      $tax=$this->gst_tax;

      $t= round( $tax/100 * $amount ,2);

      return $t;
      
    }
    
    public function with_hold_tax_amount()
    {
      $amount=$this->total_amount();
      $tax=$this->net_tax;

      $t= round( $tax/100 * $amount ,2);

      return $t;
      
    }



    public function rate($item_id,$pivot_id)
    {
              $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();
              //$item_count=count( $this->items );
             
              $qty= $item['pivot']['qty'] ?? 0 ; 
                  
                 

                 $rate=$item['pivot']['rate'] ?? 0;

              $discount=$item['pivot']['discount'] ?? 0 ;


              $discount=($discount / 100) *  $rate ?? 0 ;

                       $rate = $rate + $discount;


                     
                 //$rate=$this->rate_inclusive_tax($item_id,$pivot_id);
                // $amount=$rate * $total_qty;
                  
                //    $n_d=($this->net_discount / 100) *  $amount ;

                //    $amount=round( ($amount - $n_d) ,2 );

                //    foreach ($this->expenses as $exp ) {
                       
                //       
                //    }

                //    $rate=$amount / $total_qty;
                     
                //        $rate=round( $rate ,2 );

                   return $rate;

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

         $amount= $amount  + $loading_charges;
           
        return $amount ;
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
