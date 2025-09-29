<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliverychallan extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(inventory::class,'delivery_item','challan_id','item_id')->withPivot('id','av_qty','av_rack_qty','qty','unit_weight','unit_feet','rack','rack_qty','loading_sq')->withTimestamps();

        //,'expiry_date','business_type','discount_type','discount_factor','tax'
    }

    public function outgoing_stock_list()
    {
        return $this->hasMany('App\Models\outgoing_stock','challan_id','id');
    }

     public function delivered_via()
    {
        return $this->belongsTo('App\Models\Configuration','deliver_via','id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function order()
    {
      
        return $this->belongsTo('App\Models\Order');

    }

     public function transections()
    {
        return $this->morphMany(Transection::class, 'account_voucherable');
    }

    public function sale_invoice()
    {
        return $this->hasOne('App\Models\Sale','challan_id');
    }

    public function total_quantity()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
            $total += $item['pivot']['qty'] ;
            //$total += $item['pivot']['qty'] * $item['pivot']['pack_size'] ;
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

     public function total_amount()
    {
        $total = 0;

        foreach ($this->items as $item ) {
            
            $qty = $item['pivot']['qty'] * $item['pivot']['pack_size'] ;
              $rate=$this->rate($item['id'],$item['pivot']['id']);

              $amount=$qty  * $rate ;
              $total= $total + $amount;

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

    public function rate($item_id,$pivot_id)
    {
              $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();
              //$item_count=count( $this->items );
              $total_qty= $item['pivot']['qty'] * $item['pivot']['pack_size'] ; 

            
              $tp=0.85 * $item['pivot']['mrp'];
               $d=0;

               if($item['pivot']['discount_type']=='flat')
                 $d=$item['pivot']['discount_factor'];
                if($item['pivot']['discount_type']=='percentage')
                $d=($item['pivot']['discount_factor'] / 100) *  $tp;
              
              $rate=$tp - $d;
                  

                  $tax=$item['pivot']['tax'];
                $t=($tax / 100) * $rate;
                $rate=$rate  + $t;

                //$amount=$rate * $total_qty;

                // if($this->net_discount_type=='flat')
                //     $net_discount=$this->net_discount / $item_count;
                // elseif($this->net_discount_type=='percentage')
                //       $net_discount=($this->net_discount /100)*$rate;
              
                //   $rate = $rate- $net_discount;
                                      
                       $rate=round( $rate ,2 );

                   return $rate;

    }


}
