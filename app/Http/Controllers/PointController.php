<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Employee;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $points=Point::orderBy('name')->get();
        return view('point.list',compact('points'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers=Customer::where('activeness','1')->orderBy('name')->get();
        $doctors=Doctor::where('activeness','1')->orderBy('name')->get();
        $salesmen=Employee::sales_man();
        return view('point.point_create',compact('doctors','customers','salesmen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $active=$request->activeness;
        if($active=='')
            $active=0;

        $point=new Point;

        $point->name=$request->name;
        $point->distributor_id=$request->distributor_id;
        $point->salesman_id=$request->salesman_id;
        $point->doctor_id=$request->doctor_id;

        $point->contact=$request->contact;
        $point->mobile=$request->mobile;
         $point->contact2=$request->contact2;
        $point->mobile2=$request->mobile2;
        $point->phone=$request->phone;
        $point->email=$request->email;

        $point->address=$request->address;
        $point->activeness=$active;
        
        $point->save();

        return redirect()->back()->with('success','Sale Point Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function show(Point $point)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function edit(Point $point)
    {
        $customers=Customer::where('activeness','1')->orWhere('id',$point['customer_id'])->orderBy('name')->get();
        $doctors=Doctor::where('activeness','1')->orWhere('id',$point['doctor_id'])->orderBy('name')->get();
        $salesmen=Employee::sales_man();
        return view('point.point_edit',compact('doctors','customers','salesmen','point'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $active=$request->activeness;
        if($active=='')
            $active=0;

        $point=Point::find($request->id);

        $point->name=$request->name;
        $point->distributor_id=$request->distributor_id;
        $point->salesman_id=$request->salesman_id;
        $point->doctor_id=$request->doctor_id;

        $point->contact=$request->contact;
        $point->mobile=$request->mobile;
         $point->contact2=$request->contact2;
        $point->mobile2=$request->mobile2;
        $point->phone=$request->phone;
        $point->email=$request->email;

        $point->address=$request->address;
        $point->activeness=$active;
        
        $point->save();

        return redirect()->back()->with('success','Sale Point Updated!');

    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point)
    {
        //
    }
}
