<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gtin extends Model
{
    use HasFactory;


    public function product()
    {

        return $this->hasOne('App\Models\inventory','gtin_id','id');
    }


    
}
