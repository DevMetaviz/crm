<?php

namespace App\Http\Controllers;

use App\Models\Overtime;

use App\Models\Employee;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $overtimes=Overtime::orderBy('created_at')->get();
        return view('overtime.list',compact('overtimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$doc_no="OT-".Date("y")."-";
        $num=1;

       $over=Overtime::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->latest()->first();
         
         if($over=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $over['doc_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

        $employees=Employee::where('activeness','like','active')->orderBy('created_at')->get();
        return view('overtime.create',compact('employees','doc_no'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$active=$request->get('activeness');
    	if($active=='')
    		$active=0;

        $overtime=new Overtime;

        $overtime->doc_no=$request->get('doc_no');
        $overtime->overtime_date=$request->get('overtime_date');
        $overtime->employee_id=$request->get('employee_id');
        $overtime->start_time=$request->get('start_time');
        $overtime->end_time=$request->get('end_time');
        $overtime->total_time=$request->get('total_time');
        $overtime->remarks=$request->get('remarks');
        $overtime->activeness=$active;
       

        $overtime->save();

     return redirect(url('overtime/edit/'.$overtime->id))->with('success','Overtime Added!');
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function show(Overtime $overtime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function edit(Overtime $overtime)
    {
        $employees=Employee::where('activeness','like','active')->orderBy('created_at')->get();
          //print_r(json_encode($overtime));die;
        return view('overtime.edit',compact('employees','overtime'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Overtime $overtime)
    {
        $active=$request->get('activeness');
        if($active=='')
            $active=0;

        $overtime=Overtime::find($request->overtime_id);

        $overtime->doc_no=$request->get('doc_no');
        $overtime->overtime_date=$request->get('overtime_date');
        $overtime->employee_id=$request->get('employee_id');
        $overtime->start_time=$request->get('start_time');
        $overtime->end_time=$request->get('end_time');
        $overtime->total_time=$request->get('total_time');
        $overtime->remarks=$request->get('remarks');
        $overtime->activeness=$active;
       

        $overtime->save();

     return redirect()->back()->with('success','Overtime Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allowance  $overtime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Overtime $overtime)
    {
        //
    }
}

