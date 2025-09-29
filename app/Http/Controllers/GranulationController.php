<?php

namespace App\Http\Controllers;

use App\Models\Goods_Yield;
use Illuminate\Http\Request;
use App\Models\Productionplan;
use App\Models\yield_detail;
use App\Models\Granulation;
use App\Models\container;
use App\Models\Configuration;
use PDF;

class GranulationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $granules=Granulation::orderBy('created_at','desc')->get();

        return view('production.granulation.index',compact('granules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plns=Productionplan::doesntHave('granulation')->get();

             $plans=[];
            foreach ($plns as $pn) {

               

              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'pack_size'=>$pn['product']['pack_size']];

              array_push($plans, $plan);
            }
        
        return view('production.granulation.create',compact('plans'));

    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $yield=new Granulation;
         $yield->plan_id=$request->plan_id;
         $yield->grn_start=$request->grn_start;
         $yield->grn_comp=$request->grn_comp;
         $yield->lead_time=$request->lead_time;
         $yield->temprature=$request->temprature;
         $yield->humidity=$request->humidity;
         $yield->sev_start=$request->sev_start;
         $yield->sev_complete=$request->sev_complete;
         $yield->sev_num=$request->sev_num;
         $yield->dry_time=$request->dry_time;
         $yield->dry_temp=$request->dry_temp;
          $yield->mixing_start_time=$request->mixing_start_time;
          $yield->mixing_complete_time=$request->mixing_complete_time;
        $yield->save();

         $no=$request->no;
        $gross=$request->gross;
        $net=$request->net;
        $tare=$request->tare;
        $performed_by=$request->performed_by;


        for ($i=0; $i < count($gross) ; $i++) { 
             $dt=new container;
         $dt->containerable_id=$yield->id;
        $dt->containerable_type='App\Models\Granulation';
         $dt->no=$no[$i];
         $dt->gross=$gross[$i];
         $dt->tare=$tare[$i];
         $dt->net=$net[$i];
         $dt->performed_by=$performed_by[$i];
        $dt->save();
        }

         return redirect(url('/edit/granulation/'.$yield['id']))->with('success','Granulation genrated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Goods_Yield  $goods_Yield
     * @return \Illuminate\Http\Response
     */
    public function show(Goods_Yield $goods_Yield)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Goods_Yield  $goods_Yield
     * @return \Illuminate\Http\Response
     */
    public function edit(Granulation $granulation)
    {
        $plns=Productionplan::doesntHave('granulation')->orWhere('id',$granulation['plan_id'])->get();

             $plans=[];
            foreach ($plns as $pn) {

              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'pack_size'=>$pn['product']['pack_size']];

              array_push($plans, $plan);
            }
        
        return view('production.granulation.edit',compact('plans','granulation'));
    }

    public function print(Granulation $granulation)
    {
          $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $data = [
            
            'plan'=>$granulation['plan'],
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.challan_pdf',compact('data'));
           view()->share('production.granulation.report',$data);
        $pdf = PDF::loadView('production.granulation.report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($granulation['id'].'.pdf');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Goods_Yield  $goods_Yield
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $yield=Granulation::find($request->id);
         $yield->plan_id=$request->plan_id;
         $yield->grn_start=$request->grn_start;
         $yield->grn_comp=$request->grn_comp;
         $yield->lead_time=$request->lead_time;
         $yield->temprature=$request->temprature;
         $yield->humidity=$request->humidity;
         $yield->sev_start=$request->sev_start;
         $yield->sev_complete=$request->sev_complete;
         $yield->sev_num=$request->sev_num;
         $yield->dry_time=$request->dry_time;
         $yield->dry_temp=$request->dry_temp;
          $yield->mixing_start_time=$request->mixing_start_time;
          $yield->mixing_complete_time=$request->mixing_complete_time;
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
        $dt->containerable_type='App\Models\Granulation';
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

         return redirect()->back()->with('success','Granulation Updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Goods_Yield  $goods_Yield
     * @return \Illuminate\Http\Response
     */
    public function destroy(Goods_Yield $goods_Yield)
    {
        //
    }
}
