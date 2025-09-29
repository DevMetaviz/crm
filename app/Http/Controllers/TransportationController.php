<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportation;

class TransportationController extends Controller
{

	public function index(Request $request)
    {
         $methods=Transportation::orderBy('text')->get();
        return view('configuration.transport_methods',compact('methods'));
    }

    public function store(Request $request)
    {
          $a=$request->get('activeness');
        if($a!='1')
            $a=0;

        $config=new Transportation;
        $config->text=$request->get('text');
        
        $config->remarks=$request->get('remarks');
        $config->activeness=$a;
        $config->sort_order=$request->get('sort_order');
        $config->save();

        return redirect()->back()->with('success','Transport Method Added!');  

  }

  public function edit(Transportation $transport)
    {
         $methods=Transportation::orderBy('text')->get();
        return view('configuration.edit_transport_methods',compact('transport','methods'));
    }

    public function update(Request $request)
    {
        
        $a=$request->get('activeness');
        if($a!='1')
            $a=0;

        $config=Transportation::find($request->get('id'));

        //print_r($config); die;
        $config->text=$request->get('text');
        
        $config->remarks=$request->get('remarks');
        $config->activeness=$a;
        $config->sort_order=$request->get('sort_order');
        $config->save();

        return redirect()->back()->with('success','Transport Method Updated!');  

  }


    
}
