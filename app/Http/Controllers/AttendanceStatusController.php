<?php

namespace App\Http\Controllers;

use App\Models\AttendanceStatus;
use Illuminate\Http\Request;
use App\Models\LeaveType;

class AttendanceStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses=AttendanceStatus::orderBy('sort_order','asc')->get();
        $leave_types=LeaveType::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        return view('attendance.attendance-status',compact('statuses','leave_types'));
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
        $status=new AttendanceStatus;
        $status->text=$request->get('text');
        $status->code=$request->get('code');
         $status->leave_type_id=$request->get('leave_type');
          $status->activeness=$active;
          $status->sort_order=$request->get('sort_order');
       
        $status->save();

     return redirect()->back()->with('success','Status Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttendanceStatus  $attendanceStatus
     * @return \Illuminate\Http\Response
     */
    public function show(AttendanceStatus $attendanceStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttendanceStatus  $attendanceStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(AttendanceStatus $attendanceStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttendanceStatus  $attendanceStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttendanceStatus $attendanceStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttendanceStatus  $attendanceStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttendanceStatus $attendanceStatus)
    {
        //
    }
}
