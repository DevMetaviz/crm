<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Configuration;
use App\Models\Employee;
use App\Models\Penality;
use App\Models\Allowance;
use App\Models\Department;
use App\Models\Salary;
use App\Models\Transection;
use App\Models\employee_salary;
use PDF;


class salaryController extends Controller
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

    public function generate_salary(Request $request)
    {
       
        return view('salary.genrateSalaries');
    }

    public function make_salary(Request $request)
    {

        $departments=Department::with('active_employees')->where('activeness','like','1')->orderBy('sort_order')->get();

          
        return view('salary.make_salary',compact('departments'));
    }

    public function test()
    {
        $emp=Employee::find(1);
        $c=$emp->attendance_days_count('2021-05');
        print_r(json_encode($c));
    }

    public function make_month_salary(Request $request)
    {
      $let_emps=$request->employees;

      


      
         $salary_month=$request->salary_month;
         $month_year=explode("-",$salary_month);
        $days_in_month=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);

       
          $departs=Department::with(['employees'=>function($q)use ($let_emps){
                 $q->whereIn('employees.id',$let_emps);
         } ])->where('activeness','like','1')->wherehas('employees',function($q)use ($let_emps){
                 $q->whereIn('employees.id',$let_emps);
         })->orderBy('sort_order')->get();
         //print_r(json_encode($dpr));die;
        // $departments=Department::with('employees')->where('activeness','like','1')->orderBy('sort_order')->get();
         $allowances=Allowance::where('type','allowance')->where('activeness','1')->orderBy('sort_order')->get();
         $deductions=Allowance::where('type','deduction')->where('activeness','1')->orderBy('sort_order')->get();

         $departments=array();

         foreach ($departs as $depart) {
             $employees=array();
              

             foreach ($depart->employees as $emp) {

                   $emp=Employee::find($emp['id']);
                   $per_day_salary=$emp->per_day_salary($salary_month);//per day salry

                   $attendance_days_count=0;

                   if($emp['shift']['attendance']==0)
                    $attendance_days_count=$days_in_month;
                    elseif($emp['shift']['attendance']==1)
                   $attendance_days_count=$emp->attendance_days_count($salary_month);

                   $month_late_comings_count=$emp->month_late_comings_count($salary_month);
                   // end month_late_comings_count

                    $month_late_comings_amount=round( ($month_late_comings_count/4)*$per_day_salary );

                    $month_overtime_hours=$emp->month_overtime_hours($salary_month);

                    $overtime_amount=round ($month_overtime_hours * ( $per_day_salary / 8) , 0 );

                    $earned_salary= ($per_day_salary * $attendance_days_count ) - $month_late_comings_amount + $overtime_amount  ;
                    $earned_salary=round (  $earned_salary ,0 ) ;

                    //penality
                            $ps=$emp->month_penalities($salary_month);
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
                        $p_amount=$percent*$per_day_salary;
                            elseif($p['weight']=='per month')
                        $p_amount=$percent*$emp['salary'];
                    }
                    $one=array('text'=>$p['text'],'amount'=>$p_amount);
                                array_push($penalities, $one);
                      $penality_amount+=$p_amount;
                  }

                            //end penality

                  //Allowance
            
            $employee_allowances=array();
                           // print_r(count($emp->allowances));die;
             $allowance_amount=0;
                            foreach ($emp->allowances as $all) {
                                $type=$all['pivot']['type'];
                                $amount=$all['pivot']['amount'];

                              
                                

                                if($type=='fixed')
                                {
                                    $amount=$amount;
                                }
                                else
                                {
                                    $amount=($amount/100)*$emp['salary'];
                                }

                              
                                    $allowance_amount += $amount;
                                

                            $one=array('id'=>$all['id'],'text'=>$all['text'],'amount'=>$amount);

                                $let=array($all['id']=>$one);
                                $employee_allowances+= $let;
                                //array_push($employee_allowances, $let);

                            }
                //Allowance end

                            //Deduction
            
            $employee_deductions=array();
                           // print_r(count($emp->allowances));die;
             $deduction_amount=0;
                            foreach ($emp->deductions as $all) {
                                $type=$all['pivot']['type'];
                                $amount=$all['pivot']['amount'];

                              
                                

                                if($type=='fixed')
                                {
                                    $amount=$amount;
                                }
                                else
                                {
                                    $amount=($amount/100)*$emp['salary'];
                                }

                              
                                    $deduction_amount += $amount;
                                

                            $one=array('id'=>$all['id'],'text'=>$all['text'],'amount'=>$amount);

                                $let=array($all['id']=>$one);
                                $employee_deductions+= $let;
                                //array_push($employee_allowances, $let);

                            }
                //Deduction end
                 
                 //start tax deduction
                            $tax_amount=0;
                 //end tax deduction
                //start loan deduction
                            $loan_deduction=0;
                //end loan deduction
                 $gross_salary=$earned_salary + $allowance_amount ;
                 $net_salary= $gross_salary - $deduction_amount -$penality_amount - $tax_amount;
                 $payable_salary= $net_salary - $loan_deduction ;

                 $emp=array('id'=>$emp['id'],'name'=>$emp['name'],'designation'=>$emp['designation'],'basic_salary'=>$emp['salary'],'attendance_days_count'=>$attendance_days_count ,'month_late_comings_count'=>$month_late_comings_count , 'month_late_comings_amount'=>$month_late_comings_amount,'month_overtime_hours'=>$month_overtime_hours,'overtime_amount'=>$overtime_amount, 'earned_salary' => $earned_salary ,'penality_amount'=>$penality_amount, 'allowances'=>$employee_allowances,'deductions'=>$employee_deductions,'gross_salary'=>$gross_salary,'tax_amount'=>$tax_amount,'net_salary'=>$net_salary,'loan_deduction'=>$loan_deduction, 'payable_salary'=>$payable_salary);

                  array_push($employees, $emp);
             }

             //$dp=Department::find($depart);

             
             $depart=array('department'=>$depart ,'employees' => $employees);
             array_push($departments, $depart);
         }

        $doc_no="ES-".Date("y")."-";
        $num=1;

         $std=Salary::select('id','doc_no')->where('doc_no','like',$doc_no.'%')->orderBy('doc_no','desc')->first();
         if($std=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $std['doc_no']);//print_r(json_encode($let));die;
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }

         
          
        return view('salary.make_month_salary',compact('doc_no','salary_month','departments','allowances','deductions'));
    }


    public function save_month_salary(Request $request)
    {
      
         $salary_month=$request->salary_month;
         $employee_ids=$request->employee_ids;
         $basic_salaries=$request->basic_salaries;
         $att_days=$request->att_days;
         $lates=$request->lates;
         $late_fines=$request->late_fines;
         $overtime_hours=$request->overtime_hours;
         $overtime_amounts=$request->overtime_amounts;
         $earned_salary=$request->earned_salary;
         $gross=$request->gross;
         $penality=$request->penality;
         $tax=$request->tax;
         $net=$request->net;
         $loan=$request->loan;
         $payables=$request->payables;

         //print_r($salary_month);die;

         $salary= new Salary;
         $salary->doc_no=$request->doc_no;
         $salary->doc_date=$request->doc_date;
         $salary->month=$salary_month;
         $salary->save();


         $allowances=Allowance::where('type','allowance')->where('activeness','1')->orderBy('sort_order')->get();
         $deductions=Allowance::where('type','deduction')->where('activeness','1')->orderBy('sort_order')->get();

        
        for ($i=0; $i <count($employee_ids) ; $i++) { 
        
         $emp= new employee_salary;

         $emp->employee_id=$employee_ids[$i];
         $emp->salary_id=$salary['id'];
         $emp->current_salary=$basic_salaries[$i];
         $emp->attendance_days=$att_days[$i];
         $emp->late_coming_days=$lates[$i];
         $emp->late_fine=$late_fines[$i];
         $emp->overtime=$overtime_hours[$i];
         $emp->overtime_amount=$overtime_amounts[$i];
         $emp->earned_salary=$earned_salary[$i];
         $emp->gross_salary=$gross[$i];
         $emp->penality_charges=$penality[$i];
         $emp->tax=$tax[$i];
         $emp->net_salary=$net[$i];
         $emp->loan_deduction=$loan[$i];
         $emp->payable_salary=$payables[$i];
         
         $emp->save();

         $acc=Employee::find($employee_ids[$i])->account_id;
          $trans=new Transection;
           $trans->account_voucherable_id=$salary->id;
           $trans->account_voucherable_type='App\Models\Salary';
           $trans->account_id=$acc;
           //$trans->corporate_id=$item['id'];
           $trans->remarks=$emp['employee']['name'].' Earned Salary Month: '.$salary['month'];
           $trans->debit=0;
           $trans->credit=$emp->earned_salary;
           $trans->save();



         foreach ($allowances as $key ) {
            $n='allowances_'.$key['id'];
            $n=$request->$n;
            $a=$n[$i];

                if($a!='')
                 {
                  $emp->allowances()->attach( $key['id'] , [ 'amount'=>$a ]);

                      $trans=new Transection;
                   $trans->account_voucherable_id=$salary->id;
                   $trans->account_voucherable_type='App\Models\Salary';
                   $trans->account_id=$acc;
                   //$trans->corporate_id=$item['id'];
                   $trans->remarks=$emp['employee']['name'].' '.$key['text'].' Allowance Month: '.$salary['month'];
                   $trans->debit=0;
                   $trans->credit=$a;
                   $trans->save();
                  }
          }

          foreach ($deductions as $key ) {
            $n='deductions_'.$key['id'];
            $n=$request->$n;
            $a=$n[$i];

            if($a!='')
                 {
                  $emp->deductions()->attach( $key['id'] , [ 'amount'=>$a ]);

                   $trans=new Transection;
                   $trans->account_voucherable_id=$salary->id;
                   $trans->account_voucherable_type='App\Models\Salary';
                   $trans->account_id=$acc;
                   //$trans->corporate_id=$item['id'];
                   $trans->remarks=$emp['employee']['name'].' '.$key['text'].' Deduction Month: '.$salary['month'];
                   $trans->debit=$a;
                   $trans->credit=0;
                   $trans->save();

                   }

                   }
                   
                   if($emp->penality_charges != '' && $emp->penality_charges > 0)
                   {
                    $trans=new Transection;
                   $trans->account_voucherable_id=$salary->id;
                   $trans->account_voucherable_type='App\Models\Salary';
                   $trans->account_id=$acc;
                   //$trans->corporate_id=$item['id'];
                   $trans->remarks=$emp['employee']['name'].' '.'Penality charges month: '.$salary['month'];
                   $trans->debit=$emp->penality_charges;
                   $trans->credit=0;
                   $trans->save();
                   }

                   if($emp->tax != '' && $emp->tax > 0)
                   {
                    $trans=new Transection;
                   $trans->account_voucherable_id=$salary->id;
                   $trans->account_voucherable_type='App\Models\Salary';
                   $trans->account_id=$acc;
                   //$trans->corporate_id=$item['id'];
                   $trans->remarks=$emp['employee']['name'].' Income Tax deduction month: '.$salary['month'];
                   $trans->debit=$emp->tax;
                   $trans->credit=0;
                   $trans->save();

                   $trans=new Transection;
                   $trans->account_voucherable_id=$salary->id;
                   $trans->account_voucherable_type='App\Models\Salary';
                   $trans->account_id=273;
                   //$trans->corporate_id=$item['id'];
                   $trans->remarks=$emp['employee']['name'].' Income Tax deduction month: '.$salary['month'];
                   $trans->debit=0;
                   $trans->credit=$emp->tax;
                   $trans->save();

                   }


          
          
        
        


        }
         
          
          
          return redirect(url('make-salary'))->with('success','Salary Saved!');

          
         

       }

       public function salary_history(Request $request)
    {
      //$list = Salary::groupBy('month')->select('month')->get();
      $list = Salary::orderBy('doc_no')->get();

      return view('salary.history',compact('list'));
    }

    public function salary_report(Salary $salary_doc)
    {

       $allowances=Allowance::where('type','allowance')->orderBy('sort_order')->get();
         $deductions=Allowance::where('type','deduction')->orderBy('sort_order')->get();
          
           $let_emps = employee_salary::where('salary_id',$salary_doc['id'])->pluck('employee_id');

         $departs=Department::with(['employees'=>function($q)use ($let_emps){
                 $q->whereIn('employees.id',$let_emps);
         } ])->wherehas('employees',function($q)use ($let_emps){
                 $q->whereIn('employees.id',$let_emps);
         })->orderBy('sort_order')->get();

             $departments=array( );
            foreach ($departs as $depart) {
                  $employees=array( );
                   foreach ($depart->employees->whereIn('id',$let_emps) as $emp) {
                    $emp=Employee::find($emp['id']);

                    array_push($employees, $emp);
                   }

                   $depart=array('department'=>$depart ,'employees' => $employees);
             array_push($departments, $depart);
         }

         $name=Configuration::company_full_name();
        $address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();

       
       $data = [
            
             'name'=>$name,
            'address'=>$address,
            'logo'=>$logo,

            'salary_doc'=>$salary_doc,
            'departments'=>$departments,
            'allowances'=>$allowances,
            'deductions'=>$deductions,
        
        ];
       
            view()->share('salary.salary_report',$data);
        $pdf = PDF::loadView('salary.report.salary_report', $data);
        $pdf->setPaper('A4','landscape');
        return $pdf->stream($salary_doc['doc_no'].'.pdf');
      
      
    }


    public function salary_edit(Salary $salary_doc)
    {

       $allowances=Allowance::where('type','allowance')->where('activeness','1')->orderBy('sort_order')->get();
         $deductions=Allowance::where('type','deduction')->where('activeness','1')->orderBy('sort_order')->get();
          
           $let_emps = employee_salary::where('salary_id',$salary_doc['id'])->pluck('employee_id');

         $departs=Department::with(['employees'=>function($q)use ($let_emps){
                 $q->whereIn('employees.id',$let_emps);
         } ])->wherehas('employees',function($q)use ($let_emps){
                 $q->whereIn('employees.id',$let_emps);
         })->orderBy('sort_order')->get();

             $departments=array( );
            foreach ($departs as $depart) {
                  $employees=array( );
                   foreach ($depart->employees->whereIn('id',$let_emps) as $emp) {
                    $emp=Employee::find($emp['id']);

                    array_push($employees, $emp);
                   }

                   $depart=array('department'=>$depart ,'employees' => $employees);
             array_push($departments, $depart);
         }

      
      return view('salary.edit_salary',compact('salary_doc','departments','allowances','deductions'));
    }

    public function salary_update(Request $request)
    {    

        $salary_ids=$request->salary_ids;
        $employee_ids=$request->employee_ids;
        $basic_salaries=$request->basic_salaries;
        $att_days=$request->att_days;
        $lates=$request->lates;
        $late_fines=$request->late_fines;
        $overtime_hours=$request->overtime_hours;
        $overtime_amounts=$request->overtime_amounts;
        $earned_salary=$request->earned_salary;
        $gross=$request->gross;
        $penality=$request->penality;
        $tax=$request->tax;
         $net=$request->net;
         $loan=$request->loan;
        $payables=$request->payables;

         $allowances=Allowance::where('type','allowance')->where('activeness','1')->orderBy('sort_order')->get();
         $deductions=Allowance::where('type','deduction')->where('activeness','1')->orderBy('sort_order')->get();

        
        $salary= Salary::find($request->id);
          $salary->doc_no=$request->doc_no;
         $salary->doc_date=$request->doc_date;       
         $salary->save();

         //$transections=$salary->transections()->where('account_id',$acc)->get();
         $transections=$salary->transections;
            $no=0;

        for ($i=0; $i < count($salary_ids) ; $i++) { 
            
            $emp= employee_salary::find($salary_ids[$i]);
         
         $emp->salary_id=$salary['id'];
         $emp->employee_id=$employee_ids[$i];
         $emp->current_salary=$basic_salaries[$i];
         $emp->attendance_days=$att_days[$i];
         $emp->late_coming_days=$lates[$i];
         $emp->late_fine=$late_fines[$i];
         $emp->overtime=$overtime_hours[$i];
         $emp->overtime_amount=$overtime_amounts[$i];
         $emp->earned_salary=$earned_salary[$i];
         $emp->gross_salary=$gross[$i];
         $emp->penality_charges=$penality[$i];
         $emp->tax=$tax[$i];
         $emp->net_salary=$net[$i];
         $emp->loan_deduction=$loan[$i];
         $emp->payable_salary=$payables[$i];
         
         $emp->save();

         // $acc=Employee::find($employee_ids[$i])->account_id;
                      
         //   if($no < count($transections))
         //           $trans=$transections[$no];
         //           else
         //           $trans=new Transection;
        
         //   $trans->account_voucherable_id=$salary->id;
         //   $trans->account_voucherable_type='App\Models\Salary';
         //   $trans->account_id=$acc;
         //   //$trans->corporate_id=$item['id'];
         //   $trans->remarks=$emp['employee']['name'].' Earned Salary Month: '.$salary['month'];
         //   $trans->debit=0;
         //   $trans->credit=$emp->earned_salary;
         //   $trans->save();
         //   $no++;
         
         $rel=array();
         foreach ($allowances as $key ) {
            $n='allowances_'.$key['id'];
            $n=$request->$n;
            $a=$n[$i];
            

            if($a!='')
            {
            $pivot=array('amount' => $a  );

                $let=array( $key['id'].'' =>$pivot );

                $rel=$rel+$let;

                // if($no < count($transections))
                //    $trans=$transections[$no];
                //    else
                //    $trans=new Transection;
                //    $trans->account_voucherable_id=$salary->id;
                //    $trans->account_voucherable_type='App\Models\Salary';
                //    $trans->account_id=$acc;
                //    //$trans->corporate_id=$item['id'];
                //    $trans->remarks=$emp['employee']['name'].' '.$key['text'].' Allowance Month: '.$salary['month'];
                //    $trans->debit=0;
                //    $trans->credit=$a;
                //    $trans->save();
                //    $no++;
            }

                                
          }
          //$emp->allowances()->sync($rel);

          //$rel=array();
         foreach ($deductions as $key ) {
            $n='deductions_'.$key['id'];
            $n=$request->$n;
            $a=$n[$i];
            

            if($a!='')
            {
            $pivot=array('amount' => $a  );

                $let=array( $key['id'].'' =>$pivot );

                $rel=$rel+$let;
                 
                 // if($no < count($transections))
                 //   $trans=$transections[$no];
                 //   else
                 //   $trans=new Transection;
                 //   $trans->account_voucherable_id=$salary->id;
                 //   $trans->account_voucherable_type='App\Models\Salary';
                 //   $trans->account_id=$acc;
                 //   //$trans->corporate_id=$item['id'];
                 //   $trans->remarks=$emp['employee']['name'].' '.$key['text'].' Deduction Month: '.$salary['month'];
                 //   $trans->debit=$a;
                 //   $trans->credit=0;
                 //   $trans->save();
                 //   $no++;
            }

                                
          }
          $emp->deductions()->sync($rel);
           
           
             //print_r( $emp->penality_charges );die;
           // if($emp->penality_charges != '' && $emp->penality_charges > 0)
           //         {
           //          if($no < count($transections))
           //         $trans=$transections[$no];
           //         else
           //          $trans=new Transection;
           //         $trans->account_voucherable_id=$salary->id;
           //         $trans->account_voucherable_type='App\Models\Salary';
           //         $trans->account_id=$acc;
           //         //$trans->corporate_id=$item['id'];
           //         $trans->remarks=$emp['employee']['name'].' Penality charges month: '.$salary['month'];
           //         $trans->debit=$emp->penality_charges;
           //         $trans->credit=0;
           //         $trans->save();
           //         $no++;
           //         }

                   if($emp->tax != '' && $emp->tax > 0)
                   {
                   //  if($no < count($transections))
                   // $trans=$transections[$no];
                   // else
                   //  $trans=new Transection;
                   // $trans->account_voucherable_id=$salary->id;
                   // $trans->account_voucherable_type='App\Models\Salary';
                   // $trans->account_id=$acc;
                   // //$trans->corporate_id=$item['id'];
                   // $trans->remarks=$emp['employee']['name'].' Income Tax deduction month: '.$salary['month'];
                   // $trans->debit=$emp->tax;
                   // $trans->credit=0;
                   // $trans->save();
                   // $no++;
                    
                    if($no < count($transections))
                   $trans=$transections[$no];
                   else
                   $trans=new Transection;
                   $trans->account_voucherable_id=$salary->id;
                   $trans->account_voucherable_type='App\Models\Salary';
                   $trans->account_id=273;
                   //$trans->corporate_id=$item['id'];
                   $trans->remarks=$emp['employee']['name'].' Income Tax deduction month: '.$salary['month'];
                   $trans->debit=0;
                   $trans->credit=$emp->tax;
                   $trans->save();
                   $no++;

                   }

           

        }
//die;
               
        for($k=$no; $k < count($transections); $k++ )
           {
               $transections[$k]->delete();
           }

        return redirect()->back()->with('success','Salary Updated!');
    }

     public function generate_salaries(Request $request)
    {
            $salary_month=$request->salary_month;
             
             $month_year=explode("-",$salary_month);
           
            $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
            
            $emps=Employee::where('activeness','like','active')->orderBy('created_at','asc')->get();

            $employees=array();

            $total_basic_salary=0;
            $total_gross_salary=0;

            foreach ($emps as $emp) {

                //$attendance_profile=$emp->monthly_profile($salary_month);
                      //die;
                $profile=$this->getProfile($salary_month,$emp['id']);

                 //$employee=array('id'=>$emp['id'],'name'=>$emp['name'],'salary'=>$emp['salary'],'presents'=>$presents, 'leave_absent_deduction' => $leave_absent_deduction ,'penality_charges'=>$p_charges,'late_count'=>$late_count,'late_charges'=>$late_count_deduct,'overtime_hours'=>$month_overtime_hours, 'overtime_charges'=>$overtime_charges,'allowance_amount'=>$allowance_amount,'gross_salary'=>$t_salary);
                 //print_r($employee);die;

                $emp_salary=$profile['employee']['salary'];
                $emp_total_salary=$profile['profile']['total_salary'];

                $total_basic_salary+=$emp_salary;
            $total_gross_salary+=$emp_total_salary;
                 
                array_push($employees,$profile);
                //if($i>)
            //return view('salary.salaryMonth',compact('employees','salary_month'));
            }//end loop for employes

            // print_r($employees);die;

            return view('salary.salaryMonth',compact('employees','salary_month','total_basic_salary','total_gross_salary'));
    }

     public function getProfile($month,$employee_id)
    {
        //$month=$request->get('month');
        //$month='2021-01';
        //$emp=$request->get('employee');
        $employee=Employee::find($employee_id);

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
                   //print_r($month_overtime_count);die;
                  // month_late_comings_count
                  $month_late_comings_count=$employee->month_late_comings_count($month);
                   // end month_late_comings_count
                   $per_d=$employee->per_day_salary($month);

                    $month_late_comings_amount=round( intval($month_late_comings_count/4)*$per_d );
                  // month_working_hours
                  $month_working_hours=$employee->month_working_hours($month);
                   // end month_working_hours
                   $total_salary=$employee['salary']-($monthly_leave_deduction+$penality_amount+$month_late_comings_amount)+($allowance_amount+$month_overtime_amount);
                  //$total_salary=0;
              $detail=array('monthly_attendance_status_count'=>$monthly_attendance_status_count,
                'allocated_leave_count'=>$allocated_leave_count,
                'availed_leave_count'=>$availed_leave_count,
                'current_availed_leave_count'=>$current_availed_leave_count,
                'monthly_leave_deduction' => $monthly_leave_deduction,
                'allowances'=> $allowances,
                'allowance_amount'=> $allowance_amount,
                'penalities'=> $penalities,
                'penality_amount'=> $penality_amount,
                'month_overtime_count'=>$month_overtime_count,
                'month_overtime_amount'=>$month_overtime_amount,
                'month_working_hours'=> $month_working_hours,
                'month_late_comings_count'=>$month_late_comings_count,
                'month_late_comings_amount'=>$month_late_comings_amount,
                'total_salary'=>$total_salary,
            ); 
            }
            
            $profile=array('employee'=>$employee,'profile'=>$detail);

        return $profile;
    }

    public function generate_salaries1(Request $request)//old salaries
    {
            $salary_month=$request->salary_month;
             
             $month_year=explode("-",$salary_month);
           
            $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
            
            $emps=Employee::where('activeness','like','active')->orderBy('created_at','asc')->get();

            $employees=array();

            foreach ($emps as $emp) {

                $attendance_profile=$emp->monthly_profile($salary_month);
                      //die;
                $perDay= (int) $emp['salary'] / (int) $days; //per day salary
                 
                 $presents=$attendance_profile['count']['presents']+$attendance_profile['count']['offdays']+$attendance_profile['count']['alter_offdays'];  
                 $absents=$attendance_profile['count']['absents'];              
                   $leaves=$attendance_profile['count']['leaves'];
               
               //start leave deduction amount
                  $leave_types=Configuration::leave_types();
                  $leave_deduct_amount=0;
                  $absent_deduct_amount=0;
                   foreach ($leave_types as $key) {
                     
                     if(isset($leaves[$key['id'].'_']) && $leaves[$key['id'].'_'] > 0 )
                         {
                     //$allowed = json_decode( $emp->shift['leave_types'][0]['pivot']['attributes'] )->allowed_leave;
                     $allowed=json_decode( $emp->shift->leave_types->where('id',$key['id'])->first()->pivot->attributes )->allowed_leave ;

                      $w8 = json_decode( $emp->shift->leave_types->where('id',$key['id'])->first()->attributes )->deduction_amount ;


                      $let_amount=( $leaves[$key['id'].'_'] - $allowed ) * ( $perDay * ( $w8 / 100 ) );
                      if($let_amount>0)
                     $leave_deduct_amount+=$let_amount;
                     //print_r( $key['id'].'  '.$leave_deduct_amount ); 
                        }

                    
                 }
                //start absent deduction amount
                    
                    if($absents > 0)
                    {

                    $casual=Configuration::leave_types()->where('id',3)->first();
                   
                    $allowed = json_decode( $emp->shift['leave_types'][$casual['id']]['pivot']['attributes'] )->allowed_leave;
                    
                     
                      $w8 = json_decode( $casual['attributes'] )->deduction_amount ;

                      $casual_leave=$leaves[$casual['id'].'_'] ;
                         $rem_allowed=$allowed-$casual_leave;
                         $let_amount= 0 ;
                         if( $rem_allowed > 0 && ($absents - $rem_allowed) >0 )
                         {
                            $let_amount=( $absents - $rem_allowed ) * ( $perDay * ( $w8 / 100 ) );
                         }
                         elseif($rem_allowed > 0 && ($absents - $rem_allowed) < 0)
                         {
                            $let_amount= 0 ;
                         }
                         else
                         {
                               $let_amount=( $absents ) * ( $perDay * ( $w8 / 100 ) );
                         }

                         $absent_deduct_amount+=$let_amount;

                     }

                $leave_absent_deduction=round($absent_deduct_amount+$leave_deduct_amount);
             

                  $ps=$emp->month_penalities($salary_month);
                  $p_charges=0;//penality charges
                  foreach ($ps as $p) {
                      $p_charges+=$p['amount'];
                  }


                   //Monthly late comings
                $lates=$emp->month_late_comings($salary_month);
                   $late_count= count($lates);
                   $late_count_deduct=round ( ($perDay)*(intdiv( $late_count,4) ) );

                   //Monthly overtime

                     $month_overtime_days=$emp->month_overtime_days($salary_month);
                         //print_r(count($emp->month_overtime_days($salary_month)));die;
                     $month_overtime_mins=$emp->month_overtime_mins($salary_month);
                     //print_r($month_overtime_days);
                            $month_overtime_hours=round( $month_overtime_mins/60 , 2 );

                            $overtime_charges=round( ($month_overtime_hours)*($perDay/8)  );           

                    //end Monthly overtime 

                            //allowance

                            $allowance_amount=0;
                           // print_r(count($emp->allowances));die;
                            foreach ($emp->allowances as $all) {
                                $type=$all['pivot']['type'];
                                $amount=$all['pivot']['amount'];

                                if($type=='fixed')
                                {
                                    $allowance_amount+=$amount;
                                }
                                else
                                {
                                    $allowance_amount+=($amount/100)*$emp['salary'];
                                }


                            }
                            //print_r($allowance_amount) ;die;
                            //end allowances
                //$t_salary=round($emp['salary']-($perDay*$un)-$p_charges-$late_count_deduct+$overtime_charges );
                $t_salary=round((int) $emp['salary']-$leave_absent_deduction-$p_charges-$late_count_deduct+$overtime_charges +$allowance_amount);

                 $employee=array('id'=>$emp['id'],'name'=>$emp['name'],'salary'=>$emp['salary'],'presents'=>$presents, 'leave_absent_deduction' => $leave_absent_deduction ,'penality_charges'=>$p_charges,'late_count'=>$late_count,'late_charges'=>$late_count_deduct,'overtime_hours'=>$month_overtime_hours, 'overtime_charges'=>$overtime_charges,'allowance_amount'=>$allowance_amount,'gross_salary'=>$t_salary);
                 //print_r($employee);die;
                 
                array_push($employees,$employee);
            
            }//end loop for employes

            // print_r($employees);die;

            return view('salary.salaryMonth',compact('employees','salary_month'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
