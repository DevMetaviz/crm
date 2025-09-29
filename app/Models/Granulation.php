<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Granulation extends Model
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

    public function sevied_items()
    {
        $its=$this->plan->items->where('pivot.stage_id','15');

        //print_r(json_encode($its));die;
     $items=[];
        foreach ($its as $it ) {
        	$q=$it['pivot']['pack_size'] * $it['pivot']['qty'];
            $uom='';
            if(isset($it['unit']['name']))
            	$uom=$it['unit']['name'];

          array_push($items, 	['id'=>$it['id'],'name'=>$it['item_name'],'qty'=>$q,'uom'=>$uom] );
        }
        return $items;
    }

    public function paste_items()
    {
        $its=$this->plan->items->where('pivot.stage_id','19');

        //print_r(json_encode($its));die;
     $items=[];
        foreach ($its as $it ) {
        	$q=$it['pivot']['pack_size'] * $it['pivot']['qty'];
            $uom='';
            if(isset($it['unit']['name']))
            	$uom=$it['unit']['name'];

          array_push($items, 	['id'=>$it['id'],'name'=>$it['item_name'],'qty'=>$q,'uom'=>$uom] );
        }
        return $items;
    }

    public function mixing_items()
    {
        $its=$this->plan->items->where('pivot.stage_id','23');

        //print_r(json_encode($its));die;
     $items=[];
        foreach ($its as $it ) {
        	$q=$it['pivot']['pack_size'] * $it['pivot']['qty'];
            $uom='';
            if(isset($it['unit']['name']))
            	$uom=$it['unit']['name'];

          array_push($items, 	['id'=>$it['id'],'name'=>$it['item_name'],'qty'=>$q,'uom'=>$uom] );
        }
        return $items;
    }

    
    public function grn_total_time()
    {
    	$date1 = date_create($this['grn_start']);
          $date2 = date_create($this['grn_comp']);
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

    public function sev_total_time()
    {
    	$date1 = date_create($this['sev_start']);
          $date2 = date_create($this['sev_complete']);
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

     public function mix_total_time()
    {
    	$date1 = date_create($this['mixing_start_time']);
          $date2 = date_create($this['mixing_complete_time']);
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
