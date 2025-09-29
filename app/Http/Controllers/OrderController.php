<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\InventoryDepartment;
use App\Models\InventoryCategory;
use App\Models\rate_type;
use App\Models\Deliverychallan;
use App\Models\Configuration;
use App\Models\Quotation;
use App\Models\order_item;
use App\Models\Company;
use App\Models\Branch;
use App\Models\inventory;
use Illuminate\Support\Facades\Auth;
use App\Models\Rate;
use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $orders = Order::query();

        if(isset($request['status']) && $request['status']!='')
        {
            if($request['status']==1){
                $orders = $orders->doesntHave('delivery_challans')->where('status','1');
            }

        }

         $orders = $orders->orderBy('doc_no','desc')->get();
        

        return view('sale.orders',compact('orders'));
    }

    public function pending_approval_orders(Request $request)
    {
         $orders = Order::where('status','3');

        
         $orders = $orders->orderBy('id','desc')->get();
        

        return view('sale.pending_approval_orders',compact('orders'));
    }
    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:1,0'
    ]);

    $order = Order::findOrFail($id);

    $msg='';

    if ($request->status === '1') {
        $order->status = '1';
        $msg='Order approved successfully.';
    } else {
        $order->status = '4';
        $msg='Order rejected successfully.';
    }

    $order->save();

    return response()->json(['success' => true, 'status' => $order->status,'message' => $msg]);
}

    public function pending()
    {
        $orders=Order::doesnthave('delivery_challans')->orderBy('doc_no','desc')->get();

        return view('sale.order.pending',compact('orders'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers=Customer::where('status','1')->get();
        $companies=Company::with('branches')->get();


        $doc_no="SO-".Date("y")."-";
        $num=1;

         $order=Order::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->latest()->first();
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

        $categories=InventoryCategory::orderBy('name','asc')->get();

          $items=inventory::getItems();

          
          $today = now(); // Carbon instance

// If current month >= July, financial year is current year - next year
if ($today->month >= 7) {
    $financialYear = $today->year . '-' . ($today->year + 1);
} else {
    // Else it's last year - current year
    $financialYear = ($today->year - 1) . '-' . $today->year;
}
           $order = new Order(); // empty instance
             $order->doc_no = $doc_no;
             $order->financial_year = $financialYear;

             $branches=[];


             $latestRate = Rate::latest()->first();

        return view('sale.order',compact('customers','companies','order','categories','items','branches','latestRate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chln=Order::where('doc_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->withErrors(['error'=>'Doc No. already existed!']);



         $location_ids=$request->location_ids;

       $item_id=$request->item_id;
        //$quotation_items_id=$request->quotation_items_id;
       //$units=$request->units;
        $av_qty=$request->av_qty;
        $qty=$request->qty;
        //$pack_sizes=$request->p_s;

        $rate=$request->rate;
        $disc=$request->disc;
        $unit_weight=$request->unit_weight;
        $unit_feet=$request->unit_feet;
        $pricing_by=$request->pricing_by;

         
         $status=1;

          $balance_due=str_replace(',', '', $request->balance_due);

        $credit_limits=str_replace(',', '', $request->credit_limits);
         $total_amount=str_replace(',', '', $request->total_amount);

         $net=$balance_due+$total_amount;
            
         if($net>=$credit_limits)
            $status=3;

           

        
            

        $order=new Order;

        $order->doc_no=$request->doc_no;
        $order->order_date=$request->order_date;

        $order->po_no=$request->po_no;
        $order->po_date=$request->po_date;
        
        
        $order->status=$status;
        $order->invoice_type=$request->invoice_type;
        $order->customer_id=$request->customer_id;
       // $order->dispatch_to_id=$request->dispatch_to_id;
        //$order->invoice_to_id=$request->invoice_to_id;
         //$order->quotation_id=$request->quotation_id;
        $order->remarks=$request->remarks;

         $order->user_id = Auth::id();

        //$order->financial_year=$request->financial_year;
        $order->company_id=$request->company_id;

        $order->branch_id=$request->branch_id;
        

        $order->freight_charges=str_replace(',', '', $request->freight_charges);
        $order->loading_charges=str_replace(',', '', $request->loading_charges);
        //$order->tax1=$request->tax1;
        //$order->tax2=$request->tax2;
        //$order->tax3=$request->tax3;

        $order->last_sales=str_replace(',', '', $request->last_sales);
        $order->current_month_sales=str_replace(',', '', $request->current_month_sales);
        $order->current_year_sales=str_replace(',', '', $request->current_year_sales);
        $order->credit_days=str_replace(',', '', $request->credit_days);
        $order->avg_days=str_replace(',', '', $request->avg_days);
        $order->balance_due=str_replace(',', '', $request->balance_due);
        $order->credit_limits=str_replace(',', '', $request->credit_limits);
        $order->remaining_limit=str_replace(',', '', $request->remaining_limit);
        $order->previous_balance=str_replace(',', '', $request->previous_balance);
        

        $order->save();
            
            for($i=0;$i<count($item_id);$i++)
            {
                if(!$item_id[$i]>0)
                    continue;


               $qty_p=str_replace(',', '',$qty[$i]);
               $rate_p=str_replace(',', '',$rate[$i]);
               $disc_p=str_replace(',', '',$disc[$i]);
               $unit_weight_p=str_replace(',', '',$unit_weight[$i]);
               $unit_feet_p=str_replace(',', '',$unit_feet[$i]);

           $order->items()->attach($item_id[$i] , ['av_qty'=>$av_qty[$i], 'qty'=>$qty_p, 'rate'=>$rate_p , 'discount' => $disc_p , 'unit_weight' => $unit_weight_p ,'unit_feet'=>$unit_feet_p, 'pricing_by'=>$pricing_by[$i] ]);
           }

           $order->total_amount=$order->total_amount();
           $order->total_weight=$order->total_weight();

            $order->save();

            foreach($order->item_list as $item) {

               $amount=$order->item_amount($item['item']['id'],$item['id']);

               $item->total_amount=$amount;
               $item->save();

           }

           $msg='Order genrated!';

           if($status==3)
           $msg='Sale Order has been generated but requires CEO approval because the customer outstanding balance exceeds the credit limit.';

         return redirect(url('/edit/order/'.$order['id']))->with('success',$msg);

    }

    public function getCustomerNewOrders(Request $request)
    {
          $customer_id=$request->customer_id;

          $orders=Order::select('id','doc_no','order_date','customer_id')->where('customer_id',$customer_id)->where('activeness','1')->orderBy('doc_no','desc')->doesnthave('delivery_challans')->get();

          return response()->json($orders, 200);
    }

    public function getSaleOrder(Request $request)
    {
          $order_id=$request->order_id;
          $order=Order::find($order_id);

           $customer_id=$order['customer_id'];
          $customer=Customer::find($customer_id);

          $items=array();

          foreach ($order->item_list as $key ) {

            $total_order_qty=$key['qty'] * $key['pack_size'] ;

              $batches=$key['item']['batches'];
             $mrp=0; $b_n=''; $exp='';
 
            $seleted_batch=[];
            if(count($batches)>0)
               { 
                   $r_t=$total_order_qty; $r_q=$key['qty']; $r_p=$key['pack_size']; $r_u=$key['unit'];

                for ($i=0;$i< count($batches);$i++) {
                    if($batches[$i]['qty']>$r_t)
                    {
                        $tp= 0.85 * $batches[$i]['mrp'];
                         $tp=round($tp,2);

                        $b=['unit'=>$r_u,'qty'=>$r_q,'pack_size'=>$r_p,'total_qty'=>$r_t,'stock_qty'=>$batches[$i]['qty'],'batch_no'=>$batches[$i]['batch_no'],'exp_date'=>$batches[$i]['exp_date'],'mrp'=>$batches[$i]['mrp'],'tp'=>$tp];
                        array_push($seleted_batch, $b);
                        break;
                    }
                    else
                    {
                      $tp= 0.85 * $batches[$i]['mrp'];
                         $tp=round($tp,2);

                        $b=['unit'=>'loose','qty'=>$batches[$i]['qty'],'pack_size'=>'1','total_qty'=>$batches[$i]['qty'],'stock_qty'=>$batches[$i]['qty'],'batch_no'=>$batches[$i]['batch_no'],'exp_date'=>$batches[$i]['exp_date'],'mrp'=>$batches[$i]['mrp'],'tp'=>$tp];
                        array_push($seleted_batch, $b);

                         $r_q=$r_t-$batches[$i]['qty']; $r_p=1; $r_u='loose';
                         $r_t=$r_q;
                    }
                }   //print_r(json_encode($seleted_batch));die;
                  foreach ($seleted_batch as $bat ) {
                      $item=array('item_id'=>$key['item_id'],'item_name'=>$key['item']['item_name'],'order_item_id'=>$key['id'],'order_qty'=>$total_order_qty,'batches'=>$batches);
                      $item=array_merge($item,$bat);
                      array_push($items, $item);
                  }
               }
               else
               {
                  $tp= 0.85 * $key['item']['mrp'];
                         $tp=round($tp,2);

                         if($key['item']['current_stock']>$key['qty'])
                         {
                              $u=$key['unit']; $q=$key['qty']; $p=$key['pack_size']; $t=$key['qty']*$key['pack_size'];
                         }
                         else
                         {
                          $u='loose'; $q=$key['item']['current_stock']; $p=1; $t=$key['item']['current_stock'];
                         }

                 $item=array('item_id'=>$key['item_id'],'item_name'=>$key['item']['item_name'],'order_item_id'=>$key['id'],'order_qty'=>$total_order_qty,'stock_qty'=>$key['item']['current_stock'],'unit'=>$u,'qty'=>$q,'pack_size'=>$p,'total_qty'=>$t,'batches'=>[],'mrp'=>$key['item']['mrp'],'tp'=>$tp,'exp_date'=>'');
                  array_push($items, $item); 
               }

               
              
            


            
            
            // if($order['quotation']!='' && $key['quotation_item']!='')
            // {
            //    $it=$key['quotation_item'];

              
            //    $rate=''; $bt=$it['business_type'];  $discount_type=$it['discount_type']; $discount_factor=$it['discount_factor']; $discounted_value=''; 

            //       if($bt=='flat_rate')
            //    {
            //     $rate=($it['mrp'] * 0.85 ) - $it['discount_factor'];
            //   $discount_factor=$tp-$rate;
            //   $discounted_value=$discount_factor;

            //      }
            //      elseif($bt=='tp_percent')
            //       {
            //      $discounted_value=round(($discount_factor / 100 )* $tp , 2 ) ; 
            //      $rate=$tp-$discounted_value;
            //        }
                 
            // }
            // else
            // {
                
            //     $cat=$customer->getRate($key['item_id']);
            //    $rate=$cat['rate']; $discount_type=$cat['discount_type']; $discount_factor=$cat['discount_factor']; $discounted_value=''; 
            //     $bt=$cat['business_type'];
            //   //print_r($cat);die;
            //     if($bt!='')
            //  { 
           
            // if($bt=='flat_rate')
            // {
            //     $discount_type='flat';
            //   $discount_factor=$tp-$rate;
            //   $discounted_value=$discount_factor;

            // }
            // elseif($bt=='tp_percent')
            // {
            //      $discount_type='percentage'; 
            //      $discounted_value=round(($discount_factor / 100 )* $tp , 2 ) ; 
                
            //      $rate=$tp-$discounted_value;
            // }
            
            //   }//$bt

            //   }

          // $rate=round($rate,2);

          //  $total=$rate * $total_qty;
          //   $total=round($total,2);
            
            
          }

          return response()->json($items, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
         $customers=Customer::where('status','1')->orWhere('id',$order['customer_id'])->get();
          $companies=Company::with('branches')->get();
        $categories=InventoryCategory::orderBy('name','asc')->get();

        $items=inventory::getItems();

        $branches = $order->company_id > 0 
        ? Branch::where('company_id', $order->company_id)->get()
        : collect();

        //$quotations=Quotation::select('id','doc_no','doc_date','customer_id')->where('customer_id',$order['customer_id'])->where('activeness','1')->where('approved','1')->orderBy('doc_no','desc')->doesntHave('order')->orWhere('id',$order['quotation_id'])->get();

        $latestRate = Rate::latest()->first();

        return view('sale.order', compact('order','customers','companies','categories','items','branches','latestRate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //$location_ids=$request->location_ids;

       $item_id=$request->item_id; 
        //$quotation_items_id=$request->quotation_items_id;
        $pivots_id=$request->pivots_id;
       //$units=$request->units;
        $qty=$request->qty;
        $av_qty=$request->av_qty;
        //$pack_sizes=$request->p_s;

          $rate=$request->rate;
         $disc=$request->disc;
        $unit_weight=$request->unit_weight;
        $unit_feet=$request->unit_feet;
        $pricing_by=$request->pricing_by;


         //print_r($items_id);die;

        /*$status=$request->status;
         
         if($status!=''){

         }
         else{

         $status=1;

          $balance_due=str_replace(',', '', $request->balance_due);

        $credit_limits=str_replace(',', '', $request->credit_limits);
         $total_amount=str_replace(',', '', $request->total_amount);

         $net=$balance_due+$total_amount;
            
         if($net>=$credit_limits)
            $status=3;
        }*/


        $order=Order::find($request->id);

        if($order['status']==4){
            return redirect()->back()->withErrors(['error'=>'You can not update the rejected order.']);
        }

        $order->doc_no=$request->doc_no;
        $order->order_date=$request->order_date;
        $order->po_no=$request->po_no;
        $order->po_date=$request->po_date;
        
        
        //$order->status=$status;
        
        $order->customer_id=$request->customer_id;
        $order->invoice_type=$request->invoice_type;
         /*$order->dispatch_to_id=$request->dispatch_to_id;
        $order->invoice_to_id=$request->invoice_to_id;
        $order->quotation_id=$request->quotation_id;*/
        $order->remarks=$request->remarks;

        //$order->financial_year=$request->financial_year;
        $order->company_id=$request->company_id;

        $order->branch_id=$request->branch_id;
        $order->po_date=$request->po_date;

        $order->freight_charges=str_replace(',', '', $request->freight_charges);
        $order->loading_charges=str_replace(',', '', $request->loading_charges);
        //$order->tax1=$request->tax1;
        //$order->tax2=$request->tax2;
        //$order->tax3=$request->tax3;

        $order->last_sales=str_replace(',', '', $request->last_sales);
        $order->current_month_sales=str_replace(',', '', $request->current_month_sales);
        $order->current_year_sales=str_replace(',', '', $request->current_year_sales);
        $order->credit_days=str_replace(',', '', $request->credit_days);
        $order->avg_days=str_replace(',', '', $request->avg_days);
        $order->balance_due=str_replace(',', '', $request->balance_due);
        $order->credit_limits=str_replace(',', '', $request->credit_limits);
        $order->remaining_limit=str_replace(',', '', $request->remaining_limit);
        $order->previous_balance=str_replace(',', '', $request->previous_balance);


        $order->save();
                  

    $items=order_item::where('order_id',$order['id'])->whereNotIn('id',$pivots_id)->get();

        foreach ($items as $tr) {
            $tr->delete();
        }

           for ($i=0;$i<count($item_id);$i++)
           {

                if(!$item_id[$i]>0)
                    continue;

                $qty_p=str_replace(',', '',$qty[$i]);
               $rate_p=str_replace(',', '',$rate[$i]);
               $disc_p=str_replace(',', '',$disc[$i]);
               $unit_weight_p=str_replace(',', '',$unit_weight[$i]);
               $unit_feet_p=str_replace(',', '',$unit_feet[$i]);


                 if($pivots_id[$i]!=0)
                 $item=order_item::find($pivots_id[$i]);
                  else
                  $item=new order_item;

                $item->order_id=$order['id'];
                $item->item_id=$item_id[$i];
                $item->av_qty=$av_qty[$i];
                $item->qty=$qty_p;
                 $item->rate=$rate_p;
                $item->discount=$disc_p;
                $item->unit_weight=$unit_weight_p;
                $item->unit_feet=$unit_feet_p;
                $item->pricing_by=$pricing_by[$i];
                
                $item->save();
           }

            $order->total_amount=$order->total_amount();
            $order->total_weight=$order->total_weight();

            $order->save();

            foreach($order->item_list as $item) {

               $amount=$order->item_amount($item['item']['id'],$item['id']);

               $item->total_amount=$amount;
               $item->save();

           }

           $msg='Order Updated!';

           if($status==3)
           $msg='Sale Order has been updated but requires CEO approval because the customer outstanding balance exceeds the credit limit.';


            if($status==4)
            {
                return redirect('/order/history')->with('success','Order rejected.');
            }

                  return redirect()->back()->with('success',$msg);
    }

    public function order_report(Order $order)
    {
    
          $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $data = [
            
            'order'=>$order,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.order_pdf',compact('order','name','address','logo'));
           view()->share('sale.order_pdf',$data);
        $pdf = PDF::loadView('sale.order_pdf', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('sale.order_pdf.pdf');
    }

    public function order_report1(Order $order)
    {
    
          

         $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $head_office=Configuration::company_head_office();
        $logo=Configuration::company_logo();
        $phone=Configuration::company_phone();
        $mobile=Configuration::company_mobile();
        $whats_app=Configuration::company_whats_app();
         $fax=Configuration::company_fax();
          $email=Configuration::company_email();
           $tag_line=Configuration::company_tag_line();


        $data = [
            
            'order'=>$order,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
            'phone'=>$phone,
            'mobile'=>$mobile,
            'whats_app'=>$whats_app,
            'fax'=>$fax,
            'email'=>$email,
            'head_office'=>$head_office,
            'tag_line'=>$tag_line,

        ];
       // return view('sale.order_pdf1',compact('order','name','address','logo','phone','mobile','whats_app','fax','email','head_office','tag_line'));
           view()->share('sale.order_pdf1',$data);
        $pdf = PDF::loadView('sale.order_pdf1', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('sale.order_pdf1.pdf');
    }

    public function order_form(Order $order)
    {
    
          $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $data = [
            
            'order'=>$order,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.order_pdf',compact('order','name','address','logo'));
           view()->share('sale.order_form',$data);
        $pdf = PDF::loadView('sale.order_form', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('sale.order_form.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
         $challan=Deliverychallan::where('order_id',$order['id'])->first();


            if($challan!='')
             return redirect()->back()->withErrors(['error'=>'Delete DC first, than sale orde!']);

         $order->items()->detach();
         $order->delete();

        return redirect(url('order/create'))->with('success','Order Deleted!');
    }
}
