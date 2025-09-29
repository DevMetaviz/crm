<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventorySize extends Model
{
    use HasFactory;

    public function inventories()
    {
        return $this->hasMany('App\Models\inventory');
    }
}
