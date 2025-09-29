<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\DailyAttendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\AttendancesExport;
use App\Imports\AttendancesImport;
use App\Models\AttendanceStatus;

class attendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
    {
        //$attendances=Attendance::with('employee')->orderBy('date','desc')->orderBy('time','desc')->get();
        //print_r('expression');die;
        $attendances=Attendance::with('DailyAttendance','DailyAttendance.employee')->orderBy('date','desc')->orderBy('time','desc')->get();
       // print_r($attendances[0]);die;
        return view('employee.attendance',compact('attendances'));
    }

    public function monthly_attendance()
    {
        $employees=Employee::active_employees();
        
       
        return view('employee.monthly_attendance',compact('employees'));
    }

    public function save_employee_monthly_attendance(Request $request)
    {
          $employee=Employee::find($request->employee_id);
       $dates=$request->dates;
        //$zk_id=$employee['zk_id'];
        $statuses=$request->statuses;
        $in_times=$request->in_times;
        $out_times=$request->out_times;
           //print_r($statuses);die;
           for ($i=0; $i < count($dates) ; $i++) { 

            //if($zk_id=='')
               // continue ;
            
          $att=DailyAttendance::where('employee_id','like',$employee['id'])->where('date','like',$dates[$i])->first();
              //print_r($att);die;
              if($att==null)
              {
                 $att=new DailyAttendance;
              }
              
              $att->employee_id=$employee['id'];
             // $att->name=$zk_id;
              //$att->no=$zk_id;
              $att->date=$dates[$i];
              $att->status=$statuses[$i];
              $att->save();

              $att_in=Attendance::where('dailyattendance_id','like',$att->id)->where('status','like','C/In')->first();
              $att_out=Attendance::where('dailyattendance_id','like',$att->id)->where('status','like','C/Out')->first();
              if($att_in==null)
              {
                 $att_in=new Attendance;
                 
              }
              else
              {
                if($in_times[$i] == null)
                 {
                   $att_in->delete();
                 }
              }
              if($att_out==null)
              {
                 $att_out=new Attendance;
              }
              else
              {
                if($out_times[$i] == null)
                 {
                   $att_out->delete();
                 }
              }
              
              if($in_times[$i] != null)
              {
              $att_in->dailyattendance_id=$att->id;
              $att_in->time=$in_times[$i];
              $att_in->status='C/In';
              $att_in->save();
              }
              if($out_times[$i] != null)
              {
              $att_out->dailyattendance_id=$att->id;
              $att_out->time=$out_times[$i];
              $att_out->status='C/Out';
              $att_out->save();
                }


           }
     return redirect()->back()->with('success','Attendance updated!');

    }//end save employee_monthly_attendance

    public function employee_monthly_attendance(Request $request)
    {
        $employees=Employee::active_employees();
        
       $attendance_month=$request->attendance_month;
       $emp=$request->employee_id;

        if($attendance_month=='')
        {
            return view('employee.monthly_attendance',compact('employees'));
        }
            $statuses=AttendanceStatus::where('activeness','like','active')->orderBy('sort_order','asc')->get();

        $config=array('attendance_month'=>$attendance_month,'statuses'=>$statuses,'employee_id'=>$emp);
        
        $employee=Employee::find($emp);

        $month_year=explode("-",$attendance_month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
    
        $f_month=$attendance_month.'-01';   //first date of month
        $l_month=$attendance_month.'-'.$days;   //last date of month
        $attendances=array();
        $total_working_hours=0;
        for ($i=0; $i < $days ; $i++) { 
            $date=date('Y-m-d',strtotime($f_month . "+".$i." days"));
            $day=date('l',mktime(0,0,0,$month_year[1],$i+1,$month_year[0]));
             $in_time=''; $out_time=''; $status='';
            $att=DailyAttendance::where('employee_id','like',$employee['id'])->where('date','like',$date)->first();
            $diff1='00:00:00'; $diff2=0;
            if($att!='')
            {
            $in=Attendance::where('dailyattendance_id','like',$att['id'])->where('status','like','C/In')->first();
            $out=Attendance::where('dailyattendance_id','like',$att['id'])->where('status','like','C/Out')->first();
            if($in!='')
                {$in_time=$in['time'];}
            if($out!='')
                {$out_time=$out['time'];}
            $status=$att['status'];
           
           
           if( $in!='' && $out!='' )
           {
             $time=strtotime($in_time);
             $time1=strtotime($out_time);
           
             $diff1=date("H:i:s",($time1-$time) );
             $diff2= round( ( (($time1-$time)/60)/60 )-1 ,2 ); //convert in hours
            }
            $total_working_hours+=$diff2;
        }
            $att1=array('date'=>$date , 'day'=>$day , 'status'=>$status , 'in_time'=>$in_time , 'out_time'=>$out_time , 'working_hours'=>$diff1 );  //print_r($time);die;
            array_push($attendances, $att1); 
            
        }  
        
        //die;
        //$attendances=$employee->daily_attendances->whereBetween('date',[$f_month,$l_month]);
        return view('employee.monthly_attendance',compact('attendances','employees','config','total_working_hours'));

        
    }

    public function employee_monthly_attendance_report(Request $request)
    {
        $employees=Employee::active_employees();
        
       $attendance_month=$request->attendance_month;
       


        if($attendance_month=='')
        {
            return view('employee.report_monthly_attendance',compact('employees'));
        }
            $statuses=AttendanceStatus::where('activeness','like','active')->orderBy('sort_order','asc')->get();

            $emp=$request->employee_id;
       $emp_name=Employee::find($emp)->name;

        $config=array('attendance_month'=>$attendance_month,'statuses'=>$statuses,'employee_id'=>$emp,'employee_name'=>$emp_name);
        
        $employee=Employee::find($emp);

        $month_year=explode("-",$attendance_month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
    
        $f_month=$attendance_month.'-01';   //first date of month
        $l_month=$attendance_month.'-'.$days;   //last date of month
        $attendances=array();
        $total_working_hours=0;
        for ($i=0; $i < $days ; $i++) { 
            $date=date('Y-m-d',strtotime($f_month . "+".$i." days"));
            $day=date('l',mktime(0,0,0,$month_year[1],$i+1,$month_year[0]));
             $in_time=''; $out_time=''; $status='';
            $att=DailyAttendance::where('employee_id','like',$employee['id'])->where('date','like',$date)->first();
            $diff1='00:00:00'; $diff2=0;
            if($att!='')
            {
            $in=Attendance::where('dailyattendance_id','like',$att['id'])->where('status','like','C/In')->first();
            $out=Attendance::where('dailyattendance_id','like',$att['id'])->where('status','like','C/Out')->first();
            if($in!='')
                {$in_time=$in['time'];}
            if($out!='')
                {$out_time=$out['time'];}
            //$status= $att['status'];
              
                $status='------';
                //print_r($att['status']);die;
            if($att['status']!='none')
             $status=AttendanceStatus::find($att['status'])->text;
           
           if( $in!='' && $out!='' )
           {
             $time=strtotime($in_time);
             $time1=strtotime($out_time);
           
             $diff1=date("H:i:s",($time1-$time) );
              $diff2= round( ( (($time1-$time)/60)/60 ) ,2 ); //convert in hours
             //$diff2= round( ( (($time1-$time)/60)/60 )-1 ,2 ); //convert in hours
            }
            $total_working_hours+=$diff2;
        }
            $att1=array('date'=>$date , 'day'=>$day , 'status'=>$status , 'in_time'=>$in_time , 'out_time'=>$out_time , 'working_hours'=>$diff2 );  //print_r($time);die;
            array_push($attendances, $att1); 
            
        }  
        
        //die;
        //$attendances=$employee->daily_attendances->whereBetween('date',[$f_month,$l_month]);
        return view('employee.report_monthly_attendance',compact('attendances','employees','config','total_working_hours'));

        
    }

    public function employees_attendance(Request $request)
    {
        $attendance_date=$request->attendance_date;
        if($attendance_date=='')
        {
            return view('attendance.employees_attendance');
        }
         $statuses=AttendanceStatus::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        $config=array('attendance_date'=>$attendance_date,'statuses'=>$statuses);
        $emps=Employee::active_employees();
        $employees=array();
         foreach ($emps as $emp) {
             $att=$emp->daily_attendances->where('date','like',$attendance_date)->first();
             $in_time=''; $out_time=''; $status='';
             if($att!='')
             {
             $in=$att['attendances']->where('status','like','C/In')->first();
             $out=$att['attendances']->where('status','like','C/Out')->first();
              
              $att_p_status=AttendanceStatus::where('text','like','present')->first();
             if($in!='' )
                $in_time=$in['time']; //$status=$att_p_status['id'];
            if($out!='')
                $out_time=$out['time']; //$status='present';
        
            if($att['status']!='')
            {
                $status=$att['status'];
            }
            


            }
             $emp=array('employee_id'=>$emp['id'],'employee_name'=>$emp['name'],'status'=>$status,'in_time'=>$in_time,'out_time'=>$out_time);
             // print_r($out);die;
             array_push($employees, $emp);
         }

        //$attendances=Attendance::with('employee')->orderBy('date','desc')->orderBy('time','desc')->paginate(100);
       
        return view('attendance.employees_attendance',compact('employees','config'));
    }

    public function save_daily_attendances(Request $request)
    {
        $date=$request->attendance_date;
        //$zk_ids=$request->zk_ids;
        $emp_ids=$request->emp_ids;
        $statuses=$request->statuses;
        $in_times=$request->in_times;
        $out_times=$request->out_times;
           //print_r($statuses);die;
           for ($i=0; $i < count($emp_ids) ; $i++) { 

            // if($zk_ids[$i]=='')
            //     continue ;
            
            $att=DailyAttendance::where('employee_id','like',$emp_ids[$i])->where('date','like',$date)->first();
              
              if($att==null)
              {
                 $att=new DailyAttendance;
              }
              
              $att->employee_id=$emp_ids[$i];
              //$att->name=$zk_ids[$i];
              //$att->no=$zk_ids[$i];
              $att->date=$date;
              $att->status=$statuses[$i];
              $att->save();

              $att_in=Attendance::where('dailyattendance_id','like',$att->id)->where('status','like','C/In')->first();
              $att_out=Attendance::where('dailyattendance_id','like',$att->id)->where('status','like','C/Out')->first();
              if($att_in==null)
              {
                 $att_in=new Attendance;
              }
              else
              {
                if($in_times[$i] == null)
                 {
                   $att_in->delete();
                 }
              }
              if($att_out==null)
              {
                 $att_out=new Attendance;
              }
              else
              {
                if($out_times[$i] == null)
                 {
                   $att_out->delete();
                 }
              }
              
              if($in_times[$i] != null)
              {
              $att_in->dailyattendance_id=$att->id;
              $att_in->time=$in_times[$i];
              $att_in->status='C/In';
              $att_in->save();
              }
              if($out_times[$i] != null)
              {
              $att_out->dailyattendance_id=$att->id;
              $att_out->time=$out_times[$i];
              $att_out->status='C/Out';
              $att_out->save();
                }


           }
     return redirect()->back()->with('success','Attendance updated!');
    }
    public function search_attendance(Request $request)
    {
        $to_date=$request->to_date;
        $from_date=$request->from_date;

        $attendances=Attendance::with('employee')->whereBetween('date', array($request->from_date, $request->to_date))->orderBy('date','desc')->orderBy('time','desc')->get();

        //$employees=Employee::with('attendances')->whereHas('attendances', function($query) use ($to_date,$from_date) {
        //$query->whereBetween('date',array($from_date,$to_date));
    //})->get();



       
      
        return view('employee.employees_attendance',compact('attendances','to_date','from_date'));
    }


    public function attendance_register(Request $request)
    { 
        $attendance_date=$request->attendance_date;
        $attendance_month=$request->attendance_month;

        if($attendance_date!=null )
        {
           

            $emps=Employee::orderBy('created_at','asc')->get();

            $employees=array();

            $attendance_errors=0;
            $attendance_in_errors=0;
            $attendance_out_errors=0;

            foreach ($emps as $emp) {

                $in=Attendance::where('employee_id','like',''.$emp['id'])->where('date','like',$attendance_date)->where('status','like','C/In')->get();

                $out=Attendance::where('employee_id','like',''.$emp['id'])->where('date','like',$attendance_date)->where('status','like','C/Out')->get();

                $in_time=array(); $out_time=array();
                
        
                if(count($in)>1)
                {
                    
                    //$in_time=$in[0]['time'];
                    $attendance_errors++;
                 
                }

                foreach($in as $i)
                { 
                            array_push($in_time, $i['time']);
                }
               

                if(count($out)>1)
                {
                    //$out_time=$out[0]['time'];
                    $attendance_errors++;
                }

                if(count($in)>0 && count($out)==0)
                {
                    $attendance_out_errors++;
                }
                elseif(count($out)>0 && count($in)==0)
                {
                    $attendance_in_errors++;
                }

                foreach($out as $i)
                { 
                            array_push($out_time, $i['time']);
                }

                if(count($in_time)==0 && count($out_time)==0)
                {
                    $status='A';
                }
                else
                {
                    $status='P';
                }


                $employee=array('id'=>$emp['id'],'name'=>$emp['name'],'in'=>$in_time,'out'=>$out_time,'status'=>$status);


                 //print_r($employee);//die;
                array_push($employees,$employee);
                
            }

                return view('attendance.dateRegister',compact('employees','attendance_date','attendance_errors','attendance_in_errors','attendance_out_errors'));
        }
        elseif($attendance_month!=null )
        {
            $month_year=explode("-",$attendance_month);
           
            $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
            
            $emps=Employee::orderBy('created_at','asc')->get();

            $employees=array();

            foreach ($emps as $emp) {


            

            $attendances=array();
             $present=0; $absent=0;
            for ($i=1; $i <= $days ; $i++) { 
                   $c_date=date('Y-m-d',mktime(0,0,0,$month_year[1],$i,$month_year[0]));

                    $in=Attendance::where('employee_id','like',''.$emp['id'])->where('date','like',$c_date)->where('status','like','C/In')->get();

                $out=Attendance::where('employee_id','like',''.$emp['id'])->where('date','like',$c_date)->where('status','like','C/Out')->get();

                $in_time=''; $out_time='';
                
                
        
                if(count($in)>0)
                {
                    
                    $in_time=$in[0]['time'];
                 
                }
               

                if(count($out)>0)
                {
                    $out_time=$out[0]['time'];
                }

                if($in_time=='' && $out_time=='')
                {
                    
                    $sun=date('l',mktime(0,0,0,$month_year[1],$i,$month_year[0]));
                   if($sun=='Sunday')
                   {
                    $status='';
                   }
                   else
                   {
                      $status='A';
                      $absent++;
                   }
                }
                else
                {
                    $status='P';
                    $present++;
                }

                $sun=date('l',mktime(0,0,0,$month_year[1],$i,$month_year[0]));
                 if($sun=='Sunday')
                {
                    $status='';
                }

                $att=array($i=>$status);
                $attendances=array_merge($attendances,$att);
            
                 
                }//end loop for days
                 
                 $employee=array('id'=>$emp['id'],'name'=>$emp['name'],'present'=>$present,'absent'=>$absent,'attendances'=>$attendances);

                 //print_r($employee);//die;
                array_push($employees,$employee);
                
            }

                return view('attendance.monthRegister',compact('employees','attendance_month'));
        }
        else
        {
        return view('attendance.register');
        }
    }

    public function emp_att_register(Request $request)
    {
        $emps=Employee::select('id','name','employee_code')->orderBy('created_at','asc')->get();
        $config=array('emp_id'=>'','to_date'=>'','from_date'=>'');
        return view('attendance.emp_att_register',compact('emps','config'));

    }

    public function emp_att_register1(Request $request)
    {
        $emps=Employee::select('id','name','employee_code')->orderBy('created_at','asc')->get();

        $p_to_date=$request->to_date;
        $to_date=$request->to_date;
        $p_from_date=$request->from_date;
        $from_date=date("Y-m-d",strtotime($p_from_date.'+1 days'));
        $s_employee=$request->employee;
//print_r($from_date);die;
           $attendances=array();

            $emp=Employee::where('id',$s_employee)->first();

             $offDays= explode(',', $emp->shift->offdays);
            $alterOffDays= explode(',', $emp->shift->alter_offdays);
            $count_alter=0;

             do
             {
                $in=Attendance::where('employee_id','like',''.$emp['id'])->where('date','like',$to_date)->where('status','like','C/In')->get();

                $out=Attendance::where('employee_id','like',''.$emp['id'])->where('date','like',$to_date)->where('status','like','C/Out')->get();

                $in_time=''; $out_time='';
                
        
                if(count($in)>0)
                {
                    
                    $in_time=$in[0]['time'];
                 
                }
               

                if(count($out)>0)
                {
                    $out_time=$out[0]['time'];
                }

                if($in_time=='' && $out_time=='')
                {
                    //$day=strtolower( date('l', $to_date ) );
                    //$have=in_array($day, $offDays);
                    $day=strtolower( date_format(date_create($to_date),"l") );
                     
                if(in_array($day, $offDays))
                {
                
                $status=$day;
           
                     }
                     elseif(in_array($day, $alterOffDays))
                     {

                        if($count_alter<2)
                               { $status='alternate '.$day.' off';   }
                           else
                           {
                            $status='A';
                           }
                            $count_alter++;
                     }
                   else
                    { $status='A'; }
                }
                else
                {
                    $status='P';
                }


                $att=array('date'=>$to_date,'in'=>$in_time,'out'=>$out_time,'status'=>$status);
                array_push($attendances, $att);

                $to_date=date("Y-m-d",strtotime($to_date.'+1 days'));

                 } while(strcmp( $to_date,$from_date));
                

                //return view('attendance.register',compact('employees','attendance_date'));

             $config=array('emp_id'=>$s_employee,'to_date'=>$p_to_date,'from_date'=>$p_from_date);
        return view('attendance.emp_att_register',compact('emps','config','attendances'));
    }

    public function import_attendance()
    {
        $employees=Employee::where('activeness','like','active')->orderBy('created_at','asc')->get();
        $statuses=AttendanceStatus::where('activeness','like','active')->orderBy('sort_order','asc')->get();
        return view('employee.importAttendance',compact('employees','statuses'));
    }

    public function mark_attendance(Request $request)
    {
        $date=$request->date;
        $employee_ids=$request->employee_ids;
        $status=$request->status;
        $time=$request->time;
        $attendance_type=$request->attendance_type;

        //print_r($employee_ids);die;
        
         for ($i=0; $i < count($employee_ids) ; $i++) { 

            if($employee_ids[$i]=='')
                continue ;

            $emp=Employee::find($employee_ids[$i]);

            // if($emp['zk_id']=='')
            //     continue ;
            
            $att=DailyAttendance::where('employee_id','like',$emp['id'])->where('date','like',$date)->first();
              
              if($att==null)
              {
                 $att=new DailyAttendance;
              }
              
              $att->employee_id=$emp['id'];
              //$att->name=$emp['zk_id'];
              //$att->no=$emp['zk_id'];
              $att->date=$date;
              $att->status=$status;
              $att->save();
            
             if($attendance_type!='' && $time!='')
             {
              $att_in=Attendance::where('dailyattendance_id','like',$att->id)->where('status','like',$attendance_type)->first();
              
              if($att_in==null)
              {
                 $att_in=new Attendance;
              }
              
              
              if($time != null)
              {
              $att_in->dailyattendance_id=$att->id;
              $att_in->time=$time;
              $att_in->status=$attendance_type;
              $att_in->save();
              }

              }
              
//die;

           }

     return redirect()->back()->with('success','Attendance Added!');

        
    }

    public function save_attendance_file(Request $request)
    {
       
        \Excel::import(new AttendancesImport,request()->file('sheet'));

        //\Session::put('success', 'Your file is imported successfully in database.');

        return redirect()->back()->with('success','Your file is imported successfully in database.');
           
    
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {

        return view('attendance.edit',compact('attendance'));
    }

    public function edit_attendance(Employee $employee,$date)
    {
          $in=$employee->attendances->where('date','like',$date)->where('status','like','C/In');
          $out=$employee->attendances->where('date','like',$date)->where('status','like','C/Out');

          $in_time=array(); $out_time=array();

                foreach($in as $i)
                { 
                            array_push($in_time, $i['time']);
                }

                foreach($out as $i)
                { 
                            array_push($out_time, $i['time']);
                }

                 $employee=array('id'=>$employee['id'],'name'=>$employee['name'],'in'=>$in_time,'out'=>$out_time);

          //print_r( $attendances ); die;

        return view('attendance.edit_attendance_employee_date',compact('employee','date'));
    }

    public function update_attendance(Request $request,Employee $employee,$date)
    {
           $time_in=$request->time_in;
           $time_out=$request->time_out;
            
            //$employee->attendances;

            $in=$employee->attendances->where('date','like',$date)->where('status','like','C/In');
            $out=$employee->attendances->where('date','like',$date)->where('status','like','C/Out');

            if(count($in)==0 || count($in)>1)
            {
                foreach ($in as $i) {
                    $attendance=Attendance::find($i['id']);
                    $attendance->delete();
                }
                
                $attendance=New Attendance;

                    $attendance->date=$date;
                    $attendance->time=$time_in;
                     $attendance->status='C/In';
                     //$attendance->name=$employee['zk_id'];
                     //$attendance->no=$employee['zk_id'];


                  $attendance->save();


            }
            elseif (count($in)==1) {

                $attendance=$employee->attendances->where('date','like',$date)->where('status','like','C/In')->first();
                $attendance->time=$time_in;
                $attendance->save(); 
            }


            if(count($out)==0 || count($out)>1)
            {
                foreach ($out as $i) {
                    $attendance=Attendance::find($i['id']);
                    $attendance->delete();
                }
                
                $attendance=New Attendance;

                    $attendance->date=$date;
                    $attendance->time=$time_out;
                     $attendance->status='C/Out';
                     //$attendance->name=$employee['zk_id'];
                    // $attendance->no=$employee['zk_id'];


                  $attendance->save();


            }
            elseif (count($out)==1) {

                $attendance=$employee->attendances->where('date','like',$date)->where('status','like','C/Out')->first();
                $attendance->time=$time_out;
                $attendance->save(); 
            }
            

            

           return redirect()->back()->with('success','Attendance Record Updated!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
           $date=$request->date;
           $time=$request->time;
           $status=$request->status;

           $attendance->date=$date;
           $attendance->time=$time;
           $attendance->status=$status;

           $attendance->save();

           return redirect()->back()->with('success','Attendance Record Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->back()->with('attendance_delete','Attendance Record Deleted!');
    }
}
