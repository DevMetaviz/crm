<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class standard_item extends Model
{
    use HasFactory;
     protected $table = 'item_production_standard';

     public function item()
    {

        return $this->belongsTo('App\Models\inventory','item_id');
    }

      public function standard()
    {

        return $this->belongsTo('App\Models\ProductionStandard','std_id');
    }



}
