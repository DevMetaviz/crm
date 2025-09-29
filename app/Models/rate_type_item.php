<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rate_type_item extends Model
{
    use HasFactory;

    protected $table = 'rate_type_item';

    public function item()
    {
        return $this->belongsTo(inventory::class,'item_id');
    }

    public function rate_type()
    {
        return $this->belongsTo(rate_type::class,'type_id');
    }


   


}
