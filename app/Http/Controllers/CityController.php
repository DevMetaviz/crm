<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\country;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries=country::orderBy('sort_order','asc')->get();

        $cities=City::orderBy('sort_order','asc')->get();

        return view('others.city',compact('countries','cities'));
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
        $city=new City;

         $activeness=$request->get('activeness');
         if($activeness=='')
            $activeness='0';
        $country=$request->get('country');
        $province=$request->get('province');
        $region=$request->get('region');
        $district=$request->get('district');
         if($province=='')
            $province='';
         if($region=='')
            $region='';
        if($district=='')
            $district='';

         $city->country_id=$country;
          $city->province_id=$province;
          $city->region_id=$region;
          $city->district_id=$district;
         $city->name=$request->get('city');
         $city->description=$request->get('description');
          $city->sort_order=$request->get('sort_order');
         $city->activeness=$activeness;
        $city->save();

        return redirect()->back()->with('success','City Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }
}
