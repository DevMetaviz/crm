<?php

namespace App\Http\Controllers;

use App\Models\Gtin;
use Illuminate\Http\Request;

class GtinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gtins=Gtin::orderBy('created_at','desc')->get();
        return view('inventory.gtin.index',compact('gtins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.gtin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gtin=new Gtin;
        $gtin->gtin_no=$request->no;
        $gtin->remarks=$request->remarks;
        $gtin->save();

         return redirect()->back()->with('success','GTIN Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gtin  $gtin
     * @return \Illuminate\Http\Response
     */
    public function show(Gtin $gtin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gtin  $gtin
     * @return \Illuminate\Http\Response
     */
    public function edit(Gtin $gtin)
    {
        return view('inventory.gtin.edit',compact('gtin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gtin  $gtin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gtin $gtin)
    {
        $gtin->gtin_no=$request->no;
        $gtin->remarks=$request->remarks;
        $gtin->save();

         return redirect()->back()->with('success','GTIN Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gtin  $gtin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gtin $gtin)
    {
        //
    }
}
