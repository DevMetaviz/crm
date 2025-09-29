<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(inventory::class,'item_sale','invoice_id','item_id')->withPivot('id','av_qty','qty','rate','unit_weight','unit_feet','discount','pricing_by')->withTimestamps();
        //return $this->belongsToMany(inventory::class,'item_sale','invoice_id','item_id')->withPivot('id','unit','qty','pack_size','mrp','batch_no','expiry_date','rate','discount_type','discount_factor','commission_type','commission_factor')->withTimestamps();
    }

    public function sale_stock_list()
    {
        return $this->hasMany('App\Models\sale_stock','invoice_id','id');
    }

    public function salesman()
    {
        return $this->belongsTo('App\Models\Employee','salesman_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function return()
    {
        return $this->hasOne('App\Models\Salereturn','invoice_id');
    }

     public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    public function shipment_port()
    {
        return $this->belongsTo('App\Models\Port','shipment_port_id');
    }

    public function discharge_port()
    {
        return $this->belongsTo('App\Models\Port','discharge_port_id');
    }

    public function packing_type()
    {
        return $this->belongsTo('App\Models\packing_type','packing_type_id');
    }

    public function freight_type()
    {
        return $this->belongsTo('App\Models\freight_type','freight_type_id');
    }

    public function transportation()
    {
        return $this->belongsTo('App\Models\Transportation','transportation_id');
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class,'sale_expense','sale_id','expense_id')->withPivot('amount')->withTimestamps();
    }

    //public function salereturn()
    //{
        //return $this->hasOne('App\Models\Salereturn','invoice_id');
    //}

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }


    public function challan()
    {
        return $this->belongsTo('App\Models\Deliverychallan');
    }

    public function total_quantity()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
            $total += $item['pivot']['qty']  ;
           // $total += $item['pivot']['qty'] * $item['pivot']['pack_size'] ;
        }

        return $total ;
    }

     public function total_weight()
    {
        $total = 0;
        foreach ($this->items as $item ) {
            
         $total += $item['pivot']['qty'] * $item['pivot']['unit_weight'] ;
        }

        return $total ;
    }

    public function amount_ex_discount()
    {
        $total = 0;

        foreach ($this->items as $item ) {
            
            $qty = $item['pivot']['qty'] ;  //* $item['pivot']['pack_size'] ;
              
              //$rate=$this->rate($item['id'],$item['pivot']['id']);
              //$amount=$qty  * $rate ;

                $amount=$this->item_amount($item['id'],$item['pivot']['id']);
              

              
              $total= $total + $amount;

        }

        return $total ;
    }

    public function net_discount()
    {
        $total = $this->amount_ex_discount();
        $discount=0;

        /*if($this->net_discount==null || $this->net_discount==0 || $this->net_discount=='')
            return $discount;
        $type=$this->net_discount_type;

          if($type=='flat')
              $discount=$this->net_discount;
            elseif($type=='percentage')
            {
                $discount=round( ($this->net_discount / 100 )*$total ,2 );
            }*/
    
        return $discount ;
    }

    public function amount_in_discount()
    {
        $total = $this->amount_ex_discount();
        $discount=$this->net_discount();
          $rem=$total-$discount;

          return $rem;
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
        // $gst=$this->gst_amount();
        // $exp=$this->expense_amount();
        //$total=$amount+$gst+$exp;

          $freight_charges=$this->freight_charges ?? 0;
          $loading_charges=$this->loading_charges ?? 0;

          $total= $amount + $freight_charges + $loading_charges;
           
        return $total ;
    }


    public function item_names()
    {
        $names = '';

        $i=1; $count= count($this->items);
        foreach ($this->items as $item ) {
            
            $names  = $names . $item['item_name'] ;
             
             if( $i!= $count )
               $names  = $names . ' , ' ;

            $i++;
        }

        return $names ;
    }

    public function transections()
    {
        return $this->morphMany(Transection::class, 'account_voucherable');
    }

    

    public function rate($item_id,$pivot_id)
    {
        $item=$this->items->where('id',$item_id)->where('pivot.id',$pivot_id)->first();

        $discount = $item['pivot']['discount'] ?? 0; 
        $rate = $item['pivot']['rate'] ?? 0; 
        
              //$item_count=count( $this->items );

              //$total_qty= $item['pivot']['qty'] * $item['pivot']['pack_size'] ; 

            
              // $tp=0.85 * $item['pivot']['mrp'];
                $d=0;

               //if($item['pivot']['discount_type']=='flat')
                 //$d=$item['pivot']['discount_factor'];
                //if($item['pivot']['discount_type']=='percentage')
                //$d=($item['pivot']['discount_factor'] / 100) *  $item['pivot']['rate'];


                $d=($discount / 100) *  $rate;
              
              //$rate=$item['pivot']['rate'] - $d;

              $rate=$rate + $d ;
                  

                 

                //$amount=$rate * $total_qty;

                // if($this->net_discount_type=='flat')
                //     $net_discount=$this->net_discount / $item_count;
                // elseif($this->net_discount_type=='percentage')
                //       $net_discount=($this->net_discount /100)*$rate;
              
                //   $rate = $rate- $net_discount;
                                      
                       $rate=round( $rate ,2 );

                   return $rate;

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

        $pricing_by=$item['pivot']['pricing_by'] ?? '';
  


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

    public function commission($pivot_id)
    {
          $item=$this->items->where('pivot.id',$pivot_id)->first();
          $rate=$this->rate($item['id'],$pivot_id);

          $v=0;

               if($item['pivot']['commission_type']=='flat')
                 $v=$item['pivot']['commission_factor'];
                if($item['pivot']['commission_type']=='percentage')
                $v=($item['pivot']['commission_factor'] / 100) *  $rate;
              
              $amount= $v;
              $total_qty= $item['pivot']['qty'] * $item['pivot']['pack_size'] ; 
                $amount=$amount * $total_qty;

            return $amount;
    }

    public function gst_amount()
    {
          
          $amount=$this->amount_ex_discount();

         
          $amount=round( ($this->gst / 100) *  $amount ,2 );
              
              

            return $amount;
    }

    public function expense_amount()
    {
          
          $amount=0;

          foreach ($this->expenses as $key ) {
            
            $amount= $amount + $key['pivot']['amount'];
          }    

            return $amount;
    }

    public static function sale_detail($params=[]){

        $invoice_type='';

        if(isset($params['invoice_type']) && $params['invoice_type']!=''){
            $invoice_type=$params['invoice_type'];
        }

        $query=DB::table('sales');

        if (!empty($invoice_type)) {
        $query->where('invoice_type', $invoice_type);
        }

        $todaySales = (clone $query)
        ->whereDate('doc_date', now()->toDateString())
        ->sum('total_amount');

    $todaySalesWeight = (clone $query)
    ->whereDate('doc_date', now()->toDateString())
    ->sum('total_weight');


    

 $yesterdaySales = (clone $query)
    ->whereDate('doc_date', now()->subDay()->toDateString())
    ->sum('total_amount');

    $yesterdaySalesWeight = (clone $query)
    ->whereDate('doc_date', now()->subDay()->toDateString())
    ->sum('total_weight');


   /* $currentMonthSales = DB::table('sales')
    ->join('item_sale', 'sales.id', '=', 'item_sale.invoice_id')
    ->whereYear('sales.doc_date', now()->year)
    ->whereMonth('sales.doc_date', now()->month)
    ->sum(DB::raw('item_sale.qty * IFNULL(item_sale.pack_size,1) * item_sale.rate'));*/

     $currentMonthSales = (clone $query)
    ->whereYear('doc_date', now()->year)
    ->whereMonth('doc_date', now()->month)
    ->sum('total_amount');

    $currentMonthSalesWeight = (clone $query)
    ->whereYear('doc_date', now()->year)
    ->whereMonth('doc_date', now()->month)
    ->sum('total_weight');



    $currentYearSales = (clone $query)
    ->whereYear('doc_date', now()->year)
    ->sum('total_amount');

    $currentYearSalesWeight = (clone $query)
    ->whereYear('doc_date', now()->year)
    ->sum('total_weight');






          return [
    'today' => $todaySales,
    'today_weight' => $todaySalesWeight,
    'yesterday' => $yesterdaySales,
     'yesterday_weight' => $yesterdaySalesWeight,
    'month' => $currentMonthSales,
    'month_weight' => $currentMonthSalesWeight,
    'year' => $currentYearSales,
    'year_weight' => $currentYearSalesWeight
    
       ];
    }


     public static function sale_detail_comparison1($params=[]){

            // Get last 7 days excluding today
$start = now()->subDays(7)->startOfDay();
$end   = now()->subDay()->endOfDay();

$sales = DB::table('sales')
    ->selectRaw('
        DATE(doc_date) as date,
        DAYNAME(doc_date) as day_name,
        SUM(total_amount) as total
    ')
    ->whereBetween('doc_date', [$start, $end])
    ->groupBy('date','day_name')
    ->orderBy('date')
    ->get()
    ->keyBy('date');


                    // Build last 7 days array
        $days = collect();
        for ($i = 7; $i >= 1; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dayName = now()->subDays($i)->format('l'); // full day name (Monday)
            $days->push([
                'date'     => $date,
                'day_name' => $dayName,
                'total'    => $sales[$date]->total ?? 0
            ]);
        }

        return $days;

     }

 public static function sale_detail_comparison($params = [])
{
    $range = $params['range'] ?? 'weekly';
    $sales = DB::table('sales')
        ->select(DB::raw('DATE(doc_date) as date'), DB::raw('SUM(total_amount) as total'))
        ->groupBy('date')
        ->pluck('total','date');

    if ($range == 'weekly') {
        $days = collect();
        for ($i = 7; $i >= 1; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dayName = now()->subDays($i)->format('l');
              
              if($dayName=='Sunday')
                continue;

            $days->push([
                'date'     => $date,
                'day_name' => $dayName,
                'total'    => $sales[$date] ?? 0
            ]);
        }
        return $days;
    }

    if ($range == 'monthly') {
        return collect(range(1,12))->map(function($m){
            $monthName = now()->subMonths(12-$m)->format('M');
            $yearMonth = now()->subMonths(12-$m)->format('Y-m');
            $total = DB::table('sales')
                ->whereYear('doc_date', substr($yearMonth,0,4))
                ->whereMonth('doc_date', substr($yearMonth,5,2))
                ->sum('total_amount');
            return ['month_name' => $monthName, 'total' => $total];
        });
    }

    if ($range == 'yearly') {
        return collect(range(0,7))->map(function($i){
            $year = now()->subYears($i)->year;
            $total = DB::table('sales')
                ->whereYear('doc_date', $year)
                ->sum('total_amount');
            return ['year' => $year, 'total' => $total];
        })->reverse();
    }

    return collect();
}



}
