<?php

namespace App\Http\Controllers;

use App\Models\Compression;
//use App\Models\Coating;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\Productionplan;
use PDF;

class FillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $plns=Productionplan::where('demand_id','<>','0')->get();

             $plans=[];
            foreach ($plns as $pn) {

                
          


              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'pack_size'=>$pn['product']['pack_size']];

              array_push($plans, $plan);
            }
        
        return view('production.filling.create',compact('plans'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compression  $compression
     * @return \Illuminate\Http\Response
     */
    public function show(Compression $compression)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compression  $compression
     * @return \Illuminate\Http\Response
     */
    public function edit(Compression $compression)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compression  $compression
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compression $compression)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compression  $compression
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compression $compression)
    {
        //
    }
}
