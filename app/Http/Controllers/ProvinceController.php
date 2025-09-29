<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Region;
use App\Models\District;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\country;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries=country::where('activeness','1')->orderBy('sort_order','asc')->get();

        $provinces=Province::orderBy('sort_order','asc')->get();

        return view('others.province',compact('provinces','countries'));
    }

    public function getStates(Request $request)
    {
         $country = $request->country;
        $provinces=Province::with('country')->where('country_id',$country)->orderBy('sort_order','asc')->get();

        return response()->json($provinces, 200);
    }

    public function getStateDetail(Request $request)
    {
        
         $province  =  $request->province ;

                

        //print_r($input);
        //$province=Province::with('regions','districts','cities','cities.country','cities.province','cities.region','cities.district')->select('id','name')->find($province);

        $regions=Region::where('province_id','like',$province)->select('id','name')->get();
        $districts=District::where('province_id','like',$province)->select('id','name')->get();
        $cities=City::with('country','province','region','district')->where('province_id','like',$province)->get();

        $province=array('regions'=>$regions,'districts'=>$districts,'cities'=>$cities);
        
        //$country->provinces()->get(['id','name']);

        return response()->json($province, 200);

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
        $province=new Province;

         $activeness=$request->get('activeness');
         if($activeness=='')
            $activeness='0';
         $province->country_id=$request->get('country');
         $province->name=$request->get('name');
         $province->description=$request->get('description');
          $province->sort_order=$request->get('sort_order');
         $province->activeness=$activeness;
        $province->save();

        return redirect()->back()->with('success','Province Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Province $province)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {
        //
    }
}
