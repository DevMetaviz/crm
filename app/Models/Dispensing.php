<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispensing extends Model
{
    use HasFactory;


     public function plan()
    {
        return $this->belongsTo('App\Models\Productionplan','plan_id');
    }

    
}
