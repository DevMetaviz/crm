<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    public function mid_account()
    {
        return $this->belongsTo('App\Models\Account','mid_sale_account_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\rate_type');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee','so_id');
    }

    public function points()
    {
        return $this->hasMany(Point::class , 'distributor_id' , 'id');
    }
    public function doctors()
    {
        return $this->hasMany(Doctor::class , 'distributor_id' , 'id');
    }


    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function delivery_challans()
    {
        return $this->hasMany('App\Models\Deliverychallan');
    }


    public function incoming_stock_list()
    {
        return $this->hasManyThrough(outgoing_stock::class , Deliverychallan::class ,'customer_id','challan_id','id','id') ;
    }

    public function sales()
    {
        return $this->hasMany('App\Models\Sale');
    }

    public function sale_stock_list()
    {
        return $this->hasManyThrough(sale_stock::class , Sale::class ,'customer_id','invoice_id','id','id');
    }

     public function sale_returns()
    {
        return $this->hasMany('App\Models\Salereturn');
    }

    public function stock_returns()
    {
        return $this->hasMany('App\Models\Salereturn');
    }

    public function stock_transfer_from()
    {
        return $this->hasMany('App\Models\stock_transfer','from_id');
    }

    public function stock_transfer_to()
    {
        return $this->hasMany('App\Models\stock_transfer','to_id');
    }

    public function sale_return_list()
    {
        return $this->hasManyThrough(salereturn_ledger::class , Salereturn::class ,'customer_id','return_id','id','id');
    }

    public function stock_transfer_from_list()
    {
        return $this->hasManyThrough(stock_transfer_ledger::class , stock_transfer::class ,'from_id','transfer_id','id','id');
    }

    public function stock_transfered_to_list()
    {
        return $this->hasManyThrough(stock_transfer_ledger::class , stock_transfer::class ,'to_id','transfer_id','id','id');
    }

    public function getBalanceWithDue()
    {
            $balance=$this->account->closing_balance('');

            $info=[];

             $due_balance=0;

              if($balance>0){
             
             $amount = $this->sales()
                ->whereDate('doc_date', '>=', now()->subDays(15))
                ->sum('total_amount');

                if($balance>$amount)
                   $due_balance=$balance-$amount;

             }

              $info['balance']=$balance;
              $info['due_balance']=$due_balance;

            return $info;
    }

    public function info()
    {

        $info=[];

           $credit_days=$this->credit_days ?? 0;

           $credit_limits=$this->credit_limits ?? 0;

           $bal=$this->getBalanceWithDue();

           //$balance=$this->account->closing_balance('');

           $balance=$bal['balance'];
           $due_balance=$bal['due_balance'];

           $remaining_limit=$credit_limits-$due_balance;

           $last_sales = $this->sales()->latest('doc_date')->first();

    
        $current_month_sales = $this->sales()
        ->whereMonth('doc_date', now()->month)
        ->whereYear('doc_date', now()->year)
        ->sum('total_amount');
    
    $current_year_sales = $this->sales()
        ->whereYear('doc_date', now()->year)
        ->sum('total_amount');

         

            $info['credit_days']=$credit_days; 
            $info['credit_limits']=round($credit_limits,2); 
             $info['balance']=round($balance,2); 
              $info['due_balance']=round($due_balance,2); 
              $info['remaining_limit']=round($remaining_limit,2);

              $info['last_sales'] = $last_sales ? round($last_sales->total_amount, 2) : 0;
    $info['current_month_sales'] = round($current_month_sales, 2);
    $info['current_year_sales'] = round($current_year_sales, 2);

        return $info;
    }

    public function closing_stock_with_value($item_id , $to='')
    {
           
        $it=inventory::find($item_id);

            $all_ins=$this->incoming_stock_list()->where('item_id', $it['id'] )->whereHas('challan', function($q) use($to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->toArray();

             $in=array_sum( array_column(  $all_ins,'total_qty' ) );
         $in_amount=array_sum(array_column($all_ins,'amount'));

        
    
        $all_sales=$this->sale_stock_list()->where('item_id', $it['id'] )->whereHas('sale', function($q) use($to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->toArray();

        $sale=array_sum( array_column(  $all_sales,'total_qty' ) );
         $sale_amount=array_sum(array_column($all_sales,'amount'));

         $all_returns=$this->sale_return_list()->where('item_id', $it['id'] )->whereHas('sale_return', function($q) use($to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->toArray();

         $return=array_sum( array_column(  $all_returns,'total_qty' ) );
         $return_amount=array_sum(array_column($all_returns,'amount'));


         $all_transfer_from=$this->stock_transfer_from_list()->where('item_id', $it['id'] )->whereHas('transfer', function($q) use($to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->toArray();

         $transfer_from=array_sum( array_column(  $all_transfer_from,'total_qty' ) );
         $transfer_from_amount=array_sum(array_column($all_transfer_from,'from_net_amount'));

        
        

        $all_transfer_to=$this->stock_transfered_to_list()->where('item_id',  $it['id'] )->whereHas('transfer', function($q) use($to){
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->toArray();

         $transfer_to=array_sum( array_column(  $all_transfer_to,'total_qty' ) );
         $transfer_to_amount=array_sum(array_column($all_transfer_to,'to_net_amount'));

        

            $t_purchase=$in + $transfer_to;
            $t_return=$return + $transfer_from ;
         $current= $t_purchase -  $t_return - $sale ; 

         $t_purchase_amount=$in_amount + $transfer_to_amount;
            $t_return_amount=$return_amount + $transfer_from_amount ;
         $current_amount= $t_purchase_amount -  $t_return_amount - $sale_amount ;        
           
           return ['closing_stock'=>$current , 'closing_stock_value'=>$current_amount ];
        
    }


    public function closing_stock($item_id , $to='')
    {
           

                 $current=$this->closing_stock_with_value($item_id,$to);     
           
           return $current['closing_stock'];
        
    }

     public function closing_stock_value($item_id , $to='')
    {
           

                 $current=$this->closing_stock_with_value($item_id,$to);     
           
           return $current['closing_stock_value'];
        
    }

    public function current_stock_list($from='',$to='')
    {
        $items=inventory::where('department_id',1)->where('status','like','1')->orderBy('item_name')->get();
        $products=array();
        foreach ($items as $it) {

            // $in=$this->incoming_stock_list->where('item_id', $it['id'] )->where('challan.status',1)->sum(function($t){ 
            //    return $t->qty * $t->pack_size; 
            // });

            $all_ins=$this->incoming_stock_list()->where('item_id', $it['id'] )->whereHas('challan', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->toArray();

            $in=array_sum( array_column(  $all_ins,'total_qty' ) );
         $in_amount=array_sum(array_column($all_ins,'amount'));

         //print_r(json_encode($all_ins) );

         // $sale=$this->sale_stock_list->where('item_id', $it['id'] )->where('sale.status',1)->sum(function($t){ 
         //       return $t->qty * $t->pack_size; 
         //    });

         // $sale=$this->sale_stock_list()->where('item_id', $it['id'] )->whereHas('sale', function($q) use($from,$to){
         //         if($from!='')
         //          { $q->where('doc_date', '>=', $from); }
         //        if($to!='')
         //          { $q->where('doc_date', '<=', $to); }
         //        $q->where('status',1);
         //        })->sum(\DB::raw('qty * pack_size'));

         $all_sales=$this->sale_stock_list()->where('item_id', $it['id'] )->whereHas('sale', function($q) use($from,$to){
                 if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->toArray();
         $sale=array_sum( array_column(  $all_sales,'total_qty' ) );
         $sale_amount=array_sum(array_column($all_sales,'amount'));

         //print_r(json_encode($sale_amount));die;

         // $return=$this->sale_return_list->where('item_id', $it['id'] )->where('sale_return.status',1)->sum(function($t){ 
         //       return $t->qty * $t->pack_size; 
         //    });

         $all_returns=$this->sale_return_list()->where('item_id', $it['id'] )->whereHas('sale_return', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->toArray();

          $return=array_sum( array_column(  $all_returns,'total_qty' ) );
         $return_amount=array_sum(array_column($all_returns,'amount'));

         

         // $transfer_from=$this->stock_transfer_from_list->where('item_id', $it['id'] )->where('transfer.status',1)->sum(function($t){ 
         //       return $t->qty * $t->pack_size; 
         //    });

          $all_transfer_from=$this->stock_transfer_from_list()->where('item_id', $it['id'] )->whereHas('transfer', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->toArray();

          $transfer_from=array_sum( array_column(  $all_transfer_from,'total_qty' ) );
         $transfer_from_amount=array_sum(array_column($all_transfer_from,'from_net_amount'));

          // $transfer_to=$this->stock_transfered_to_list->where('item_id',  $it['id'] )->where('transfer.status',1)->sum(function($t){ 
          //       return $t->qty * $t->pack_size; 
          //    });

            $all_transfer_to=$this->stock_transfered_to_list()->where('item_id',  $it['id'] )->whereHas('transfer', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->toArray();

            $transfer_to=array_sum( array_column(  $all_transfer_to,'total_qty' ) );
         $transfer_to_amount=array_sum(array_column($all_transfer_to,'to_net_amount'));

        

            $t_purchase=$in + $transfer_to;
            $t_return=$return + $transfer_from ;
         $current= $t_purchase -  $t_return - $sale ;

          $t_purchase_amount=$in_amount + $transfer_to_amount;
            $t_return_amount=$return_amount + $transfer_from_amount ;

        
         if($from!='')
         {
            $openings=$this->closing_stock_with_value($it['id'] , date('Y-m-d', strtotime($from. '-1 days')) );
            $opening=$openings['closing_stock'];
           $opening_value=$openings['closing_stock_value'];
         }
         if($from=='')
         { 
            $opening=0;
            $opening_value=0;
          }

          
         $closings=$this->closing_stock_with_value($it['id'] , $to );
         $closing=$closings['closing_stock'];
         $closing_value=$closings['closing_stock_value'];
     
        

            $item=array('id'=>$it['id'] , 'item_name'=>$it['item_name'] , 'item_code'=>$it['item_code'], 'opening'=>$opening , 'opening_value'=>$opening_value , 'purchase' => $t_purchase , 'purchase_amount' => $t_purchase_amount , 'sale'=>$sale , 'sale_amount'=>$sale_amount , 'return'=>$t_return , 'return_amount'=>$t_return_amount  , 'current'=> $current , 'closing'=> $closing , 'closing_value'=> $closing_value );
               array_push($products , $item);
        }
           
           return $products;
        
    }

    public function customer_store_detail($from='',$to='')
    {
        $ins=$this->incoming_stock_list()->whereHas('challan', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->sortByDesc('challan.doc_date');
    
        $outs=$this->sale_stock_list()->whereHas('sale', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->sortByDesc('sale.doc_date');

        $outs1=$this->sale_return_list()->whereHas('sale_return', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->sortByDesc('sale_return.doc_date');

        $trans_f=$this->stock_transfer_from_list()->whereHas('transfer', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->sortByDesc('transfer.doc_date');

        $trans_t=$this->stock_transfered_to_list()->whereHas('transfer', function($q) use($from,$to){
                if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
                $q->where('status',1);
                })->get()->sortByDesc('transfer.doc_date');


        $challans=array();
                 foreach ($ins as $let) {
                    $status='Unpost';
                    if($let['challan']['status']==1)
                        $status='Post';
                    $qty=$let['qty']*$let['pack_size'];
                     $challan=array('id'=>$let['challan']['id'] ,'doc_no'=>$let['challan']['doc_no'] , 'doc_date'=>$let['challan']['doc_date'] , 'item_name'=>$let['item']['item_name'], 'item_code'=>$let['item']['item_code'] , 'qty'=>$qty,'mrp'=>$let['mrp'] ,'batch_no'=>$let['batch_no'] ,'link'=> 'edit/delivery-challan/'.$let['challan']['id'] );
                     array_push($challans, $challan);
                 }

                 $sales=array();
                 foreach ($outs as $let) {
                    $status='Unpost';
                    if($let['sale']['status']==1)
                        $status='Post';
                    $qty=$let['qty']*$let['pack_size'];
                     $sale=array('id'=>$let['sale']['id'] ,'doc_no'=>$let['sale']['doc_no'] , 'doc_date'=>$let['sale']['doc_date'] ,  'item_name'=>$let['item']['item_name'], 'item_code'=>$let['item']['item_code'] , 'qty'=>$qty,'mrp'=>$let['mrp'] ,'batch_no'=>$let['batch_no'] ,'link'=> 'edit/sale/'.$let['sale']['id'] );
                     array_push($sales, $sale);
                 }

                 $returns=array();
                 foreach ($outs1 as $let) {
                    $status='Unpost';
                    if($let['sale_return']['status']==1)
                        $status='Post';
                    $qty=$let['qty']*$let['pack_size'];
                     $sale=array('id'=>$let['sale_return']['id'] ,'doc_no'=>$let['sale_return']['doc_no'] , 'doc_date'=>$let['sale_return']['doc_date'] ,  'item_name'=>$let['item']['item_name'], 'item_code'=>$let['item']['item_code'] , 'qty'=>$qty,'mrp'=>$let['mrp'] ,'batch_no'=>$let['batch_no'] ,'link'=> 'edit/sale/return/'.$let['sale_return']['id'] );
                     array_push($returns, $sale);
                 }

                 $transfer_from=array();
                 foreach ($trans_f as $let) {
                    $status='Unpost';
                    if($let['transfer']['status']==1)
                        $status='Post';
                    $qty=$let['qty']*$let['pack_size'];
                     $sale=array('id'=>$let['transfer']['id'] ,'doc_no'=>$let['transfer']['doc_no'] , 'doc_date'=>$let['transfer']['doc_date'] ,  'item_name'=>$let['item']['item_name'], 'item_code'=>$let['item']['item_code'] , 'qty'=>$qty,'mrp'=>$let['mrp'] ,'batch_no'=>$let['batch_no'] ,'link'=> 'edit/stock/transfer/'.$let['transfer']['id'] );
                     array_push($transfer_from, $sale);
                 }

                 $transfer_to=array();
                 foreach ($trans_t as $let) {
                    $status='Unpost';
                    if($let['transfer']['status']==1)
                        $status='Post';
                    $qty=$let['qty']*$let['pack_size'];
                     $sale=array('id'=>$let['transfer']['id'] ,'doc_no'=>$let['transfer']['doc_no'] , 'doc_date'=>$let['transfer']['doc_date'] ,  'item_name'=>$let['item']['item_name'], 'item_code'=>$let['item']['item_code'] , 'qty'=>$qty,'mrp'=>$let['mrp'] ,'batch_no'=>$let['batch_no'] ,'link'=> 'edit/stock/transfer/'.$let['transfer']['id'] );
                     array_push($transfer_to, $sale);
                 }
                
                  $all = array_merge($challans, $sales,$returns,$transfer_from,$transfer_to)   ;
                   $sort_col  = array_column($all, 'doc_date');
           array_multisort($sort_col,SORT_ASC,$all);
            //print_r(json_encode($all));die;
        return $all;

    }

    public function customer_store_summary($from='',$to='')
    {
        $let_challans=Deliverychallan::where('status',1)->where('customer_id',$this->id)->where(function($q) use($from,$to){
               if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
        })->get();

        $let_sales=Sale::where('status',1)->where('customer_id',$this->id)->where(function($q) use($from,$to){
               if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
        })->get();
               
         $let_returns=Salereturn::where('status',1)->where('customer_id',$this->id)->where(function($q) use($from,$to){
               if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
        })->get();

         $let_transfer_from=stock_transfer::where('status',1)->where('from_id',$this->id)->where(function($q) use($from,$to){
               if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
        })->get();

         $let_transfer_to=stock_transfer::where('status',1)->where('to_id',$this->id)->where(function($q) use($from,$to){
               if($from!='')
                  { $q->where('doc_date', '>=', $from); }
                if($to!='')
                  { $q->where('doc_date', '<=', $to); }
        })->get();
        
                 
                 $challans=array();
                 foreach ($let_challans as $let) {
                    $status='Unpost';
                    if($let['status']==1)
                        $status='Post';
                     $challan=array('id'=>$let['id'] ,'doc_no'=>$let['doc_no'] , 'doc_date'=>$let['doc_date'] , 'total_quantity'=>$let->total_quantity(), 'total_amount'=>$let->total_amount(),'item_names'=>$let->item_names() ,'status'=>$status ,'remarks'=>$let['remarks'],'link'=> 'edit/delivery-challan/'.$let['id'] );
                     array_push($challans, $challan);
                 }

                 $sales=array();
                 foreach ($let_sales as $let) {
                    $status='Unpost';
                    if($let['status']==1)
                        $status='Post';
                     $sale=array('id'=>$let['id'] ,'doc_no'=>$let['doc_no'] , 'doc_date'=>$let['doc_date'] , 'total_quantity'=>$let->total_quantity(),'total_amount'=>$let->total_amount(),'item_names'=>$let->item_names() ,'status'=>$status ,'remarks'=>$let['remarks'],'link'=> 'edit/sale/'.$let['id'] );
                     array_push($sales, $sale);
                 }

                 $returns=array();
                 foreach ($let_returns as $let) {
                    $status='Unpost';
                    if($let['status']==1)
                        $status='Post';
                     $sale=array('id'=>$let['id'] ,'doc_no'=>$let['doc_no'] , 'doc_date'=>$let['doc_date'] , 'total_quantity'=>$let->total_quantity(),'item_names'=>$let->item_names() ,'status'=>$status ,'remarks'=>$let['remarks'],'link'=> 'edit/sale/return/'.$let['id'] );
                     array_push($returns, $sale);
                 }

                 $transfer_from=array();
                 foreach ($let_transfer_from as $let) {
                    $status='Unpost';
                    if($let['status']==1)
                        $status='Post';
                     $sale=array('id'=>$let['id'] ,'doc_no'=>$let['doc_no'] , 'doc_date'=>$let['doc_date'] , 'total_quantity'=>$let->total_quantity(),'item_names'=>$let->item_names() ,'status'=>$status ,'remarks'=>$let['remarks'],'link'=> 'edit/stock/transfer/'.$let['id'] );
                     array_push($transfer_from, $sale);
                 }

                 $transfer_to=array();
                 foreach ($let_transfer_to as $let) {
                    $status='Unpost';
                    if($let['status']==1)
                        $status='Post';
                     $sale=array('id'=>$let['id'] ,'doc_no'=>$let['doc_no'] , 'doc_date'=>$let['doc_date'] , 'total_quantity'=>$let->total_quantity(),'item_names'=>$let->item_names() ,'status'=>$status ,'remarks'=>$let['remarks'],'link'=> 'edit/stock/transfer/'.$let['id'] );
                     array_push($transfer_to, $sale);
                 }
                
                  $all = array_merge($challans, $sales, $returns, $transfer_from, $transfer_to)   ;

                   $sort_col  = array_column($all, 'doc_date');
           array_multisort($sort_col,SORT_ASC,$all);
            //print_r(json_encode($all));die;
        return $all;

        
    }


     public function customer_receivable($from,$to,$type)
    {
                   
        $all=$this->custom_ledger($from,$to,$type);

        return $all;


    }

    public function custom_ledger($from,$to,$type)//ledger of account
    {       
           $opening=$this->custom_opening_balance($from);
           $closing=$this->custom_closing_balance($to);
           //$opening=0;
           //$closing=0;

         //print_r($opening);die;
           $all_transections=[];

           if($type==1)
           {

           
                $all_transections=Transection::whereIn('account_id',[$this->account_id,$this->mid_sale_account_id])->where(function($q) use($from,$to){

                         $q->where('account_voucherable_type','App\Models\Voucher')
                            ->whereHas('voucher', function($q) use($from,$to){
                              
                           if($from!='')
                          { $q->where('voucher_date', '>=', $from); }
                            if($to!='')
                             { $q->where('voucher_date', '<=', $to); }
                    
                
                              })
                   //          ->orWhere('account_voucherable_type','App\Models\Sale')
                   //          ->whereHas('sale', function($q) use($from,$to){

                   //        $q->orderBy('doc_date', 'asc');
                   //  if($from!='')
                   //  { $q->where('doc_date', '>=', $from); }
                   // if($to!='')
                   // { $q->where('doc_date', '<=', $to); }
                    
                
                   //            })

                            ->orWhere('account_voucherable_type','App\Models\Deliverychallan')
                            ->whereHas('challan', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\Purchase')
                            ->whereHas('purchase', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\Purchasereturn')
                            ->whereHas('purchasereturn', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\Salereturn')
                            ->whereHas('salereturn', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\stock_transfer')
                            ->whereHas('stock_transfer', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })


                                        

                            ;
                          if($from=='')
                          $q->orWhere('account_voucherable_type','App\Models\inventory');

                })->get();

                }
           elseif($type==0)
           {

           

                //for summary ledger

                 $all_transections=Transection::with('account_voucherable')->whereIn('account_id',[$this->account_id,$this->mid_sale_account_id])->selectRaw('sum(debit) as debit,sum(credit) as credit, account_id,account_voucherable_id,account_voucherable_type, remarks,cheque_no')->groupBy('account_voucherable_id','account_voucherable_type')->where(function($q) use($from,$to){

                         $q->where('account_voucherable_type','App\Models\Voucher')
                            ->whereHas('voucher', function($q) use($from,$to){
                              
                           if($from!='')
                          { $q->where('voucher_date', '>=', $from); }
                            if($to!='')
                             { $q->where('voucher_date', '<=', $to); }
                    
                
                              })
                   //          ->orWhere('account_voucherable_type','App\Models\Sale')
                   //          ->whereHas('sale', function($q) use($from,$to){

                   //        $q->orderBy('doc_date', 'asc');
                   //  if($from!='')
                   //  { $q->where('doc_date', '>=', $from); }
                   // if($to!='')
                   // { $q->where('doc_date', '<=', $to); }
                    
                
                   //            })

                            ->orWhere('account_voucherable_type','App\Models\Deliverychallan')
                            ->whereHas('challan', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\Purchase')
                            ->whereHas('purchase', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\Purchasereturn')
                            ->whereHas('purchasereturn', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\Salereturn')
                            ->whereHas('salereturn', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\stock_transfer')
                            ->whereHas('stock_transfer', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })


                                        

                            ;
                          if($from=='')
                          $q->orWhere('account_voucherable_type','App\Models\inventory');

                })->get();


                 }

                
               
               $transections=array();
               foreach ($all_transections as $all ) {

                $date='';
                if($all['account_voucherable_type']=='App\Models\Sale')
                  $date=$all['account_voucherable']['doc_date'];
                elseif($all['account_voucherable_type']=='App\Models\Deliverychallan')
                  $date=$all['account_voucherable']['doc_date'];
                elseif($all['account_voucherable_type']=='App\Models\Voucher')
                  $date=$all['account_voucherable']['doc_date'];
                elseif($all['account_voucherable_type']=='App\Models\Purchase')
                  $date=$all['account_voucherable']['doc_date'];
                elseif($all['account_voucherable_type']=='App\Models\Purchasereturn')
                  $date=$all['account_voucherable']['doc_date'];
                elseif($all['account_voucherable_type']=='App\Models\Salereturn')
                  $date=$all['account_voucherable']['doc_date'];
                elseif($all['account_voucherable_type']=='App\Models\stock_transfer')
                  $date=$all['account_voucherable']['doc_date'];


                $voucher_no='';
                if($all['account_voucherable_type']=='App\Models\Sale')
                  $voucher_no=$all['account_voucherable']['doc_no'];
                elseif($all['account_voucherable_type']=='App\Models\Deliverychallan')
                  $voucher_no=$all['account_voucherable']['doc_no'];
                elseif($all['account_voucherable_type']=='App\Models\Voucher')
                  $voucher_no=$all['account_voucherable']['voucher_no'];
                elseif($all['account_voucherable_type']=='App\Models\Purchase')
                  $voucher_no=$all['account_voucherable']['doc_no'];
                elseif($all['account_voucherable_type']=='App\Models\Purchasereturn')
                  $voucher_no=$all['account_voucherable']['doc_no'];
                elseif($all['account_voucherable_type']=='App\Models\Salereturn')
                  $voucher_no=$all['account_voucherable']['doc_no'];
                elseif($all['account_voucherable_type']=='App\Models\stock_transfer')
                  $voucher_no=$all['account_voucherable']['doc_no'];

                $link='';
                if($all['account_voucherable_type']=='App\Models\Sale')
                  $link='edit/sale/'.$all['account_voucherable']['id'];
                elseif($all['account_voucherable_type']=='App\Models\Deliverychallan')
                  $link='edit/delivery-challan/'.$all['account_voucherable']['id'];
                elseif($all['account_voucherable_type']=='App\Models\Voucher')
                  {
                    if($all['account_voucherable']['category']=='voucher')
                    $link='edit/voucher/'.$all['account_voucherable']['id'];
                     elseif($all['account_voucherable']['category']=='payment')
                    $link='edit/payment/'.$all['account_voucherable']['id'];
                     elseif($all['account_voucherable']['category']=='receipt')
                    $link='edit/receipt/'.$all['account_voucherable']['id'];
                  elseif($all['account_voucherable']['category']=='expense')
                    $link='edit/expense/'.$all['account_voucherable']['id'];
                  }
                  elseif($all['account_voucherable_type']=='App\Models\Purchase')
                     $link='edit/purchase/'.$all['account_voucherable']['id'];
                   elseif($all['account_voucherable_type']=='App\Models\Purchasereturn')
                     $link='edit/purchase/return/'.$all['account_voucherable']['id'];
                   elseif($all['account_voucherable_type']=='App\Models\Salereturn')
                     $link='edit/sale/return/'.$all['account_voucherable']['id'];
                   elseif($all['account_voucherable_type']=='App\Models\stock_transfer')
                     $link='edit/stock/transfer/'.$all['account_voucherable']['id'];
                  else
                    $link='#';

                 $remarks='';
                 if($type==0)
                 {
                    if($all['account_voucherable_type']=='App\Models\Sale')
                  $remarks='Sale Invoice';
                elseif($all['account_voucherable_type']=='App\Models\Deliverychallan')
                  $remarks='Delivery Challan';
                elseif($all['account_voucherable_type']=='App\Models\Voucher')
                  {
                    if($all['account_voucherable']['category']=='voucher')
                       $remarks='Voucher';
                     elseif($all['account_voucherable']['category']=='payment')
                       $remarks='Payment Voucher';
                     elseif($all['account_voucherable']['category']=='receipt')
                       $remarks='Receipt Voucher';
                  elseif($all['account_voucherable']['category']=='expense')
                       $remarks='Expense Voucher';
                  }
                  elseif($all['account_voucherable_type']=='App\Models\Purchase')
                     $remarks='Purchase Invoice';
                   elseif($all['account_voucherable_type']=='App\Models\Purchasereturn')
                     $remarks='Purchase Return';
                   elseif($all['account_voucherable_type']=='App\Models\Salereturn')
                     $remarks='Sale Return';
                   elseif($all['account_voucherable_type']=='App\Models\stock_transfer')
                     $remarks='Stock Transfer';
                  else
                    $remarks='#';
                }
                else
                {
                  $remarks=$all['remarks'];
                }
              

                 $trans=array('date'=>$date,'link'=>$link,'voucher_no'=>$voucher_no,'remarks'=>$remarks,'cheque_no'=>$all['cheque_no'],'debit'=>$all['debit'],'credit'=>$all['credit']);

                 array_push($transections, $trans);
               }

                $sort_col  = array_column($transections, 'date');
           array_multisort($sort_col,SORT_ASC,$transections);

 
           

           return [  'transections'=>$transections, 'opening'=>$opening, 'closing'=>$closing ];
    }


    public function custom_opening_balance($from="")//opening balance of account
    {
         $opening_balance=0;

         $acc=Account::find($this->mid_sale_account_id);

           if($from=='')
              return $acc->opening_balance;
           
           $to=date('Y-m-d', strtotime($from. ' -1 days'));
        
            
              $close=$this->custom_closing_balance($to);
              //$opening_balance  = $trail['debit'] - $trail['credit'] ;
            

            return $close;

    }

     public function custom_closing_balance($to,$from='')//closing balance of account
    {    

        

         $open=Account::find($this->mid_sale_account_id)->opening_balance;

           

          $debit=Transection::whereIn('account_id',[$this->account_id,$this->mid_sale_account_id])->where(function($q) use($from,$to){
                         $q->where('account_voucherable_type','App\Models\Voucher')
                            ->whereHas('voucher', function($q) use($from,$to){
                              
                              
                           if($from!='')
                          { $q->where('voucher_date', '>=', $from); }
                            if($to!='')
                             { $q->where('voucher_date', '<=', $to); }
                    
                
                              })
                   //          ->orWhere('account_voucherable_type','App\Models\Sale')
                   //          ->whereHas('sale', function($q) use($from,$to){

                   //        $q->orderBy('doc_date', 'asc');
                   //  if($from!='')
                   //  { $q->where('doc_date', '>=', $from); }
                   // if($to!='')
                   // { $q->where('doc_date', '<=', $to); }
                    
                
                   //            })

                            ->orWhere('account_voucherable_type','App\Models\Deliverychallan')
                            ->whereHas('challan', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\Purchase')
                            ->whereHas('purchase', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\Purchasereturn')
                            ->whereHas('purchasereturn', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\Salereturn')
                            ->whereHas('salereturn', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\stock_transfer')
                            ->whereHas('stock_transfer', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                             ->orWhere('account_voucherable_type','App\Models\inventory')

                            ;

                            if($from=='')
                          $q->orWhere('account_voucherable_type','App\Models\inventory');

                })->sum('debit');

            


            $credit=Transection::whereIn('account_id',[$this->account_id,$this->mid_sale_account_id])->where(function($q) use($from,$to){
                         $q->where('account_voucherable_type','App\Models\Voucher')
                            ->whereHas('voucher', function($q) use($from,$to){
                              
                              
                           if($from!='')
                          { $q->where('voucher_date', '>=', $from); }
                            if($to!='')
                             { $q->where('voucher_date', '<=', $to); }
                    
                
                              })

                   //          ->orWhere('account_voucherable_type','App\Models\Sale')
                   //          ->whereHas('sale', function($q) use($from,$to){

                   //        $q->orderBy('doc_date', 'asc');
                   //  if($from!='')
                   //  { $q->where('doc_date', '>=', $from); }
                   // if($to!='')
                   // { $q->where('doc_date', '<=', $to); }
                    
                
                   //            })

                            ->orWhere('account_voucherable_type','App\Models\Deliverychallan')
                            ->whereHas('challan', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })


                            ->orWhere('account_voucherable_type','App\Models\Purchase')
                            ->whereHas('purchase', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\Purchasereturn')
                            ->whereHas('purchasereturn', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\Salereturn')
                            ->whereHas('salereturn', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })

                            ->orWhere('account_voucherable_type','App\Models\stock_transfer')
                            ->whereHas('stock_transfer', function($q) use($from,$to){

                          $q->orderBy('doc_date', 'asc');
                    if($from!='')
                    { $q->where('doc_date', '>=', $from); }
                   if($to!='')
                   { $q->where('doc_date', '<=', $to); }
                    
                
                              })


                            ;

                            if($from=='')
                          $q->orWhere('account_voucherable_type','App\Models\inventory');



                })->sum('credit');
            
               $closing=$open + $debit - $credit ;

            return $closing;

    }


    public function getRate($item_id)
    {
        $type_id=$this->rate_type_id;
           

           // $category='';
           // $rate=0; $business_type=''; $discount_type='';
           //  $discount_factor=0;
           $ad='';
          if($type_id!='' || $type_id!=0)
          {          
             $type=rate_type::find($type_id);
           
            $ad='';
              $t=$type->items->where('id',$item_id)->first();//print_r($item_id);die;
              if($t!='')
              {
                $ad=$t->pivot->value; //$category=$t->pivot->bt;
               }
              //if( $ad != '')
              //{
            // if($category=='flat_rate')
            // {
            //     $discount_type='flat';
            //       $rate=$ad;
            //       $business_type='flat_rate';
             

            // }
            // elseif($category=='tp_percent')
            // {
            //      $discount_type='percentage'; 

            //      $discount_factor=$ad; 
            //      $business_type='tp_percent';

            // }
            //}//End if ad !=''
               //$rate=round($rate,2);
            
                      }
         //$config=array('business_type'=>$category, 'discount_type'=>$discount_type , 'discount_factor'=>$discount_factor,'rate'=>$rate );
      //return $config;
                      return $ad;
    }//end get rate

}
