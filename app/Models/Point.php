<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    public function distributor()
    {
        return $this->belongsTo('App\Models\Customer','distributor_id');
    }

    public function salesman()
    {
        return $this->belongsTo('App\Models\Employee','salesman_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor','doctor_id');
    }

     public function sales()
    {
        return $this->hasMany(point_sale::class,'point_id','id');
    }

    public function items()
    {
        return $this->hasManyThrough(point_sale_item::class, point_sale::class,'point_id','point_sale_id','id','id');
    }

    public function saled_items($criteria=[])
    {    

         $from=''; $to='';
           if(isset($criteria['from']))
               $from=$criteria['from'];

             if(isset($criteria['to']))
               $to=$criteria['to'];

        $lets=$this->items()->whereHas('sale', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }

                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                
                    $q->where('activeness','1');
                })->get()->groupBy('item_id');
          
          $items=array();

          foreach ($lets as $value ) {
          	$qty=0; $amount=0;
          	foreach ($value as $k ) {
          	  $qty+=$k['qty'];

              $amount+=$k['amount'] ;

             }

             $rate=round( $amount/$qty ,2 );
  
            $it=array('item'=>$value[0]['item'],'qty'=>$qty,'rate'=>$rate,'amount'=>$amount);
            array_push($items, $it);
          }

          return $items;

    }


}
