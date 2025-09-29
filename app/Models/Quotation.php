<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    
     public function items()
    {
        return $this->belongsToMany(inventory::class,'quotation_item','quotation_id','item_id')->withPivot('id','unit','qty','pack_size','mrp','rate','batch_no','expiry_date','discount_type','discount_factor','tax')->withTimestamps();
    }

    public function item_list()
    {
        return $this->hasMany('App\Models\quotation_item','quotation_id','id');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order','quotation_id');
    }


    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    public function shipment_port()
    {
        return $this->belongsTo('App\Models\Port','shipment_port_id');
    }

    public function discharge_port()
    {
        return $this->belongsTo('App\Models\Port','discharge_port_id');
    }

    public function packing_type()
    {
        return $this->belongsTo('App\Models\packing_type','packing_type_id');
    }

    public function freight_type()
    {
        return $this->belongsTo('App\Models\freight_type','freight_type_id');
    }

    public function transportation()
    {
        return $this->belongsTo('App\Models\Transportation','transportation_id');
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class,'quotation_expense','quotation_id','expense_id')->withPivot('amount')->withTimestamps();
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

    public function rate($item_id,$pivot_id)
    {
              $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();
              //$item_count=count( $this->items );
              $total_qty= $item['pivot']['qty'] * $item['pivot']['pack_size'] ; 

            
              $rate=$item['rate'];
               $d=0;

               if($item['pivot']['discount_type']=='flat')
                 $d=$item['pivot']['discount_factor'];
                if($item['pivot']['discount_type']=='percentage')
                $d=($item['pivot']['discount_factor'] / 100) *  $rate;
              
              $rate=$rate - $d;
                  

               
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
