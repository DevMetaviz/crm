<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    public function distributor()
    {
        return $this->belongsTo(Customer::class , 'distributor_id' , 'id');
    }

    public function salesman()
    {
        return $this->belongsTo('App\Models\Employee','salesman_id');
    }

    public function points()
    {
        return $this->hasMany(Point::class , 'doctor_id' , 'id');
    }

    public function investments()
    {
        return $this->hasMany(Investment::class , 'doctor_id' , 'id');
    }

    public function targets()
    {
        return $this->hasMany(Target::class , 'doctor_id' , 'id');
    }

    public function sales()
    {
        return $this->hasMany(point_sale::class,'doctor_id','id');
    }

    public function items()
    {
        return $this->hasManyThrough(point_sale_item::class, point_sale::class,'doctor_id','point_sale_id','id','id');
    }

    public function sale_value($from='',$to='')
    {
         //   $items=$this->items()->whereHas('sale',function($q) use($from,$to){
         //    if($from!='')
         //     $q->where('doc_date','>=',$from);
         // if($to!='')
         //     $q->where('doc_date','<=',$to);
         //   })->sum(\DB::raw('rate * qty'));

           $sales=$this->sales()->where(function($q) use($from,$to){
                  if($from!='')
                 $q->where('doc_date','>=',$from);
                   if($to!='')
                   $q->where('doc_date','<=',$to);
           })->get();
           $amount=0;
           foreach ($sales as $sl) {
               
               $t=$sl->total_amount();

               $amount= $amount + $t;
           }

           return $amount;
    }

     public function investment_value($from='',$to='')
    {
         
           $targets=$this->targets()->where(function($q) use($from,$to){
                  if($from!='')
                 $q->where('doc_date','>=',$from);
                   if($to!='')
                   $q->where('doc_date','<=',$to);
           })->get();
           $amount=0;
           foreach ($targets as $sl) {
               
               $t=$sl->investment_amount;

               $amount= $amount + $t;
           }

           return $amount;
    }

    public function target_value($from='',$to='')
    {
         
           $targets=$this->targets()->where(function($q) use($from,$to){
                  if($from!='')
                 $q->where('doc_date','>=',$from);
                   if($to!='')
                   $q->where('doc_date','<=',$to);
           })->get();
           $amount=0;
           foreach ($targets as $sl) {
               
               $t=$sl->target_value;

               $amount= $amount + $t;
           }

           return $amount;
    }


}
