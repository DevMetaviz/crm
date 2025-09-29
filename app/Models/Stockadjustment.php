<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockadjustment extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(inventory::class,'adjustment_item','adjustment_id','item_id')->withPivot('grn_no','batch_no','type','unit','qty','pack_size','rate')->withTimestamps();
    }

    public function adjusted_items()
    {
        return $this->hasMany(adjusted_item::class,'adjustment_id');
    }


}
