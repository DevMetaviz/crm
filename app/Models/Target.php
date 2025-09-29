<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor','doctor_id');
    }

    public function items()
    {
        return $this->belongsToMany(inventory::class,'target_item','target_id','item_id')->withPivot('id','qty','rate')->withTimestamps();
    }

    public function total_quantity()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
            $total += $item['pivot']['qty']  ;
        }

        return $total ;
    }

    public function target_value()
    {
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
