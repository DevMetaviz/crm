<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasedemand extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(inventory::class,'inventory_purchasedemand','demand_id','item_id')->withPivot('variant_id','unit','quantity','pack_size')->withTimestamps();
    }

    public function department()
    {
        return $this->belongsTo('App\Models\InventoryDepartment','department_id');
    }

    public function order()
    {
        return $this->hasOne(Purchaseorder::class,'purchasedemand_id','id');
    }

    


}
