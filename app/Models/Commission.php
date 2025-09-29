<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(inventory::class,'commission_item','commission_id','item_id')->withPivot('id','type','value')->withTimestamps();
    }

    public function salesman()
    {
        return $this->belongsTo(Employee::class,'salesman_id');
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }


}
