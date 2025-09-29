<?php

namespace App\Http\Controllers;

use App\Models\country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries=country::orderBy('sort_order','asc')->get();

        return view('others.country',compact('countries'));

    }

    public function getCountryDetail(Request $request)
    {
        $country  =  $request->country ;
        

        //print_r($input);
        $country=country::with('provinces','regions','districts','cities','territories','cities.country','cities.province','cities.region','cities.district')->find($country);
       

        return response()->json($country, 200);

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
        $country=new country;

         $status=$request->get('status');
         if($status=='')
            $status='0';
         $country->name=$request->get('name');
         $country->description=$request->get('description');
          $country->sort_order=$request->get('sort_order');
         $country->status=$status;
        $country->save();

        return redirect()->back()->with('success','Country Added!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(country $country)
    {
        //
    }
}
