<?php

namespace App\Http\Controllers;

use App\Models\inventory;
use Illuminate\Http\Request;
use App\Models\InventoryDepartment;
use App\Models\InventoryType;
use App\Models\InventoryCategory;
use App\Models\InventorySize;
use App\Models\InventoryColor;
use App\Models\Origin;
use App\Models\Unit;
use App\Models\Grn;
use App\Models\Ticket;
use App\Models\Processparameter;
use App\Models\Process;
use App\Models\Procedure;
use App\Models\ProductionStandard;
use App\Models\Productionplan;
use App\Models\Requisition;
use App\Models\Issuance;
use App\Models\Department;
use App\Models\Stock;
use App\Models\Transection;
use App\Models\Configuration;
use App\Models\Employee;
use App\Models\Packings;
use App\Models\Gtin;
use App\Models\Attribute;
use App\Models\Gage;
use App\Models\Shape;
use App\Models\sale_stock;
use App\Models\Customer;
use App\Models\Company;
use App\Models\Branch;
use App\Models\City;
use App\Models\Vendor;
use App\Models\purchase_ledger;
use PDF;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          $department_id=$request->department_id;
          $category_id=$request->category_id;
          $sub_category_id=$request->sub_category_id;
          $gage_id=$request->gage_id;
             
             
          $items= inventory::where(function($q) use($department_id,$category_id,$sub_category_id,$gage_id){
              if($department_id!='')
                $q->where('department_id',$department_id);
            if($category_id!='')
                $q->where('category_id',$category_id);
            if($sub_category_id!='')
                $q->where('sub_category_id',$sub_category_id);
            if($gage_id!='')
                $q->where('gage_id',$gage_id);
          })->orderBy('item_name')->get();

         $categories=InventoryCategory::with('sub_categories')->orderBy('name','asc')->get();

          $gages=Gage::orderBy('name','asc')->get();

          return view('inventory.index',compact('items','categories','gages'));
    }

    public function item(Request $request)
    {
        $item_id=$request->item_id;
        $item_code=$request->item_code;

        if($item_code!='')
          $item= inventory::with('color','size','unit','packings')->where('item_code','like',$item_code)->first();

        if($item_id!='')
          $item= inventory::with('color','size','unit')->find($item_id);

          return response()->json($item, 200);

          
    }

    public function getItemWithRackQty(Request $request)
    {
          
    $item = inventory::findOrFail($request->item_id);
    
    
   
      $info = $item->getQtyWithRack();

                        
    return response()->json([
            'success' => true,
            'data' => $info
        ]);

  }

    public function item_exist(Request $request)
    {
          $item= inventory::where('item_name','like',$request->item_name)->first();

          $bool=true;

          if($item=='')
            $bool=false;

          return response()->json($bool, 200);

          
    }

    public function get_item_code(Request $request)
    {
          //$department=$request->get('department');
          $type=$request->get('type');
          //$category=$request->get('category');
        
          //$depart_code='';
          $type_code='';
          // $category_code='';

          /*if($department==null)
            {
            //$department='%';
        }
        else
        {
          $depart_code=strtoupper (InventoryDepartment::find($department)->code).'-';
        }*/

          if($type==null)
            {
                //$type='%';
            }
            else
            {
                $type_code=strtoupper (InventoryType::find($type)->code).'-';
            }

            /*if($category==null)
            {
                //$category='%';
            }
            else
            {

            $category_code=strtoupper(InventoryCategory::find($category)->code).'-';
            }*/

            
          //$item_code=$depart_code.$category_code.$type_code;
          $item_code=$type_code;

/*-'department','type',   
     >where(function($query)use($department) {
           if($department!=null)
                $query->where('department_id', $department);
            if($department==null || $department=='')
                $query->where('department_id', null);
            })->where(function($query)use($category) {
           if($category!=null)
                $query->where('category_id', $category);
            if($category==null || $category=='')
                $query->where('category_id', null);
            })*/


 $item= inventory::with('category')->orderBy('item_code','desc')->where(function($query)use($type) {
           if($type!=null)
                $query->where('sub_category_id', $type);
            if($type==null || $type=='')
                $query->where('sub_category_id', null);
            })->latest()->first();//RM-PB-001

         //print_r(json_encode($category));die;
          $num=1;
          //print_r($item);die;
         //print_r(json_encode($item));die;
         if($item=='')
         {
              $num=sprintf('%03d', $num);
         }
         else
         {

            
            $num=explode($item_code , $item['item_code']); 

            if(isset($num[1])){
            $num=intval($num[1]) + 1;
            $num=sprintf('%03d', $num);
             }
             else{
                $num=1;
             }
              
         }

          $item_code=$item_code.$num;

          return response()->json($item_code, 200);

          
    }

     public function get_sub_category_code(Request $request)
    {
          
          $category=$request->get('category');
        
          

            if($category==null)
            {
                //$category='%';
            }
            else
            {

            $category_code=strtoupper (InventoryCategory::find($category)->code).'-';
            }

            
          $item_code=$category_code;


 $item= InventoryType::with('category')->orderBy('code','desc')->where(function($query)use($category) {
           if($category!=null)
                $query->where('category_id', $category);
            if($category==null || $category=='')
                $query->where('category_id', null);
            })->latest()->first();//RM-PB-001

         //print_r(json_encode($category));die;
          $num=1;
          //print_r($item);die;
         //print_r(json_encode($item));die;
         if($item=='')
         {
              $num=sprintf('%03d', $num);
         }
         else
         {

            $num=explode($item_code , $item['code']); 
            $num=intval($num[1]) + 1;
            $num=sprintf('%03d', $num);
              
         }

          $item_code=$item_code.$num;

          return response()->json($item_code, 200);

          
    }      


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$departments=InventoryDepartment::where('status','1')->orderBy('sort_order','asc')->get();
        
        $types=InventoryType::orderBy('name','asc')->get();
         $categories=InventoryCategory::orderBy('name','asc')->get();
        $sizes=InventorySize::orderBy('name','asc')->get();
         $shapes=Shape::orderBy('name','asc')->get();
           $gages=Gage::orderBy('name','asc')->get();
         
         //$units=Unit::where('status','1')->orderBy('sort_order','asc')->get();
        // $origins=Origin::where('status','1')->orderBy('sort_order','asc')->get();

         // $procedures=Procedure::where('activeness','like','1')->orderBy('created_at','desc')->get();

          //$gtins=Gtin::doesnthave('product')->orderBy('created_at')->get();

          //$attributes=Attribute::orderBy('name')->get();

         $config=array('types'=>$types,'categories'=>$categories,'sizes'=>$sizes,'shapes'=>$shapes,'gages'=>$gages);

           


        return view('inventory.create',compact('config'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    

        $chln=inventory::where('item_code',$request->item_code)->first();
        $chln1=inventory::where('item_name',$request->item_name)->first();
            if($chln!='' || $chln1!='')
             return redirect()->back()->withErrors(['error'=>'Item Code/Name already existed!']);


        /*$manufactured=$request->manufactured;
        if($manufactured=='')
            $manufactured=0;

        $status=$request->status;
        if($status=='')
            $status=0;

        $colors=$request->color;

         if($colors!='')
         $colors = implode(',', array_filter($colors));

     $pack=$request->packing;

         if($pack!='')
         $pack = implode(',', array_filter($pack));*/

        $inventory=new inventory;

        $inventory->category_id=$request->category;
        $inventory->sub_category_id=$request->type;
        $inventory->item_code=$request->item_code;
        $inventory->item_name=$request->item_name;
        
        $inventory->loading_qty=$request->loading_qty;
        $inventory->pricing_by=$request->pricing_by;
        $inventory->standard_rate=$request->standard_rate;

         $inventory->minimal=$request->minimal;
        $inventory->weight=$request->weight;
        $inventory->feet=$request->feet;

        $inventory->status=1;

        //$inventory->pack_size=$request->pack_size;
        //$inventory->pack_size_qty=$request->pack_size_qty;

        //$inventory->status=$status;
        /*$inventory->manufactured_by=$request->manufactured_by;
        $inventory->item_bar_code=$request->item_bar_code;
        $inventory->generic=$request->generic;
        $inventory->origin_id=$request->origin;
        $inventory->category_id=$request->category;
        $inventory->unit_id=$request->unit;
        $inventory->small_unit_id=$request->small_unit_id;
        $inventory->unit_rate=$request->unit_rate;
        $inventory->procedure_id=$request->procedure;
        //$inventory->gtin_id=$request->gtin_id;
        $inventory->is_manufactured=$manufactured;
        
        $inventory->optimal=$request->optimal;
        $inventory->maximal=$request->maximal;
        
       
        $inventory->purchase_price=$request->purchase_price;
         $inventory->mrp=$request->mrp;
        $inventory->remarks=$request->remarks;
        $inventory->rate=$request->rate;*/

        $inventory->shape_id=$request->shape_id;
        $inventory->size_id=$request->size_id;
         $inventory->gage_id=$request->gage_id;

        $inventory->save();

        /* $colors=$request->color;

        $pack=$request->packing;
        
        if($pack!=''){
        for ($i=0; $i < count($pack) ; $i++) { 

            if($pack[$i]=='')
                continue;
            
           
           $pk=new Packings;
           $pk->item_id=$inventory['id'];
           $pk->packing=$pack[$i];
           $pk->save();

            
        }
    }*/

        //$qty=$request->qty;

        $txt='Item Added!';
        
        /*if($qty >0 )
        {
         
         $chln2=Stock::where('grn_no',$request->grn_no)->first();

         if($chln2!='')
         {
           $txt='This grn no already existed!';
         }
         else
         {
        $stock=new Stock;
        $stock->grn_id=0;
        $stock->item_id=$inventory->id;
        $stock->approved_qty=$request->qty;
        $stock->quantity=$request->qty;
        $stock->rec_quantity=$request->qty;
        $stock->pack_size=1;
        $stock->unit='loose';
        //$stock->stock_status=5;
        $stock->batch_no=$request->batch_no;
        $stock->grn_no=$request->grn_no;
        $stock->is_active=1;
        $stock->save();

        $inventory->stock_id=$stock->id;
        $inventory->save();

        $depart=InventoryDepartment::find($inventory['department_id'])->account_id;

             $amount=round($stock->approved_qty * $inventory->rate,2);
               
                $trans=new Transection;

              $trans->account_voucherable_id=$inventory->id;
              $trans->account_voucherable_type='App\Models\inventory';
             $trans->account_id=$depart;
             $trans->corporate_id=$inventory['id'];
             $trans->remarks='Ref: Opening quantity of '.$inventory->item_name;
              $trans->debit=$amount;
               $trans->credit=0;
               $trans->save();
           }

         }
         elseif($qty==0 || $qty=='' || $qty==null)
         {
            
             
             
         }*/

        return redirect()->back()->with('success',$txt);
    }

    public function department_inventory(Request $request)
    {
           $depart=$request->department_id;
           $customer_id=$request->customer_id;


/*
           if($customer_id!="" && $depart!='')
           {
             $items= inventory::with('type','category','size','color','unit','small_unit','packings')->where('department_id',$depart)->where('status','1')->orderBy('item_name')->get();
           }

           if($depart=='')
           {
            $items= inventory::with('type','category','size','color','unit','small_unit','packings')->where('status','1')->orderBy('item_name')->get();
           }
           else
           {
          $items= inventory::with('type','category','size','color','unit','small_unit','packings')->where('department_id',$depart)->where('status','1')->orderBy('item_name')->get();
           }*/

        if($customer_id!="" && $depart!='')
           {
             $items= inventory::with('type','category','size','unit')->where('department_id',$depart)->where('status','1')->orderBy('item_name')->get();
           }

           if($depart=='')
           {
            $items= inventory::with('type','category','size','unit')->where('status','1')->orderBy('item_name')->get();
           }
           else
           {
          $items= inventory::with('type','category','size','unit')->where('department_id',$depart)->where('status','1')->orderBy('item_name')->get();
           }


          return response()->json($items, 200);
    }


    public function store_issuance($request_id='')
    {
        $doc_no="ISS-".Date("y")."-";
        $num=1;

         $std=Issuance::select('id','issuance_no')->where('issuance_no','like',$doc_no.'%')->orderBy('issuance_no','desc')->first();
         if($std=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $std['issuance_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

        
        $employees=Employee::with('designation')->where('status','1')->orderBy('name','asc')->get();

        $departments=Department::where('status','1')->orderBy('sort_order')->get();

        //$locations=InventoryDepartment::departments_with_items_with_qty();
      $locations=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->select('id','name')->get();        
           $request='';

        if($request_id!='')
        {
            $req=Requisition::find($request_id);
            $department_id=$req['department_id'];

            $plan_no=''; $pro=''; $bt=''; $bt_no='';
            if($req['plan']!='')
              {
                $plan_no=$req['plan']['plan_no'];
                $pro=$req['plan']['product']['item_name'];
                 $bt=$req['plan']['batch_size'];
                 $bt_no=$req['plan']['batch_no'];
             }

         

             $issued_items=array();
             
             foreach ($req['items'] as $item) {
                 
                // print_r(json_encode($item));die;

                $grn_no=''; $batch_no=''; $qty=0; $pack_size=1; 

                $request_item_id=$item['pivot']['id'];
                $app_qty=$item['pivot']['approved_qty'];

                $stage_id=$item['pivot']['stage_id']; $stage_text='';
                if($stage_id=='')
                    $stage_id=-1;
                          if($stage_id!='' && $stage_id!='-1')
                          {  
                            $stage=Process::find($stage_id);
                            $stage_text=$stage['process_name'];
                          }

                   $t=$item['pivot']['pack_size'] * $item['pivot']['approved_qty'];
                     
                    // $index=array_search($item['department_id'],array_column($locations, 'id'));
                     //$index1=array_search($item['id'],array_column($locations[$index]['items'], 'id'));
                     //$s_item=$locations[$index]['items'][$index1];
                    // print_r(json_encode($index));die;

                     $let=[];
                     array_push($let,['unit'=>$item['pivot']['unit'],'qty'=>$item['pivot']['approved_qty'],'pack_size'=>$item['pivot']['pack_size'],'grn_no'=>'','batch_no'=>'']);
                // if($s_item['qty']<=0)
                // {
                //   array_push($let,['unit'=>$item['pivot']['unit'],'qty'=>0,'pack_size'=>$item['pivot']['pack_size'],'grn_no'=>'','batch_no'=>'']);
                //    //print_r(json_encode($let));die;
                // }
                // else
                // {           
                //     $grn=$s_item['grns']; $q=$item['pivot']['approved_qty']; $p_s=$item['pivot']['pack_size']; $u=$item['pivot']['unit'];


                       
                //        for($i=0;$i<count($item['grns']);$i++)
                //        {
                //           if($grn[$i]['qty']>=$t)
                //            { 
                //              $qty=$q;
                //              $pack_size=$p_s;
                //              $unit=$u;
                             
                //             }
                //             else
                //             {
                //                 $qty=$grn[$i]['qty'];
                //              $pack_size=1;
                //              $unit='loose';
                //              //for next loop
                //              $q=$t-$qty;
                //              $t=$t-$qty;
                             
                //              $p_s=1;
                //              $u='loose';

                //             } 

                //             $grn_no=$grn[$i]['grn_no'];
                //              $batch_no=$grn[$i]['batch_no'];
                //              array_push($let,['unit'=>$unit,'qty'=>$qty,'pack_size'=>$pack_size,'grn_no'=>$grn_no,'batch_no'=>$batch_no]);
                //              if($grn[$i]['qty']>=$t)
                //              break;
                //         }//for
                // }//else

                 $uom='';
                 if($item['unit']!='')
                    $uom=$item['unit']['name'];
                  
                   for($i=0;$i<count($let);$i++)
                   {
                     $it=['item_id'=>$item['id'],'item_name'=>$item['item_name'],'uom'=>$uom,'stage_id'=>$stage_id,'stage_text'=>$stage_text,'request_item_id'=>$request_item_id,'app_qty'=>$app_qty];

                     $new=array_merge($it,$let[$i]);

                     array_push($issued_items, $new);  
                   }
                 

                 
             }//end for loop

             $request=['id'=>$req['id'],'doc_no'=>$req['requisition_no'],'doc_date'=>$req['requisition_date'],'department_id'=>$req['department_id'],'plan_id'=>$req['plan_id'],'plan_no'=>$plan_no,'product'=>$pro,'batch_size'=>$bt,'batch_no'=>$bt_no,'items'=>$issued_items];

           }// enf if request

       return view('inventory.store_issuance',compact('departments','employees','locations','doc_no','request'));

    }


    public function item_sales_report(Request $request)
    {  

         $companies=Company::with('branches')->get();


         $branches = $request->company_id > 0 
        ? Branch::where('company_id', $request->company_id)->get()
        : collect();

            $cities=City::orderBy('name')->get();


        $categories=InventoryCategory::orderBy('name','asc')->get();

         $items=inventory::getItems();

         $customers=Customer::where('status','1')->orderBy('name','asc')->get();


        $from=$request->from;
        $to=$request->to;

        $company_id=$request->company_id;
        $branch_id=$request->branch_id;
        $category_id=$request->category_id;
        $item_id=$request->item_id;
        $customer_id=$request->customer_id;
        $city_id=$request->city_id;


          
        $query = sale_stock::with(['sale','item', 'sale.customer'])->orderByDesc('id');

// Filter: item_id (direct column)
if ($request->item_id) {
    $query->where('item_id', $request->item_id);
}

// Filter: sale-level fields
if ($request->company_id) {
    $query->whereHas('sale', function ($q) use ($request) {
        $q->where('company_id', $request->company_id);
    });
}

if ($request->branch_id) {
    $query->whereHas('sale', function ($q) use ($request) {
        $q->where('branch_id', $request->branch_id);
    });
}

if ($request->category_id) {
    $query->whereHas('item', function ($q) use ($request) {
        $q->where('category_id', $request->category_id);
    });
}

// Filter: customer + city
if ($request->customer_id) {
    $query->whereHas('sale.customer', function ($q) use ($request) {
        $q->where('id', $request->customer_id);
    });
}

if ($request->city_id) {
    $query->whereHas('sale.customer', function ($q) use ($request) {
        $q->where('city_id', $request->city_id);
    });
}

// Filter: date range (if on sale table)
if ($request->from) {
    $query->whereHas('sale', function ($q) use ($request) {
        $q->whereDate('invoice_date', '>=', $request->from );
    });
}

if ($request->to) {
    $query->whereHas('sale', function ($q) use ($request) {
        $q->whereDate('invoice_date', '<=', $request->to);
    });
}

$stocks = $query->get();




        return view('inventory.sales_report',compact('companies','branches','cities','categories','items','customers','stocks','from','to'));
    }

    public function item_purchase_report(Request $request)
    {  

         $companies=Company::with('branches')->get();


         $branches = $request->company_id > 0 
        ? Branch::where('company_id', $request->company_id)->get()
        : collect();

            $cities=City::orderBy('name')->get();


        $categories=InventoryCategory::orderBy('name','asc')->get();

         $items=inventory::getItems();

         $vendors=Vendor::where('status','1')->orderBy('name','asc')->get();


        $from=$request->from;
        $to=$request->to;

        $company_id=$request->company_id;
        $branch_id=$request->branch_id;
        $category_id=$request->category_id;
        $item_id=$request->item_id;
        $vendor_id=$request->vendor_id;
        $city_id=$request->city_id;


          
        $query = purchase_ledger::with(['purchase','item', 'purchase.vendor'])->orderByDesc('id');

// Filter: item_id (direct column)
if ($request->item_id) {
    $query->where('item_id', $request->item_id);
}

// Filter: purchase-level fields
if ($request->company_id) {
    $query->whereHas('purchase', function ($q) use ($request) {
        $q->where('company_id', $request->company_id);
    });
}

if ($request->branch_id) {
    $query->whereHas('purchase', function ($q) use ($request) {
        $q->where('branch_id', $request->branch_id);
    });
}

if ($request->category_id) {
    $query->whereHas('item', function ($q) use ($request) {
        $q->where('category_id', $request->category_id);
    });
}

// Filter: customer + city
if ($request->vendor_id) {
    $query->whereHas('purchase.vendor', function ($q) use ($request) {
        $q->where('id', $request->vendor_id);
    });
}

if ($request->city_id) {
    $query->whereHas('purchase.vendor', function ($q) use ($request) {
        $q->where('city_id', $request->city_id);
    });
}

// Filter: date range (if on purchase table)
if ($request->from) {
    $query->whereHas('purchase', function ($q) use ($request) {
        $q->whereDate('doc_date', '>=', $request->from );
    });
}

if ($request->to) {
    $query->whereHas('purchase', function ($q) use ($request) {
        $q->whereDate('doc_date', '<=', $request->to);
    });
}

$stocks = $query->get();




        return view('inventory.purchase_report',compact('companies','branches','cities','categories','items','vendors','stocks','from','to'));
    }

    public function item_history()
    {
        //$departments=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->get();

        $categories=InventoryCategory::orderBy('name','asc')->get();

         $items=inventory::getItems();



        return view('inventory.item_history',compact('categories','items'));
    }

    public function search_item_history(Request $request)
    {  

    //$departments=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->get();

     $categories=InventoryCategory::orderBy('name','asc')->get();

         $items=inventory::getItems();
       
        //$department=$request->location;
        
        // $item_combine=$request->item_code;
        // if($item_combine=='')
        //     return view('inventory.item_history',compact('departments'));
        // $item_combine_array=explode('_', $item_combine);

        $item_id=$request->item_id;

        if($item_id=='')
            return view('inventory.item_history',compact('categories','items'));

        $item_id=explode('_', $item_id);

         $from=$request->from;
          $to=$request->to;

         //$item=inventory::with('type','category','size','color','unit')->where('item_code','like',$item_combine_array[1])->first();
        // $item=inventory::with('type','category','size','color','unit')->where('id','like',$item_id)->first();
         $item=inventory::where('id','like',$item_id)->first();


         //item history

         $records=$item->item_history(['from'=>$from,'to'=>$to]);

         $open=$item->opening_stock([ 'from'=> $from ]);
         $close=$item->closing_stock(['to'=>$to]);
         $current=$item->closing_stock();
         //end item history

        

       // $inventories=inventory::with('type','category')->where('department_id',$department)->where('status','like','1')->orderBy('created_at')->get();


        
        return view('inventory.item_history',compact('items','categories','item','from','to','records','close','open','current'));
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(inventory $inventory)
    {
        //$departments=InventoryDepartment::where('status','1')->orderBy('sort_order','asc')->get();

         $types=InventoryType::orderBy('name','asc')->get();
         $categories=InventoryCategory::orderBy('name','asc')->get();
         $sizes=InventorySize::orderBy('name','asc')->get();
         $shapes=Shape::orderBy('name','asc')->get();
         $gages=Gage::orderBy('name','asc')->get();


        
         //$units=Unit::where('status','1')->orderBy('sort_order','asc')->get();
         //$origins=Origin::where('status','1')->orderBy('sort_order','asc')->get();
         //$procedures=Procedure::where('activeness','like','1')->orderBy('created_at','desc')->get();

         //$gtins=Gtin::doesnthave('product')->orWhere('id',$inventory['gtin_id'])->orderBy('created_at')->get();

         //$attributes=Attribute::orderBy('name')->get();

         $config=array('types'=>$types,'categories'=>$categories, 'sizes'=>$sizes , 'shapes'=>$shapes, 'gages'=>$gages);

          //'types'=>$types,'origins'=>$origins,'sizes'=>$sizes,

        return view('inventory.edit',compact('config','inventory'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, inventory $inventory)
    {
        //$inventory=new inventory;

        $chln=inventory::where('id','<>',$inventory['id'])->where('item_code',$request->item_code)->first();
        $chln1=inventory::where('id','<>',$inventory['id'])->where('item_name',$request->item_name)->first();
            if($chln!='' || $chln1!='')
             return redirect()->back()->withErrors(['error'=>'Item Code/Name already existed!']);


       /* $manufactured=$request->manufactured;
        if($manufactured=='')
            $manufactured=0;

        $status=$request->status;
        if($status=='')
            $status=0;

         $colors=$request->color;

         if($colors!='')
         $colors = implode(',', array_filter($colors));

      $pack=$request->packing;

         if($pack!='')
         $pack = implode(',', array_filter($pack));*/


          $inventory->category_id=$request->category;
        $inventory->sub_category_id=$request->type;
        $inventory->item_code=$request->item_code;
        $inventory->item_name=$request->item_name;
        
        $inventory->loading_qty=$request->loading_qty;
        $inventory->pricing_by=$request->pricing_by;
        $inventory->standard_rate=$request->standard_rate;

         $inventory->minimal=$request->minimal;
        $inventory->weight=$request->weight;
        $inventory->feet=$request->feet;
/*
        $inventory->department_id=$request->department;
        $inventory->type_id=$request->type;
        $inventory->item_code=$request->item_code;
        $inventory->item_name=$request->item_name;

       $inventory->color_ids=$colors;
       $inventory->packings=$pack;

          //$p=$request->pack_size;
            //$p=str_replace("'","\'",$p);
        //$inventory->pack_size=$p;
        //$inventory->pack_size_qty=$request->pack_size_qty;
        $inventory->status=$status;
        $inventory->manufactured_by=$request->manufactured_by;
        $inventory->item_bar_code=$request->item_bar_code;
        $inventory->generic=$request->generic;
        $inventory->origin_id=$request->origin;
        $inventory->procedure_id=$request->procedure;
        //$inventory->gtin_id=$request->gtin_id;
        $inventory->is_manufactured=$manufactured;
        $inventory->category_id=$request->category;
        $inventory->unit_id=$request->unit;
        $inventory->small_unit_id=$request->small_unit_id;
        $inventory->unit_rate=$request->unit_rate;
        $inventory->minimal=$request->minimal;
        $inventory->optimal=$request->optimal;
        $inventory->maximal=$request->maximal;
         $inventory->size_id=$request->size;
        //$inventory->color_id=$request->color;
        $inventory->purchase_price=$request->purchase_price;
        $inventory->mrp=$request->mrp;
        $inventory->remarks=$request->remarks;

        $inventory->rate=$request->rate;*/

         $inventory->shape_id=$request->shape_id;
        $inventory->size_id=$request->size_id;
         $inventory->gage_id=$request->gage_id;

        $inventory->save();

        /*$pack=$request->packing;
        $packs=$inventory->packings;
        $n=0;
        if($pack!=''){
        for ($i=0; $i < count($pack) ; $i++) { 

            if($pack[$i]=='')
                continue;
            
             if($n < count($packs))
          $pk=$packs[$n];
          else
           $pk=new Packings;
           $pk->item_id=$inventory['id'];
           $pk->packing=$pack[$i];
           $pk->save();

            $n++;
        }
    }

        for($i=$n; $i < count($packs); $i++ )
           {
               $packs[$i]->delete();
           }*/


        //$qty=$request->qty;


        $txt='Item Updated!';
        
       /* if($qty >0 )
        {

         
           $chln2='';
        if($request->stock_id!='' || $request->stock_id!=null )
         { 
            $stock=Stock::find($request->stock_id);

            $chln2=Stock::where('id','<>',$request->stock_id)->where('grn_no',$request->grn_no)->first();
         }
        else
            $stock=new Stock;



         if($chln2!='')
         {
           $txt='Item upadted but this grn no already existed!';
         }
         else
         {
        
        $stock->grn_id=0;
        $stock->item_id=$inventory->id;
        $stock->approved_qty=$request->qty;
        $stock->quantity=$request->qty;
        $stock->rec_quantity=$request->qty;
        $stock->pack_size=1;
        $stock->unit='loose';
        //$stock->stock_status=5;
        $stock->batch_no=$request->batch_no;
        $stock->grn_no=$request->grn_no;
        $stock->is_active=1;
        $stock->save();

        $inventory->stock_id=$stock->id;
        $inventory->save();

        $depart=InventoryDepartment::find($inventory['department_id'])->account_id;

         $trans=Transection::where('account_voucherable_id',$inventory['id'])->where('account_voucherable_type','App\Models\inventory')->where('account_id',$depart)->first();
             $amount=round($stock->approved_qty * $inventory->rate,2);
               if($trans=='')
                $trans=new Transection;

              $trans->account_voucherable_id=$inventory->id;
              $trans->account_voucherable_type='App\Models\inventory';
             $trans->account_id=$depart;
             $trans->corporate_id=$inventory['id'];
             $trans->remarks='Ref: Opening quantity of '.$inventory->item_name;
              $trans->debit=$amount;
               $trans->credit=0;
               $trans->save();

               $trans=Transection::where('id','<>',$trans['id'])->where('account_voucherable_id',$inventory['id'])->where('account_voucherable_type','App\Models\inventory')->get();
             if($trans!=''){
             foreach ($trans as $key ) {
                 $key->delete();
             }
             }

             }

         }
         elseif($qty==0 || $qty=='' || $qty==null)
         {
            if($inventory->stock_id!='')
            {
            $stock=Stock::find($inventory->stock_id);
            $stock->delete();

             $inventory->stock_id=null;
              $inventory->save();
             }
             //->where('account_id',$depart)
             $depart=InventoryDepartment::find($inventory['department_id'])->account_id;
             $trans=Transection::where('account_voucherable_id',$inventory['id'])->where('account_voucherable_type','App\Models\inventory')->get();
             if($trans!=''){
             foreach ($trans as $key ) {
                 $key->delete();
             }
             }
                
         }*/

        return redirect()->back()->with('success',$txt);
    }

    public function stock_wise_inventory(Request $request)
    {
    
        $department=$request->department;
        $from=$request->from;
        $to=$request->to;
        $stock_type=$request->stock_type;
        
        $expiry_num=$request->expiry_num;
        $expiry_type=$request->expiry_type;
        $is_expired=$request->is_expired;
        
        $exp_within=''; $today=Date('Y-m-d'); $next='';
        if($expiry_num!='' && $expiry_type!='')
           {
            $exp_within='+'.$expiry_num.' '.$expiry_type;
            $next=Date('Y-m-d', strtotime($exp_within));
            }
                
            if($is_expired=='1')
                $next=$today;
               
        $department_id='';
           if($department=='')
              $department_id='';
            else
                $department_id=$department;

            $departments=InventoryDepartment::where('status','like','1')->orderBy('sort_order','asc')->get();

         $its=inventory::where('department_id','like',$department_id)->where('status','like','1')->orderBy('item_name','asc')->get();

         $items=array();
         foreach ($its as $it) {
            $lists=[];

            if($stock_type=='batch_no')
            $lists= $it->getBatches() ;
            elseif($stock_type=='grn_no')
            $lists= $it->getGrns() ;
             
             $batches=array();
             $opening_total=0; $closing_total=0; 
              foreach ($lists as $list) {
               
                   $stk_dt=$it->getStockDetail([$stock_type=>$list]);
                
               

                $exp='';
                 if(isset($stk_dt['exp_date']))
                $exp=$stk_dt['exp_date'];

            $mrp='';
                 if(isset($stk_dt['mrp']))
                $mrp=$stk_dt['mrp'];

                if($next!='' )
                {  //print_r($exp);die;
                    if($exp=='' || $next <= $exp)
                        continue;
                }

                 $detail=$it->item_detail_transections(['from'=>$from,'to'=>$to,$stock_type=>$list]);
                            
                  $opening=$it->opening_stock(['from'=>$from,'to'=>$to,$stock_type=>$list]);
                  $closing=$it->closing_stock(['from'=>$from,'to'=>$to,$stock_type=>$list]);
                  $closing_total  = $closing_total + $closing; 
                  $opening_total  = $opening_total + $opening; 
                 
                 if($opening==0 && $closing==0 && $detail['grn_qty']==0 && $detail['production_qty']==0 && $detail['add_adjustment']==0 && $detail['sale_return']==0 && $detail['issue_qty']==0 && $detail['dc_qty']==0 && $detail['less_adjustment']==0 && $detail['purchase_return']==0)
                {  
                        continue;
                }

                $batch=array('batch_no'=>$list,'exp_date'=>$exp,'mrp'=>$mrp,'opening'=>$opening,'closing'=>$closing,'detail'=>$detail);
               
                array_push($batches, $batch);
              }
              $item=array('item'=>$it,'opening_total'=>$opening_total,'closing_total'=>$closing_total,'batches'=>$batches);
               
              if(count($batches) > 0)
              array_push($items,$item );
             
         }
         
       $config=array('department'=>$department,'from'=>$from,'to'=>$to,'stock_type'=>$stock_type,'expiry_num'=>$expiry_num,'expiry_type'=>$expiry_type,'is_expired'=>$is_expired);
          

         return view('inventory.stock_wise',compact('items','departments','config'));


     }

     public function expired_inventory(Request $request)
    {

        $invts=inventory::where('department_id','like','1')->where('is_manufactured','1')->where('status','like','1')->orderBy('item_name','asc')->get();
          
          $items=array();

        foreach ($invts as $key ) {
            $list= $key->getBatches() ;
             
             $batches=array();
            foreach ($list as $bt) {
            
                $let=$key->item_batch_detail($bt,'');

                             $today=date('Y-m-d');
                             $next=date('Y-m-d',strtotime('+1 year'));
                                $n=['batch_no'=>$bt,'exp_date'=>$let['exp_date'],'current'=>$let['current']];
                            if(!($let['exp_date'] >= $today))
                               array_push($batches,  $n);
            }

            if(count($batches)>0)
                {
                    $item=array('batches'=>$batches,'item'=>$key);
                    array_push($items, $item);
                }
        }
           return view('inventory.expired_inventory',compact('items'));
    }

     public function print_expired_inventory(Request $request)
    {

        $invts=inventory::where('department_id','like','1')->where('is_manufactured','1')->where('status','like','1')->orderBy('item_name','asc')->get();
          
          $items=array();

        foreach ($invts as $key ) {
            $list= $key->getBatches() ;
             
             $batches=array();
            foreach ($list as $bt) {
            
                $let=$key->item_batch_detail($bt,'');

                             $today=date('Y-m-d');
                             $next=date('Y-m-d',strtotime('+1 year'));
                                $n=['batch_no'=>$bt,'exp_date'=>$let['exp_date'],'current'=>$let['current']];
                            if(!($let['exp_date'] >= $today))
                               array_push($batches,  $n);
            }

            if(count($batches)>0)
                {
                    $item=array('batches'=>$batches,'item'=>$key);
                    array_push($items, $item);
                }
        }

        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();


        $data = [
            
            'items'=>$items,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];

        view()->share('inventory.print_expired',$data);
        $pdf = PDF::loadView('inventory.print_expired', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('inventory.print_expired.pdf');
           return view('inventory.near_expiry',compact('items'));
    }

     public function near_expiry_inventory(Request $request)
    {

        $invts=inventory::where('department_id','like','1')->where('is_manufactured','1')->where('status','like','1')->orderBy('item_name','asc')->get();
          
          $items=array();

        foreach ($invts as $key ) {
            $list= $key->getBatches() ;
             
             $batches=array();
            foreach ($list as $bt) {
            
                $let=$key->item_batch_detail($bt,'');

                             $today=date('Y-m-d');
                             $next=date('Y-m-d',strtotime('+1 year'));
                                $n=['batch_no'=>$bt,'exp_date'=>$let['exp_date'],'current'=>$let['current']];
                            if(!($let['exp_date'] >= $next))
                               array_push($batches,  $n);
            }

            if(count($batches)>0)
                {
                    $item=array('batches'=>$batches,'item'=>$key);
                    array_push($items, $item);
                }
        }
           return view('inventory.near_expiry',compact('items'));
    }

    public function print_near_expiry_inventory(Request $request)
    {

        $invts=inventory::where('department_id','like','1')->where('is_manufactured','1')->where('status','like','1')->orderBy('item_name','asc')->get();
          
          $items=array();

        foreach ($invts as $key ) {
            $list= $key->getBatches() ;
             
             $batches=array();
            foreach ($list as $bt) {
            
                $let=$key->item_batch_detail($bt,'');

                             $today=date('Y-m-d');
                             $next=date('Y-m-d',strtotime('+1 year'));
                                $n=['batch_no'=>$bt,'exp_date'=>$let['exp_date'],'current'=>$let['current']];
                            if(!($let['exp_date'] >= $next))
                               array_push($batches,  $n);
            }

            if(count($batches)>0)
                {
                    $item=array('batches'=>$batches,'item'=>$key);
                    array_push($items, $item);
                }
        }

        $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();


        $data = [
            
            'items'=>$items,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];

        view()->share('inventory.print_near_expiry',$data);
        $pdf = PDF::loadView('inventory.print_near_expiry', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('inventory.print_near_expiry.pdf');
           return view('inventory.near_expiry',compact('items'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(inventory $inventory)
    {
        //
    }

    public function get_item_current_grn_no(Request $request)
    {
        $item=inventory::where('id',$request->item_id)->first();
        $grns=$item->grns;

        return response()->json($grns, 200);
    }
}
