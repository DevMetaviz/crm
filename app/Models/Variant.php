<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    
   public function variant_items()
    {

        return $this->hasMany('App\Models\variant_item','variant_id');
    }

    public function get_variant_items()
    {

        $items=array();

        foreach($this->variant_items as $item){
        
            $attribute=$item->attribute;

             $items[]= [
                'attribute_id'=>$attribute['attribute_id'] ,
                'value'=>$attribute['value'] 
                 ];
           }

         return $items;

    }


    public static function getVariantItems($variant_id)
    {
           $variant=Variant::find($variant_id);
        $items=array();

       if( isset($variant['id']) && count($variant->variant_items)>0){
        foreach($variant->variant_items as $item){
        
            $attribute=$item->attribute;

             $items[]= [
                'attribute_id'=>$attribute['attribute_id'] ,
                'value'=>$attribute['value'] 
                 ];
           }
     }
         return $items;

    }



 


   
        

}





