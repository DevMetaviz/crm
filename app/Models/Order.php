<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(inventory::class,'order_item','order_id','item_id')->withPivot('id','av_qty','qty','rate','discount','unit_weight','unit_feet','pricing_by')->withTimestamps();
    }

    public function item_list()
    {
        return $this->hasMany('App\Models\order_item','order_id','id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function quotation()
    {
      
        return $this->belongsTo('App\Models\Quotation');

    }

     public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    

    public function dispatch_to()
    {
        return $this->belongsTo('App\Models\Customer','dispatch_to_id','id');
    }
     public function invoice_to()
    {
        return $this->belongsTo('App\Models\Customer','invoice_to_id','id');
    }

    

    public function delivery_challans()
    {
        return $this->hasMany('App\Models\Deliverychallan','order_id');
    }

    public function total_quantity()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
            //$total += $item['pivot']['qty'] * $item['pivot']['pack_size'] ;
            $total += $item['pivot']['qty'] ;
        }

        return $total ;
    }

    public function total_weight()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
            //$total += $item['pivot']['qty'] * $item['pivot']['pack_size'] ;
            $total += $item['pivot']['qty']*$item['pivot']['unit_weight'] ;
        }

        return $total ;
    }

    public function total_items_amount()
    {
        $total = 0;

        foreach ($this->items as $item ) {
            

                $amount=$this->item_amount($item['id'],$item['pivot']['id']);
              

              
              $total= $total + $amount;

        }

        return $total ;
    }

    public function total_amount()
    {
        

        $amount=$this->total_items_amount();
     

           $freight_charges = (float) ($this->freight_charges ?? 0);
           $loading_charges = (float) ($this->loading_charges ?? 0);

          $total= $amount + $freight_charges + $loading_charges;
           
        return $total ;
    }

     public function item_amount($item_id,$pivot_id)
    {
                          

         $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();

         $qty=$item['pivot']['qty'] ?? 0;

        $discount = $item['pivot']['discount'] ?? 0; 
        $rate = $item['pivot']['rate'] ?? 0; 

         $d=($discount / 100) *  $rate;

         $rate = $rate + $d;



        $unit_weight=$item['pivot']['unit_weight'] ?? 0;
        $unit_feet=$item['pivot']['unit_feet'] ?? 0;

        $pricing_by=$item['pivot']['pricing_by'];


        $total_weight=$unit_weight*$qty;
        $total_feet=$unit_feet*$qty;

        $amount=0;

        if($pricing_by=='weight')
            $amount= $total_weight * $rate;
        elseif($pricing_by=='feet')
            $amount= $total_feet * $rate;

       
            
                                      
                       $amount=round( $amount ,2 );

                   return $amount;

    }

    public function order_status()
    {
         $status=$this->status;

         //$status=1;

         if($status==1){
            if(count( $this->delivery_challans)>0)
              $status=2;
         }
          return $status;
    }

    public function order_status_text()
    {
         $status=$this->order_status();
          $txt='';

         //if($status==0)
         //$txt='<span class="badge badge-warning" >Draft</span>';
         //else
            if($status==1)
         $txt='<span class="badge badge-primary" >Pending</span>';
         elseif($status==2)
           $txt= '<span class="badge badge-success" >Delivered</span>';
       elseif($status==3)
           $txt= '<span class="badge badge-warning" >Pending Approval</span>';
       elseif($status==4)
           $txt= '<span class="badge badge-warning" >Rejected</span>';
         
          return $txt;
    }

      public static function pending_count()
      {
        $orders=Order::doesnthave('delivery_challans')->count(); //where('status',1)->
        return $orders;
      }
      public static function order_count($type='')
      {

        $query = Order::query();   //where('status', '1');

            if ($type == 'yearly') {
                $query->whereYear('order_date', now()->year);
            } 
            elseif ($type == 'monthly') {
                $query->whereYear('order_date', now()->year)
                      ->whereMonth('order_date', now()->month);
            } elseif ($type == 'today') {
                $query->whereDate('order_date', now()->toDateString());
            }

            return $query->count();
      }

       public static function order_details(){

        $pending=Order::doesnthave('delivery_challans')->count();

        $pending_weight=Order::doesnthave('delivery_challans')->sum('total_weight');

        $year_orders = Order::whereYear('order_date', now()->year)->count();

         $year_orders_weight = Order::whereYear('order_date', now()->year)->sum('total_weight');


         $month_orders = Order::whereYear('order_date', now()->year)->whereMonth('order_date', now()->month)->count();

         $month_orders_weight = Order::whereYear('order_date', now()->year)->whereMonth('order_date', now()->month)->sum('total_weight');


         $today_orders = Order::whereYear('order_date', now()->toDateString())->count();

         $today_orders_weight = Order::whereYear('order_date', now()->toDateString())->sum('total_weight');

        
         $total_orders = Order::count();



          return [
   
    'pending' => $pending,
     'pending_weight' => $pending_weight,
      'today' => $today_orders,
    'today_weight' => $today_orders_weight,
    'month' => $month_orders,
    'month_weight' => $month_orders_weight,
    'year' => $year_orders,
    'year_weight' => $year_orders_weight,
    'total_orders' => $total_orders
       ];
    }

}
