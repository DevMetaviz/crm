<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Configuration;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\InventoryDepartment;
use App\Models\Customer;
use App\Models\quotation_item;
use App\Models\rate_type;
use App\Models\inventory;
use App\Models\Expense;
use App\Models\Transportation;
use App\Models\packing_type;
use App\Models\Port;
use App\Models\freight_type;
use App\Models\Currency;
use PDF;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

         $quotations=Quotation::orderBy('created_at','desc')->get();

        return view('sale.quotations',compact('quotations'));

    }

    public function get_quotation(Request $request)
    {
        

         $quotation_id=$request->quotation_id;
          $quotation=Quotation::with('item_list','item_list.item')->find($quotation_id);

          return response()->json($quotation, 200);


    }

    public function new_quotations(Request $request)
    {
        

         $customer_id=$request->customer_id;
          $orders=Quotation::select('id','doc_no','doc_date','customer_id')->where('customer_id',$customer_id)->where('activeness','1')->where('approved','1')->orderBy('doc_no','desc')->doesntHave('order')->get();

          return response()->json($orders, 200);


    }
    

    public function get_doc_no(Request $request)
    {
        
            $type=$request->type;

         if($type=='local')
         $doc_no="QU-".Date("y")."-";
         elseif($type=='export')
            $doc_no="FP/EXP-".Date("y")."-";
        $num=1;

         $order=Quotation::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->where('type',$type)->latest()->first();

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

          return response()->json($doc_no, 200);


    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        $customers=Customer::where('status','1')->get();

        $doc_no="QU-".Date("y")."-";
        $num=1;

         $order=Quotation::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->where('type','local')->latest()->first();
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

              $config=array(
                 'conditions'=>['department_id'=>1],
                 'attributes'=>[]
              );

          //$inventories=inventory::getVariantItems($config);

        $its=inventory::where('department_id',1)->where(function($q){
            $q->where('status','like','1');
         })->get();

            $inventories=[];
         foreach ($its as $key ) {
             
             $uom='';
             if(isset($key['unit']['name']))
                $uom=$key['unit']['name'];
            
             $q=$key->closing_stock();
             $p=$key->packs;
             //$p=$key->packings1(); //print_r(json_encode($p));

        $it=['id'=>$key['id'],'item_name'=>$key['item_name'],'unit'=>$uom,'mrp'=>$key['mrp'],'qty'=>$q,'batches'=>$key['batches'] ,'packings'=>$p ];

             array_push($inventories, $it);
         } //die;

     $expenses=Expense::where('activeness','1')->orderBy('name','asc')->get();
     $currencies=Currency::where('activeness','1')->get();
     $ports=Port::orderBy('text')->get();
     $freight_types=freight_type::orderBy('text')->get();
     $transportations=Transportation::orderBy('text')->get();
     $packing_types=packing_type::orderBy('text')->get();


    return view('sale.quotation',compact('currencies','ports','transportations','packing_types','freight_types','customers','doc_no','inventories','expenses'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $chln=Quotation::where('doc_no',$request->doc_no)->first();
            if($chln!='')
             return redirect()->back()->withErrors(['error'=>'Doc no. already existed!']);
        //$location_ids=$request->location_ids;

       $items_id=$request->items_id;
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;

        $mrps=$request->mrp;
        //$batch_nos=$request->batch_no;
        $expiry_dates=$request->exp_dates;
        $rates=$request->rate;
        //$business_type=$request->business_type;
        $discount_types=$request->discount_type;
        $discount_factors=$request->discount_factor;
        

         
         $active=$request->active;
        if($active=='')
            $active='0';

        $approved=$request->approved;
        if($approved=='')
            $approved='0';


        $challan=new Quotation;

        $challan->doc_no=$request->doc_no;
        $challan->doc_date=$request->doc_date;
        $challan->gst=$request->gst;
        $challan->type=$request->type;

       $challan->net_discount=$request->disc;
        $challan->net_discount_type=$request->net_disc;

        $challan->currency_id=$request->currency_id;
        $challan->cur_rate=$request->cur_rate;
        
        $challan->activeness=$active;
        $challan->approved=$approved;
        $challan->customer_id=$request->customer_id;

        $challan->shipment_port_id=$request->shipment_port_id;
        $challan->discharge_port_id=$request->discharge_port_id;
        $challan->packing_type_id=$request->packing_type_id;
        $challan->freight_type_id=$request->freight_type_id;
        $challan->transportation_id=$request->transportation_id;

        //$challan->order_id=$request->order_id;
        $challan->remarks=$request->remarks;

        $challan->save();
            
            for($i=0;$i<count($items_id);$i++)
            {
         $challan->items()->attach($items_id[$i] , ['unit' => $units[$i] , 'qty' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i] ,'mrp'=>$mrps[$i] ,'expiry_date'=>$expiry_dates[$i],'rate'=>$rates[$i],'discount_type'=>$discount_types[$i],'discount_factor'=>$discount_factors[$i] ]);
           }
           
             //expense
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

        
         return redirect('/edit/quotation/'.$challan['id'])->with('success','Quotation genrated!');
        
    }

     

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        $customers=Customer::where('id',$quotation['customer_id'])->orWhere('status','1')->get();

        $its=inventory::where('department_id',1)->where(function($q){
            $q->where('status','like','1');
         })->get();

            $inventories=[];
         foreach ($its as $key ) {
             
             $uom='';
             if(isset($key['unit']))
                $uom=$key['unit'];
            
             $q=$key->closing_stock();
             $p=$key->packings1(); //print_r(json_encode($p));

        $it=['id'=>$key['id'],'item_name'=>$key['item_name'],'unit'=>$uom,'mrp'=>$key['mrp'],'qty'=>$q,'batches'=>$key['batches'] ,'packings'=>$p ];

             array_push($inventories, $it);
         }

        $expenses=Expense::where('activeness','1')->orderBy('name','asc')->get();

        $currencies=Currency::where('activeness','1')->get();
     $ports=Port::orderBy('text')->get();
     $freight_types=freight_type::orderBy('text')->get();
     $transportations=Transportation::orderBy('text')->get();
     $packing_types=packing_type::orderBy('text')->get();
       
        return view('sale.edit_quotation',compact('currencies','ports','transportations','packing_types','freight_types','customers','quotation','inventories','expenses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quotation $quotation)
    {
        $location_ids=$request->location_ids;
        $pivot_ids=$request->pivot_ids;
       $items_id=$request->items_id;
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;

        $mrps=$request->mrp;
        //$batch_nos=$request->batch_no;
        $rates=$request->rate;
        //$business_type=$request->business_type;
        $expiry_dates=$request->exp_dates;
         $discount_types=$request->discount_type;
        $discount_factors=$request->discount_factor;
        $taxs=$request->tax;
         
         $active=$request->active;
        if($active=='')
            $active='0';

         $approved=$request->approved;
        if($approved=='')
            $approved='0';

        $challan= Quotation::find($request->id);

        $challan->doc_no=$request->doc_no;
        $challan->doc_date=$request->doc_date;
        
        $challan->type=$request->type;
        $challan->activeness=$active;
        $challan->approved=$approved;

         $challan->currency_id=$request->currency_id;
        $challan->cur_rate=$request->cur_rate;

        $challan->net_discount=$request->disc;
        $challan->net_discount_type=$request->net_disc;

        $challan->customer_id=$request->customer_id;

        $challan->shipment_port_id=$request->shipment_port_id;
        $challan->discharge_port_id=$request->discharge_port_id;
        $challan->packing_type_id=$request->packing_type_id;
        $challan->freight_type_id=$request->freight_type_id;
        $challan->transportation_id=$request->transportation_id;


        $challan->gst=$request->gst;
        $challan->remarks=$request->remarks;
        

        $challan->save();

    $items=quotation_item::where('quotation_id',$challan['id'])->whereNotIn('id',$pivot_ids)->get();

        foreach ($items as $tr) {
            $tr->delete();
        }

           for ($i=0;$i<count($items_id);$i++)
           {
                 if($pivot_ids[$i]!=0)
                 $item=quotation_item::find($pivot_ids[$i]);
                  else
                  $item=new quotation_item;

                $item->quotation_id=$challan['id'];
                $item->item_id=$items_id[$i];
                $item->unit=$units[$i];
                $item->qty=$qtys[$i];
                $item->pack_size=$pack_sizes[$i];
                $item->mrp=$mrps[$i];
                //$item->batch_no=$batch_nos[$i];
                $item->expiry_date=$expiry_dates[$i];
                $item->rate=$rates[$i];
                $item->discount_type=$discount_types[$i];
                $item->discount_factor=$discount_factors[$i];
            
                $item->save();
           }

           //expense
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
            

            
         

                  return redirect()->back()->with('success','Quotation Updated!');
    }

    public function export_report(Quotation $quotation)
    {
           
             $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

           

           
        $data = [
            
            'sale'=>$quotation,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
    
        
           
            view()->share('sale.export_quotation_rpt',$data);
        $pdf = PDF::loadView('sale.export_quotation_rpt', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($quotation['doc_no'].'.pdf');
    
        
    }


    public function report(Quotation $quotation,$report_type)
    {
           
             $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

           $total_net_amount=0;
           $total_net_qty=0;
           $total_amount=0;

           $items=array();
             foreach ($quotation['items'] as $key ) {
                 
                 $unit=$key['pivot']['unit'];
                 $qty=$key['pivot']['qty'];
                 $pack_size=$key['pivot']['pack_size'];
                 $total_qty=$qty * $pack_size;
                 $mrp=$key['pivot']['mrp'];
                  $rate=$key['pivot']['rate'];
                 //$tp=round( (0.85 * $mrp  ),2);
                 //$batch_no=$key['pivot']['batch_no'];
                 $expiry_date=$key['pivot']['expiry_date'];
                 $discount_type=$key['pivot']['discount_type'];
                 $discount_factor=$key['pivot']['discount_factor'];

                 $discounted_value=0;
                 if($discount_type=='flat')
                    $discounted_value=$discount_factor;
                elseif($discount_type=='percentage')
                   $discounted_value=round( (($discount_factor/100)*$rate) ,2);

                  $rate=$rate- $discounted_value; 
                  //print_r($discounted_value);die;
                  $total=round( ($total_qty * $rate),2);
                 //$tax=$key['pivot']['tax'];
                  //$tax_amount= round( (($tax/100)*$total),2);

                  

                  $total_net_qty = $total_net_qty +  $total_qty;
                     $total_amount=$total_amount +  $total;
                  

                    $item=array('item_id'=>$key['id'],'location_id'=>$key['department_id'],'location_text'=>$key['department']['name'],'item_name'=>$key['item_name'],'item_pack_size'=>$key['pack_size'],'unit'=>$unit,'qty'=>$qty,'pack_size'=>$pack_size,'mrp'=>$mrp,'expiry_date'=>$expiry_date,'total_qty'=>$total_qty,'discount_type'=>$discount_type,'discount_factor'=>$discount_factor,'discounted_value'=>$discounted_value,'rate'=>$rate,'total'=>$total);

                 array_push($items, $item);
             }
          //$net_discount=$quotation['net_discount'];
          //$net_discount_type=$quotation['net_discount_type'];
          // $net_discount_value=0;
           // if($net_discount_type=='flat')
                //$net_discount_value=$net_discount;
            //elseif($net_discount_type=='percentage')
                //$net_discount_value=round (( ($net_discount/100) * $total_net_amount),2);

           // $net_bill = $total_net_amount - $net_discount_value ;

            $sale=array( 'id'=>$quotation['id'], 'doc_no'=>$quotation['doc_no'], 'doc_date'=>$quotation['doc_date'] , 'gst'=>$quotation['gst'], 'customer'=>$quotation['customer'] , 'remarks'=>$quotation['remarks'], 'items'=>$items   ,'total_net_qty'=>$total_net_qty , 'total_amount'=>$total_amount  , 'expenses'=>$quotation['expenses'] );

           
        $data = [
            
            'sale'=>$sale,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
        //return view('sale.estimated_invoice',compact('data'));
        if($report_type=='quotation')
           {
            view()->share('sale.quotation_rpt',$data);
        $pdf = PDF::loadView('sale.quotation_rpt', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('sale.quotation_rpt.pdf');
      }
        elseif($report_type=='tp-quotation')
          {
            view()->share('sale.quotation_rpt1',$data);
        $pdf = PDF::loadView('sale.quotation_rpt1', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('sale.quotation_rpt1.pdf');
      }

      elseif($report_type=='lh-quotation')
          {
            view()->share('sale.quotation_rpt2',$data);
        $pdf = PDF::loadView('sale.quotation_rpt2', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('sale.quotation_rpt2.pdf');
      }

        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $allowance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        

         $quotation->items()->detach();

         $quotation->delete();

        return redirect(url('quotation/create'))->with('success','Quotation Deleted!');
    }
}
