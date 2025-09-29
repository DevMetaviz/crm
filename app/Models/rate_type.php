<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rate_type extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(inventory::class,'rate_type_item','type_id','item_id')->withPivot('value')->withTimestamps();
    }

    public function item_list()
    {
        return $this->hasMany(rate_type_item::class , 'type_id' , 'id');
    }

    public function customers()
    {
        return $this->hasMany('App\Models\Customer','rate_type_id','id');
    }


}
