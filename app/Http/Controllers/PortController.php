<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Port;

class PortController extends Controller
{
    public function index(Request $request)
    {
        $methods=Port::orderBy('text')->get();
        return view('configuration.ports',compact('methods'));
    }

    public function store(Request $request)
    {   
         $a=$request->get('activeness');
    	if($a!='1')
    		$a=0;

        $config=new Port;
        $config->text=$request->get('text');
        
        $config->remarks=$request->get('remarks');
        $config->activeness=$a;
        $config->sort_order=$request->get('sort_order');
        $config->save();

        return redirect()->back()->with('success','Port Added!');  

  }

  public function edit(Port $port)
    {
         $methods=Port::orderBy('text')->get();
        return view('configuration.edit_ports',compact('port','methods'));
    }

    public function update(Request $request)
    {
           $a=$request->get('activeness');
    	if($a!='1')
    		$a=0;

        $config=Port::find($request->get('id'));

        //print_r($config); die;
        $config->text=$request->get('text');
        
        $config->remarks=$request->get('remarks');
        $config->activeness=$a;
        $config->sort_order=$request->get('sort_order');
        $config->save();

        return redirect()->back()->with('success','Port Updated!');  

  }
}
