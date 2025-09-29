<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Models\country;
use App\Models\Province;
use App\Models\District;
use App\Models\City;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries=country::orderBy('sort_order','asc')->get();

        return view('others.region',compact('countries'));
    }

    public function getRegions(Request $request)
    {
         $province = $request->province;
         $country = $request->country;
         if($province=='')
            $province='%';
        $regions=Region::where('country_id',$country)->where('province_id','like',$province)->orderBy('sort_order','asc')->get();

        return response()->json($regions, 200);
    }

     public function getCountryRegions(Request $request)
    {
         $country = $request->country;
        $regions=Region::where('country_id',$country)->orderBy('sort_order','asc')->get();

        return response()->json($regions, 200);
    }

    public function getRegionDetail(Request $request)
    {
        
         $region  =  $request->region ;

                

        //print_r($input);
        //$province=Province::with('regions','districts','cities','cities.country','cities.province','cities.region','cities.district')->select('id','name')->find($province);

        $districts=District::where('region_id','like',$region)->select('id','name')->get();
        $cities=City::with('country','province','region','district')->where('region_id','like',$region)->get();

        $region=array('districts'=>$districts,'cities'=>$cities);
        
        //$country->provinces()->get(['id','name']);

        return response()->json($region, 200);

    }

    public function getStateRegions(Request $request)
    {
         $province = $request->province;
          $country = $request->country;
          if($province==null)
            $regions=Region::where('country_id','like',$country)->orderBy('sort_order','asc')->get();
        // if($country==null)
           // $country='%';
        else
        $regions=Region::where('country_id','like',$country)->where('province_id','like',$province)->orderBy('sort_order','asc')->get();

        return response()->json($regions, 200);
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
        $region=new Region;

         $activeness=$request->get('activeness');
         if($activeness=='')
            $activeness='0';
        $province=$request->get('province');
         if($province=='')
            $province='';
         $region->country_id=$request->get('country');
          $region->province_id=$province;
         $region->name=$request->get('name');
         $region->description=$request->get('description');
          $region->sort_order=$request->get('sort_order');
         $region->activeness=$activeness;
        $region->save();

        return redirect()->back()->with('success','Region Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        //
    }
}
