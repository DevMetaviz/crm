<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Employee;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invests=Investment::orderBy('doc_no','desc')->get();
        return view('point.investment_list',compact('invests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $doc_no="PI-".Date("y")."-";
        $num=1;

         $in=Investment::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->latest()->first();
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

        $doctors=Doctor::where('activeness','1')->get();
        
        $employees=Employee::sales_man();
        return view('point.investment_create',compact('doc_no','doctors','employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $active=$request->active;
        if($active=='')
            $active=0;

        $invested=$request->invested;
        if($invested=='')
            $invested=0;


        $invest=new Investment;

        $invest->doc_no=$request->doc_no;
        $invest->investment_date=$request->investment_date;
        

        $invest->invested_through=$request->invested_through;
        $invest->remarks=$request->remarks;
         $invest->doctor_id=$request->doctor_id;
        $invest->type=$request->type;
        $invest->amount=$request->amount;
        $invest->comment=$request->comment;

        $invest->is_invested=$invested;
        $invest->activeness=$active;
        
        $invest->save();

        return redirect()->back()->with('success','Investment genrated!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function show(Investment $investment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function edit(Investment $investment)
    {
         $doctors=Doctor::where('activeness','1')->orWhere('id',$investment['doctor_id'])->get();

        $employees=Employee::sales_man();
        return view('point.investment_edit',compact('investment','doctors','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $active=$request->active;
        if($active=='')
            $active=0;

        $invested=$request->invested;
        if($invested=='')
            $invested=0;


        $invest=Investment::find($request->id);

        $invest->doc_no=$request->doc_no;
        $invest->investment_date=$request->investment_date;
        

        $invest->invested_through=$request->invested_through;
        $invest->remarks=$request->remarks;
         $invest->doctor_id=$request->doctor_id;
        $invest->type=$request->type;
        $invest->amount=$request->amount;
        $invest->comment=$request->comment;

        $invest->is_invested=$invested;
        $invest->activeness=$active;
        
        $invest->save();

        return redirect()->back()->with('success','Investment updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Investment  $investment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investment $investment)
    {
        //
    }
}
