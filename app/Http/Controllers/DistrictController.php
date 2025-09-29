<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\country;
use App\Models\City;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $countries=country::orderBy('sort_order','asc')->get();

        return view('others.district',compact('countries'));
    }

    public function getDistricts(Request $request)
    {
         $province = $request->province;
          $country = $request->country;
          $region = $request->region;
         
         if($province==null)
            $province='%';
        if($region==null)
            $region='%';
        
        $districts=District::with('country','province','region')->where('country_id','like',$country)->where('province_id','like',$province)->where('region_id','like',$region)->orderBy('sort_order','asc')->get();

        return response()->json($districts, 200);
    }

    public function getDistrictDetail(Request $request)
    {
        
         $district  =  $request->district ;

                

        //print_r($input);
        //$province=Province::with('regions','districts','cities','cities.country','cities.province','cities.region','cities.district')->select('id','name')->find($province);

        $cities=City::with('country','province','region','district')->where('district_id','like',$district)->get();

        $region=array('cities'=>$cities);
        
        //$country->provinces()->get(['id','name']);

        return response()->json($region, 200);

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
        $district=new District;

         $activeness=$request->get('activeness');
         if($activeness=='')
            $activeness='0';
        $country=$request->get('country');
        $province=$request->get('province');
        $region=$request->get('region');
         if($province=='')
            $province='';
         if($region=='')
            $region='';
         $district->country_id=$country;
          $district->province_id=$province;
          $district->region_id=$region;
         $district->name=$request->get('district');
         $district->description=$request->get('description');
          $district->sort_order=$request->get('sort_order');
         $district->activeness=$activeness;
        $district->save();

        return redirect()->back()->with('success','District Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $district)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        //
    }
}
