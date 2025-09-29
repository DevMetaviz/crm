<?php

namespace App\Http\Controllers;

use App\Models\stock_transfer;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\InventoryDepartment;
use App\Models\inventory;
use App\Models\Transection;
use App\Models\Salereturn;
use App\Models\stock_transfer_ledger;

class StockTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfers=stock_transfer::orderBy('doc_no', 'desc')->get();

        return view('sale.transfer_history',compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doc_no="ST-";
        $num=1;

         $order=stock_transfer::select('id','doc_no')->orderBy('doc_no','desc')->first();
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

        $customers=Customer::where('activeness','1')->get();
        
        $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        //$sales=Sale::select('id','invoice_no','invoice_date')->orderBy('invoice_no','desc')->get()->whereNull('salereturn');
        $products=inventory::where('department_id','1')->where('activeness','like','active')->get();

        return view('sale.stock_transfer',compact('products','departments','doc_no','customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chln=stock_transfer::where('doc_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->withErrors(['error'=>'Doc No. already existed!']);

        $location_ids=$request->location_ids;

       $items_id=$request->items_id;
       $challans_id=$request->challans_id;
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;

        $mrps=$request->mrp;
        $tps=$request->tp;
        $batch_nos=$request->batch_no;
        $expiry_dates=$request->expiry_date;

         $from_business_type=$request->from_business_type;
        $from_discount_types=$request->from_discount_type;
        $from_discount_factors=$request->from_discount_factor;
        $from_taxs=$request->from_tax;

        $to_business_type=$request->to_business_type;
        $to_discount_types=$request->to_discount_type;
        $to_discount_factors=$request->to_discount_factor;
        $to_taxs=$request->to_tax;

         
         $active=$request->active;
        if($active=='')
            $active='0';

        

        $challan=new stock_transfer;

        $challan->doc_no=$request->doc_no;
        $challan->doc_date=$request->doc_date;
        
        
        $challan->activeness=$active;
        
        $challan->from_id=$request->from_customer_id;

        $challan->to_id=$request->to_customer_id;
         //$challan->net_discount=$request->disc;
         // $challan->net_discount_type=$request->net_disc;
        $challan->remarks=$request->remarks;

        $challan->save();
            
            for($i=0;$i<count($items_id);$i++)
            {
         $challan->items()->attach($items_id[$i] , ['challan_id'=>$challans_id[$i],'unit' => $units[$i] , 'qty' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i] ,'mrp'=>$mrps[$i],'batch_no'=>$batch_nos[$i] ,'expiry_date'=>$expiry_dates[$i] ,'from_business_type'=>$from_business_type[$i] , 'from_discount_type'=>$from_discount_types[$i],'from_discount_factor'=>$from_discount_factors[$i],'from_tax'=>$from_taxs[$i] ,'to_business_type'=>$to_business_type[$i] , 'to_discount_type'=>$to_discount_types[$i],'to_discount_factor'=>$to_discount_factors[$i],'to_tax'=>$to_taxs[$i] ]);

           }

           foreach ($challan->stock_transfer_items as $item) {
                
               $from_rate=$challan->from_rate($item['item']['id'],$item['id']);
               $to_rate=$challan->to_rate($item['item']['id'],$item['id']);
               $f_amount= $from_rate * ($item['qty'] * $item['pack_size'] );
                $t_amount= $to_rate * ($item['qty'] * $item['pack_size'] );

                $remarks=$item['item']['item_name'].' ('.$from_rate.'*'.$item['qty'].')';
                $remarks1=$item['item']['item_name'].' ('.$to_rate.'*'.$item['qty'].')';

         $customer_acc=Customer::find($request->from_customer_id)->mid_sale_account_id;
           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\stock_transfer';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$f_amount;
           $trans->save();

           $customer_acc=Customer::find($request->to_customer_id)->mid_sale_account_id;
           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\stock_transfer';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks1;
           $trans->debit=$t_amount;
           $trans->credit=0;
           $trans->save();


           }

           

        return redirect('/edit/stock/transfer/'.$challan['id'])->with('success','Sale transfer genrated!');
                  return redirect()->back()->with('success','Sale transfer genrated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\stock_transfer  $stock_transfer
     * @return \Illuminate\Http\Response
     */
    public function show(stock_transfer $stock_transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\stock_transfer  $stock_transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(stock_transfer $transfer)
    {
        $customers=Customer::where('activeness','1')->get();
        
        $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        $products=inventory::where('department_id','1')->where('activeness','like','active')->get();

        return view('sale.edit_stock_transfer',compact('products','departments','transfer','customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\stock_transfer  $stock_transfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $location_ids=$request->location_ids;
         $pivot_ids=$request->pivots_id;
       $items_id=$request->items_id;
       $challans_id=$request->challans_id;
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;

        $mrps=$request->mrp;
        $tps=$request->tp;
        $batch_nos=$request->batch_no;
        $expiry_dates=$request->expiry_date;

         $from_business_type=$request->from_business_type;
        $from_discount_types=$request->from_discount_type;
        $from_discount_factors=$request->from_discount_factor;
        $from_taxs=$request->from_tax;

        $to_business_type=$request->to_business_type;
        $to_discount_types=$request->to_discount_type;
        $to_discount_factors=$request->to_discount_factor;
        $to_taxs=$request->to_tax;

         
         $active=$request->active;
        if($active=='')
            $active='0';

        

        $challan=stock_transfer::find($request->id);

        $challan->doc_no=$request->doc_no;
        $challan->doc_date=$request->doc_date;
        
        
        $challan->activeness=$active;
        
        $challan->from_id=$request->from_customer_id;

        $challan->to_id=$request->to_customer_id;
         //$challan->net_discount=$request->disc;
         // $challan->net_discount_type=$request->net_disc;
        $challan->remarks=$request->remarks;

        $challan->save();

         $items=stock_transfer_ledger::where('transfer_id',$challan['id'])->whereNotIn('id',$pivot_ids)->get();

        foreach ($items as $tr) {
            $tr->delete();
        }

           for ($i=0;$i<count($items_id);$i++)
           {
                  
                    if($pivot_ids[$i]!=0)
                 $item=stock_transfer_ledger::find($pivot_ids[$i]);
                  else
                  $item=new stock_transfer_ledger;

                $item->transfer_id=$challan['id'];
                $item->item_id=$items_id[$i];
                $item->challan_id=$challans_id[$i];
                $item->unit=$units[$i];
                $item->qty=$qtys[$i];
                $item->pack_size=$pack_sizes[$i];
                $item->mrp=$mrps[$i];
                $item->batch_no=$batch_nos[$i];
                $item->expiry_date=$expiry_dates[$i];
                $item->from_business_type=$from_business_type[$i];
                $item->from_discount_type=$from_discount_types[$i];
                $item->from_discount_factor=$from_discount_factors[$i];
                $item->from_tax=$from_taxs[$i];

                $item->to_business_type=$to_business_type[$i];
                $item->to_discount_type=$to_discount_types[$i];
                $item->to_discount_factor=$to_discount_factors[$i];
                $item->to_tax=$to_taxs[$i];
                $item->save();
           }
            
              $transections=$challan->transections;

               $no=0;
           foreach ($challan->stock_transfer_items as $item) {

             $from_rate=$challan->from_rate($item['item']['id'],$item['id']);
               $to_rate=$challan->to_rate($item['item']['id'],$item['id']);
               $f_amount= $from_rate * ($item['qty'] * $item['pack_size'] );
                $t_amount= $to_rate * ($item['qty'] * $item['pack_size'] );

                $remarks=$item['item']['item_name'].' ('.$from_rate.'*'.$item['qty'].')';
                $remarks1=$item['item']['item_name'].' ('.$to_rate.'*'.$item['qty'].')';

         $customer_acc=Customer::find($request->from_customer_id)->mid_sale_account_id;
           
           if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\stock_transfer';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks;
           $trans->debit=0;
           $trans->credit=$f_amount;
           $trans->save();
           $no++;

           $customer_acc=Customer::find($request->to_customer_id)->mid_sale_account_id;
           if($no < count($transections))
          $trans=$transections[$no];
          else
           $trans=new Transection;
        
           $trans->account_voucherable_id=$challan->id;
           $trans->account_voucherable_type='App\Models\stock_transfer';
           $trans->account_id=$customer_acc;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$remarks1;
           $trans->debit=$t_amount;
           $trans->credit=0;
           $trans->save();
           $no++;

           }

           for($i=$no; $i < count($transections); $i++ )
           {
               $transections[$i]->delete();
           }


           
            return redirect()->back()->with('success','Sale transfer updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\stock_transfer  $stock_transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(stock_transfer $transfer)
    {
        $transfer->items()->detach();


            foreach($transfer->transections as $trans )
           {
               $trans->delete();
           }


         $transfer->delete();

        return redirect(url('stock/transfer'))->with('success','STock Transfer Deleted!');
    }
}
