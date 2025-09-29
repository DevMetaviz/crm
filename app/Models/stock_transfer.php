<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_transfer extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(inventory::class,'stock_transfer_item','transfer_id','item_id')->withPivot('id','challan_id','unit','qty','pack_size','mrp','batch_no','expiry_date','from_business_type','from_discount_type','from_discount_factor','from_tax','to_business_type','to_discount_type','to_discount_factor','to_tax')->withTimestamps();
    }

    public function stock_transfer_items()
    {
        return $this->hasMany(stock_transfer_ledger::class,'transfer_id');
    }

    public function from_customer()
    {
        return $this->belongsTo('App\Models\Customer','from_id');
    }

    public function to_customer()
    {
        return $this->belongsTo('App\Models\Customer','to_id');
    }

    public function transections()
    {
        return $this->morphMany(Transection::class, 'account_voucherable');
    }

    public function total_quantity()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
            $total += $item['pivot']['qty'] * $item['pivot']['pack_size'] ;
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

     public function from_rate($item_id,$pivot_id)
    {
              $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();

              $total_qty= $item['pivot']['qty'] * $item['pivot']['pack_size'] ; 
            
              $tp=0.85 * $item['pivot']['mrp'];
               $d=0;

               if($item['pivot']['from_discount_type']=='flat')
                 $d=$item['pivot']['from_discount_factor'];
                if($item['pivot']['from_discount_type']=='percentage')
                $d=($item['pivot']['from_discount_factor'] / 100) *  $tp;
              
              $rate=$tp - $d;
                  

                  $tax=$item['pivot']['from_tax'];
                $t=($tax / 100) * $rate;
                $rate=$rate  + $t;

                $amount=$rate * $total_qty;
                                      
                       $rate=round( $rate ,2 );

                   return $rate;

    }

    public function to_rate($item_id,$pivot_id)
    {
              $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();

              $total_qty= $item['pivot']['qty'] * $item['pivot']['pack_size'] ; 
            
              $tp=0.85 * $item['pivot']['mrp'];
               $d=0;

               if($item['pivot']['to_discount_type']=='flat')
                 $d=$item['pivot']['to_discount_factor'];
                if($item['pivot']['to_discount_type']=='percentage')
                $d=($item['pivot']['to_discount_factor'] / 100) *  $tp;
              
              $rate=$tp - $d;
                  

                  $tax=$item['pivot']['to_tax'];
                $t=($tax / 100) * $rate;
                $rate=$rate  + $t;

                $amount=$rate * $total_qty;
                                      
                       $rate=round( $rate ,2 );

                   return $rate;

    }



}
