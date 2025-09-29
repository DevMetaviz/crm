<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    use HasFactory;
    protected $table = 'order_item';
 


    public function item()
    {

        return $this->belongsTo('App\Models\inventory','item_id');
    }

      public function order()
    {

        return $this->belongsTo('App\Models\Order','order_id');
    }

    public function quotation_item()
    {

        return $this->belongsTo('App\Models\quotation_item','quotation_item_id');
    }


    

    




}
