<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saledemand extends Model
{
    use HasFactory;


    public function items()
    {
        return $this->belongsToMany(inventory::class,'saledemand_item','demand_id','item_id')->withPivot('id','qty')->withTimestamps();
    }

}
