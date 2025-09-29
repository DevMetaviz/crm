<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adjusted_item extends Model //stock adjustment pivot
{
    use HasFactory;

     protected $table = 'adjustment_item';

     public function item()
    {

        return $this->belongsTo('App\Models\inventory','item_id');
    }

    public function adjustment()
    {

        return $this->belongsTo('App\Models\Stockadjustment','adjustment_id');
    }

    public function stock()
    {

        return $this->belongsTo('App\Models\Stock','grn_no','grn_no');
    }


}
