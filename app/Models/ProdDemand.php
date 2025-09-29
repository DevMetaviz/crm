<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdDemand extends Model
{
    use HasFactory;

      public function product()
    {
        return $this->belongsTo(inventory::class,'product_id');
    }

    public function plan()
    {
        return $this->hasOne(Productionplan::class,'demand_id','id');
    }

    public function status()
    {
    	$status='';
        
        if($this->plan=='')
        	$status='Pending';
        else
        	$status='Planned';

        return $status;
    }
}
