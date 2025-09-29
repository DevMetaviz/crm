<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryColor extends Model
{
    use HasFactory;


    public function inventories()
    {
        return $this->hasMany('App\Models\inventory');
    }



}
