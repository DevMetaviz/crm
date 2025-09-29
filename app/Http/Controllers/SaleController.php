<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\InventoryDepartment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\sale_stock;
use App\Models\Transection;
use App\Models\rate_type;
use App\Models\Configuration;
use App\Models\salereturn_ledger;
use App\Imports\SalesImport;
use App\Models\inventory;
use App\Models\Expense;
use App\Models\Transportation;
use App\Models\packing_type;
use App\Models\Port;
use App\Models\freight_type;
use App\Models\Currency;
use App\Models\InventoryCategory;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Deliverychallan;
use App\Models\Order;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use App\Models\Rate;
use PDF;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales=Sale::orderBy('doc_no', 'desc')->get();

        return view('sale.sale_history',compact('sales'));
    }

    public function sale_ledger_summary(Request $request)
    {
         $from=$request->from;
         $to=$request->to;

         
           
           if($from!='' || $to!='')
         $lists=Sale::where('doc_date','>=',$from)->where('doc_date','<=',$to)->orderBy('doc_date','asc')->get();
       else
        $lists=Sale::orderBy('doc_date','asc')->get();

         $config=array('from'=>$from,'to'=>$to);

         return view('sale.reports.sale_ledger_summary',compact('lists','config'));
    }

    public function get_doc_no(Request $request)
    {
        
            $type=$request->type;

         $doc_no="SI-".Date("y")."-";

         if($type=='local')
         $doc_no="SI-".Date("y")."-";
         elseif($type=='export')
            $doc_no="FP/EXP-".Date("y")."-";

        $num=1;

         $order=Sale::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->where('type',$type)->latest()->first();

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

          return response()->json($doc_no, 200);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        

        $doc_no="SI-".Date("y")."-";
        $num=1;

         //->where('type','local')
         $order=Sale::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->latest()->first();
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

        $customers=Customer::where('status','1')->get();
        $companies=Company::with('branches')->get();

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
           $order = new Sale(); // empty instance
             $order->doc_no = $doc_no;
             $order->financial_year = $financialYear;

             $branches=[];



         if(isset($request['challan']) && $request['challan']>0 ){
        
                  $clone_challan= Deliverychallan::find($request->challan);
                  $clone_order= Order::find($clone_challan->order_id);

                  if($clone_challan['id']>0){

                     $due_date=date('Y-m-d');  

                    if(isset($clone_challan['customer']['credit_days']) && $clone_challan['customer']['credit_days']>0)
                    $due_date=date('Y-m-d', strtotime('+ '.$clone_challan['customer']['credit_days'].' days'));

                     $order->challan_id = $clone_challan['id'];
                      $order->challan_no = $clone_challan['doc_no'];
                      $order->challan_date = $clone_challan['doc_date'];

                      $order->due_date = $due_date;
                       $order->customer_id = $clone_challan['customer_id'];
                       $order->company_id = $clone_challan['company_id'];
                       $order->branch_id = $clone_challan['branch_id'];

                       $order->freight_charges = $clone_challan['freight_charges'];
                       $order->loading_charges = $clone_challan['loading_charges'];

                        if(isset($clone_challan->order)){
                             $order->invoice_type=$clone_challan['order']['invoice_type'];
                          }

                         $branches = $clone_challan->company_id > 0 
                      ? Branch::where('company_id', $clone_challan->company_id)->get()
                      : collect();
                       

                       $clone_items=[];  

                       foreach($clone_challan->items as $it){

                        $item=$it;  $discount=0; $rate=$it['standard_rate']; $pricing_by=$it['pricing_by'];



                        if(isset($clone_challan->order)){

                            $it1=$clone_challan->order->items->where('id',$it['id'])->first();

                            if(isset($it1['id'])  && $it1['id']>0)
                            {
                                $discount=$it1['pivot']['discount']; 
                                $rate=$it1['pivot']['rate']; 
                                  $pricing_by=$it1['pivot']['pricing_by'];
                            }
                            

                        }

                       $item['pivot']['av_qty']=$item['pivot']['av_qty'];
                        $item['pivot']['discount']=$discount;
                        $item['pivot']['rate']=$rate;
                        $item['pivot']['pricing_by']=$pricing_by;
                        $item['pivot']['id']=0;

                        $clone_items[]=$item;

                       }

                      $order->items = $clone_items;
                  }
           }

        
        /*
        // $departments=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->get();
        $its=inventory::where('department_id',1)->where(function($q){
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

      //  $salesmen=Employee::where('is_so','1')->where('status','1')->orderBy('name')->get();

        //$expenses=Expense::where('status','1')->orderBy('name','asc')->get();
         //$currencies=Currency::where('status','1')->get();
     //$ports=Port::orderBy('text')->get();
     //$freight_types=freight_type::orderBy('text')->get();
     //$transportations=Transportation::orderBy('text')->get();
     //$packing_types=packing_type::orderBy('text')->get();


         $freight_ids=Configuration::find(47)->description;

         if($freight_ids!=''){
            $freight_ids=explode(',',$freight_ids);
         }

         $freight_expenses=Account::select('id','code','name')->whereIN('id',$freight_ids)->get();

         $latestRate = Rate::latest()->first();

        return view('sale.sale',compact('categories','customers','items','companies','branches','order','freight_expenses','latestRate'));

       // return view('sale.sale',compact('currencies','ports','transportations','packing_types','freight_types','salesmen','inventories','doc_no','customers','expenses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {

      $chln=Sale::where('doc_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->withErrors(['error'=>'Invoice No. already existed!']);

         $balance_due=str_replace(',', '', $request->balance_due);

        $credit_limits=str_replace(',', '', $request->credit_limits);
         $total_amount=str_replace(',', '', $request->total_amount);

         $net=$balance_due+$total_amount;
            
         if($net>=$credit_limits)
            return redirect()->back()->withErrors(['error'=>'Invoice can not be genrated becuase due balance exceeded to limits!']);

        //$location_ids=$request->location_ids;
       $item_id=$request->item_id;
         $qty=$request->qty;
          $av_qty=$request->av_qty;
       /*$units=$request->units;
      
        $pack_sizes=$request->p_s;
        $mrps=$request->mrp;
        //$tps=$request->tp;
        $batch_nos=$request->batch_no;
        $expiry_dates=$request->expiry_date;
        $rates=$request->rate;
        $discount_types=$request->discount_type;
        $discount_factors=$request->discount_factor;
        $taxs=$request->tax;*/


        $rate=$request->rate;
        $disc=$request->disc;
        $unit_weight=$request->unit_weight;
        $unit_feet=$request->unit_feet;
        $pricing_by=$request->pricing_by;

         
         $status=$request->status;
        if($status=='')
            $status='0';


        $challan=new Sale;

        $challan->doc_no=$request->doc_no;
        $challan->doc_date=$request->doc_date;  
        $challan->due_date=$request->due_date;

        $challan->invoice_type=$request->invoice_type;
        //$challan->type=$request->type;
        
        $challan->status=$status;
        $challan->customer_id=$request->customer_id;
        $challan->challan_id=$request->challan_id;
        // $challan->salesman_id=$request->salesman_id;
         //$challan->net_discount=$request->disc;
          //$challan->net_discount_type=$request->net_disc;

          //$challan->gst=$request->gst;
        $challan->remarks=$request->remarks;
        $challan->user_id = Auth::id();


        /*$challan->currency_id=$request->currency_id;
        $challan->cur_rate=$request->cur_rate;

        $challan->shipment_port_id=$request->shipment_port_id;
        $challan->discharge_port_id=$request->discharge_port_id;
        $challan->packing_type_id=$request->packing_type_id;
        $challan->freight_type_id=$request->freight_type_id;
        $challan->transportation_id=$request->transportation_id;*/

        //$challan->financial_year=$request->financial_year;
        $challan->company_id=$request->company_id;

        $challan->branch_id=$request->branch_id;
        
        $challan->last_sales=str_replace(',', '', $request->last_sales);
        $challan->current_month_sales=str_replace(',', '', $request->current_month_sales);
        $challan->current_year_sales=str_replace(',', '', $request->current_year_sales);
        $challan->credit_days=str_replace(',', '', $request->credit_days);
        $challan->avg_days=str_replace(',', '', $request->avg_days);
        $challan->balance_due=str_replace(',', '', $request->balance_due);
        $challan->credit_limits=str_replace(',', '', $request->credit_limits);
        $challan->remaining_limit=str_replace(',', '', $request->remaining_limit);
        $challan->previous_balance=str_replace(',', '', $request->previous_balance);
        
        $challan->freight_expense_id=$request->freight_expense_id;
        $challan->freight_charges=$request->freight_charges;
        $challan->loading_charges=$request->loading_charges;

        $challan->save();
            
            for($i=0;$i<count($item_id);$i++)
            {

                if(!$item_id[$i]>0)
                    continue;

                $qty_p=str_replace(',', '',$qty[$i]);
               $rate_p=str_replace(',', '',$rate[$i]);
               $disc_p=str_replace(',', '',$disc[$i]);
               $unit_weight_p=str_replace(',', '',$unit_weight[$i]);
               $unit_feet_p=str_replace(',', '',$unit_feet[$i]);

              /*$com_type=''; $com_value='';
              if($challan->salesman!='')
              {
                 $com=$challan->salesman->estimate_commission($challan['customer_id'],$item_id[$i]);
                $com_type=$com['type']; $com_value=$com['value'];
              }*/

         $challan->items()->attach($item_id[$i] , [ 'av_qty' => $av_qty[$i], 'qty' => $qty_p ,'rate'=>$rate_p ,'discount'=>$disc_p ,'unit_weight'=>$unit_weight_p ,'unit_feet'=>$unit_feet_p,'pricing_by'=>$pricing_by[$i]  ]);

           }

           $challan->total_amount=$challan->total_amount();
           $challan->total_weight=$challan->total_weight();

            $challan->save();

        $customer_acc=Customer::find($request->customer_id)->account_id;

           /*$gst_amount=$challan->gst_amount();
             if($gst_amount!=0)
             {
              $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Ref '.$challan['doc_no'].': Gst Amount';
           $trans->debit=$gst_amount;
           $trans->credit=0;
           $trans->save();

           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=776;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Ref '.$challan['doc_no'].': Gst Amount';
           $trans->debit=0;
           $trans->credit=$gst_amount;
           $trans->save();


             }*/

           foreach($challan->sale_stock_list as $item) {

                
               //$rate=$challan->rate($item['item']['id'],$item['id']);
               //$amount= $rate * ($item['qty'] * $item['pack_size'] );

               $amount=$challan->item_amount($item['item']['id'],$item['id']);


               $item->total_amount=$amount;
               $item->save();

               $remarks=$item['item']['item_name'].' ('.$amount.')';

        
           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks=$remarks;
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();

           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=368;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;
           $trans->save();

           /*$com=$item->commission();
            if($challan->salesman!='' && $com > 0)
              { 
                 $val=$item['commission_factor'];
               
                $remarks='Commission to '.$challan['salesman']['name'].' against '.$item['sale']['customer']['name'].' for '.$item['item']['item_name'].' ('.$item['qty'].')';
                $acc=$challan['salesman']['account_id'];

                     $trans=new Transection;

                     $trans->account_voucherable_id=$challan->id;
                     $trans->account_voucherable_type='App\Models\Sale';
                     $trans->account_id=$acc;
                     //$trans->corporate_id=$item['id'];
                     $trans->transection_date=$challan->doc_date;
                     $trans->remarks=$remarks;
                     $trans->debit=0;
                     $trans->credit=$com;
                     $trans->save();
                    
                     $trans=new Transection;

                     $trans->account_voucherable_id=$challan->id;
                     $trans->account_voucherable_type='App\Models\Sale';
                     $trans->account_id=369;
                     //$trans->corporate_id=$item['id'];
                     $trans->transection_date=$challan->doc_date;
                     $trans->remarks=$remarks;
                     $trans->debit=$com;
                     $trans->credit=0;
                     $trans->save();
                    
                }*/


           } 


    
           /*$amount=$challan->net_discount();
           if($amount > 0)
           {
              $remarks="Ref: Discount on Invoice : ".$challan['doc_no'];
           

         
           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;
           $trans->save();
         }*/
       
       
       if($challan->loading_charges > 0){

        $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Loading Charges';
           $trans->debit=$challan->loading_charges ;
           $trans->credit=0;
           $trans->save();

           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=998;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Loading Charges';
           $trans->debit=0;
           $trans->credit=$challan->loading_charges ;
           $trans->save();

       }

       if($challan->freight_charges > 0){

        $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Freight Charges';
           $trans->debit=$challan->freight_charges ;
           $trans->credit=0;
           $trans->save();

           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$challan->freight_expense_id;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Freight Charges';
           $trans->debit=0;
           $trans->credit=$challan->freight_charges ;
           $trans->save();

       }

       /*//expense
        $expense_ids=$request->expense_ids;
        $exp_amount=$request->exp_amount;
           //start expense

           if($expense_ids!='' || $expense_ids!=null)
            {
           for($i=0;$i<count($expense_ids);$i++)
            {
                 $amount=0; 

              if($exp_amount[$i]!='')
                $amount=$exp_amount[$i];

               $challan->expenses()->attach($expense_ids[$i] , ['amount' => $amount ]);
 
           }
           }

           foreach ($challan['expenses'] as $exp) 
             {
              $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Ref '.$challan['doc_no'].':'.$exp['name'];
           $trans->debit=$exp['pivot']['amount'];
           $trans->credit=0;
           $trans->save();

           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=775;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Ref '.$challan['doc_no'].':'.$exp['name'];
           $trans->debit=0;
           $trans->credit=$exp['pivot']['amount'];
           $trans->save();

             }*/

        return redirect('/edit/sale/'.$challan['id'])->with('success','Sale genrated!');
                  //return redirect()->back()->with('success','Sale genrated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $customers=Customer::where('status','1')->get();
        
        // $departments=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->get();

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
         }

        $items=array();
             foreach ($sale['items'] as $key ) {
                 
                 $pivot_id=$key['pivot']['id'];
                 $unit=$key['pivot']['unit'];
                 $qty=$key['pivot']['qty'];
                 $pack_size=$key['pivot']['pack_size'];
                 $total_qty=$qty * $pack_size;
                 $mrp=$key['pivot']['mrp'];
                 //$tp=round( (0.85 * $mrp  ),2);
                 $batch_no=$key['pivot']['batch_no'];
                 $expiry_date=$key['pivot']['expiry_date'];
                 $rate=$key['pivot']['rate'];
                 $discount_type=$key['pivot']['discount_type'];
                 $discount_factor=$key['pivot']['discount_factor'];

                 $discounted_value=0;

                 if($discount_type=='flat')
                    $discounted_value=$discount_factor;
                elseif($discount_type=='percentage')
                   $discounted_value=round( (($discount_factor/100)*$rate) ,2);

                  $d_rate=$rate- $discounted_value;
                  $total=round( ($total_qty * $d_rate),2);
                 //$tax=$key['pivot']['tax'];
                  //$tax_amount= round( (($tax/100)*$total),2);

                 // $net_amount = $tax_amount + $total ;

                    $item=array( 'item_id'=>$key['id'] , 'pivot_id'=>$pivot_id , 'location_id'=>$key['department_id'],'location_text'=>$key['department']['name'],'item_name'=>$key['item_name'],'unit'=>$unit,'qty'=>$qty,'pack_size'=>$pack_size,'mrp'=>$mrp,'batch_no'=>$batch_no,'expiry_date'=>$expiry_date,'total_qty'=>$total_qty,'discount_type'=>$discount_type,'discount_factor'=>$discount_factor,'discounted_value'=>$discounted_value,'rate'=>$rate,'discounted_rate'=>$d_rate,'total'=>$total);

                 array_push($items, $item);
             } //print_r(json_encode($items));die;

             */

        /*$salesmen=Employee::where('is_so','1')->where('status','1')->orderBy('name')->get();
         $expenses=Expense::where('status','1')->orderBy('name','asc')->get();
           $currencies=Currency::where('status','1')->get();
     $ports=Port::orderBy('text')->get();
     $freight_types=freight_type::orderBy('text')->get();
     $transportations=Transportation::orderBy('text')->get();
     $packing_types=packing_type::orderBy('text')->get();*/

        $customers=Customer::where('status','1')->get();
        $companies=Company::with('branches')->get();

        $categories=InventoryCategory::orderBy('name','asc')->get();

          $items=inventory::getItems();

           $order=$sale;



        $branches = $order->company_id > 0 
        ? Branch::where('company_id', $order->company_id)->get()
        : collect();

          $freight_ids=Configuration::find(47)->description;

         if($freight_ids!=''){
            $freight_ids=explode(',',$freight_ids);
         }

         $freight_expenses=Account::select('id','code','name')->whereIN('id',$freight_ids)->get();


         $latestRate = Rate::latest()->first();

         return view('sale.sale',compact('customers','companies','branches','categories','items','order','freight_expenses','latestRate'));

        //return view('sale.edit_sale',compact('currencies','ports','transportations','packing_types','freight_types','salesmen','inventories','sale','items','customers','expenses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


        //$location_ids=$request->location_ids;
        $pivot_ids=$request->pivots_id;
       $item_id=$request->item_id;
       
       $qty=$request->qty;
       $av_qty=$request->av_qty;

       $rate=$request->rate;
        $disc=$request->disc;
        $unit_weight=$request->unit_weight;
        $unit_feet=$request->unit_feet;
        $pricing_by=$request->pricing_by;

       /*$units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;

        $mrps=$request->mrp;
        //$tps=$request->tp;
        $batch_nos=$request->batch_no;
        $expiry_dates=$request->expiry_date;
        $discount_types=$request->discount_type;
        $discount_factors=$request->discount_factor;
        $rates=$request->rate;
        $taxs=$request->tax;*/

         
         $status=$request->status;
        if($status=='')
            $status='0';

        

        $challan=Sale::find($request->id);

                  
          $old_salesman_id=$challan['salesman_id'];

        $challan->doc_no=$request->doc_no;
        $challan->doc_date=$request->doc_date;
        $challan->due_date=$request->due_date;
        $challan->invoice_type=$request->invoice_type;
        //$challan->type=$request->type;
        $challan->status=$status;
        $challan->customer_id=$request->customer_id;
        $challan->challan_id=$request->challan_id;
         
         /*$challan->salesman_id=$request->salesman_id;
         $challan->net_discount=$request->disc;
          $challan->net_discount_type=$request->net_disc;
           $challan->gst=$request->gst;*/
        $challan->remarks=$request->remarks;

         /*$challan->currency_id=$request->currency_id;
        $challan->cur_rate=$request->cur_rate;

        $challan->shipment_port_id=$request->shipment_port_id;
        $challan->discharge_port_id=$request->discharge_port_id;
        $challan->packing_type_id=$request->packing_type_id;
        $challan->freight_type_id=$request->freight_type_id;
        $challan->transportation_id=$request->transportation_id;*/

        //$challan->financial_year=$request->financial_year;
        $challan->company_id=$request->company_id;

        $challan->branch_id=$request->branch_id;
        
       $challan->freight_expense_id=$request->freight_expense_id;
        $challan->freight_charges=$request->freight_charges;
        $challan->loading_charges=$request->loading_charges;

        $challan->last_sales=str_replace(',', '', $request->last_sales);
        $challan->current_month_sales=str_replace(',', '', $request->current_month_sales);
        $challan->current_year_sales=str_replace(',', '', $request->current_year_sales);
        $challan->credit_days=str_replace(',', '', $request->credit_days);
        $challan->avg_days=str_replace(',', '', $request->avg_days);
        $challan->balance_due=str_replace(',', '', $request->balance_due);
        $challan->credit_limits=str_replace(',', '', $request->credit_limits);
        $challan->remaining_limit=str_replace(',', '', $request->remaining_limit);
        $challan->previous_balance=str_replace(',', '', $request->previous_balance);

        $challan->save();
            
        $items=sale_stock::where('invoice_id',$challan['id'])->whereNotIn('id',$pivot_ids)->get();

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


                 if($pivot_ids[$i]!=0)
                 $item=sale_stock::find($pivot_ids[$i]);
                  else
                    $item=new sale_stock;
                  
               /* if($pivot_ids[$i]==0 || $old_salesman_id!=$challan['salesman_id'])
                  {
                    $com_type=''; $com_value='';
              if($challan->salesman!='')
              {
                 $com=$challan->salesman->estimate_commission($challan['customer_id'],$items_id[$i]);
                $com_type=$com['type']; $com_value=$com['value'];
                $item->commission_type=$com_type;
                $item->commission_factor=$com_value;
              }
            }

            if($challan->salesman=='')
              {
                $item->commission_type='';
                $item->commission_factor='';
              }*/



                $item->invoice_id=$challan['id'];
                $item->item_id=$item_id[$i];
                //$item->unit=$units[$i];
                $item->av_qty=$av_qty[$i];
                $item->qty=$qty_p;
                $item->rate=$rate_p;
                $item->discount=$disc_p;
                $item->unit_weight=$unit_weight_p;
                $item->unit_feet=$unit_feet_p;
                
                $item->pricing_by=$pricing_by[$i];
                
                
                /*$item->pack_size=$pack_sizes[$i];
                $item->mrp=$mrps[$i];
                $item->batch_no=$batch_nos[$i];
                $item->expiry_date=$expiry_dates[$i];
                $item->rate=$rates[$i];
                //$item->business_type=$business_type[$i];
                $item->discount_type=$discount_types[$i];
                $item->discount_factor=$discount_factors[$i];*/
              
                $item->save();
           }


           $challan->total_amount=$challan->total_amount();
           $challan->total_weight=$challan->total_weight();

            $challan->save();


            
            $transections=$challan->transections;

            // for ($i=0; $i < count($transections) ; $i++) { 
            //   print_r(json_encode($transections[$i]['account_id']));die;
            // }
            $no=0;

            $customer_acc=Customer::find($request->customer_id)->account_id;

           /*$gst_amount=$challan->gst_amount();
             if($gst_amount!=0)
             {

              if($no < count($transections))
          $trans=$transections[$no];
          else
              $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Ref '.$challan['doc_no'].': Gst Amount';
           $trans->debit=$gst_amount;
           $trans->credit=0;
           $trans->save();
           $no++;
          
          if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=776;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Ref '.$challan['doc_no'].': Gst Amount';
           $trans->debit=0;
           $trans->credit=$gst_amount;
           $trans->save();
           $no++;


             }*/

           foreach ($challan->sale_stock_list as $item) {

                
               //$rate=$challan->rate($item['item']['id'],$item['id']);
               //$amount= $rate * ($item['qty'] * $item['pack_size'] );


               $amount=$challan->item_amount($item['item']['id'],$item['id']);

               $item->total_amount=$amount;
               $item->save();

               $remarks=$item['item']['item_name'].' ('.$amount.')';

       

         if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;

           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks=$remarks;
           $trans->debit=$amount;
           $trans->credit=0;

           $trans->save();
           $no++;
          

           if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;

           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=368;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;
           $trans->save();
           $no++;
                 
                /* $com=$item->commission();
            if($challan->salesman!='' && $com > 0)
              { 
                 $val=$item['commission_factor'];
                //$remarks='Commission : '.$item['sale']['customer']['name'].' for '.$item['item']['item_name'].' ('.$item['qty'].')';
                $remarks='Commission to '.$challan['salesman']['name'].' against '.$item['sale']['customer']['name'].' for '.$item['item']['item_name'].' ('.$item['qty'].')';
                $acc=$challan['salesman']['account_id'];

                     if($no < count($transections))
                    $trans=$transections[$no];
                    else
                     $trans=new Transection;

                     $trans->account_voucherable_id=$challan->id;
                     $trans->account_voucherable_type='App\Models\Sale';
                     $trans->account_id=$acc;
                     //$trans->corporate_id=$item['id'];
                     $trans->transection_date=$challan->doc_date;
                     $trans->remarks=$remarks;
                     $trans->debit=0;
                     $trans->credit=$com;
                     $trans->save();
                     $no++;



                     if($no < count($transections))
                    $trans=$transections[$no];
                    else
                     $trans=new Transection;

                     $trans->account_voucherable_id=$challan->id;
                     $trans->account_voucherable_type='App\Models\Sale';
                     $trans->account_id=369;
                     //$trans->corporate_id=$item['id'];
                     $trans->transection_date=$challan->doc_date;
                     $trans->remarks=$remarks;
                     $trans->debit=$com;
                     $trans->credit=0;
                     $trans->save();
                     $no++;
                }*/

           }

            /* $amount=$challan->net_discount();
           if($amount > 0)
           {
              $remarks="Ref: Discount on Invoice : ".$challan['doc_no'];
           

        // $customer_acc=Customer::find($request->customer_id)->account_id;
            if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;
           $trans->save();
           $no++;
         }*/


         if($challan->loading_charges > 0){

        if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;
        
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Loading Charges';
           $trans->debit=$challan->loading_charges ;
           $trans->credit=0;
           $trans->save();

           $no++;

            if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;
           
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=998;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Loading Charges';
           $trans->debit=0;
           $trans->credit=$challan->loading_charges ;
           $trans->save();
           $no++;

       }


       if($challan->freight_charges > 0){

        if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;
        
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Freight Charges';
           $trans->debit=$challan->freight_charges ;
           $trans->credit=0;
           $trans->save();
           $no++;

           if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;

           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$challan->freight_expense_id;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Freight Charges';
           $trans->debit=0;
           $trans->credit=$challan->freight_charges ;
           $trans->save();
           $no++;

       }

           
           /*//expense
        $expense_ids=$request->expense_ids;
        $exp_amount=$request->exp_amount;
           //start expense

        $rel1=array();
            if($expense_ids!='' || $expense_ids!=null)
            {
           for($i=0;$i<count($expense_ids);$i++)
            {
                 $amount=0; 

              if($exp_amount[$i]!='')
                $amount=$exp_amount[$i];

              

              $pivot1=array('amount' => $amount   );

                $let1=array( $expense_ids[$i].'' => $pivot1 );

                $rel1=$rel1+$let1;

                            

               
           } 
           
              $challan->expenses()->sync($rel1);
           }
           else
           {  
            
            $challan->expenses()->detach();

           }

           foreach ($challan['expenses'] as $exp) 
             {

              if($no < count($transections))
          $trans=$transections[$no];
          else
              $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Ref '.$challan['doc_no'].':'.$exp['name'];
           $trans->debit=$exp['pivot']['amount'];
           $trans->credit=0;
           $trans->save();
           $no++;
            

            if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Sale';
           $trans->account_id=775;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks='Ref '.$challan['doc_no'].':'.$exp['name'];
           $trans->debit=0;
           $trans->credit=$exp['pivot']['amount'];
           $trans->save();
            $no++;

             }*/

             for($i=$no; $i < count($transections); $i++ )
           {
               $transections[$i]->delete();
           }



                  return redirect()->back()->with('success','Sale Updated!');
    }

    public function estimated_invoice(Sale $sale,$invoice_type)
    {

        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
           
          
           $total_net_qty=0;
           $total_amount=0;

           /*$items=array();
             foreach ($sale['items'] as $key ) {
                 
                 $unit=$key['pivot']['unit'];
                 $qty=$key['pivot']['qty'];
                 $pack_size=$key['pivot']['pack_size'];
                 $total_qty=$qty * $pack_size;
                 $mrp=$key['pivot']['mrp'];
                 $tp=round( (0.85 * $mrp  ),2);
                 $batch_no=$key['pivot']['batch_no'];
                 $expiry_date=$key['pivot']['expiry_date'];
                 $rate=$key['pivot']['rate'];
                 $discount_type=$key['pivot']['discount_type'];
                 $discount_factor=$key['pivot']['discount_factor'];

                 $discounted_value=0;
                 if($discount_type=='flat')
                    $discounted_value=$discount_factor;
                elseif($discount_type=='percentage')
                   $discounted_value=round( (($discount_factor/100)*$rate) ,2);

                  $d_rate=$rate- $discounted_value;
                  $total=round( ($total_qty * $d_rate),2);
                

                  $total_net_qty = $total_net_qty +  $total_qty;
                     $total_amount=$total_amount +  $total;
                  
                   $um='';
                   if(isset($key['unit']['name']))
                    $um=$key['unit']['name'];

                    $item=array('item_id'=>$key['id'],'location_id'=>$key['department_id'],'location_text'=>$key['department']['name'],'item_name'=>$key['item_name'],'um'=>$um,'unit'=>$unit,'qty'=>$qty,'pack_size'=>$pack_size,'mrp'=>$mrp,'tp'=>$tp,'batch_no'=>$batch_no,'expiry_date'=>$expiry_date,'total_qty'=>$total_qty,'discount_type'=>$discount_type,'discount_factor'=>$discount_factor,'discounted_value'=>$discounted_value,'rate'=>$rate,'discounted_rate'=>$d_rate,'total'=>$total);

                 array_push($items, $item);
             }
          $net_discount=$sale['net_discount'];
          $net_discount_type=$sale['net_discount_type'];
           $net_discount_value=0;
            if($net_discount_type=='flat')
                $net_discount_value=$net_discount;
            elseif($net_discount_type=='percentage')
                $net_discount_value=round (( ($net_discount/100) * $total_amount),2);

              $discounted_amount = $total_amount - $net_discount_value ;
              $gst_amount=round(($sale['gst'] /100)*$discounted_amount ,2);

            $net_bill = $discounted_amount + $gst_amount ;

            $expenses=[];

            foreach ($sale['expenses'] as $key ) {
              
              $net_bill=$net_bill+$key['pivot']['amount'];

              array_push($expenses, ['expense'=>$key['name'],'amount'=>$key['pivot']['amount'] ]);
            }

            $sale=array( 'id'=>$sale['id'], 'doc_no'=>$sale['doc_no'], 'doc_date'=>$sale['doc_date'] , 'customer'=>$sale['customer'] ,'remarks'=>$sale['remarks'],  'items'=>$items , 'challan' => $sale['challan'] ,'total_net_qty'=>$total_net_qty , 'total_amount'=>$total_amount ,'gst_amount'=>$gst_amount , 'net_discount'=>$net_discount , 'net_discount_type'=>$net_discount_type , 'net_discount_value'=>$net_discount_value , 'expenses'=>$expenses , 'net_bill'=>$net_bill );*/

           
        $data = [
            
            'order'=>$sale,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
        //return view('sale.estimated_invoice',compact('data'));
        if($invoice_type=='invoice')
           {
            view()->share('sale.estimated_invoice',$data);
        $pdf = PDF::loadView('sale.estimated_invoice', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($sale['doc_no'].'.pdf');
      }
        elseif($invoice_type=='tp-invoice')
          {
            view()->share('sale.tp_invoice',$data);
        $pdf = PDF::loadView('sale.tp_invoice', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($sale['doc_no'].'.pdf');
      }
      elseif($invoice_type=='mrp-invoice')
          {
            view()->share('sale.mrp_invoice',$data);
        $pdf = PDF::loadView('sale.mrp_invoice', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($sale['doc_no'].'.pdf');
      }

        
        
    }


    public function export_invoice(Sale $sale)
    {
           
             $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

           

           
        $data = [
            
            'sale'=>$sale,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
    
        
           
            view()->share('sale.export_invoice_rpt',$data);
        $pdf = PDF::loadView('sale.export_invoice_rpt', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($sale['doc_no'].'.pdf');
      
        
    }


      public function sale_history(Request $request)
      {
          

          $customer_id=$request->customer_id;
           $customer=Customer::find($customer_id);
           
           $from=$request->from;
           $to=$request->to;
           $so_id=$request->so_id;
           $manufactured_by=$request->manufactured_by;

           $item_id=$request->item_id;

         $customers=Customer::orderBy('name')->where('status','1')->get();
          $sos=Employee::sales_man();
           
           $sales=sale_stock::whereHas('sale', function ($q) use ($customer_id,$from,$to){
            $q->where('status',1);
               if($customer_id!='')   
                $q->where('customer_id',$customer_id);
                if($from!='')   
                $q->where('doc_date','>=',$from);
                if($to!='')   
                $q->where('doc_date','<=',$to);
            })->whereHas('sale.customer', function ($q) use ($so_id){
                  
               if($so_id!='')   
                $q->where('so_id',$so_id);
                
            })->whereHas('item', function ($q) use ($manufactured_by,$item_id){
                  
               if($manufactured_by!='')   
                $q->where('manufactured_by',$manufactured_by);

              if($item_id!='')   
                $q->where('id',$item_id);
                
            })->get();
             

              $depart=InventoryDepartment::find(1);
        
        $items=$depart->inventories->where('status','like','1')->sortBy('item_name');


             $config=array( 'customer'=>$customer,'from'=>$from,'to'=>$to,'so_id'=>$so_id , 'manufactured_by'=>$manufactured_by, 'item_id'=>$item_id );
             
         

            return view('sale.sale_ledger',compact('items','sales','sos','customers','config'));
      }


      public function sale_history_print(Request $request)
      {
          

          $customer_id=$request->customer_id;
           $customer=Customer::find($customer_id);
           
           $from=$request->from;
           $to=$request->to;
           $so_id=$request->so_id;
           $manufactured_by=$request->manufactured_by;

           $item_id=$request->item_id;

         //$customers=Customer::orderBy('name')->where('status','1')->get();
         // $sos=Employee::sales_man();
           
           $sales=sale_stock::whereHas('sale', function ($q) use ($customer_id,$from,$to){
            $q->where('status',1);
               if($customer_id!='')   
                $q->where('customer_id',$customer_id);
                if($from!='')   
                $q->where('doc_date','>=',$from);
                if($to!='')   
                $q->where('doc_date','<=',$to);
            })->whereHas('sale.customer', function ($q) use ($so_id){
                  
               if($so_id!='')   
                $q->where('so_id',$so_id);
                
            })->whereHas('item', function ($q) use ($manufactured_by,$item_id){
                  
               if($manufactured_by!='')   
                $q->where('manufactured_by',$manufactured_by);

              if($item_id!='')   
                $q->where('id',$item_id);
                
            })->get();
             

              //$depart=InventoryDepartment::find(1);
        
        //$items=$depart->inventories->where('status','like','1')->sortBy('item_name');


             $config=array( 'customer'=>$customer,'from'=>$from,'to'=>$to,'so_id'=>$so_id , 'manufactured_by'=>$manufactured_by, 'item_id'=>$item_id );

              $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

             $data = [
            
            'sales'=>$sales,
            'config'=>$config,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
             
         view()->share('sale.sale_ledger_print',$data);
        $pdf = PDF::loadView('sale.sale_ledger_print', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('sale.sale_ledger_print.pdf');


            //return view('sale.sale_ledger',compact('sales','config'));
      }


      public function get_invoice(Request $request)
    {
             $sale=Sale::with('customer','items','items.department','items.unit','items.size','items.color')->find($request->invoice_id);

             return response()->json($sale, 200);
    }

    public function get_customer_product_invoices(Request $request)
    {
            $product_id=$request->product_id;
            $customer_id=$request->customer_id;
             $sale=sale_stock::with('sale','item','item.department')->where('item_id',$product_id)->wherehas('sale',function($q) use($customer_id){
                 $q->where('customer_id', $customer_id);
             })->get();

             return response()->json($sale, 200);
    }

    public function get_invoice_item(Request $request)
    {
      $stock_id=$request->sale_stock_id;

          
             $sale=sale_stock::with('sale','item','item.department','item.unit','item.size','item.color')->find($stock_id);



             return response()->json($sale, 200);
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {     
      
      $list=$sale->sale_stock_list;
      foreach ($list as $key ) {
        $return=salereturn_ledger::where('sale_stock_id',$key['id'])->first();
        if($return!='')
        return redirect()->back()->withErrors(['error'=>'Delete sale return first, than invoice!']);
      }
     
          

          
         $sale->items()->detach();


            foreach($sale->transections as $trans )
           {
               $trans->delete();
           }


         $sale->delete();

        return redirect(url('sale/create'))->with('success','Invoice Deleted!');
    }

    public function import_sale()
    {
        
        return view('sale.import_sale');
    }

    public function save_import_sale(Request $request)
    {
       
        \Excel::import(new SalesImport,request()->file('sheet'));

        //\Session::put('success', 'Your file is imported successfully in database.');

        return redirect()->back()->with('success','Your file is imported successfully in database.');
           
    
    }
}
