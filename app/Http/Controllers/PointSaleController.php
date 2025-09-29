<?php

namespace App\Http\Controllers;

use App\Models\point_sale;
use Illuminate\Http\Request;
use App\Models\Point;
use App\Models\inventory;
use App\Models\Customer;
use App\Models\InventoryDepartment;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Target;
use App\Models\Configuration;
use PDF;

class PointSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales=point_sale::orderBy('doc_no')->get();
        return view('point.sale.list',compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $doc_no="PS-".Date("y")."-";
        $num=1;

         $in=point_sale::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->latest()->first();
         if($in=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $in['doc_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

        $points=Point::where('activeness','1')->get();
        
        $customers=Customer::where('activeness','1')->orderBy('name')->get();
        $doctors=Doctor::where('activeness','1')->orderBy('name')->get();
        $salesmen=Employee::sales_man();
        $items=inventory::where('department_id','1')->where('activeness','active')->orderBy('item_name')->get();
    
        return view('point.sale.create',compact('doc_no','points','customers','salesmen','doctors','items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $items_id=$request->items_id;
        $qtys=$request->qtys;
        $rates=$request->rates;


        $active=$request->active;
        if($active=='')
            $active=0;

        $sale=new point_sale;

        $sale->doc_no=$request->doc_no;
        $sale->doc_date=$request->doc_date;
          $sale->invoice_no=$request->invoice_no;        
        $sale->point_id=$request->point_id;
        $sale->distributor_id=$request->distributor_id;
        $sale->salesman_id=$request->salesman_id;
        $sale->doctor_id=$request->doctor_id;

        $sale->type=$request->type;
        $sale->sale_value=$request->sale_value;
        
        $sale->remarks=$request->remarks;
                
    
        $sale->activeness=$active;
        
        $sale->save();
       


       if($items_id)
            {

        for($i=0;$i<count($items_id);$i++)
            {
         $sale->items()->attach($items_id[$i] , [ 'qty' => $qtys[$i] ,'rate'=>$rates[$i]  ]);
           }

       }

        return redirect()->back()->with('success','Point sale genrated!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\point_sale  $point_sale
     * @return \Illuminate\Http\Response
     */
    public function show(point_sale $point_sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\point_sale  $point_sale
     * @return \Illuminate\Http\Response
     */
    public function edit(point_sale $sale)
    {
        $points=Point::where('activeness','1')->get();
        
        $customers=Customer::where('activeness','1')->orderBy('name')->get();
        $doctors=Doctor::where('activeness','1')->orderBy('name')->get();
        $salesmen=Employee::sales_man();
        $items=inventory::where('department_id','1')->where('activeness','active')->orderBy('item_name')->get();
    
        return view('point.sale.edit',compact('sale','points','customers','salesmen','doctors','items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\point_sale  $point_sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, point_sale $point_sale)
    {
        $items_id=$request->items_id;
        $qtys=$request->qtys;
        $rates=$request->rates;


        $active=$request->active;
        if($active=='')
            $active=0;

        $sale=point_sale::find($request->id);

        $sale->doc_no=$request->doc_no;
        $sale->doc_date=$request->doc_date;
          $sale->invoice_no=$request->invoice_no;
        $sale->point_id=$request->point_id;
        $sale->distributor_id=$request->distributor_id;
        $sale->salesman_id=$request->salesman_id;
        $sale->doctor_id=$request->doctor_id;

        $sale->type=$request->type;
        $sale->sale_value=$request->sale_value;
        
        $sale->remarks=$request->remarks;
                
    
        $sale->activeness=$active;
        
        $sale->save();

        

           $rel=array();

           if($items_id)
            {
            for($i=0;$i<count($items_id);$i++)
            {  
                $pivot=array( 'qty' => $qtys[$i] ,'rate'=>$rates[$i] );

                $let=array( $items_id[$i].'' =>$pivot );

                $rel=$rel+$let;
           }
            }

           $sale->items()->sync($rel);


        return redirect()->back()->with('success','Point sale updated!');
    }

    public function doctor_sales(Request $request)
    {   
        $from=$request->from;
        $to=$request->to;
        $doctor_id=$request->doctor_id;
        $customer_id=$request->customer_id;

        $doctor=Doctor::find($doctor_id);
        $customer=Customer::find($customer_id);
           
        $customers=Customer::with('doctors')->where('activeness','1')->orderBy('name')->get();
        $doctors=Doctor::where('activeness','1')->orderBy('name')->get();
        
        $config=array('from'=>$from,'to'=>$to,'doctor_id'=>$doctor_id,'customer_id'=>$customer_id);

         if($doctor=='' && $customer=='')
          return view('point.sale.doctor_sales',compact('customers','doctors','config'));

         
        return view('point.sale.doctor_sales',compact('customers','doctors','config','doctor','customer'));
    }

    public function doctor_sales_target_wise(Request $request)
    {   
        $from=$request->from;
        $to=$request->to;
        $doctor_id=$request->doctor_id;
        $customer_id=$request->customer_id;
           
        $customers=Customer::with('doctors')->where('activeness','1')->orderBy('name')->get();
        $doctors=Doctor::where('activeness','1')->orderBy('name')->get();
        
        $config=array('from'=>$from,'to'=>$to,'doctor_id'=>$doctor_id,'customer_id'=>$customer_id);

         if($doctor_id=='' && $customer_id=='')
          return view('point.target.doctor_sales',compact('customers','doctors','config'));
         
         $doctor=Doctor::find($doctor_id);
        $customer=Customer::find($customer_id);
         
        return view('point.target.doctor_sales',compact('customers','doctors','config','doctor','customer'));
    }

    public function doctor_sales_target_wise1(Request $request)
    {   
        $from=$request->from;
        $to=$request->to;
        $doctor_id=$request->doctor_id;
        $distributor_id=$request->distributor_id;
        $target_wise=$request->target_wise;
           
        $distributors=Customer::with('doctors')->where('activeness','1')->orderBy('name')->get();
        //$doctors=Doctor::where('activeness','1')->orderBy('name')->get();
        
        $config=array('from'=>$from,'to'=>$to,'doctor_id'=>$doctor_id,'distributor_id'=>$distributor_id,'target_wise'=>$target_wise);

         if($doctor_id=='' && $distributor_id=='')
          return view('point.target.doctor_sales1',compact('distributors','config'));
         
         $doctor=Doctor::find($doctor_id);
        $distributor=Customer::find($distributor_id);
           $docs=Doctor::where('distributor_id',$distributor_id)->where('activeness','1')->orderBy('name')->pluck('id');
            $doctors=Doctor::where('distributor_id',$distributor_id)->where('activeness','1')->orderBy('name')->get();
            if($target_wise==1) 
             {
                $targets=Target::whereIn('doctor_id',$docs)->get();
                return view('point.target.doctor_sales1',compact('distributors','doctors','config','doctor','distributor','targets'));
            }
            
        return view('point.target.doctor_sales1',compact('distributors','doctors','config','doctor','distributor'));
    }

    public function print_doctor_sales(Request $request)
    {   
        $from=$request->from;
        $to=$request->to;
        $doctor_id=$request->doctor_id;
        $distributor_id=$request->distributor_id;
        $target_wise=$request->target_wise;
           
        
        
        $config=array('from'=>$from,'to'=>$to,'doctor_id'=>$doctor_id,'distributor_id'=>$distributor_id,'target_wise'=>$target_wise);

         
         
         $doctor=Doctor::find($doctor_id);
        $distributor=Customer::find($distributor_id);
           $docs=Doctor::where('distributor_id',$distributor_id)->where('activeness','1')->orderBy('name')->pluck('id');

           $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

            
            if($target_wise==1) 
             {
                $targets=Target::whereIn('doctor_id',$docs)->get();
                
                $data = [
            
            'targets'=>$targets,
            'config'=>$config,
            'distributor'=>$distributor,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
            }

            else
            {
                $doctors=Doctor::where('distributor_id',$distributor_id)->where('activeness','1')->orderBy('name')->get();

                $data = [
            
            'doctors'=>$doctors,
            'config'=>$config,
            'distributor'=>$distributor,
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        
        ];
            }

                        
        view()->share('point.report.doctor_sales',$data);
        $pdf = PDF::loadView('point.report.doctor_sales', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream('point.report.doctor_sales.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\point_sale  $point_sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(point_sale $point_sale)
    {
        //
    }
}
