<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class point_sale extends Model
{
    use HasFactory;

    public function point()
    {
        return $this->belongsTo('App\Models\Point','point_id');
    }

    public function distributor()
    {
        return $this->belongsTo('App\Models\Customer','distributor_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor','doctor_id');
    }

    public function salesman()
    {
        return $this->belongsTo('App\Models\Employee','salesman_id');
    }

    public function items()
    {
        return $this->belongsToMany(inventory::class,'point_sale_item','point_sale_id','item_id')->withPivot('id','qty','rate')->withTimestamps();
    }

     public function item_list()
    {
        return $this->hasMany(point_sale_item::class,'point_sale_id','id');
    }

    public function total_quantity()
    {    
        $total = 0;
        if($this->type=='invoice_wise')
            return $total;

        foreach ($this->items as $item ) {
            
            $total += $item['pivot']['qty']  ;
        }

        return $total ;
    }

     public function total_amount()
    {
        

        if($this->type=='invoice_wise')
            { 
               return $this->sale_value;
             }
         
         $total = 0;

        foreach ($this->items as $item ) {
            
            $qty = $item['pivot']['qty'] ;
              $rate=$item['pivot']['rate'] ;

              $amount=$qty  * $rate ;
              $total= $total + $amount;

        }

        return $total ;
    }


}
