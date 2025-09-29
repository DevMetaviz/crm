<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coating extends Model
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

    

     
}
