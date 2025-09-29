<?php

namespace App\Http\Controllers;

use App\Models\Territory;
use Illuminate\Http\Request;
use App\Models\country;

class TerritoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries=country::with('provinces','provinces.regions','provinces.regions.districts','provinces.regions.districts.cities')->orderBy('sort_order','asc')->get();

        $list=Territory::orderBy('sort_order','asc')->get();

        return view('others.territory',compact('countries','list'));
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
        $city=new Territory;

         $activeness=$request->get('activeness');
         if($activeness=='')
            $activeness='0';
        $country=$request->country;
        $province=$request->get('province');
        $region=$request->get('region');
        $district=$request->get('district');
        $city1=$request->get('city');
        //  if($province=='')
        //     $province='';
        //  if($region=='')
        //     $region='';
        // if($district=='')
        //     $district='';
        // if($city=='')
        //     $city='';

         $city->country_id=$country;
          $city->province_id=$province;
          $city->region_id=$region;
          $city->district_id=$district;
          $city->city_id=$city1;
         $city->name=$request->get('territory');
         $city->description=$request->get('description');
          $city->sort_order=$request->get('sort_order');
         $city->activeness=$activeness;
        $city->save();

        return redirect()->back()->with('success','Territory Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Territory  $territory
     * @return \Illuminate\Http\Response
     */
    public function show(Territory $territory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Territory  $territory
     * @return \Illuminate\Http\Response
     */
    public function edit(Territory $territory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Territory  $territory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Territory $territory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Territory  $territory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Territory $territory)
    {
        //
    }
}
