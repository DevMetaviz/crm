<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;
use App\Models\Point;
use App\Models\inventory;
use App\Models\Doctor;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $targets=Target::orderBy('doc_no')->get();
        return view('point.target.list',compact('targets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doc_no="PT-".Date("y")."-";
        $num=1;

         $in=Target::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->latest()->first();
         if($in=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $in['doc_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

        $doctors=Doctor::where('activeness','1')->orderBy('name')->get();
        
        $items=inventory::where('department_id','1')->where('activeness','active')->orderBy('item_name')->get();
        
    
        return view('point.target.create',compact('doc_no','doctors','items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $items_id=$request->items_id;
        $qtys=$request->qtys;
        $rates=$request->rates;


        $active=$request->active;
        if($active=='')
            $active=0;

         $closed=$request->closed;
        if($closed=='')
            $closed=0;

        $sale=new Target;

        $sale->doc_no=$request->doc_no;
        $sale->doc_date=$request->doc_date;
          $sale->start_date=$request->start_date;        
        $sale->end_date=$request->end_date;
       
        $sale->doctor_id=$request->doctor_id;
        $sale->investment_amount=$request->investment_amount;
         $sale->target_value=$request->target_value;
        
        $sale->remarks=$request->remarks;
                
    
        $sale->activeness=$active;
        $sale->closed=$closed;
        
        $sale->save();
        
        if($items_id)
            {
        for($i=0;$i<count($items_id);$i++)
            {
         $sale->items()->attach($items_id[$i] , [ 'qty' => $qtys[$i] ,'rate'=>$rates[$i]  ]);
           }
          }

        return redirect()->back()->with('success','Target genrated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function show(Target $target)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function edit(Target $target)
    {
        $doctors=Doctor::where('activeness','1')->orderBy('name')->get();
        
        $items=inventory::where('department_id','1')->where('activeness','active')->orderBy('item_name')->get();
        
    
        return view('point.target.edit',compact('target','doctors','items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $items_id=$request->items_id;
        $qtys=$request->qtys;
        $rates=$request->rates;


        $active=$request->active;
        if($active=='')
            $active=0;

         $closed=$request->closed;
        if($closed=='')
            $closed=0;

        $sale=Target::find($request->id);

        $sale->doc_no=$request->doc_no;
        $sale->doc_date=$request->doc_date;
          $sale->start_date=$request->start_date;        
        $sale->end_date=$request->end_date;
       
        $sale->doctor_id=$request->doctor_id;
        $sale->investment_amount=$request->investment_amount;
        $sale->target_value=$request->target_value;
        
        $sale->remarks=$request->remarks;
                
    
        $sale->activeness=$active;
        $sale->closed=$closed;
        
        $sale->save();
           

            $rel=array();

            if($items_id)
            {
                for($i=0; $i<count($items_id);$i++)
            {  
                $pivot=array( 'qty' => $qtys[$i] ,'rate'=>$rates[$i] );

                $let=array( $items_id[$i].'' =>$pivot );

                $rel=$rel+$let;
           }
           }

           $sale->items()->sync($rel);

        return redirect()->back()->with('success','Target updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function destroy(Target $target)
    {
        //
    }
}
