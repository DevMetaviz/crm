<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gatepass extends Model
{
    use HasFactory;

    public static function getDocNo($type)
    {           
    	if($type=='inward')
          $doc_no="IG-".Date("y")."-";
      if($type=='outward')
          $doc_no="OG-".Date("y")."-";

        $num=1;

         $order=Gatepass::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->latest()->first();
         if($order=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $order['doc_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

         return $doc_no;
    }

    public function items()
    {
        return $this->hasMany(gatepass_item::class,'gatepass_id');
    }
}
