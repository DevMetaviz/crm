<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Employee;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $doctors=Doctor::orderBy('name')->get();
        return view('point.doctor.list',compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers=Customer::where('activeness','1')->orderBy('name')->get();
        $salesmen=Employee::sales_man();
        return view('point.doctor.create',compact('customers','salesmen'));
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

        $point=new Doctor;

        $point->name=$request->name;
        $point->salesman_id=$request->salesman_id;
        $point->distributor_id=$request->distributor_id;
        

        $point->contact=$request->contact;
        $point->mobile=$request->mobile;
         $point->contact2=$request->contact2;
        $point->mobile2=$request->mobile2;
        $point->phone=$request->phone;
        $point->email=$request->email;

        $point->address=$request->address;
        $point->activeness=$active;
        
        $point->save();

        return redirect()->back()->with('success','Doctor Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        $customers=Customer::where('activeness','1')->orWhere('id',$doctor['customer_id'])->orderBy('name')->get();
        $salesmen=Employee::sales_man();
        return view('point.doctor.edit',compact('customers','salesmen','doctor'));
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

        $point=Doctor::find($request->id);

        $point->name=$request->name;
        $point->salesman_id=$request->salesman_id;
        $point->distributor_id=$request->distributor_id;
        

        $point->contact=$request->contact;
        $point->mobile=$request->mobile;
         $point->contact2=$request->contact2;
        $point->mobile2=$request->mobile2;
        $point->phone=$request->phone;
        $point->email=$request->email;

        $point->address=$request->address;
        $point->activeness=$active;
        
        $point->save();

        return redirect()->back()->with('success','Doctor Updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
