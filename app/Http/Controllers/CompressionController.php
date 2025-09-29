<?php

namespace App\Http\Controllers;

use App\Models\Compression;
use App\Models\compression_variation;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\Productionplan;
use App\Models\container;
use App\Models\Parameter;
use App\Models\compression_control_sheet;
use App\Models\compression_analysis;
use PDF;

class CompressionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $granules=Compression::orderBy('created_at','desc')->get();

        return view('production.compression.index',compact('granules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $plns=Productionplan::where('demand_id','<>','0')->doesntHave('compression')->get();

             $plans=[];
            foreach ($plns as $pn) {

            $parameters=Parameter::where('item_id',$pn['product_id'])->where('process_id',42)->get();

              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'pack_size'=>$pn['product']['pack_size'],'parameters'=>$parameters ];

              array_push($plans, $plan);
            }
        //$parameters=Parameter::where('item_id',)->where('process_id',42)->get();
        return view('production.compression.create',compact('plans'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $yield=new Compression;
         $yield->plan_id=$request->plan_id;
         $yield->start_date=$request->start_date;
         $yield->comp_date=$request->comp_date;
         $yield->lead_time=$request->lead_time;
         $yield->temprature=$request->temprature;
         $yield->humidity=$request->humidity;
         $yield->granules_weight=$request->granules_weight;
         $yield->punch_size=$request->punch_size;
         $yield->initial_weight=$request->initial_weight;
         $yield->final_weight=$request->final_weight;
          $yield->recommended_weight=$request->recommended_weight;
          $yield->hardness_remarks=$request->hardness_remarks;
           $yield->thickness_remarks=$request->thickness_remarks;

           $yield->weight_date=$request->weight_date;
          $yield->weight_start_time=$request->weight_start_time;
          $yield->weight_end_time=$request->weight_end_time;
           $yield->weight_tab_size=$request->weight_tab_size;
           $yield->weight_limit=$request->weight_limit;

        $yield->save();

        $parameters=$request->parameters;
        $observations=$request->observations;
        $specifications=$request->specifications;

        for ($i=0; $i < count($parameters) ; $i++) { 
    
             $dt=new compression_analysis;
          $dt->compression_id=$yield->id;
        $dt->parameter=$parameters[$i];
         $dt->observations=$observations[$i]; 
         $dt->specifications=$specifications[$i]; 
        $dt->save();
         
        
        }

        $ws=$request->weight_of_tablets;
        $hds=$request->hardness_of_tablets;
        $ts=$request->thickness_of_tablets;

        for ($i=0; $i < 4 ; $i++) { 
                 $k=$i;
            while ( $k < 20  ) { 
             $dt=new compression_variation;
          $dt->compression_id=$yield->id;
        $dt->type='weight';
         $dt->value=$ws[$k]; 
        $dt->save();
        $k=$k+4; 
        }
        }

        for ($i=0; $i < 2 ; $i++) { 
                 $k=$i;
            while ( $k < 10  ) { 
             $dt=new compression_variation;
          $dt->compression_id=$yield->id;
        $dt->type='hardness';
         $dt->value=$hds[$k]; 
        $dt->save();
        $k=$k+2; 
        }
        }

        for ($i=0; $i < 2 ; $i++) { 
                 $k=$i;
            while ( $k < 10  ) { 
             $dt=new compression_variation;
          $dt->compression_id=$yield->id;
        $dt->type='thickness';
         $dt->value=$ts[$k]; 
        $dt->save();
        $k=$k+2; 
        }
        }


        $control_dates=$request->control_dates;
        $control_times=$request->control_times;
        $specifications=$request->specifications;

        for ($i=0; $i < count($control_dates) ; $i++) { 
    
             $dt=new compression_control_sheet;
          $dt->compression_id=$yield->id;
        $dt->date=$control_dates[$i];
         $dt->time=$control_times[$i]; 

        for ($k=1; $k <= 10 ; $k++) { 
            $n='control_'.$k.'_weights';
        
            $v=$request->$n;
            $n1='num'.$k;
         $dt->$n1=$v[$i]; 
           }

        $dt->save();
         
        
        }




         $no=$request->no;
        $gross=$request->gross;
        $net=$request->net;
        $tare=$request->tare;
        $performed_by=$request->performed_by;


        for ($i=0; $i < count($gross) ; $i++) { 
             $dt=new container;
          $dt->containerable_id=$yield->id;
        $dt->containerable_type='App\Models\Compression';
         $dt->no=$no[$i];
         $dt->gross=$gross[$i];
         $dt->tare=$tare[$i];
         $dt->net=$net[$i];
         $dt->performed_by=$performed_by[$i];
        $dt->save();
        }
    return redirect(url('/edit/compression/'.$yield['id']))->with('success','Compression genrated!');
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
    public function edit(Compression $compression)
    {
        $plns=Productionplan::where('demand_id','<>','0')->doesntHave('compression')->orWhere('id',$compression['plan_id'])->get();

             $plans=[];
            foreach ($plns as $pn) {


              $plan=['id'=>$pn['id'],'plan_no'=>$pn['plan_no'],'product_id'=>$pn['product_id'],'product_name'=>$pn['product']['item_name'],'batch_size'=>$pn['batch_size'],'batch_qty'=>$pn['batch_qty'],'batch_no'=>$pn['batch_no'],'mfg_date'=>$pn['mfg_date'],'exp_date'=>$pn['exp_date'],'pack_size'=>$pn['product']['pack_size']];

              array_push($plans, $plan);
            }
        
        return view('production.compression.edit',compact('plans','compression'));
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
        $yield= Compression::find($request->id);
         $yield->plan_id=$request->plan_id;
         $yield->start_date=$request->start_date;
         $yield->comp_date=$request->comp_date;
         $yield->lead_time=$request->lead_time;
         $yield->temprature=$request->temprature;
         $yield->humidity=$request->humidity;
         $yield->granules_weight=$request->granules_weight;
         $yield->punch_size=$request->punch_size;
         $yield->initial_weight=$request->initial_weight;
         $yield->final_weight=$request->final_weight;
          $yield->recommended_weight=$request->recommended_weight;
          $yield->hardness_remarks=$request->hardness_remarks;
           $yield->thickness_remarks=$request->thickness_remarks;

           $yield->weight_date=$request->weight_date;
          $yield->weight_start_time=$request->weight_start_time;
          $yield->weight_end_time=$request->weight_end_time;
           $yield->weight_tab_size=$request->weight_tab_size;
           $yield->weight_limit=$request->weight_limit;
        $yield->save();

        $parameters=$request->parameters;
        $observations=$request->observations;
        $specifications=$request->specifications;
          
          $prs=$yield->start_up_analysis;
           $num=0;
        for ($i=0; $i < count($parameters) ; $i++) { 
              
              if($num < count($prs))
          $dt=$prs[$num];
          else
             $dt=new compression_analysis;
          $dt->compression_id=$yield->id;
        $dt->parameter=$parameters[$i];
         $dt->observations=$observations[$i]; 
         $dt->specifications=$specifications[$i]; 
        $dt->save();
          $num++;
        }

        for($i=$num; $i < count($prs); $i++ )
           {
               $prs[$i]->delete();
           }


        $ws=$request->weight_of_tablets;
        $hds=$request->hardness_of_tablets;
        $ts=$request->thickness_of_tablets;
        
        $vari=$yield->variations;
        $new=0;

        for ($i=0; $i < 4 ; $i++) { 
                 $k=$i;
            while ( $k < 20  ) { 
             $dt=$vari[$new];
          $dt->compression_id=$yield->id;
        $dt->type='weight';
         $dt->value=$ws[$k]; 
        $dt->save();
        $k=$k+4; $new++;
        }
        }

        for ($i=0; $i < 2 ; $i++) { 
                 $k=$i;
            while ( $k < 10  ) { 
             $dt=$vari[$new];
          $dt->compression_id=$yield->id;
        $dt->type='hardness';
         $dt->value=$hds[$k]; 
        $dt->save();
        $k=$k+2; $new++;
        }
        }

        for ($i=0; $i < 2 ; $i++) { 
                 $k=$i;
            while ( $k < 10  ) { 
             $dt=$vari[$new];
          $dt->compression_id=$yield->id;
        $dt->type='thickness';
         $dt->value=$ts[$k]; 
        $dt->save();
        $k=$k+2;  $new++;
        }
        }

          

          $control_dates=$request->control_dates;
        $control_times=$request->control_times;
        $specifications=$request->specifications;
         
         $sh=$yield->control_sheet;
         $num=0;
        for ($i=0; $i < count($control_dates) ; $i++) { 
             
             if($num < count($sh))
          $dt=$sh[$num];
          else
             $dt=new compression_control_sheet;
          $dt->compression_id=$yield->id;
        $dt->date=$control_dates[$i];
         $dt->time=$control_times[$i]; 

        for ($k=1; $k <= 10 ; $k++) { 
            $n='control_'.$k.'_weights';
        
            $v=$request->$n;
            $n1='num'.$k;
         $dt->$n1=$v[$i]; 
           }

        $dt->save();
         
         $num++;
        
        }
        for($i=$num; $i < count($sh); $i++ )
           {
               $sh[$i]->delete();
           }


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
        $dt->containerable_type='App\Models\Compression';
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

    return redirect()->back()->with('success','Compression updated!');
    }

    public function print(Compression $compression)
    {
          $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $data = [
            
            'plan'=>$compression['plan'],
            'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,
        ];
        //return view('sale.challan_pdf',compact('data'));
           view()->share('production.compression.report',$data);
        $pdf = PDF::loadView('production.compression.report', $data);
        $pdf->setPaper('A4','portrait');
        return $pdf->stream($compression['id'].'.pdf');
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
