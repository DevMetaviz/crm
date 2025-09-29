<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Date_Leave;
use App\Models\Configuration;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Leaveadjustment;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaves=Leave::orderBy('created_at')->get();
    
        return view('leave.index',compact('leaves'));
    }

    public function test()
    {
        $emp=Employee::find(1);
          print_r( $emp->month_late_comings('2021-02') );die;
          print_r($emp->monthly_attendance_status_count('2021-02'));die;
          $let=$emp->monthly_profile('2020-12');
    
        return view('leave.test',compact('let'));
    }

    public function configure_leave()
    {

        $leaves=LeaveType::orderBy('sort_order','asc')->get();
        return view('leave.create',compact('leaves'));
    }

    public function mark_leave()
    {
        $employees=Employee::orderBy('created_at')->get();
         
         $leaves=Configuration::leave_types();
        return view('leave.mark_leave',compact('employees','leaves'));
    }

    public function leave_adjustment()
    {
        $employees=Employee::where('activeness','like','active')->orderBy('created_at')->get();
         
          $leaves=LeaveType::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        return view('leave.leave_adjustment',compact('employees','leaves'));
    }

    public function save_leave_adjustment(Request $request)
    {
        $adjust=new Leaveadjustment;
         
         $adjust->adjustment_num=$request->get('adjustment_no');
        $adjust->employee_id=$request->get('employee_id');
        $adjust->leave_type_id=$request->get('leave_type');
        $adjust->adjust_days=$request->get('adjust_days');
        $adjust->adjustment_date=$request->get('adjustment_date');
        $adjust->adjustment_month=$request->get('adjustment_month');
        $adjust->comment=$request->get('comment');
         
        

        $adjust->save();

        return redirect()->back()->with('success','Leave Adjustment Added!');
    }

    public function save_mark_leave(Request $request)
    { 
        $leave=new Leave;

        $leave->application_no=$request->get('application_no');
        $leave->employee_id=$request->get('employee_id');
        $leave->leave_type_id=$request->get('leave_type');
        $leave->application_date=$request->get('application_date');
       
            //$leave->type=$request->get('type');
        $leave->reason=$request->get('reason');
          $leave->status='pending';
        

        $leave->save();
            
             
             $from_date=$request->get('from_date');
             $to_date=$request->get('to_date');

             $dates = array($from_date );  $i=1;
             while($to_date!=null)
             {
                $date=date('Y-m-d', strtotime($from_date. ' + '.$i.' days'));
                $i++;
                array_push($dates, $date);
                if($date==$to_date)
                {
                    break;
                }

             }
               
    
                 foreach($dates as $date)
                 { 
                     $dates=new Date_Leave;
                     $dates->leave_id=$leave->id;
                     $dates->leave_date=$date;
                     $dates->save();
                 }
            


    
         return redirect()->back()->with('success','Leave Added!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $active='inactive';
          
        $leave=new LeaveType;
        $leave->text=$request->get('leave_text');
         $leave->type=$request->get('type');
          $leave->unit=$request->get('unit');
          $leave->deduction_amount=$request->get('deduction_amount');
       $leave->activeness=$active;
       $leave->sort_order=$request->get('sort_order');
        $leave->save();

     return redirect()->back()->with('success','Leave Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave $leave)
    {
        $employees=Employee::orderBy('created_at')->get();
         
         $leaves=Configuration::leave_types();

        return view('leave.edit',compact('leave','employees','leaves'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leave $leave)
    {

        $leave->application_no=$request->get('application_no');
        $leave->employee_id=$request->get('employee_id');
        $leave->leave_type_id=$request->get('leave_type');
        $leave->application_date=$request->get('application_date');
        $leave->from_date=$request->get('from_date');
        $leave->to_date=$request->get('to_date');
        $leave->type=$request->get('type');
        $leave->reason=$request->get('reason');
        $leave->paid_days=$request->get('paid_days');
        $leave->status=$request->get('status');
        

        $leave->save();

    
         return redirect()->back()->with('success','Leave Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leave $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
