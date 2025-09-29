<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plan_item extends Model
{
    use HasFactory;
     protected $table = 'plan_product';

     public function item()
    {

        return $this->belongsTo('App\Models\inventory','item_id');
    }

      public function plan()
    {

        return $this->belongsTo('App\Models\Productionplan','plan_id');
    }



}
