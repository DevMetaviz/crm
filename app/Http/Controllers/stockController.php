<?php

namespace App\Http\Controllers;

use App\Models\Grn;
use App\Models\inventory;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Models\Origin;
use App\Models\sampling;
use App\Models\InventoryDepartment;
use App\Models\InventoryCategory;
use App\Models\qc_report;
use App\Models\Stockadjustment;
use App\Models\Configuration;
use PDF;


class stockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
    }

  

      public function update_stock(Request $request)
    {
          $active=0; 
          if($request->active!='')
          {
            $active=$request->active;
          }

          
          
         $stock=Stock::find($request->stock_id);

         $stock->grn_no=$request->grn_no;
         $stock->origin_id=$request->origin;
         $stock->batch_no=$request->batch_no;
         $stock->mfg_date=$request->mfg_date;
         $stock->exp_date=$request->exp_date;
         $stock->no_of_container=$request->no_of_container;
         $stock->type_of_container=$request->type_of_container;
         $stock->approved_qty=$request->approved_quantity;

           $stock1=Stock::where('id','<>',$stock['id'])->where('grn_no',$request->grn_no)->first();
           if($stock1!='')
           {
            return redirect()->back()->with('error','GRN alread exist. Refresh page and try again!');
           }

          
         

           $stock->remarks=$request->remarks;

      
         $stock->is_active=$active;
         $stock->save();
             
             return redirect()->back()->with('success','Stock Updated!');
    }

    public function edit_stock($stock_id)
      {
        

           $stock=Stock::find($stock_id);

        $origins=Origin::where('activeness','like','active')->orderBy('sort_order','asc')->get();

        return view('stock.edit_stock',compact('stock','origins'));
      }

    

      

      public function stocks_under_qc()
    {

         $let_stocks=Stock::with('qa_samplings')->whereHas('qa_samplings', function($q) {   
                    $q->doesntHave('qc_report');
                })->where('is_active',1)->orderBy('created_at','desc')->get();
          //print_r(json_encode($let_stocks));die;
           $stocks=array();

          foreach ($let_stocks as $key ) {

            //if(count($key['qc_requests'])!=0)
                //continue;

            $stock=Stock::getStock($key['id']);

            array_push($stocks, $stock);

          }

          return view('stock.stocks_under_qc',compact('stocks'));

      }

      

    
   


    public function items_stock_list()
    {

         //$let_stocks=Stock::->orderBy('created_at','desc')->get();
         $let_stocks=Stock::orderBy('created_at','desc')->get();
          
           $stocks=array();

          foreach ($let_stocks as $key ) {
          
           $k= $key['item'];

           $location=''; $color=''; $size=''; $uom='';
           if($k['department']!='')
            $location=$k['department']['name'];
            $item_code=$k['item_code'];
            $item_name=$k['item_name'];
            if($k['unit']!='')
            $uom=$k['unit']['name'];
            if($k['color']!='')
            $color=$k['color']['name'];
              if($k['size']!='')
            $size=$k['size']['name'];

            
            $unit=$key['unit'];
            $rec_qty=$key['rec_quantity'];
            $rej_qty=$key['rej_quantity'];
            $app_qty=$key['approved_qty'];

            //$gross_qty=$rec_qty-$rej_qty;
            $pack_size=$key['pack_size'];
            
            // if($rej_qty=='')
            //     $rej_qty=0;

            $total_qty=$app_qty * $pack_size ;

          
            $vendor_name=''; $vendor_id='';

            if($key['grn']!='')
            {
        $vendor_id=$key['grn']['vendor_id'];
        if($vendor_id!='')
        $vendor_name=$key['grn']['vendor']['name'];
           }

         $origin='';
         if($key['origin_id']!='')
            $origin=$key['origin']['name'];

          $doc_date='';
           if($key['grn']!='')
            $doc_date=$key['grn']['doc_date'];

           $is_under_qc=$key->is_under_qc();
              
           
              //print_r(json_encode($is_under_qc));die;

            $stock=array('stock_id'=>$key['id'],'rec_date'=>$doc_date,'vendor_id'=>$vendor_id,'vendor_name'=>$vendor_name,'date'=>$doc_date,'location'=>$location,'item_code'=>$item_code,'item_name'=>$item_name,'uom'=>$uom,'color'=>$color,'size'=>$size,'unit'=>$unit,'rec_qty'=>$rec_qty,'qty'=>$app_qty,'pack_size'=>$pack_size,'total_qty'=>$total_qty,'grn_no'=>$key['grn_no'],'batch_no'=>$key['batch_no'],'mfg_date'=>$key['mfg_date'],'exp_date'=>$key['exp_date'],'origin'=>$origin,'stock_current_qty'=>$key['stock_current_qty'],'is_under_qc'=>$is_under_qc,'is_sampled'=>$key['is_sampled']);

        array_push($stocks, $stock);

          }

          return view('stock.stock_history',compact('stocks'));

          
          
    }

   

    public function item_stock_detail(Request $request)
    {
        $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();

        $item_id=$request->item_id;
        
        if($item_id=='')
        return view('stock.item_stock_detail',compact('departments'));

         $item=inventory::find($item_id);
          $stocks=$item->current_stock_list();
        return view('stock.item_stock_detail',compact('departments','stocks'));
    }


    public function items_rackwise(Request $request)
    {

    
           $category_id=$request->category_id;

           $config=['rackwise_qty'=>1];

            if($category_id!='')
                $config['category_id']=$category_id;
        
          

    $items=inventory::getItems($config);

    
   
   $departments=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->get();

   $categories=InventoryCategory::orderBy('name','asc')->get();

    return view('inventory.items_rackwise',compact('items','departments','categories'));


    }

    public function items_stock(Request $request)
    {
    
        $department=$request->location;
        $from=$request->from;
        $to=$request->to;

        $department_id='';
           if($department=='')
              $department_id='%';
            else
                $department_id=$department;

            $query = inventory::where('status', '1');

            if ($department != '') {
                $query->where('department_id', $department);
                      
            }

            if ($request->category_id != '') {
                $query->where('category_id', $request->category_id);
                      
            }

         //$inventories=inventory::where('department_id','like',$department_id)->where('status','like','1')->orderBy('item_name','asc')->get();

            $inventories=$query->orderBy('item_name','asc')->get();

    $items=array();

    foreach ($inventories as $key ) {

           $location=''; $color=''; $size=''; $uom=''; $category='';
           if($key['department']!='')
            $location=$key['department']['name'];
            $item_code=$key['item_code'];
            $item_name=$key['item_name'];
            if($key['unit']!='')
            $uom=$key['unit']['name'];
            if($key['color']!='')
            $color=$key['color']['name'];
              if($key['size']!='')
            $size=$key['size']['name'];


        if($key['category']!='')
            $category=$key['category']['name'];
            
            //$total=$key->total_quantity();

            //$total=$key->item_available_balance($from,$to);
             $opening=$key->opening_stock( ['from'=>$from] );
              $closing=$key->closing_stock(['to'=>$to]);
              $current_balance=$key->closing_stock(['to'=>$to]);

                 $status=$key->quantity_status();
                 $detail=$key->item_detail_transections(['from'=>$from,'to'=>$to]);

            $item=array('location'=>$location,'category'=>$category,'item_code'=>$item_code,'item_name'=>$item_name,'uom'=>$uom,'color'=>$color,'size'=>$size,'opening'=>$opening,'closing'=>$closing,'current_balance'=>$current_balance,'status'=>$status,'detail'=>$detail);

        array_push($items, $item);
        
    }
   
   $departments=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->get();

   $categories=InventoryCategory::orderBy('name','asc')->get();

    return view('inventory.items_stock',compact('items','departments','categories','department','from','to'));

          
    }

    public function items_stock_print(Request $request)
    {
    
        $department=$request->location;
        $from=$request->from;
        $to=$request->to;

        $department_id='';
           if($department=='')
              $department_id='%';
            else
                $department_id=$department;

         $inventories=inventory::where('department_id','like',$department_id)->where('activeness','like','active')->orderBy('item_name','asc')->get();

    $items=array();

    foreach ($inventories as $key ) {

           $location=''; $color=''; $size=''; $uom='';
           if($key['department']!='')
            $location=$key['department']['name'];
            $item_code=$key['item_code'];
            $item_name=$key['item_name'];
            if($key['unit']!='')
            $uom=$key['unit']['name'];
            if($key['color']!='')
            $color=$key['color']['name'];
              if($key['size']!='')
            $size=$key['size']['name'];
            
            //$total=$key->total_quantity();

            //$total=$key->item_available_balance($from,$to);
             $opening=$key->opening_stock( $from );
              $closing=$key->closing_stock($to);
              $current_balance=$key->closing_stock();

                 $status=$key->quantity_status();
                 $detail=$key->item_detail_transections($from,$to);

            $item=array('location'=>$location,'item_code'=>$item_code,'item_name'=>$item_name,'uom'=>$uom,'color'=>$color,'size'=>$size,'opening'=>$opening,'closing'=>$closing,'current_balance'=>$current_balance,'status'=>$status,'detail'=>$detail);

        array_push($items, $item);
        
    }
   
   $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();

    $department=InventoryDepartment::find($department);


   $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();


    $data = [
            
            'items'=>$items,
            'department'=>$department,
            'from'=>$from,
            'to'=>$to,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];

        view()->share('inventory.report.items_stock',$data);
        $pdf = PDF::loadView('inventory.report.items_stock', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('inventory.report.items_stock.pdf');

    //return view('inventory.items_stock',compact('items','departments','department','from','to'));

          
    }


    public function items_stock_batch_wise(Request $request)
    {
    
        $department=$request->location;
        $from=$request->from;
        $to=$request->to;

        $expired=$request->expired;

        $department_id='';
           if($department=='')
              $department_id='';
            else
                $department_id=$department;

         $inventories=inventory::where('department_id','like',$department_id)->where('activeness','like','active')->orderBy('item_name','asc')->get();

    $items=array();

    foreach ($inventories as $key ) {

           $location=''; $color=''; $size=''; $uom='';
           if($key['department']!='')
            $location=$key['department']['name'];
            $item_code=$key['item_code'];
            $item_name=$key['item_name'];
            if($key['unit']!='')
            $uom=$key['unit']['name'];
            if($key['color']!='')
            $color=$key['color']['name'];
              if($key['size']!='')
            $size=$key['size']['name'];
            
            //$total=$key->total_quantity();

            //$total=$key->item_available_balance($from,$to);
            // $opening=$key->opening_stock( $from );
             // $closing=$key->closing_stock($to);
              //$current_balance=$key->closing_stock();

                 //$status=$key->quantity_status();
                 //$detail=$key->item_detail_transections($from,$to);

                 $stocks=$key->item_stocks_with_detail($from,$to,$expired);

                 //if($key['department_id']==1 && $key['manufactured']==1)
                 // $stocks=[];

            // $item=array('location'=>$location,'item_code'=>$item_code,'item_name'=>$item_name,'uom'=>$uom,'color'=>$color,'size'=>$size,'opening'=>$opening,'closing'=>$closing,'current_balance'=>$current_balance,'status'=>$status,'detail'=>$detail,'stocks'=>$stocks);

                  $item=array('location'=>$location,'item_code'=>$item_code,'item_name'=>$item_name,'uom'=>$uom,'color'=>$color,'size'=>$size,'stocks'=>$stocks);

        array_push($items, $item);
        
    }
   
   $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();

    return view('inventory.items_stock_batch_wise',compact('items','departments','department','from','to'));

          
    }


    public function get_item_current_stocks(Request $request)
    {
         $item_id=$request->item_id;

         $stocks=Stock::getItemStocks($item_id);

          return response()->json($stocks, 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    public function stock_adjustment(Request $request)
    {
      

      $doc_no="SA-".Date("y")."-";
  
        $num=1;

         $stk=Stockadjustment::where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->first();
         if($stk=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $stk['doc_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

      $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        return view('stock.stock_adjustment',compact('departments','doc_no'));
    }

    public function stock_adjustment_save(Request $request)
    {
            
       
       
       $items_id=$request->items_id;
       $types=$request->types;
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;

        $batch_nos=$request->batch_nos;
        $grn_nos=$request->grn_nos;

        $rate=$request->rate;

      
         
         $active=$request->activeness;
        if($active=='')
            $active='0';

        $order=new Stockadjustment;

        $order->doc_no=$request->doc_no;
        $order->doc_date=$request->doc_date;
    
     
        $order->activeness=$active;
    
        $order->remarks=$request->remarks;

        $order->save();
            
            for($i=0;$i<count($items_id);$i++)
            {
           
            
               $item=inventory::find($items_id[$i]);
               $price=$item['purchase_price'];
               $total_qty=$item->closing_stock();
               $total_amount=$price * $total_qty ;

               if($price=='')
                $price=0;

              $new_qty=$qtys[$i] * $pack_sizes[$i];
              $new_total_amount=$new_qty * $rate[$i] ;
               
               if($types[$i]=='add stock')
               {
                $avg_rate=($total_amount+$new_total_amount)/($total_qty + $new_qty);
              }
              elseif($types[$i]=='less stock')
              {
                  $avg_rate=($total_amount-$new_total_amount)/($total_qty - $new_qty);  
              }

              $item->purchase_price=$avg_rate;
              //$item->save();

              $order->items()->attach($items_id[$i] , ['grn_no' => $grn_nos[$i] ,'batch_no' => $batch_nos[$i] ,'type' => $types[$i] ,'unit' => $units[$i] , 'qty' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i] ,'rate'=>$rate[$i]  ]);

           }

                  return redirect()->back()->with('success','Stock Adjustment saved!');
    }

    public function stock_adjustment_history(Request $request)
    {
     

         $stocks=Stockadjustment::orderBy('doc_no','desc')->get();

        return view('stock.stock_adjustment_history',compact('stocks'));
    }

    public function stock_adjustment_delete(Stockadjustment $adjustment)
    {
        
         
           
           

         $adjustment->items()->detach();
      

         $adjustment->delete();

        return redirect(url('stock-adjustment'))->with('success','Adjustment Deleted!');
      }

    public function stock_adjustment_edit(Stockadjustment $adjustment)
    {
      
      $departments=InventoryDepartment::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        return view('stock.stock_adjustment_edit',compact('departments','adjustment'));
    }

    public function stock_adjustment_update(Request $request)
    {
            

       $items_id=$request->items_id;
       $types=$request->types;
       $units=$request->units;
        $qtys=$request->qtys;
        $pack_sizes=$request->p_s;
         $batch_nos=$request->batch_nos;
        $grn_nos=$request->grn_nos;
        $rate=$request->rate;

      
         
         $active=$request->activeness;
        if($active=='')
            $active='0';

        $order=Stockadjustment::find($request->id);

        $order->doc_no=$request->doc_no;
        $order->doc_date=$request->doc_date;
    
     
        $order->activeness=$active;
    
        $order->remarks=$request->remarks;

        $order->save();
            
            $rel=array();
            for($i=0;$i<count($items_id);$i++)
            {
           
            
              //  $item=inventory::find($items_id[$i]);
              //  $price=$item['purchase_price'];
              //  $total_qty=$item->closing_stock();
              //  $total_amount=$price * $total_qty ;

              //  if($price=='')
              //   $price=0;

              // $new_qty=$qtys[$i] * $pack_sizes[$i];
              // $new_total_amount=$new_qty * $rate[$i] ;
               
              //  if($types[$i]=='add stock')
              //  {
              //   $avg_rate=($total_amount+$new_total_amount)/($total_qty + $new_qty);
              // }
              // elseif($types[$i]=='less stock')
              // {
              //     $avg_rate=($total_amount-$new_total_amount)/($total_qty - $new_qty);  
              // }

              // $item->purchase_price=$avg_rate;
              //$item->save();

              $pivot=array( 'grn_no' => $grn_nos[$i] ,'batch_no' => $batch_nos[$i] , 'type' => $types[$i] ,'unit' => $units[$i] , 'qty' => $qtys[$i] ,'pack_size'=>$pack_sizes[$i] ,'rate'=>$rate[$i] );

                $let=array( $items_id[$i].'' =>$pivot );

                $rel=$rel+$let;

           }

            $order->items()->sync($rel);

                  return redirect()->back()->with('success','Stock Adjustment updated!');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }

    public function get_grn_no(Request $request)
    {
        $stk=Stock::where('grn_no',$request->grn_no)->first();
           $s=Stock::getStock($stk['id']);

           return response()->json($s, 200);


    }
}
