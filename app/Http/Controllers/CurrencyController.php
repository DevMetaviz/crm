<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $methods=Currency::orderBy('text')->get();
        return view('configuration.currency',compact('methods'));
    }

    public function store(Request $request)
    {   
         $a=$request->get('status');
    	if($a!='1')
    		$a=0;

    	$d=$request->get('is_default');
    	if($d!='1')
    		$d=0;
              
              if($d==1)
              {  
            $c=Currency::where('is_default','1')->first();

            if($c!='')
            	return redirect()->back()->with('error','Already default currency Added!'); 
             }

        $config=new Currency;
        $config->text=$request->get('text');
        
        $config->remarks=$request->get('remarks');
        $config->status=$a;
        $config->is_default=$d;
        $config->symbol=$request->get('symbol');
        $config->save();

        return redirect()->back()->with('success','Currency Added!');  

  }

  public function edit(Currency $currency)
    {
         $methods=Currency::orderBy('text')->get();
        return view('configuration.edit_currency',compact('currency','methods'));
    }

    public function update(Request $request)
    {
           $a=$request->get('status');
    	if($a!='1')
    		$a=0;

    	$d=$request->get('is_default');
    	if($d!='1')
    		$d=0;

    	 $config=Currency::find($request->get('id'));
              
              if($d==1)
              {  
            $c=Currency::where('id','<>',$config['id'])->where('is_default','1')->first();

            if($c!='')
            	return redirect()->back()->with('error','Already default currency Added!'); 
             }

       

        //print_r($config); die;
        $config->text=$request->get('text');
        
        $config->remarks=$request->get('remarks');
        $config->status=$a;
         $config->is_default=$d;
        $config->symbol=$request->get('symbol');
        $config->save();

        return redirect()->back()->with('success','Currency Updated!');  

  }
}
