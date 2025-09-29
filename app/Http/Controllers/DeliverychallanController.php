<?php

namespace App\Http\Controllers;

use App\Models\Deliverychallan;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\rate_type;
use App\Models\InventoryDepartment;
use App\Models\outgoing_stock;
use App\Models\Transection;
use App\Models\Sale;
use App\Models\salereturn_ledger;
use App\Models\stock_transfer_ledger;
use App\Models\Configuration;
use App\Models\inventory;
use App\Models\InventoryCategory;
use App\Models\Company;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use PDF;

class DeliverychallanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $challans = Deliverychallan::query();

        if(isset($request['status']) && $request['status']!='')
        {
            if($request['status']==1){
                $challans = $challans->doesntHave('sale_invoice')->where('status','1');
            }

        }

         $challans = $challans->orderBy('doc_no','desc')->get();

        return view('sale.challans',compact('challans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $customers=Customer::where('status','1')->select('id','name','mobile','address')->get();
        $companies=Company::with('branches')->get();

        $categories=InventoryCategory::orderBy('name','asc')->get();

          $items=inventory::getItems();


           
        $doc_no="DC-".Date("y")."-";
        $num=1;

         $order=Deliverychallan::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->latest()->first();
         if($order=='')
         {
              $let=sprintf('%05d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $order['doc_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%05d', $num);
              $doc_no=$doc_no. $let;
         }

        
     
  
         
             
         /*$its=inventory::where('department_id',1)->where(function($q){
            $q->where('status','like','1');
         })->get();

            $inventories=[];
         foreach ($its as $key ) {
             
             $uom='';
             if(isset($key['unit']))
                $uom=$key['unit'];
            
             $q=$key->closing_stock();



        $it=['id'=>$key['id'],'item_name'=>$key['item_name'],'unit'=>$uom,'mrp'=>$key['mrp'],'qty'=>$q,'batches'=>$key['batches']];

             array_push($inventories, $it);
         }*/

         //print_r(json_encode($customers));die;
         
        //$methods=Configuration::transport_methods();

         $today = now(); // Carbon instance

// If current month >= July, financial year is current year - next year
if ($today->month >= 7) {
    $financialYear = $today->year . '-' . ($today->year + 1);
} else {
    // Else it's last year - current year
    $financialYear = ($today->year - 1) . '-' . $today->year;
}

$branches=[];

           $order = new Deliverychallan(); // empty instance
             $order->doc_no = $doc_no;
             $order->financial_year = $financialYear;

         if(isset($request['order']) && $request['order']>0 ){
        
                  $clone_order= Order::find($request->order);

                  if($clone_order['id']>0){

                     $order->order_id = $clone_order['id'];
                      $order->order_no = $clone_order['doc_no'];
                      $order->order_date = $clone_order['order_date'];
                       $order->customer_id = $clone_order['customer_id'];
                       $order->company_id = $clone_order['company_id'];
                       $order->branch_id = $clone_order['branch_id'];

                       $order->freight_charges = $clone_order['freight_charges'];
                       $order->loading_charges = $clone_order['loading_charges'];

                         $branches = $clone_order->company_id > 0 
                      ? Branch::where('company_id', $clone_order->company_id)->get()
                      : collect();


                      $clone_items=[];  

                       foreach($clone_order->items as $it){

                        
                           $it['pivot']['id']=0;
                           
                        $clone_items[]=$it;



                       }

                      $order->items = $clone_items;
                  }
           }

             

        return view('sale.delivery_challan',compact('categories','customers','order','items','companies','branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $chln=Deliverychallan::where('doc_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->withErrors(['error'=>'Doc No. already existed!']);
       // $location_ids=$request->location_ids;

       $item_id=$request->item_id;
       //$units=$request->units;
        $qty=$request->qty;
        $av_qty=$request->av_qty;
        $av_rack_qty=$request->av_rack_qty;
        //$pack_sizes=$request->p_s;

        $unit_feet=$request->unit_feet;
        $unit_weight=$request->unit_weight;
        $rack=$request->rack;
        $rack_qty=$request->rack_qty;
        $loading_sq=$request->loading_sq;

        //$mrps=$request->mrp;
        //$batch_nos=$request->batch_no;
        //$expiry_dates=$request->expiry_date;
          //$order_items_id=$request->order_items_id;

        // $business_type=$request->business_type;
        // $discount_types=$request->discount_type;
        // $discount_factors=$request->discount_factor;
        // $taxs=$request->tax;

         
         $status=$request->status;
        if($status=='')
            $status='0';

        /*$delivered=$request->delivered;
        if($delivered=='')
            $delivered='0';*/


        $challan=new Deliverychallan;

        $challan->doc_no=$request->doc_no;
        $challan->doc_date=$request->doc_date;
        
        
        $challan->status=$status;
        //$challan->delivered=$delivered;
        $challan->customer_id=$request->customer_id;

       $challan->deliver_via=$request->deliver_via;
       $challan->bilty_no=$request->bilty_no;
        $challan->bilty_type=$request->bilty_type;

        $challan->order_id=$request->order_id;
        $challan->remarks=$request->remarks;
         $challan->user_id = Auth::id();

        $challan->financial_year=$request->financial_year;
        $challan->company_id=$request->company_id;

        $challan->branch_id=$request->branch_id;
        

        $challan->freight_charges=str_replace(',', '', $request->freight_charges);
        $challan->loading_charges=str_replace(',', '', $request->loading_charges);

        $challan->save();
            
            for($i=0;$i<count($item_id);$i++)
            {

               if(!$item_id[$i]>0)
                    continue;
                
                $qty_p=str_replace(',', '',$qty[$i]);
               $unit_weight_p=str_replace(',', '',$unit_weight[$i]);
               $unit_feet_p=str_replace(',', '',$unit_feet[$i]);

         $challan->items()->attach($item_id[$i] , ['av_qty' => $av_qty[$i], 'av_rack_qty'=>$av_rack_qty[$i], 'qty' => $qty_p , 'unit_weight' => $unit_weight_p ,'unit_feet'=>$unit_feet_p ,'rack'=>$rack[$i] ,'rack_qty'=>$rack_qty[$i] ,'loading_sq'=>$loading_sq[$i]]);
           }

          /* foreach ($challan->outgoing_stock_list as $item) {
              
             $rate=$item['item']->get_cost_rate($item['batch_no']);
               $amount= $rate * ($item['qty'] * $item['pack_size'] );
           // //print_r(json_encode($item['item']['id']));die;
               $remarks=$item['item']['item_name'].' ('.$rate.'*'.$item['qty'].')';

        $customer_acc=InventoryDepartment::find($item['item']['department_id'])->account_id;
           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Deliverychallan';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;
           $trans->save();

           $customer_acc=InventoryDepartment::find($item['item']['department_id'])->cgs_account_id;
           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Deliverychallan';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();



           }*/

         return redirect('/edit/delivery-challan/'.$challan['id'])->with('success','Delivery Challan genrated!');
    }

    public function challan_report(Deliverychallan $deliverychallan,$report_type)
    {
           $challan=$deliverychallan;
             $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $data = [
            
            'challan'=>$challan,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];    
        //return view('sale.challan_pdf',compact('data'));
         if($report_type=='local')
         {
           view()->share('sale.challan_pdf',$data);
        $pdf = PDF::loadView('sale.challan_pdf', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($challan['doc_no'].'.pdf');
      }
      elseif($report_type=='tendor')
         {
           view()->share('sale.challan_pdf2',$data);
        $pdf = PDF::loadView('sale.challan_pdf2', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($challan['doc_no'].'.pdf');
      }
    }

    public function challan_form(Deliverychallan $deliverychallan)
    {
           $challan=$deliverychallan;
             $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $data = [
            
            'challan'=>$challan,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.challan_pdf',compact('data'));
           view()->share('sale.challan_form',$data);
        $pdf = PDF::loadView('sale.challan_form', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('sale.challan_form.pdf');
    }

     public function challan_report1(Deliverychallan $deliverychallan)
    {
           $challan=$deliverychallan;
            
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
            
            'challan'=>$challan,
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
        //return view('sale.challan_pdf',compact('data'));
           view()->share('sale.challan_pdf1',$data);
        $pdf = PDF::loadView('sale.challan_pdf1', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('sale.challan_pdf1.pdf');
    }

    public function warranty_invoice($item_by,Deliverychallan $deliverychallan)
    {

             $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();


           $challan=$deliverychallan;
        $data = [
            
            'challan'=>$challan,
            'item_by'=>$item_by,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.fahmir_warranty',compact('data'));
        if($item_by=='fahmir')
        {
           view()->share('sale.fahmir_warranty',$data);
        $pdf = PDF::loadView('sale.fahmir_warranty', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('sale.fahmir_warranty.pdf');
        }
        elseif($item_by=='alsehat')
        {
           view()->share('sale.alsehat_warranty',$data);
        $pdf = PDF::loadView('sale.alsehat_warranty', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('sale.alsehat_warranty.pdf');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deliverychallan  $deliverychallan
     * @return \Illuminate\Http\Response
     */
    public function show(Deliverychallan $deliverychallan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deliverychallan  $deliverychallan
     * @return \Illuminate\Http\Response
     */
    public function edit(Deliverychallan $deliverychallan)
    {
       $customers=Customer::where('status','1')->select('id','name','mobile','address')->get();

       $companies=Company::with('branches')->get();

        $categories=InventoryCategory::orderBy('name','asc')->get();

          $items=inventory::getItems();

        /*$its=inventory::where('department_id',1)->where(function($q){
            $q->where('status','like','1');
         })->get();

            $inventories=[];
         foreach ($its as $key ) {
             
             $uom='';
             if(isset($key['unit']))
                $uom=$key['unit'];
            
             $q=$key->closing_stock();
               
               $ids=$deliverychallan->outgoing_stock_list()->select('batch_no')->distinct()->pluck('batch_no')->toArray();
               //print_r($ids);die;
             $batches=$key->getCurrentBatchesExcept($ids);

        $it=['id'=>$key['id'],'item_name'=>$key['item_name'],'unit'=>$uom,'mrp'=>$key['mrp'],'qty'=>$q,'batches'=>$batches];

             array_push($inventories, $it);
         }*/

        $order=$deliverychallan;



        $branches = $order->company_id > 0 
        ? Branch::where('company_id', $order->company_id)->get()
        : collect();

       // $methods=Configuration::transport_methods();

        return view('sale.delivery_challan',compact('categories','items','customers','order','companies','branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deliverychallan  $deliverychallan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

      $chln=Deliverychallan::where('id','<>',$request->id)->where('doc_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->withErrors(['error'=>'Doc No. already existed!']);


       // $location_ids=$request->location_ids;
        $pivot_ids=$request->pivots_id;
       $item_id=$request->item_id;
       //$units=$request->units;
        $qty=$request->qty;
        $av_qty=$request->av_qty;
        $av_rack_qty=$request->av_rack_qty;
        //$pack_sizes=$request->p_s;

        $unit_feet=$request->unit_feet;
        $unit_weight=$request->unit_weight;
        $rack=$request->rack;
        $rack_qty=$request->rack_qty;
        $loading_sq=$request->loading_sq;

        /*$mrps=$request->mrp;
        $batch_nos=$request->batch_no;
        $business_type=$request->business_type;
        $expiry_dates=$request->expiry_date;
         $discount_types=$request->discount_type;
        $discount_factors=$request->discount_factor;
        $taxs=$request->tax;*/
         
         $status=$request->status;
        if($status=='')
            $status='0';

         /*$delivered=$request->delivered;
        if($delivered=='')
            $delivered='0';*/


        $challan= Deliverychallan::find($request->id);

        $challan->doc_no=$request->doc_no;
        $challan->doc_date=$request->doc_date;
        
        
        $challan->status=$status;
        //$challan->delivered=$delivered;
        $challan->customer_id=$request->customer_id;

        $challan->deliver_via=$request->deliver_via;
       $challan->bilty_no=$request->bilty_no;
        $challan->bilty_type=$request->bilty_type;


        $challan->order_id=$request->order_id;
        $challan->remarks=$request->remarks;

        $challan->financial_year=$request->financial_year;
        $challan->company_id=$request->company_id;

        $challan->branch_id=$request->branch_id;
        

        $challan->freight_charges=str_replace(',', '', $request->freight_charges);
        $challan->loading_charges=str_replace(',', '', $request->loading_charges);
        

        $challan->save();

    $items=outgoing_stock::where('challan_id',$challan['id'])->whereNotIn('id',$pivot_ids)->get();

        foreach ($items as $tr) {
            $tr->delete();
        }

           for ($i=0;$i<count($item_id);$i++)
           {

                  if(!$item_id[$i]>0)
                    continue;

                 if($pivot_ids[$i]!=0)
                 $item=outgoing_stock::find($pivot_ids[$i]);
                  else
                  $item=new outgoing_stock;


              $qty_p=str_replace(',', '',$qty[$i]);
               $unit_weight_p=str_replace(',', '',$unit_weight[$i]);
               $unit_feet_p=str_replace(',', '',$unit_feet[$i]);

                $item->challan_id=$challan['id'];
                $item->item_id=$item_id[$i];
                //$item->unit=$units[$i];
                $item->qty=$qty_p;
                $item->av_qty=$av_qty[$i];
                $item->av_rack_qty=$av_rack_qty[$i];

                $item->unit_feet=$unit_feet_p;
                $item->unit_weight=$unit_weight_p;
                $item->rack=$rack[$i];
                $item->rack_qty=$rack_qty[$i];
                $item->loading_sq=$loading_sq[$i];

                //$item->pack_size=$pack_sizes[$i];
                //$item->mrp=$mrps[$i];
                //$item->batch_no=$batch_nos[$i];
                //$item->expiry_date=$expiry_dates[$i];
                // $item->business_type=$business_type[$i];
                // $item->discount_type=$discount_types[$i];
                // $item->discount_factor=$discount_factors[$i];
                // $item->tax=$taxs[$i];
                $item->save();
           }

           
            /*$transections=$challan->transections;

            $no=0;
           foreach ($challan->outgoing_stock_list as $item) {

               

               $rate=$item['item']->get_cost_rate($item['batch_no']);
               $amount= $rate * ($item['qty'] * $item['pack_size'] );
           // //print_r(json_encode($item['item']['id']));die;
               $remarks=$item['item']['item_name'].' ('.$rate.'*'.$item['qty'].')';

        $customer_acc=InventoryDepartment::find($item['item']['department_id'])->account_id;
          if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;

           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Deliverychallan';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;
           $trans->save();
           $no++;

           $customer_acc=InventoryDepartment::find($item['item']['department_id'])->cgs_account_id;
          if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;

           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Deliverychallan';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();
           $no++;

           }
          
            for($i=$no; $i < count($transections); $i++ )
           {
               $transections[$i]->delete();
           }*/

         

                  return redirect()->back()->with('success','Delivery Challan Updated!');
    }

    public function new_customer_challan(Request $request)
    {
        $customer_id=$request->customer_id;
          $orders=Deliverychallan::select('id','doc_no','doc_date','customer_id')->where('customer_id',$customer_id)->where('status','1')->orderBy('doc_no','desc')->doesntHave('sale_invoice')->get();

          return response()->json($orders, 200);
    }

    public function get_challan(Request $request)
    {
        $challan_id=$request->challan_id;
        $challan=Deliverychallan::find($challan_id);

          $customer_id=$challan['customer_id'];
          $customer=Customer::find($customer_id);
          $type_id=$customer['customer_type_id'];

          if($type_id!='' || $type_id!=0)
          {
             $type=rate_type::find($type_id);
             //$category=$type['category'];
          }

          $items=array();

          foreach ($challan->outgoing_stock_list as $key ) {

            $total_qty=$key['qty'] * $key['pack_size'] ;

            // $tp= 0.85 * $key['mrp'];

            // $tp=round($tp,2);

            
            $rate=0; $discount_type=''; $discount_factor='percentage'; $discounted_value='';  $d_rate='';
            
        if(isset($challan['order']['quotation']) &&  isset($key['order_item']['quotation_item']))
            {
               $it=$key['order_item']['quotation_item'];

             
               $rate=$it['rate']; //$bt=$it['business_type'];  
               $discount_type=$it['discount_type']; $discount_factor=$it['discount_factor']; $discounted_value=''; 

                  if($discount_type=='flat')
               {
                $d_rate=$rate - $discount_factor;
              
              $discounted_value=$discount_factor;

                 }
                 elseif($discount_type=='percentage')
                  {
            $discounted_value=round(($discount_factor / 100 )* $rate , 2 ) ; 
                 $d_rate=$rate-$discounted_value;
                   }
                 
            }
            else
            {
                
                $cat=$customer->getRate($key['item_id']);
               $rate=$cat; 
               //$discount_type=$cat['discount_type']; $discount_factor=$cat['discount_factor']; $discounted_value=''; 
                //$bt=$cat['business_type'];
              //print_r($cat);die;
               // if($bt!='')
             //{ 
           
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
            
              //}//$bt

              }//end else

            // if($key['pivot']['discount_factor']!='')
            // {
            //     $rate=0; 
            //     $bt=$key['pivot']['business_type'];
            //     $discount_type=$key['pivot']['discount_type']; 
            //     $discount_factor=$key['pivot']['discount_factor']; 
            //     $discounted_value='';

            //     if($discount_type=='flat')
            // {
            
            //       $rate=$tp-$discount_factor;
    
            //   $discounted_value=$discount_factor;

            // }
            // elseif($discount_type=='percentage')
            // {

            //      $discounted_value=round(($discount_factor / 100 )* $tp , 2 ) ; 
            //      $rate=$tp-$discounted_value;
            // }

            //   $rate=round($rate,2);
            // } 

      //       else
      //       {

      //       if($type_id!='')
      //     { 
            
      //          $ad=''; $category='';
      //         $t=$type->items->where('id',$key['id'])->first();
              
      //         if($t!='')
      //         {$ad=$t->pivot->rate;  $category=$t['bt'];}


      //         if( $ad != '')
      //         {
      //       if($category=='flat_rate')
      //       {
      //           $discount_type='flat_rate';
      //             $rate=$ad;
      //         $discount_factor=$tp-$rate;
      //         $discounted_value=$discount_factor;

      //       }
      //       elseif($category=='tp_percent')
      //       {
      //            $discount_type='percentage'; 

      //            $discount_factor=$ad; 

      //            $discounted_value=round(($ad / 100 )* $tp , 2 ) ; 
      //            $rate=$tp-$discounted_value;
      //       }
      //       }//End if ad !=''
      //          $rate=round($rate,2);
      //     }

      // }//else

           $total=$rate * $total_qty;
            $total=round($total,2);
            
            $item=array('item_id'=>$key['item']['id'],'item_name'=>$key['item']['item_name'],'location_id'=>$key['item']['department']['id'],'location_text'=>$key['item']['department']['name'],'unit'=>$key['unit'],'qty'=>$key['qty'],'pack_size'=>$key['pack_size'],'total_qty'=>$total_qty,'mrp'=>$key['mrp'],'batch_no'=>$key['batch_no'],'expiry_date'=>$key['expiry_date'], 'discount_type'=>$discount_type , 'discount_factor'=>$discount_factor , 'discounted_value'=>$discounted_value, 'rate'=>$rate,'discounted_rate'=>$d_rate, 'total'=>$total ,'tax'=>0,'tax_amount'=>0,'net_amount'=>$total);

            array_push($items, $item);
          }
        $challan=array('salesman_id'=>$customer['so_id'],'items'=>$items);
          return response()->json($challan, 200);
    }

    

    

    public function get_transfer_item(Request $request)
    {
          $stock_id=$request->sale_stock_id;
          $from_id=$request->from_id;
          $to_id=$request->to_id;

         $customer=Customer::find($to_id);
         $type_id=$customer['customer_type_id'];
           
           $category='';

          if($type_id!='')
          {
             $type=rate_type::find($type_id);
             $category=$type['category'];
          }

          
       $stock=outgoing_stock::with('challan','item','item.department','item.unit','item.size','item.color')->find($stock_id);

           $total_qty=$stock['qty'] * $stock['pack_size'] ;

            $tp= 0.85 * $stock['mrp'];

            $tp=round($tp,2);

            //from
              $from_discount_type=$stock['discount_type']; 
              $from_discount_factor=$stock['discount_factor']; 
             $from_business_type=$stock['business_type'];
             $from_discounted_value=$stock['discount_value'];
             $from_tax=$stock['tax'];
             $from_discounted_rate=$tp - $from_discounted_value ;
             $from_total=$total_qty * $from_discounted_rate;
             $from_tax_amount=($from_tax/100)* $from_discounted_rate;

             $from_rate= $from_discounted_rate + $from_tax_amount;
             $from_net_total= $total_qty * $from_rate;

             

            //to
            $to_rate=0; $to_discount_type=''; $to_discount_factor=''; $to_discounted_value=''; 

            if($type_id!='')
          { 
              $ad=$type->items->where('id',$stock['item_id'])->first()->pivot->rate;
              if( $ad != '')
              {
            if($category=='flat_rate')
            {
                $to_discount_type='flat';
                  $to_rate=$ad;
              $to_discount_factor=round ($tp-$to_rate,2);
              $to_discounted_value=$to_discount_factor;

            }
            elseif($category=='tp_percent')
            {
                 $to_discount_type='percentage'; 

                 $to_discount_factor=$ad; 

                 $to_discounted_value=round(($ad / 100 )* $tp , 2 ) ; 
                 $to_rate=$tp-$to_discounted_value;
            }
            }//End if ad !=''
               $to_rate=round($to_rate,2);
          }

           $to_total=$to_rate * $total_qty;
            $to_total=round($to_total,2);

            $challan_id=$stock['challan_id'];
            $challan_no='';
            if($challan_id!='')
                $challan_no=Deliverychallan::find($challan_id)->doc_no;
            
            $item=array('challan_id'=>$challan_id,'challan_no'=>$challan_no,'item_id'=>$stock['item']['id'],'item_name'=>$stock['item']['item_name'],'location_id'=>$stock['item']['department']['id'],'location_text'=>$stock['item']['department']['name'],'unit'=>$stock['unit'],'qty'=>$stock['qty'],'pack_size'=>$stock['pack_size'],'total_qty'=>$total_qty,'mrp'=>$stock['mrp'],'batch_no'=>$stock['batch_no'],'expiry_date'=>$stock['expiry_date'],'tp'=>$tp , 'from_business_type'=>$from_business_type, 'from_discount_type'=>$from_discount_type , 'from_discount_factor'=>$from_discount_factor , 'from_discounted_value'=>$from_discounted_value, 'from_rate'=>$from_discounted_rate, 'from_total'=>$from_total ,'from_tax'=>$from_tax,'from_tax_amount'=>$from_tax_amount,'from_net_amount'=>$from_net_total  , 'to_business_type'=>$category, 'to_discount_type'=>$to_discount_type , 'to_discount_factor'=>$to_discount_factor , 'to_discounted_value'=>$to_discounted_value, 'to_rate'=>$to_rate, 'to_total'=>$to_total ,'to_tax'=>0,'to_tax_amount'=>0,'to_net_amount'=>$to_total);

             return response()->json($item, 200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deliverychallan  $deliverychallan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deliverychallan $challan)
    {
         $sale=Sale::where('challan_id',$challan['id'])->first();


            if($sale!='')
             return redirect()->back()->withErrors(['error'=>'Delete sale invoice first, than DC!']);

           
           
            $transfer=stock_transfer_ledger::where('challan_id',$challan['id'])->first();

            if($transfer!='')
             return redirect()->back()->withErrors(['error'=>'Delete stock transfer first, than DC!']);


         $challan->items()->detach();


            foreach($challan->transections as $trans )
           {
               $trans->delete();
           }


         $challan->delete();

        return redirect(url('delivery-challan/create'))->with('success','DC Deleted!');
    }
}
