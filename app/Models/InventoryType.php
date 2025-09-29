<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryType extends Model
{
    use HasFactory;

    public function inventories()
    {
        return $this->hasMany('App\Models\inventory');
    }

     public function category()
    {

        return $this->belongsTo('App\Models\InventoryCategory','category_id');
    }
     public function shape()
    {

        return $this->belongsTo('App\Models\Shape','shape_id');
    }
     public function size()
    {

        return $this->belongsTo('App\Models\InventorySize','size_id');
    }
    
}





