<?php

namespace App\Http\Controllers;

use App\Models\Compression;
use App\Models\Coating;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\Productionplan;
use App\Models\container;
use PDF;

class CoatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $granules=Coating::orderBy('created_at','desc')->get();

        return view('production.coating.index',compact('granules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $plns=Productionplan::where('demand_id','<>','0')->doesntHave('coating')->get();

             $plans=[];
            foreach ($plns as $pn) {
          


              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'pack_size'=>$pn['product']['pack_size']];

              array_push($plans, $plan);
            }
        
        return view('production.coating.create',compact('plans'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $yield=new Coating;
         $yield->plan_id=$request->plan_id;
         $yield->start_date=$request->start_date;
         $yield->comp_date=$request->comp_date;
         $yield->lead_time=$request->lead_time;
         $yield->temprature=$request->temprature;
         $yield->humidity=$request->humidity;
         $yield->mix_time=$request->mix_time;
         $yield->inlet_temperature=$request->inlet_temperature;
         $yield->bed_temperature=$request->bed_temperature;
         $yield->outlet_temperature=$request->outlet_temperature;
          $yield->machine_speed=$request->machine_speed;
          $yield->distance_spray_gun=$request->distance_spray_gun;
           
        $yield->save();

        $no=$request->no;
        $gross=$request->gross;
        $net=$request->net;
        $tare=$request->tare;
        $performed_by=$request->performed_by;


        for ($i=0; $i < count($gross) ; $i++) { 
             $dt=new container;
          $dt->containerable_id=$yield->id;
        $dt->containerable_type='App\Models\Coating';
         $dt->no=$no[$i];
         $dt->gross=$gross[$i];
         $dt->tare=$tare[$i];
         $dt->net=$net[$i];
         $dt->performed_by=$performed_by[$i];
        $dt->save();
        }
    return redirect(url('/edit/coating/'.$yield['id']))->with('success','Coating genrated!');
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
    public function edit(Coating $coating)
    {
         $plns=Productionplan::where('demand_id','<>','0')->doesntHave('coating')->orWhere('id',$coating['plan_id'])->get();

             $plans=[];
            foreach ($plns as $pn) {


              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'pack_size'=>$pn['product']['pack_size']];

              array_push($plans, $plan);
            }
        
        return view('production.coating.edit',compact('plans','coating'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compression  $compression
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $yield= Coating::find($request->id);
         $yield->plan_id=$request->plan_id;
         $yield->start_date=$request->start_date;
         $yield->comp_date=$request->comp_date;
         $yield->lead_time=$request->lead_time;
         $yield->temprature=$request->temprature;
         $yield->humidity=$request->humidity;
          $yield->mix_time=$request->mix_time;
         $yield->inlet_temperature=$request->inlet_temperature;
         $yield->bed_temperature=$request->bed_temperature;
         $yield->outlet_temperature=$request->outlet_temperature;
          $yield->machine_speed=$request->machine_speed;
          $yield->distance_spray_gun=$request->distance_spray_gun;
        $yield->save();

        $no=$request->no;
        $gross=$request->gross;
        $net=$request->net;
        $tare=$request->tare;
        $performed_by=$request->performed_by;


        $items=$yield->containers;
       $num=0;

        for ($i=0; $i < count($gross) ; $i++) { 

             if($num < count($items))
          $dt=$items[$num];
          else
             $dt=new container;
             
          $dt->containerable_id=$yield->id;
        $dt->containerable_type='App\Models\Coating';
         $dt->no=$no[$i];
         $dt->gross=$gross[$i];
         $dt->tare=$tare[$i];
         $dt->net=$net[$i];
         $dt->performed_by=$performed_by[$i];
        $dt->save();
        $num++;
        }

        for($i=$num; $i < count($items); $i++ )
           {
               $items[$i]->delete();
           }

    return redirect()->back()->with('success','Coating updated!');
    }


    public function print(Coating $coating)
    {
          $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $data = [
            
            'plan'=>$coating['plan'],
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.challan_pdf',compact('data'));
           view()->share('production.coating.report',$data);
        $pdf = PDF::loadView('production.coating.report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($coating['id'].'.pdf');
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
