<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\freight_type;

class FreightTypeController extends Controller
{
    public function index(Request $request)
    {
         $methods=freight_type::orderBy('text')->get();
        return view('configuration.freight_types',compact('methods'));
    }

    public function store(Request $request)
    {   
         $a=$request->get('status');
    	if($a!='1')
    		$a=0;

        $config=new freight_type;
        $config->text=$request->get('text');
        
        $config->remarks=$request->get('remarks');
        $config->status=$a;
        $config->sort_order=$request->get('sort_order');
        $config->save();

        return redirect()->back()->with('success','Freight Type Added!');  

  }

  public function edit(freight_type $type)
    {
         $methods=freight_type::orderBy('text')->get();
        return view('configuration.edit_freight_types',compact('type','methods'));
    }

    public function update(Request $request)
    {
           $a=$request->get('status');
    	if($a!='1')
    		$a=0;

        $config=freight_type::find($request->get('id'));

        //print_r($config); die;
        $config->text=$request->get('text');
        
        $config->remarks=$request->get('remarks');
        $config->status=$a;
        $config->sort_order=$request->get('sort_order');
        $config->save();

        return redirect()->back()->with('success','Freight Type Updated!');  

  }
}
