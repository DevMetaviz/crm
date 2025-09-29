<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Allowance;
use App\Models\Shift;
use App\Models\AttendanceStatus;
use App\Models\LeaveType;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Account;
use PDF;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees=Employee::orderBy('created_at')->get();
        return view('employee.employees',compact('employees'));
    }

    public function create_department()
    {
        $departments=Department::orderBy('created_at')->get();
        return view('employee.departments',compact('departments'));
    }

    public function save_department(Request $request)
    {
        $status=$request->status;
        if($status=='')
            $status=0;

        $department=new Department;
          $department->name=$request->name;
          $department->sort_order=$request->sort_order;
          $department->remarks=$request->remarks;
          $department->status=$status;

          $department->save();

        return redirect()->back()->with('success','Department Added!');;
    }



    public function create_designation()
    {
        $designations=Designation::orderBy('created_at')->get();
        return view('employee.designations',compact('designations'));
    }

    public function save_designation(Request $request)
    {
        $status=$request->status;
        if($status=='')
            $status=0;

        $designation=new Designation;
          $designation->name=$request->name;
          $designation->sort_order=$request->sort_order;
          $designation->remarks=$request->remarks;
          $designation->status=$status;

          $designation->save();

        return redirect()->back()->with('success','Designation Added!');;
    }


    public function test()
    {

        return view('test');
       
       $employees=Employee::orderBy('created_at')->get();
        $data = [
            'title' => 'Welcome to Tutsmake.com',
            'date' => date('m/d/Y'),
            'employees'=>$employees
        ];
           view()->share('layout.testPDF',$data);
        $pdf = PDF::loadView('layout.testPDF', $data);
        return $pdf->stream('layout.testPDF');

        //return $pdf->download('tutsmake.pdf');


        

        //$pdf = App::make('dompdf.wrapper');
          //$pdf->loadHTML('<h1>Test</h1>');
           //return $pdf->stream();

       // view()->share('employee.employees',$employees);

     // $pdf = PDF::loadView('testPDF', ['employees'=>$employees]);

      //print_r(json_encode($pdf));die;

      // download PDF file with download method
      return $pdf->stream();
      //return $pdf->download('employees.pdf');

        //return view('employee.employees',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $year=date("y");
         $new_employee_code='FP-'.$year.'-';


        $employee=Employee::select('id','employee_code')->latest()->first();

        if($employee=='')
         $new_employee_code='FP-'.$year.'-'.'1001';
     else{
        $emp=explode("-",$employee['employee_code']);

        
        $num=intval($emp[2]);
        $num++;
        $new_employee_code='FP-'.$year.'-'.$num;
    }
         $shifts=Shift::orderBy('created_at')->get();

         $designations=Designation::where('status','1')->orderBy('sort_order')->get();
         $departments=Department::where('status','1')->orderBy('sort_order')->get();
         $employees=Employee::where('is_so','1')->where('status','1')->orderBy('name')->get();

        return view('employee.create',compact('new_employee_code','employees','shifts','designations','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee=new Employee;

        $employee->name=$request->get('name');
        $employee->father_husband_name=$request->get('father_name');
        $employee->gender=$request->get('gender');
        $employee->marital_status=$request->get('marital_status');
        $employee->qualification=$request->get('qualification');
        if($request->get('status')==null)
                  {
                    $employee->status='0';
                }
         else
         {
            $employee->status=$request->get('status');
         }
          $is_so=$request->get('is_so');
         if($is_so==null || $is_so=='')
                  {
                    $employee->is_so=0;
                }
         else
         {
            $employee->is_so=$is_so;
         }
          $employee->super_employee=$request->get('super_employee');
        $employee->cnic=$request->get('cnic');
        $employee->cnic_place=$request->get('cnic_place');
        $employee->dateOfBirth=$request->get('date_of_birth');
        $employee->religion=$request->get('religion');
        $employee->employee_code=$request->get('code');
        $employee->zk_id=$request->get('zk_id');
        $employee->joining_date=$request->get('joining_date');
        $employee->leaving_date=$request->get('leaving_date');
        $employee->employee_type=$request->get('type');
        $employee->designation_id=$request->get('designation');
        $employee->department_id=$request->get('department');
        $employee->refference=$request->get('refference');
        $employee->shift_id=$request->get('shift');
        $employee->allowed_leave=$request->get('allowed_leave');
        $employee->comment=$request->get('comment');

        // if($request->get('attendance')!='' || $request->get('attendance')!=null)
        // $employee->attendance_required=$request->get('attendance');
        // else
        // $employee->attendance_required=0;

        $employee->phone=$request->get('phone');
        $employee->mobile=$request->get('mobile');
        $employee->email=$request->get('email');
        $employee->domicile=$request->get('domicile');
        $employee->state=$request->get('state');
        $employee->city=$request->get('city');
        $employee->address=$request->get('address');
        $employee->salary=$request->get('salary');
    
        $employee->save();
        //return back()->withInput()->withErrors(['msg'=> 'The Message']);
        //return redirect()->back()->withInput()->with('success','Employee Enrolled!');

        $super_id='74';

        $super=Account::find($super_id);

        $sub=Account::where('super_id',$super_id)->orderBy('code','desc')->first();
          $num='';  $code=$super['code'].'-';
        if($sub=='' || $sub==null)
        {
            $num='00001';
        }
        else
        {
              $let=explode($code, $sub['code']);
              $num=$let[1] + 1 ;
              $num=sprintf('%05d', $num);
          }

          $code=$code. $num;

                

           
        $acc=new Account;
          $acc->super_id=$super_id;
          $acc->code=$code;
          $acc->name=$employee->name;
          $acc->type='detail';
          $acc->opening_balance=0;
          $acc->remarks='';

          $acc->status='1';

          $acc->save();

          $employee->account_id=$acc->id;
           $employee->save();

        return redirect('employee/edit/'.$employee['id'].'/'.$employee['name'])->with('success','Employee Enrolled!');

       
    }

     public function profile()
    {
        $employees=Employee::where('status','1')->orderBy('created_at')->select('id','name')->get();
        $attendance_statuses=AttendanceStatus::select('id','text','leave_type_id')->where('status','like','1')->orderBy('sort_order','asc')->get();
        $leave_types=LeaveType::where('status','like','1')->get();
        return view('employee.profile',compact('employees','attendance_statuses','leave_types'));
    }

    public function getProfile(Request $request)
    {
        $month=$request->get('month');
        //$month='2021-01';
        $emp=$request->get('employee');
        $employee=Employee::with('department','designation')->find($emp);

        $detail=array();
        
            if($month!='')
            {
               //$attendance_detail=$employee->monthly_attendance_profile($month);
                
               $monthly_attendance_status_count=$employee->monthly_attendance_status_count($month);
           $allocated_leave_count=$employee->allocated_leave_count($month);
           $availed_leave_count=$employee->availed_leave_count($month);
           $current_availed_leave_count=$employee->current_availed_leave_count($month);

           $monthly_leave_deduction=$employee->monthly_leave_deduction($month,$monthly_attendance_status_count,$allocated_leave_count,$availed_leave_count,$current_availed_leave_count);

             //Allowance
            $allowance_amount=0;
            $allowances=array();
                           // print_r(count($emp->allowances));die;
                            foreach ($employee->allowances as $all) {
                                $type=$all['pivot']['type'];
                                $amount=$all['pivot']['amount'];


                                $one=array('text'=>$all['text'],'amount'=>$amount);
                                array_push($allowances, $one);

                                if($type=='fixed')
                                {
                                    $amount=$amount;
                                }
                                else
                                {
                                    $amount=($amount/100)*$employee['salary'];
                                }

                                if($all['type']=='additive')
                                    {$allowance_amount+=$amount;}
                                elseif($all['type']=='deductive')
                                    {$allowance_amount-=$amount;}


                            }
                //Allowance end
                //penality
                            $ps=$employee->month_penalities($month);
                  $penality_amount=0;//penality charges
                  $penalities=array();
                  foreach ($ps as $p) {
                    $p_amount=0;
                    if($p['type']=='fixed')
                    {
                          $p_amount=$p['amount'];
                    }
                    elseif($p['type']=='percentage')
                    {
                        $percent=$p['amount']/100;
                        if($p['weight']=='per day')
                        $p_amount=$percent*$employee->per_day_salary($month);
                            elseif($p['weight']=='per month')
                        $p_amount=$percent*$employee['salary'];
                    }
                    $one=array('text'=>$p['text'],'amount'=>$p_amount);
                                array_push($penalities, $one);
                      $penality_amount+=$p_amount;
                  }

                            //end penality
                  // month_OVERTIME
                  $month_overtime_count=round ($employee->month_overtime_mins($month));
                  $per_min=round( $employee->per_day_salary($month) / 480 ,2 ) ;
                  $month_overtime_amount=round( $month_overtime_count * $per_min *2 );
                   // end OVERTIME

                  // month_late_comings_count
                  $month_late_comings_count=$employee->month_late_comings_count($month);
                   // end month_late_comings_count
                   $per_d=$employee->per_day_salary($month);

                    $month_late_comings_amount=round( intval($month_late_comings_count/4)*$per_d );
                  // month_working_hours
                  $month_working_hours=$employee->month_working_hours($month);
                   // end month_working_hours
                   $total_salary=$employee['salary']-($monthly_leave_deduction+$penality_amount+$month_late_comings_amount)+($allowance_amount);
                  //$total_salary=0;
              $detail=array('monthly_attendance_status_count'=>$monthly_attendance_status_count,
                'allocated_leave_count'=>$allocated_leave_count,
                'availed_leave_count'=>$availed_leave_count,
                'current_availed_leave_count'=>$current_availed_leave_count,
                'monthly_leave_deduction' => $monthly_leave_deduction,
                'month_overtime_count'=>$month_overtime_count,
                'month_overtime_amount'=>$month_overtime_amount,
                'allowances'=> $allowances,
                'allowance_amount'=> $allowance_amount,
                'penalities'=> $penalities,
                'penality_amount'=> $penality_amount,
                'month_working_hours'=> $month_working_hours,
                'month_late_comings_count'=>$month_late_comings_count,
                'month_late_comings_amount'=>$month_late_comings_amount,
                'total_salary'=>$total_salary,
            ); 
            }
            

            

        $profile=array('employee'=>$employee,'profile'=>$detail);

        return response()->json($profile, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $employee=Employee::find($id);
        $allowances=Allowance::where('status','1')->orderBy('created_at')->get();
         $shifts=Shift::orderBy('created_at')->get();

          $designations=Designation::where('status','1')->orderBy('sort_order')->get();
         $departments=Department::where('status','1')->orderBy('sort_order')->get();
         $employees=Employee::where('id','<>',$id)->where('is_so','1')->where('status','1')->orderBy('name')->get();


        return view('employee.edit',compact('employees','employee','allowances','shifts','designations','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $employee=Employee::find($request->get('id'));

        $employee->name=$request->get('name');
        $employee->father_husband_name=$request->get('father_name');
        $employee->gender=$request->get('gender');
        $employee->marital_status=$request->get('marital_status');
        $employee->qualification=$request->get('qualification');
        if($request->get('status')==null)
                  {
                    $employee->status='0';
                }
         else
         {
            $employee->status=$request->get('status');
         }

         $is_so=$request->get('is_so');
         if($is_so==null || $is_so=='')
                  {
                    $employee->is_so=0;
                }
         else
         {
            $employee->is_so=$is_so;
         }
         $employee->super_employee=$request->get('super_employee');
        $employee->cnic=$request->get('cnic');
        $employee->cnic_place=$request->get('cnic_place');
        $employee->dateOfBirth=$request->get('date_of_birth');
        $employee->religion=$request->get('religion');
        $employee->employee_code=$request->get('code');
        $employee->zk_id=$request->get('zk_id');
        $employee->joining_date=$request->get('joining_date');
        $employee->leaving_date=$request->get('leaving_date');
        $employee->employee_type=$request->get('type');
        $employee->designation_id=$request->get('designation');
        $employee->department_id=$request->get('department');
        $employee->refference=$request->get('refference');
        $employee->shift_id=$request->get('shift');
        $employee->allowed_leave=$request->get('allowed_leave');
        $employee->comment=$request->get('comment');

        // if($request->get('attendance')!='' || $request->get('attendance')!=null)
        // $employee->attendance_required=$request->get('attendance');
        // else
        // $employee->attendance_required=0;

        
        $employee->phone=$request->get('phone');
        $employee->mobile=$request->get('mobile');
        $employee->email=$request->get('email');
        $employee->domicile=$request->get('domicile');
        $employee->state=$request->get('state');
        $employee->city=$request->get('city');
        $employee->address=$request->get('address');
        $employee->salary=$request->get('salary');
    
        $employee->save();
        //return back()->withInput()->withErrors(['msg'=> 'The Message']);

        if($employee['account']=='')
       {
        $super_id='74';

        $super=Account::find($super_id);

        $sub=Account::where('super_id',$super_id)->orderBy('code','desc')->first();
          $num='';  $code=$super['code'].'-';
        if($sub=='' || $sub==null)
        {
            $num='00001';
        }
        else
        {
              $let=explode($code, $sub['code']);
              $num=$let[1] + 1 ;
              $num=sprintf('%05d', $num);
          }

          $code=$code. $num;

                

           
        $acc=new Account;
          $acc->super_id=$super_id;
          $acc->code=$code;
          $acc->name=$employee->name;
          $acc->type='detail';
          $acc->opening_balance=0;
          $acc->remarks='';

          $acc->status='1';

          $acc->save();

          $employee->account_id=$acc->id;
           $employee->save();

       }
       else
       {
           $acc= Account::find($employee['account_id']);
           $acc->name=$employee['name'];
           $acc->save();
       }

        return redirect()->back()->with('success','Employee Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    

     


}
