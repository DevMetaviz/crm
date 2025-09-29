<?php

namespace App\Http\Controllers;

use App\Models\Salereturn;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\InventoryDepartment;
use App\Models\inventory;
use App\Models\Transection;
use App\Models\Deliverychallan;
use App\Models\salereturn_ledger;
use App\Models\sale_stock;
use App\Models\Configuration;
use App\Models\InventoryCategory;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use PDF;

class SalereturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales=Salereturn::orderBy('doc_no', 'desc')->get();

        return view('sale.return_history',compact('sales'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $doc_no="SR-";
        $num=1;

         $order=Salereturn::select('id','doc_no')->orderBy('doc_no','desc')->first();
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
        
        //$departments=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->get();
        //$sales=Sale::select('id','doc_no','doc_date')->orderBy('doc_no','desc')->get()->whereNull('salereturn');
       // $products=inventory::where('department_id','1')->where('status','like','1')->get();

         $companies=Company::with('branches')->get();

        $categories=InventoryCategory::orderBy('name','asc')->get();

          $items=inventory::getItems();

          $order = new Salereturn(); // empty instance
             $order->doc_no = $doc_no;
             

          $branches=[];

          if(isset($request['sale']) && $request['sale']>0 ){
        
                  $clone_challan= Sale::find($request->sale);
                  

                  if(isset($clone_challan['id']) && $clone_challan['id']>0){


                   

                     $order->invoice_id = $clone_challan['id'];
                      $order->invoice_no = $clone_challan['doc_no'];
                      $order->invoice_date = $clone_challan['doc_date'];

                       $order->customer_id = $clone_challan['customer_id'];
                       $order->company_id = $clone_challan['company_id'];
                       $order->branch_id = $clone_challan['branch_id'];

                       $order->freight_charges = $clone_challan['freight_charges'];
                       $order->loading_charges = $clone_challan['loading_charges'];

                         $branches = $clone_challan->company_id > 0 
                      ? Branch::where('company_id', $clone_challan->company_id)->get()
                      : collect();
                       

                       $clone_items=[];  

                       foreach($clone_challan->items as $it){

                        $item=$it;  


                        $item['pivot']['id']=0;

                        $clone_items[]=$item;

                       }

                      $order->items = $clone_items;
                  }
           }

           $freight_expenses=Account::select('id','code','name')->where('super_id',63)->get(); 

        return view('sale.sale_return',compact('categories','customers','items','companies','branches','order','freight_expenses'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $chln=Salereturn::where('doc_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->withErrors(['error'=>'Doc No. already existed!']);
           
        //$location_ids=$request->location_ids;

       $item_id=$request->item_id;
       //$stocks_id=$request->stocks_id;
       //$units=$request->units;
        $qty=$request->qty;
        /*$pack_sizes=$request->p_s;

        $mrps=$request->mrp;
        $tps=$request->tp;
         $business_type=$request->business_type;
        $batch_nos=$request->batch_no;
        $expiry_dates=$request->expiry_date;
        $discount_types=$request->discount_type;
        $discount_factors=$request->discount_factor;
        $taxs=$request->tax;*/

        $rate=$request->rate;
        $disc=$request->disc;
        $unit_weight=$request->unit_weight;
        $unit_feet=$request->unit_feet;
        $pricing_by=$request->pricing_by;

         $rack=$request->rack;
        $rack_qty=$request->rack_qty;

         
         $status=$request->status;
        if($status=='')
            $status='0';

        

        $challan=new Salereturn;

        $challan->doc_no=$request->doc_no;
        $challan->doc_date=$request->doc_date;
         $challan->invoice_id=$request->invoice_id;
        
        $challan->status=$status;
        
        $challan->customer_id=$request->customer_id;

        //$challan->challan_id=$request->challan_id;
         //$challan->net_discount=$request->disc;
         // $challan->net_discount_type=$request->net_disc;
        $challan->remarks=$request->remarks;
         $challan->user_id = Auth::id();

        $challan->company_id=$request->company_id;

        $challan->branch_id=$request->branch_id;
        
        
       // $challan->freight_expense_id=$request->freight_expense_id;
         $challan->freight_charges=str_replace(',', '', $request->freight_charges);
        $challan->loading_charges=str_replace(',', '', $request->loading_charges);

         $challan->previous_balance=str_replace(',', '', $request->previous_balance);

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

         //$challan->items()->attach($items_id[$i] , ['sale_stock_id'=>$stocks_id[$i],'unit' => $units[$i] , 'qty' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i] ,'mrp'=>$mrps[$i],'business_type'=>$business_type[$i] ,'batch_no'=>$batch_nos[$i] ,'expiry_date'=>$expiry_dates[$i] ,'discount_type'=>$discount_types[$i],'discount_factor'=>$discount_factors[$i],'tax'=>$taxs[$i] ]);

         $challan->items()->attach($item_id[$i] , [ 'qty' => $qty_p ,'rate'=>$rate_p ,'discount'=>$disc_p ,'unit_weight'=>$unit_weight_p ,'unit_feet'=>$unit_feet_p,'pricing_by'=>$pricing_by[$i],'rack'=>$rack[$i] ,'rack_qty'=>$rack_qty[$i] ]);

           }

           $challan->total_amount=$challan->total_amount();
           $challan->total_weight=$challan->total_weight();

            $challan->save();


           $customer_acc=Customer::find($request->customer_id)->account_id;

           foreach ($challan->return_list as $item) {
                   

                
               //$rate=$challan->rate($item['item']['id'],$item['id']);
               //$amount= $rate * ($item['qty'] * $item['pack_size'] );

                $amount=$challan->item_amount($item['item']['id'],$item['id']);


               $item->total_amount=$amount;
               $item->save();

                $remarks='Return: '.$item['item']['item_name'].'';

         
           $trans=new Transection;

           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Salereturn';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;

           $trans->save();


           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Salereturn';
           $trans->account_id=368;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks=$remarks;
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();


           }

           

        return redirect('/edit/sale/return/'.$challan['id'])->with('success','Sale return genrated!');
                  return redirect()->back()->with('success','Sale return genrated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salereturn  $salereturn
     * @return \Illuminate\Http\Response
     */
    public function show(Salereturn $salereturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salereturn  $salereturn
     * @return \Illuminate\Http\Response
     */
    public function edit(Salereturn $return)
    {
        $customers=Customer::where('status','1')->get();
        
        /*$departments=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->get();
        $products=inventory::where('department_id','1')->where('status','like','1')->get();

        $items=array();
             foreach ($return['items'] as $key ) {
                 
                 $pivot_id=$key['pivot']['id'];
                 $sale_stock_id=$key['pivot']['sale_stock_id'];
                 $doc_no='';
                    if($sale_stock_id!='')
                 {
                  $s=sale_stock::find($sale_stock_id);
                   if($s!='')
                    $doc_no=$s->sale->doc_no;
                }

                 $unit=$key['pivot']['unit'];
                 $qty=$key['pivot']['qty'];
                 $pack_size=$key['pivot']['pack_size'];
                 $total_qty=$qty * $pack_size;
                 $mrp=$key['pivot']['mrp'];
                 $tp=round( (0.85 * $mrp  ),2);
                 $batch_no=$key['pivot']['batch_no'];
                 $expiry_date=$key['pivot']['expiry_date'];
                 $business_type=$key['pivot']['business_type'];
                 $discount_type=$key['pivot']['discount_type'];
                 $discount_factor=$key['pivot']['discount_factor'];

                 $discounted_value=0;

                 if($discount_type=='flat')
                    $discounted_value=$discount_factor;
                elseif($discount_type=='percentage')
                   $discounted_value=round( (($discount_factor/100)*$tp) ,2);

                  $rate=round($tp- $discounted_value,2);
                  $total=round( ($total_qty * $rate),2);
                 $tax=$key['pivot']['tax'];
                  $tax_amount= round( (($tax/100)*$total),2);

                  $net_amount =round( $tax_amount + $total ,2 );

                    $item=array('pivot_id'=>$pivot_id,'sale_stock_id'=>$sale_stock_id,'invoice_no'=>$doc_no,'item_id'=>$key['id'],'location_id'=>$key['department_id'],'location_text'=>$key['department']['name'],'item_name'=>$key['item_name'],'unit'=>$unit,'qty'=>$qty,'pack_size'=>$pack_size,'mrp'=>$mrp,'tp'=>$tp,'batch_no'=>$batch_no,'business_type'=>$business_type,'expiry_date'=>$expiry_date,'total_qty'=>$total_qty,'discount_type'=>$discount_type,'discount_factor'=>$discount_factor,'discounted_value'=>$discounted_value,'rate'=>$rate,'total'=>$total,'tax'=>$tax,'tax_amount'=>$tax_amount,'net_amount'=>$net_amount);

                 array_push($items, $item);
             } //print_r(json_encode($items));die;*/

             $customers=Customer::where('status','1')->get();
        $companies=Company::with('branches')->get();

        $categories=InventoryCategory::orderBy('name','asc')->get();

          $items=inventory::getItems();

           $order=$return;

           $branches = $order->company_id > 0 
        ? Branch::where('company_id', $order->company_id)->get()
        : collect();

         $freight_expenses=Account::select('id','code','name')->where('super_id',63)->get();


        return view('sale.sale_return',compact('customers','companies','branches','categories','items','order','freight_expenses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salereturn  $salereturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //$location_ids=$request->location_ids;
        $pivots_id=$request->pivots_id;
       $item_id=$request->item_id;
       //$stocks_id=$request->stocks_id;
       //$units=$request->units;
        $qty=$request->qty;
        /*$pack_sizes=$request->p_s;
        $business_type=$request->business_type;
        $mrps=$request->mrp;
        $tps=$request->tp;
        $batch_nos=$request->batch_no;
        $expiry_dates=$request->expiry_date;
        $discount_types=$request->discount_type;
        $discount_factors=$request->discount_factor;
        $taxs=$request->tax;*/

        $rate=$request->rate;
        $disc=$request->disc;
        $unit_weight=$request->unit_weight;
        $unit_feet=$request->unit_feet;
        $pricing_by=$request->pricing_by;

         $rack=$request->rack;
        $rack_qty=$request->rack_qty;

   //print_r(json_encode($challans_id));die;
         
         $status=$request->status;
        if($status=='')
            $status='0';

        

        $challan=Salereturn::find($request->id);

        $challan->doc_no=$request->doc_no;
        $challan->doc_date=$request->doc_date;
        
        
        $challan->status=$status;
        
        $challan->customer_id=$request->customer_id;
        $challan->invoice_id=$request->invoice_id;

        //$challan->challan_id=$request->challan_id;
         //$challan->net_discount=$request->disc;
         // $challan->net_discount_type=$request->net_disc;
        $challan->remarks=$request->remarks;

        $challan->company_id=$request->company_id;

        $challan->branch_id=$request->branch_id;
        
       //$challan->freight_expense_id=$request->freight_expense_id;
       
        $challan->freight_charges=str_replace(',', '', $request->freight_charges);
        $challan->loading_charges=str_replace(',', '', $request->loading_charges);

         $challan->previous_balance=str_replace(',', '', $request->previous_balance);

       $challan->save();

       $items=salereturn_ledger::where('return_id',$challan['id'])->whereNotIn('id',$pivots_id)->get();

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
                 $item=salereturn_ledger::find($pivots_id[$i]);
                  else
                  $item=new salereturn_ledger;
                
                 $item->return_id=$challan['id'];
               // $item->sale_stock_id=$stocks_id[$i];
                $item->item_id=$item_id[$i];
                //$item->unit=$units[$i];
                $item->qty=$qty_p;
                /*$item->pack_size=$pack_sizes[$i];
                $item->mrp=$mrps[$i];
                $item->batch_no=$batch_nos[$i];
                $item->expiry_date=$expiry_dates[$i];
                $item->business_type=$business_type[$i];
                $item->discount_type=$discount_types[$i];
                $item->discount_factor=$discount_factors[$i];
                $item->tax=$taxs[$i];*/
                $item->rate=$rate_p;
                $item->discount=$disc_p;
                $item->unit_weight=$unit_weight_p;
                $item->unit_feet=$unit_feet_p;
                
                $item->pricing_by=$pricing_by[$i];

                $item->rack=$rack[$i];
                $item->rack_qty=$rack_qty[$i];

                $item->save();
           }


           $challan->total_amount=$challan->total_amount();
           $challan->total_weight=$challan->total_weight();

            $challan->save();

  

                  $transections=$challan->transections;

            $no=0;

            $customer_acc=Customer::find($request->customer_id)->account_id;

           foreach ($challan->return_list as $item) {
                   

                
               //$rate=$challan->rate($item['item']['id'],$item['id']);
               //$amount= $rate * ($item['qty'] * $item['pack_size'] );

               $amount=$challan->item_amount($item['item']['id'],$item['id']);

               $item->total_amount=$amount;
               $item->save();


                $remarks='Return: '.$item['item']['item_name'];

         
           if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;

           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Salereturn';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
            $trans->transection_date=$challan->doc_date;
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$amount;

           $trans->save();
            $no++;

            if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;

           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\Salereturn';
           $trans->account_id=368;
           //$trans->corporate_id=$item['id'];
           $trans->transection_date=$challan->doc_date;
           $trans->remarks=$remarks;
           $trans->debit=$amount;
           $trans->credit=0;
           $trans->save();
           $no++;


           }

           for($i=$no; $i < count($transections); $i++ )
           {
               $transections[$i]->delete();
           }

           
                  return redirect()->back()->with('success','Sale return updated!');
    }

    public function return_report(Salereturn $return,$type)
    {

        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
           
           
           
        $data = [
            
            'return'=>$return,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
        //return view('sale.estimated_invoice',compact('data'));
        if($type=='invoice1')
           {
            view()->share('sale.reports.return1',$data);
        $pdf = PDF::loadView('sale.reports.return1', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($return['doc_no'].'.pdf');
      }
        elseif($type=='invoice2')
          {
            view()->share('sale.reports.return2',$data);
        $pdf = PDF::loadView('sale.reports.return2', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($return['doc_no'].'.pdf');
      }
      
        
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salereturn  $salereturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salereturn $return)
    {
        


         $return->items()->detach();


            foreach($return->transections as $trans )
           {
               $trans->delete();
           }


         $return->delete();

        return redirect(url('sale/return'))->with('success','Sale return Deleted!');
    }
}
