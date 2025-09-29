<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class yield_detail extends Model
{
    use HasFactory;

    public function yield()
    {
        return $this->belongsTo(Goods_Yield::class,'yield_id');
    }

    public function transections()
    {
        return $this->morphMany(Transection::class, 'account_voucherable');
    }


    // public function plan()
    // {
    //   return $this->hasOneThrough( Productionplan::class,Goods_Yield::class,'plan_id','yield_id','id','id');
    // }


}
