<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compression extends Model
{
    use HasFactory;

    public function plan()
    {
        return $this->belongsTo('App\Models\Productionplan','plan_id');
    }

    public function containers()
    {
        return $this->morphMany(container::class, 'containerable');
    }


    public function variations()
    {
        return $this->hasMany(compression_variation::class, 'compression_id');
    }

    public function start_up_analysis()
    {
        return $this->hasMany(compression_analysis::class, 'compression_id');
    }

    public function control_sheet()
    {
        return $this->hasMany(compression_control_sheet::class, 'compression_id');
    }

     public function weights()
    {
       $let=$this->variations()->where('type','weight')->select('value')->get();
         $a=[];
         foreach ($let as $key ) {
           array_push($a, $key['value']);
         }
       return $a;
    }

    public function hardness()
    {
       $let=$this->variations()->where('type','hardness')->select('value')->get();
         $a=[];
         foreach ($let as $key ) {
           array_push($a, $key['value']);
         }
       return $a;
    }

    public function thickness()
    {
       $let=$this->variations()->where('type','thickness')->select('value')->get();
         $a=[];
         foreach ($let as $key ) {
           array_push($a, $key['value']);
         }
       return $a;
    }



    public function total_time()
    {
    	$date1 = date_create($this['start_date']);
          $date2 = date_create($this['comp_date']);
          $result =date_diff($date1, $date2);
          
           $y=''; $m=''; $d=''; $h=''; $m1=''; $s=''; 
           if($result->format('%y'))
            $y=$result->format('%y year ');
          if($result->format('%m'))
            $m=$result->format('%m month ');
          if($result->format('%d'))
            $d=$result->format('%d day ');
          if($result->format('%h'))
            $h=$result->format('%h hours ');
          if($result->format('%i'))
            $m1=$result->format('%i mins ');
          if($result->format('%s'))
            $s=$result->format('%s secs ');
           
          $result=$y.$m.$d.$h.$m1.$s;

          return $result;
    }

    public function total_time1()
    {
       $i = $this['initial_weight'];
          $f = $this['final_weight'];

          $t= $i - $f ;
          $t=( $t /$i ) * 100;

          return $t;
    }

     
}
