<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\inventory;
use App\Models\country;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list=commission::orderBy('created_at')->get();
        return view('employee.salesman.commission_list',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $men=Employee::sales_man();
        $items=inventory::where('department_id','1')->where('activeness','like','active')->orderBy('item_name')->get();
        $countries=country::with('provinces','provinces.regions','provinces.regions.districts','provinces.regions.districts.cities','provinces.regions.districts.cities.territories')->orderBy('sort_order','asc')->get();
        //$customers=Customer::where('so_id',$so_id)->where('activeness','1')->get();
        return view('employee.salesman.area_wise_config',compact('men','items','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

       $items=$request->items;
       $types=$request->types;
        $values=$request->values;


         $active=$request->activeness;
        if($active=='')
            $active='0';

        $order=new commission;

        $order->salesman_id=$request->salesman_id;
        $order->customer_id=$request->customer_id;
        
        
        $order->type=$request->type;
        $order->value=$request->value;
        $order->country_id=$request->country_id;
        $order->state_id=$request->state_id;
        $order->region_id=$request->region_id;
        $order->district_id=$request->district_id;
        $order->city_id=$request->city_id;
        $order->territory_id=$request->territory_id;
        $order->activeness=$active;
        $order->remarks=$request->remarks;

        $order->save();
            
            for($i=0;$i<count($items);$i++)
            { 

                if($values[$i]=='')
                    continue;
            $order->items()->attach($items[$i] , ['type' => $types[$i] , 'value' => $values[$i]  ]);
           }

         return redirect()->back()->with('success','Commission config saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show(Commission $commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        $men=Employee::sales_man();
        $items=inventory::where('department_id','1')->where('activeness','like','active')->orderBy('item_name')->get();
        $countries=country::with('provinces','provinces.regions','provinces.regions.districts','provinces.regions.districts.cities','provinces.regions.districts.cities.territories')->orderBy('sort_order','asc')->get();
        //$customers=Customer::where('so_id',$so_id)->where('activeness','1')->get();
        return view('employee.salesman.edit_area_wise_config',compact('men','items','countries','commission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $items=$request->items;
       $types=$request->types;
        $values=$request->values;


         $active=$request->activeness;
        if($active=='')
            $active='0';

        $order=commission::find($request->id);

        $order->salesman_id=$request->salesman_id;
        $order->customer_id=$request->customer_id;
        
        
        $order->type=$request->type;
        $order->value=$request->value;
        $order->country_id=$request->country_id;
        $order->state_id=$request->state_id;
        $order->region_id=$request->region_id;
        $order->district_id=$request->district_id;
        $order->city_id=$request->city_id;
        $order->territory_id=$request->territory_id;
        $order->activeness=$active;
        $order->remarks=$request->remarks;

        $order->save();
            
            
           $rel=array();
            for($i=0;$i<count($items);$i++)
            {  
                if($values[$i]=='')
                    continue;
                
                $pivot=array('type' => $types[$i] , 'value' => $values[$i] );

                $let=array( $items[$i].'' =>$pivot );

                $rel=$rel+$let;
           }

           $order->items()->sync($rel);

         return redirect()->back()->with('success','Commission config updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        //
    }
}
