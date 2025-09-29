<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class point_sale_item extends Model   //it is for sale item of distributor
{
    use HasFactory;
    protected $table = 'point_sale_item';
    protected $appends = ['amount'];
 
        

    public function item()
    {

        return $this->belongsTo('App\Models\inventory','item_id');
    }

      public function sale()
    {

        return $this->belongsTo('App\Models\point_sale','point_sale_id');
    }

    public function sale_qty()
    {
           
        return $this->qty ;
    }


    public function rate()
    {  

           $rate=$this->rate;
           if($rate=='' || $rate==null)
            $rate=0;

        return $rate;
    }

    public function getAmountAttribute()
    {
      return  $this->sale_qty() * $this->rate() ;
    }




}
