<?php

namespace App\Http\Controllers;

use App\Models\Dispensing;
use Illuminate\Http\Request;
use App\Models\Productionplan;
use App\Models\Configuration;
use PDF;

class DispensingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dispenses=Dispensing::orderBy('created_at','desc')->get();

        return view('production.dispensing.index',compact('dispenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plns=Productionplan::where('demand_id','<>','0')->doesntHave('dispensing')->get();

             $plans=[];
            foreach ($plns as $pn) {

              
                 
              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'pack_size'=>$pn['product']['pack_size'],'items'=>$pn->raw_items()];

              array_push($plans, $plan);
            }
        
        return view('production.dispensing.create',compact('plans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //print_r(json_encode($request));die;
        $yield=new Dispensing;
         $yield->plan_id=$request->plan_id;
         $yield->dispense_start=$request->dispense_start;
         $yield->dispense_comp=$request->dispense_comp;
        
         $yield->temprature=$request->temprature;
         $yield->humidity=$request->humidity;
        
        $yield->save();

        return redirect(url('/edit/dispensing/'.$yield['id']))->with('success','Dispensing genrated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dispensing  $dispensing
     * @return \Illuminate\Http\Response
     */
    public function show(Dispensing $dispensing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dispensing  $dispensing
     * @return \Illuminate\Http\Response
     */
    public function edit(Dispensing $dispensing)
    {
        $plns=Productionplan::where('demand_id','<>','0')->doesntHave('dispensing')->orWhere('id',$dispensing['plan_id'])->get();

             $plans=[];
            foreach ($plns as $pn) {

                 
              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'pack_size'=>$pn['product']['pack_size'],'items'=>$pn->raw_items()];

              array_push($plans, $plan);
            }
        
        return view('production.dispensing.edit',compact('plans','dispensing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dispensing  $dispensing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $yield=Dispensing::find($request->id);
         $yield->plan_id=$request->plan_id;
         $yield->dispense_start=$request->dispense_start;
         $yield->dispense_comp=$request->dispense_comp;
        
         $yield->temprature=$request->temprature;
         $yield->humidity=$request->humidity;
        
        $yield->save();

        return redirect()->back()->with('success','Dispensing updated!');
    }

    public function print(Dispensing $dispensing)
    {
          $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();


        $data = [
            
            'plan'=>$dispensing['plan'],
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.challan_pdf',compact('data'));
           view()->share('production.dispensing.report',$data);
        $pdf = PDF::loadView('production.dispensing.report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($dispensing['id'].'.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dispensing  $dispensing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dispensing $dispensing)
    {
        //
    }
}
