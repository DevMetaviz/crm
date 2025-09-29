<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    use HasFactory;

    public function inventories()
    {
        return $this->hasMany('App\Models\inventory');
    }

    public function sub_categories()
    {
        return $this->hasMany('App\Models\InventoryType','category_id');
    }
    
}
