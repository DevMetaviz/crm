<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase_ledger extends Model   //it is for delivery chall items (customer store)
{
    use HasFactory;
    protected $table = 'inventory_purchase';
   // protected $appends = ['total_qty','rate'];
 


    public function item()
    {

        return $this->belongsTo('App\Models\inventory','item_id');
    }

    public function color()
    {

        return $this->belongsTo('App\Models\InventoryColor','color_id');
    }

      public function purchase()
    {

        return $this->belongsTo('App\Models\Purchase','purchase_id');
    }

    public function stock()
    {

        return $this->belongsTo('App\Models\Stock','stock_id');
    }
    

    /*public function getTotalQtyAttribute()
    {
      return $this->total_qty();
    }*/

    /*public function total_qty()
    {
           
        return $this->quantity * $this->pack_size;
    }

    public function rate_exclusive_tax()
    {
              
                  
                  $unit_rate=$this->unit_rate;
                  $pack_rate=$this->pack_rate;

                  $rate=0;

                  if($unit_rate!=null && $pack_rate==null)
                    $rate=$unit_rate;
                  elseif($unit_rate==null && $pack_rate!=null)
                    $rate=$pack_rate/$this->pack_size;
                 elseif($unit_rate==null && $pack_rate==null)
                    $rate=0;

               $d=($this->discount / 100) *  $rate ;

                $rate=$rate - $d;

                
                     
                      // $rate=round( $rate ,2 );

                   return $rate;

    }

    public function rate_inclusive_tax()
    {
            
                $rate=$this->rate_exclusive_tax();

                $t=($this->tax / 100) * $rate;
                $rate=$rate  + $t;
                     
                       //$rate=round( $rate ,2 );

                   return $rate;

    }


    public function getRateAttribute()
    {
      return $this->rate_inclusive_tax();
    }*/

     public function rate()
    {  

           
           $discount=$this->discount ?? 0;
           
            $rate = $this->rate ?? 0; 

            $d=($discount / 100) *  $rate;
              

              $rate=$rate + $d ;
          

            $rate=round($rate,2);

        return $rate;
    }

    public function total_amount()
    {
        
        $qty=$this->qty ?? 0;
        $rate=$this->rate();
        

        $unit_weight=$this->unit_weight ?? 0;
        $unit_feet=$this->unit_feet ?? 0;

        $pricing_by=$this->pricing_by ?? '';
  


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
