<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

         
  
        $rates = Rate::latest()
                         ->paginate(20)
                         ->withQueryString();

     

       

    

        return view('configuration.rate.index', compact('rates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        
        return view('configuration.rate.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
                    'hr_gol_marketing'   => 'required',
                    'hr_gol_all'   => 'required',
                    'hr_gol_special' => 'required',
                    'hr_sqr_marketing'   => 'required',
                    'hr_sqr_all'        => 'required',
                    'hr_sqr_special'        => 'required',
                    'cr_marketing1'   => 'required',
                    'cr_all1'   => 'required',
                    'cr_special1' => 'required',
                    'cr_marketing2'   => 'required',
                    'cr_all2'        => 'required',
                    'cr_special2'        => 'required',
                    'ss_gol_marketing'   => 'required',
                    'ss_gol_all'   => 'required',
                    'ss_gol_special' => 'required',
                    'ss_sqr_marketing'   => 'required',
                    'ss_sqr_all'        => 'required',
                    'ss_sqr_special'        => 'required',
        ]);

        $data['user_id'] = auth()->id();
 
        Rate::create($data);

        return redirect()->route('rates.index')->with('success', 'Rates saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show(Rate $rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function edit(Rate $rate)
    {
         
       
        return view('configuration.rate.form', compact('rate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rate $rate)
    {
        $data = $request->validate([
                    'hr_gol_marketing'   => 'required',
                    'hr_gol_all'   => 'required',
                    'hr_gol_special' => 'required',
                    'hr_sqr_marketing'   => 'required',
                    'hr_sqr_all'        => 'required',
                    'hr_sqr_special'        => 'required',
                    'cr_marketing1'   => 'required',
                    'cr_all1'   => 'required',
                    'cr_special1' => 'required',
                    'cr_marketing2'   => 'required',
                    'cr_all2'        => 'required',
                    'cr_special2'        => 'required',
                    'ss_gol_marketing'   => 'required',
                    'ss_gol_all'   => 'required',
                    'ss_gol_special' => 'required',
                    'ss_sqr_marketing'   => 'required',
                    'ss_sqr_all'        => 'required',
                    'ss_sqr_special'        => 'required',
        ]);


        $rate->update($data);

        return redirect()->route('rates.index')->with('success', 'Rates updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rate $rate)
    {
        $rate->delete();
        return redirect()->route('rates.index')->with('success', 'Rate deleted successfully.');
    }
}
