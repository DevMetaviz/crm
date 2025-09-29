<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class variant_item extends Model
{
    use HasFactory;

    
   public function attribute()
    {

        return $this->belongsTo('App\Models\attribute_value','attribute_value_id');
    }

 


   
        

}





