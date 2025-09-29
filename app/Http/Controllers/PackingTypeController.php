<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\packing_type;

class PackingTypeController extends Controller
{
    public function index(Request $request)
    {
         $methods=packing_type::orderBy('text')->get();
        return view('configuration.packing_types',compact('methods'));
    }

    public function store(Request $request)
    {   
         $a=$request->get('activeness');
    	if($a!='1')
    		$a=0;

        $config=new packing_type;
        $config->text=$request->get('text');
        
        $config->remarks=$request->get('remarks');
        $config->activeness=$a;
        $config->sort_order=$request->get('sort_order');
        $config->save();

        return redirect()->back()->with('success','Packing Type Added!');  

  }

  public function edit(packing_type $type)
    {
         $methods=packing_type::orderBy('text')->get();
        return view('configuration.edit_packing_types',compact('type','methods'));
    }

    public function update(Request $request)
    {
           $a=$request->get('activeness');
    	if($a!='1')
    		$a=0;

        $config=packing_type::find($request->get('id'));

        //print_r($config); die;
        $config->text=$request->get('text');
        
        $config->remarks=$request->get('remarks');
        $config->activeness=$a;
        $config->sort_order=$request->get('sort_order');
        $config->save();

        return redirect()->back()->with('success','Packing Type Updated!');  

  }
}
