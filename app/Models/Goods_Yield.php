<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods_Yield extends Model
{
    use HasFactory;

public function yield_items()
    {
        return $this->hasMany(yield_detail::class,'yield_id');
    }

    
    public function plan()
    {
        return $this->belongsTo(Productionplan::class,'plan_id');
    }

   
   public function actual_qty()
    {
    	$items=$this->yield_items;
    	$net=0;

    	foreach ($items as $key ) {
    		$t=$key['qty'] * $key['pack_size'];
    		$net=$net + $t ;
    	}
        return $net;
    }

    public function percent_yield()
    {
    	$actual=$this->actual_qty();
    	$theoretical=$this['plan']['batch_qty'];
    	$qa=$this->qa_sample;
    	$qc=$this->qc_sample;

    	$net=$actual+$qa+$qc;
    	$net=round(($net / $theoretical )*100 ,2 );

        return $net;
    }

    public function percent_loss()
    {
    	$y=$this->percent_yield();
    	

    	$net=round( 100 - $y ,2 );

        return $net;
    }

    // public function transections()
    // {
    //     return $this->morphMany(Transection::class, 'account_voucherable');
    // }


}
