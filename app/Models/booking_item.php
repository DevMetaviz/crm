<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking_item extends Model
{
    use HasFactory;
    protected $table = 'booking_items';
 


    public function category()
    {

        return $this->belongsTo('App\Models\inventoryCategory','category_id');
    }

      public function booking()
    {

        return $this->belongsTo('App\Models\Booking','booking_id');
    }

    
     public function received_weight()
    {
        //$total=$this->booking()->orders()->items()->where('category_id',$this->category_id)->sum('pivot.qty * pivot.unit_weight');

          //$total=$this->booking;

          //echo json_encode($total);die;

          //$it=Purchaseorder::where('booking_id',$this->booking_id)->get();

           $total = \DB::table('inventory_purchaseorder')
    ->join('purchaseorders', 'purchaseorders.id', '=', 'inventory_purchaseorder.order_id')
    ->join('inventories', 'inventories.id', '=', 'inventory_purchaseorder.item_id')
    ->where('purchaseorders.booking_id', $this->booking_id)
    ->where('inventories.category_id', $this->category_id)
    ->selectRaw('SUM(inventory_purchaseorder.qty * inventory_purchaseorder.unit_weight) as total')
    ->value('total');

        //  echo json_encode($it);
         // die;

        return $total;

       
    }

     

    




}
