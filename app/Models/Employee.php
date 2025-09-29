<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Date_Leave;

class Employee extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne('App\Models\User','employee_id');
    }

    public function reporting_manager()
    {
        return $this->belongsTo('App\Models\Employee','super_employee');
    }

    public function sub_employees()
    {
        return $this->hasMany('App\Models\Employee','super_employee','id');
    }

    public function points()
    {
        return $this->hasMany(Point::class , 'salesman_id' , 'id');
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class , 'salesman_id' , 'id');
    }

    public function sales()
    {
        return $this->hasMany('App\Models\Sale','salesman_id','id');
    }

    public function estimate_commission($customer_id,$item_id)
    {
        
    
      $value=array('type'=>'' ,'value'=>'');
      $com=Commission::where('salesman_id',$this->id)->where('customer_id',$customer_id)->first();

      $customer=Customer::find($customer_id);
      if($com=='' && $customer['territory_id']!='') //start for areas
      $com=Commission::where('salesman_id',$this->id)->where('territory_id',$customer['territory_id'])->first();

      if($com=='' && $customer['city_id']!='') 
      $com=Commission::where('salesman_id',$this->id)->where('city_id',$customer['city_id'])->first();

    if($com=='' && $customer['district_id']!='') 
      $com=Commission::where('salesman_id',$this->id)->where('district_id',$customer['district_id'])->first();

    if($com=='' && $customer['region_id']!='') 
      $com=Commission::where('salesman_id',$this->id)->where('region_id',$customer['region_id'])->first();

    if($com=='' && $customer['state_id']!='') 
      $com=Commission::where('salesman_id',$this->id)->where('state_id',$customer['state_id'])->first();

    if($com=='' && $customer['country_id']!='') 
      $com=Commission::where('salesman_id',$this->id)->where('country_id',$customer['country_id'])->first();
     

      if($com=='')
        $com=Commission::where('salesman_id',$this->id)->first();

         if($com=='')
          return $value;

        $item=$com->items->where('id',$item_id)->first(); //print_r($item);die;
     
        if($item!='')
          {    
             
          $value=array('type'=>$item['pivot']['type'] ,'value'=>$item['pivot']['value']);
            
          }
          else
          {

             $value=array('type'=>$com['type'] ,'value'=>$com['value']);
          }
          
       return $value;
    }

    public function sub_employees1()
    {
        $employees=array();
         


    }

    public function sales1()
    {    $id=$this->id;
          $emps=Employee::where(function($q) use($id){
                
              $q->where('id',$id);

          })->get();

         $sales=Sale::where('salesman_id',$this->id)->get();
        return $sales;
    }


    public function account()
    {
        return $this->belongsTo('App\Models\Account','account_id');
    }


    public static function active_employees()
    {
        
        
        $emps = Employee::where('status','1')->orderBy('created_at', 'asc')->get();
        return $emps;        
    }

    public static function sales_man()
    {
        
        $emps = Employee::where('is_so',1)->where('status','1')->orderBy('name', 'asc')->get();
          return $emps; 
    }

    public function customers()
    {
        return $this->hasMany('App\Models\Customer','so_id');
    }

     public function salaries()
    {
        return $this->hasMany('App\Models\employee_salary','employee_id','id');
    }

    public function salary($month)
    {
      $s=employee_salary::where('employee_id',$this->id)->first();
        
        return $s;
    }

     public function loans()
    {
        return $this->hasMany('App\Models\Loan','employee_id','id');
    }

    public function estimate_loan_deduction($month)
    {
        $id=$this->id;
        $total=loan_installment::whereHas('loan',function($q) use($id){
            $q->where('employee_id',$id);
        })->where('month',$month)->sum('amount');
         
        return $total;
    }



    public function overtimes()
    {
        return $this->hasMany('App\Models\Overtime','employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function daily_attendances()
    {
        return $this->hasMany('App\Models\DailyAttendance','employee_id','id');
    }
    
    public function attendance_days_count($month)
    {
      $statuses=AttendanceStatus::where('leave_type_id',null)->where('id','<>','2')->where('status','1')->pluck('id');

      $month_year=explode("-",$month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
   
        $f_month=$month.'-01';   //first date of month
        $l_month=$month.'-'.$days;   //last date of month

        //$att=$this->employee_monthly_attendance($month);
        $ps=$this->daily_attendances->whereBetween('date',[$f_month,$l_month])->whereIn('status',$statuses)->count();
        //$att=$this->daily_attendances->whereBetween('date',[$f_month,$l_month])->whereNotIn('status',$statuses)->count();
       
         $statuses=AttendanceStatus::where('leave_type_id','<>',null)->where('id','<>','2')->where('status','1')->pluck('id');
         $sts=AttendanceStatus::where('leave_type_id','<>',null)->where('id','<>','2')->where('status','1')->get();

         $leaves=$this->daily_attendances->whereBetween('date',[$f_month,$l_month])->whereIn('status',$statuses);
          $p_month=date('Y-m-d', strtotime('-1 day', strtotime($f_month)));

          if($this->shift=='')
               return ;
          $allocated_leave_count=$this->allocated_leave_count($month);
         $monthly_attendance_status_count =$this->monthly_attendance_status_count($month);
      //print_r(json_encode($monthly_attendance_status_count));die;
          foreach ($sts as $key ) {
             
             $count=$this->status_count($key,'2021-01-01',$p_month);

             $total=$allocated_leave_count[$key['leave_type_id'].'_allocated_leave'];

             $rem=$total - $count ;
             $m=$monthly_attendance_status_count[$key['id'].'_att_status'];

             if($rem<0)
               {  continue; }
              
             

             $let=$rem-$m;

             if($let > 0)
              { $ps+=$m; }

            if($let < 0)
              { $ps+=($let * -1 ) ; }


          }

           //print_r(json_encode($statuses));die;

          
          

       return $ps;
       //print_r(json_encode($att));die;
    }

    public function status_count($status_id,$from,$to)
    {
           return $this->daily_attendances->whereBetween('date',[$from,$to])->where('status',$status_id)->count();
    }



    public function employee_daily_attendance($date) //employee att of a day
    {
    
       $att=$this->daily_attendances->where('date','like',$date)->first();
     
      
           //print_r(json_encode($att));die;
       $in_time=''; $out_time=''; $status=''; $status_id='none'; $status_text=''; $status_code='';
             if($att!='' )
             {
             $in=$att['attendances']->where('status','like','C/In')->first();
             $out=$att['attendances']->where('status','like','C/Out')->first();
              
              $att_p_status=AttendanceStatus::where('text','like','present')->first();

             if($in!='' )
                $in_time=$in['time']; $status=$att_p_status['id'];
            if($out!='')
                $out_time=$out['time']; $status='present';
        //print_r(json_encode($att));die;
            if($att['status']!='' && $att['status']!='none')
            {
                $status=$att['status'];

                if($att['status']!='none')
                {
                $sta=AttendanceStatus::find($att['status']);
                $status_text=$sta['text'];
                $status_code=$sta['code'];
                 }
                
            }
               
            }

            $attendance=array('date'=>$date,'status_id'=>$status,'status_text'=>$status_text,'status_code'=>$status_code,'in_time'=>$in_time,'out_time'=>$out_time);

            return $attendance;

    }

    public function employee_monthly_attendance($month) //employee att of a month
    {
          $month_year=explode("-",$month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
    
        $f_month=$month.'-01';   //first date of month
        $l_month=$month.'-'.$days;   //last date of month
        
        $attendances=array();

        for ($i=0; $i < $days ; $i++) { 
             
             $date=date('Y-m-d',strtotime($f_month . "+".$i." days"));

             $att=$this->employee_daily_attendance($date);
             array_push($attendances, $att);
        }

        return $attendances;
    }

    public function employee_attendance_from_to($f_date,$l_date) //employee att from date to date
    {        
        $attendances=array();
           
           $i=0;
        while (true) { 
             
             $date=date('Y-m-d',strtotime($f_date . "+".$i." days"));

             $att=$this->employee_daily_attendance($date);
             array_push($attendances, $att);

             if($date==$l_date)
              break;
            $i++;
        }

        return $attendances;
    }

    //start attendance status count of emp with attendance status id as key
    public function monthly_attendance_status_count($month) 
    {
        $month_year=explode("-",$month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
    
        $f_month=$month.'-01';   //first date of month
        $l_month=$month.'-'.$days;   //last date of month
          
          $statuses=AttendanceStatus::where('status','like','1')->orderBy('sort_order','asc')->get();
          $attendance_status_count=array();
          foreach ($statuses as $status ) {

            $count=$this->daily_attendances->whereBetween('date',[$f_month,$l_month])->where('status','like',$status['id'])->count();
            $let=array($status['id'].'_att_status'=>$count);
            $attendance_status_count=array_merge($attendance_status_count,$let);
          }

           $count=$this->daily_attendances->whereBetween('date',[$f_month,$l_month])->where('status','like','none')->count();
           $count1=$this->daily_attendances->whereBetween('date',[$f_month,$l_month])->count();
           $total=$days-$count1+$count;
            $let=array('none'=>$total);
            $total_days=array('total_days'=>$days);
            $attendance_status_count=array_merge($attendance_status_count,$let);
            $attendance_status_count=array_merge($attendance_status_count,$total_days);
        //end attendance statuses count

          return $attendance_status_count;

    }//end attendance status count with attendance status id as key

    

    public function penalities()
    {
        return $this->hasMany('App\Models\Penality');
    }

    public function month_penalities($month)
    {
        return $this->penalities->where('month','like',$month);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function leaveadjustments()
    {
        return $this->hasMany(Leaveadjustment::class);
    }




    public function allocated_leave_count($month) //allocated_leave_count with leave id as key
    {
           $leave_types=$this->shift->leave_types;
           $allocated_leave_count=array();
           foreach ($leave_types as $type) {

              $count=$type['pivot']['allowed_leave'];
              
              $adjustments=$this->leaveadjustments->where('leave_type_id','like',$type['id'])->where('adjustment_month','like',$month);
              foreach ($adjustments as $adjust) {
                  $count+=$adjust['adjust_days'];
              }

              $let=array($type['id'].'_allocated_leave'=>$count);
            $allocated_leave_count=array_merge($allocated_leave_count,$let);
           }
           return $allocated_leave_count;
       

    } //end allocated_leave_count with leave id as key

    public function availed_leave_count($month) //availed_leave_count with leave id as key
    {

           $leave_types=$this->shift->leave_types;
           $availed_leave_count=array();
           foreach ($leave_types as $type) {

            $allocated_leave=$type['pivot']['allowed_leave'];
            $leave_type=$type['type'];
  //print_r($leave_type);die;
            $statuses=AttendanceStatus::where('leave_type_id',$type['id'])->get();
            $end_date=''; $start_date='';
                   if($leave_type=='yearly')
                    {
                        $month_year=explode("-",$month);
                        $start_date=$month_year[0].'-01-01';
                        $end_date=$month_year[0].'-12-31';
                    }
                    elseif($leave_type=='monthly')
                        {
                            $month_year=explode("-",$month);
                            $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
                            $start_date=$month.'-01';
                            $end_date=$month.'-'.$days;
                        }
                    $count=0;
            foreach ($statuses as $st ) {

               $count+=$this->daily_attendances->whereBetween('date',[$start_date,$end_date])->where('status','like',$st['id'])->count();
               //print_r($count);die;
            }
              $let=array($type['id'].'_availed_leave'=>$count);
            $availed_leave_count=array_merge($availed_leave_count,$let);
           }
           return $availed_leave_count;


    } //end availed_leave_count with leave id as key

    public function current_availed_leave_count($month) //current availed_leave_count with leave id as key
    {

           $leave_types=$this->shift->leave_types;
           $availed_leave_count=array();
           foreach ($leave_types as $type) {

            $allocated_leave=$type['pivot']['allowed_leave'];
            $leave_type=$type['type'];
  //print_r($leave_type);die;
            $statuses=AttendanceStatus::where('leave_type_id',$type['id'])->get();
            $end_date=''; $start_date='';
                   
                    
                $month_year=explode("-",$month);
            $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
                            $start_date=$month.'-01';
                            $end_date=$month.'-'.$days;
                        
                    $count=0;
            foreach ($statuses as $st ) {

               $count+=$this->daily_attendances->whereBetween('date',[$start_date,$end_date])->where('status','like',$st['id'])->count();
               //print_r($count);die;
            }
              $let=array($type['id'].'_current_leave'=>$count);
            $availed_leave_count=array_merge($availed_leave_count,$let);
           }
           return $availed_leave_count;


    } //end current availed_leave_count with leave id as key

    public function per_day_salary($month)
    {
      $salary=$this->salary;
      if($salary=='')
        $salary=0;
         $month_year=explode("-",$month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
          $perDay= round( ($salary / $days) ,  2 );
        return $perDay;
    }

    public function monthly_leave_deduction($month,$monthly_attendance_status_count,$allocated_leave_count,$availed_leave_count,$current_availed_leave_count) 
    {
           //$monthly_attendance_status_count=$this->monthly_attendance_status_count($month);
           //$allocated_leave_count=$this->allocated_leave_count($month);
           //$availed_leave_count=$this->availed_leave_count($month);
           //$current_availed_leave_count=$this->current_availed_leave_count($month);
           $attendance_statuses=AttendanceStatus::where('status','1')->orderBy('sort_order','asc')->get();
           $types=LeaveType::where('status','1')->get();
           foreach ($types as $key ) {
               $avail=$availed_leave_count[$key['id'].'_availed_leave'];
               $current=$current_availed_leave_count[$key['id'].'_current_leave'];
               $allocated=$allocated_leave_count[$key['id'].'_allocated_leave'];
               $deduction=0;
               //print_r($allocated.' '.$avail.' '.$current);die;
            if($key['type']=='yearly')
            {
               $rem=$allocated- $avail-$current;
               $rem=$rem-$current;
               
            }
            elseif($key['type']=='monthly')
            {
               $rem=$allocated-$avail;
               
            }

            if($rem<0)
               {
                    $deduction+=($rem*-1) * ($key['deduction_amount']/100) * $this->per_day_salary($month);
               }
               
           }

           return intval($deduction);
    }

    public function month_working_hours($month)
    {


        $month_year=explode("-",$month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
    
        $f_month=$month.'-01';   //first date of month
        $l_month=$month.'-'.$days;   //last date of month
    
        $total_working_hours=0;

        for ($i=0; $i < $days ; $i++) { 
            $date=date('Y-m-d',strtotime($f_month . "+".$i." days"));
        
             $in_time=''; $out_time=''; $status='';
            $att=DailyAttendance::where('employee_id','like',$this->id)->where('date','like',$date)->first();
            $diff1='00:00:00'; $diff2=0;
            if($att!='')
            {
            $in=Attendance::where('dailyattendance_id','like',$att['id'])->where('status','like','C/In')->first();
            $out=Attendance::where('dailyattendance_id','like',$att['id'])->where('status','like','C/Out')->first();
            if($in!='')
                {$in_time=$in['time'];}
            if($out!='')
                {$out_time=$out['time'];}
    
           
           
           if( $in!='' && $out!='' )
           {
             $time=strtotime($in_time);
             $time1=strtotime($out_time);
           
             $diff1=date("H:i:s",($time1-$time) );
             $diff2= round( (($time1-$time)/60)/60 ,2 );
            }
            $total_working_hours+=$diff2;
           }
            
             $total_working_hours=round($total_working_hours,2);        
        } 

        return $total_working_hours;
           
    }// end month working hours

    public function month_late_comings($month)
    {   
      if($this->shift=='')
        return [];
        $startTime=$this->shift->start_time;
        $rel=$this->shift->relaxation;
       // $endTime=strtotime("+".$rel." minutes", strtotime($startTime));
        //$end_hour =   date('h', $endTime );
        //$end_min =   date('i', $endTime );
             //echo date('h:i:s', $endTime);
        //print_r($rel.' '.$startTime.' '.$endTime);die;
        $late_time=date('H:i:s',strtotime("+".$rel." minutes", strtotime($startTime)));
        //$late_time=date('H:i:s',mktime($end_hour,$end_min,0,0,0,0));
        $month_year=explode("-",$month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
        $f_month=$month.'-01';
        $l_month=$month.'-'.$days;
        //print_r($late_time);die;
           $emp_id=$this->id;
        $attendances=Attendance::with('DailyAttendance')->whereHas('DailyAttendance', function($query) use ($f_month,$l_month,$emp_id) {
        $query->where('employee_id','like',$emp_id)->whereBetween('date',[$f_month,$l_month]);
    })->where('time','>',$late_time)->where('status','like','C/In')->get();

        //print_r(count( $attendances )   );die;
        
        return $attendances;
        
    }

    public function month_late_comings_count($month)
    { 
        return count($this->month_late_comings($month) );
    }

    public function month_overtime_days($month)
    {
    //     $over_time=date('H:i:s',mktime(17,30,0,0,0,0));
        $month_year=explode("-",$month);
         $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
         $f_month=$month.'-01';   //first date of month
         $l_month=$month.'-'.$days;   //last date of month
       
    //     //$over_time_days=$this->attendances->whereBetween('date',[$f_month,$l_month])->where('time','>',$over_time)->where('status','like','C/Out');
    //          $zk_id=$this->zk_id;
    //     $over_time_days=Attendance::with('DailyAttendance')->whereHas('DailyAttendance', function($query) use ($f_month,$l_month,$zk_id) {
    //     $query->where('name','like',$zk_id)->whereBetween('date',[$f_month,$l_month]);
    // })->where('time','>',$over_time)->where('status','like','C/Out')->get();

      $over_time_days=$this->overtimes->whereBetween('overtime_date',[$f_month,$l_month]);

        return $over_time_days;
        
    }

    public function month_overtime_hours($month)
    {
             $days=$this->month_overtime_days($month);

             $total_hours=0;

             foreach ($days as $day) {
                $total_time=$day['total_time'];
                 $time=explode(':', $total_time);
                 $hours=$time[0];
                 $mins=$time[1];

                 $total_hours +=$hours + ($mins/60);
             }
             $total_hours=round($total_hours,2);
          
             return  $total_hours;
    }

    public function month_overtime_mins($month)
    {
        $overtime_days=$this->month_overtime_days($month);

        //$over_time=date('H:i:s',mktime(17,0,0,0,0,0));

         $over_time_point=strtotime('17:00:00');
        
        $over_time=0;
        foreach ($overtime_days as $o) {
           // $min=$o['time']-$over_time;date("Y-m-d",strtotime($p_from_date.'+1 days'));
               //print_r(json_encode( $o ));
             //$min=date("H:i:s",strtotime($o['time']));
             $emp_time=strtotime($o['time']);
             $time=($emp_time-$over_time_point)/60;

             $over_time+=$time;

        }
           //print_r($over_time);die;
        return $over_time;
        
    }

    public function allowances()
    {
        
        return $this->belongsToMany(Allowance::class,'allowance_employee')->withPivot('type', 'amount')->withTimestamps()->where('allowances.type','allowance');
    }

    public function deductions()
    {
        
        return $this->belongsToMany(Allowance::class,'allowance_employee')->withPivot('type', 'amount')->withTimestamps()->where('allowances.type','deduction');
    }


    public function leaves()
    {
         return $this->hasMany('App\Models\Leave');
    }
         public function monthly_profile_count($month) //not in + not out 
    {
        $month_year=explode("-",$month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
    
        $f_month=$month.'-01';   //first date of month
        $l_month=$month.'-'.$days;   //last date of month

         $id=$this->id;
              
              $leave_types=Configuration::leave_types();
           
           $count=array();
        foreach ($leave_types as $key ) {
            $t_id=$key['id'];
         $leave_days_count=Date_Leave::with('leave','leave.employee')->whereHas('leave', function ($query) use($t_id)             {
                         return $query->where('leave_type_id', $t_id);
                                    })->whereHas('leave.employee', function ($query) use($id) {
                         return $query->where('employee_id', $id);
                                    })->whereBetween('leave_date', [$f_month,$l_month])->count();

                                   $let=array( $t_id.'_'=>$leave_days_count );

                                   $count=array_merge($count,$let);
               }

        print_r($count);die;
    }
    public function monthly_profile1($month) //not in + not out 
    {
        $month_year=explode("-",$month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
    
        $f_month=$month.'-01';   //first date of month
        $l_month=$month.'-'.$days;   //last date of month

            $shift_offDays= explode(',', $this->shift->offdays);
            $shift_alterOffDays= explode(',', $this->shift->alter_offdays);
            $count_alter=0;
             
             $presents=array();
             $absents=array();
             $leaves=array();
             $offdays=array();
             $alter_offdays=array();

             $leaves_count=array();

              $leave_types=Configuration::leave_types();

              foreach ($leave_types as $key) {
                
                  $let=array( $key['id'].'_' => 0 );

                  $leaves_count=array_merge($leaves_count, $let );
              }

         for ($i=1; $i <= $days  ; $i++) { 

              $month_day=date('Y-m-d',mktime(0,0,0,$month_year[1],$i,$month_year[0]));

            $in=$this->attendances()->where('date','like',$month_day)->where('status','like','C/In')->first();

            $out=$this->attendances()->where('date','like',$month_day)->where('status','like','C/Out')->first();
            
            if($in!='' || $out!='')
            {
               $presents = array_merge($presents,  array($month_day => 'P') );
            }
            else  //
            {  
                   $day=strtolower( date('l',mktime(0,0,0,$month_year[1],$i,$month_year[0])) );
                
                     
                    if(in_array($day, $shift_offDays))
                    {
                
                         $offdays = array_merge($offdays,  array($month_day => $day) );  
                              
                     }
                     elseif(in_array($day, $shift_alterOffDays))
                     {
                                  if($count_alter<2)
                                    {
                                        $alter_offdays = array_merge($alter_offdays,  array($month_day => 'Alternate '.$day) ); 
                                          $count_alter++;
                                    }
                                    else
                                    {
                                        
                                        $count_alter++;

                                        $leave=$this->leaves()->whereHas('leave_dates', function ($query) use($month_day) {
                         return $query->whereDate('leave_date', $month_day);
                                    })->first();
                        if($leave!='')
                             {
                        $let=array('date'=>$month_day,'leave_type_id'=>$leave['leave_type_id'],'leave_type'=>$leave['leave_type']['value']);
                       // return $let;
                        array_push($leaves, $let);
                            }
                            else
                            {
                                $absents = array_merge($absents,  array($month_day => 'A') ); 
                            }
                                    }
                         
                     }
                     else
                     {  

                        $leave=$this->leaves()->whereHas('leave_dates', function ($query) use($month_day) {
                         return $query->whereDate('leave_date', $month_day);
                                    })->first();

                        if($leave!='')
                             {
                        $let=array('date'=>$month_day,'leave_type_id'=>$leave['leave_type_id'],'leave_type'=>$leave['leave_type']['value']);
                        $leaves_count[ $leave['leave_type_id'].'_' ] ++  ;
                       // return $let;
                        array_push($leaves, $let);
                            }
                            else
                            {
                                $absents = array_merge($absents,  array($month_day => 'A') ); 
                            }
                        //print_r($leave);die;
                     }
            }
           

         }
         
         $count=array('leaves'=>$leaves_count, 'presents'=>count($presents), 'offdays'=>count($offdays),'alter_offdays'=>count($alter_offdays),'absents'=>count($absents) );
         $days=array('presents'=>$presents, 'offdays'=>$offdays, 'alter_offdays'=>$alter_offdays, 'leaves'=>$leaves,'absents'=>$absents );

         return array('days'=>$days , 'count'=> $count) ;
          // print_r($count);
           // print_r($leaves_count);
          // print_r($offdays);
          // print_r($alter_offdays);
           //print_r($leaves);
          // print_r($absents);
           //die;

    }
   public function monthly_presents_count($month) //not in + not out 
    {
        $month_year=explode("-",$month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
        $f_month=$month.'-01';   //first date of month
        $l_month=$month.'-'.$days;   //last date of month
            
            $presents=0;

            for ($i=1; $i <= $days  ; $i++) { 
    
              $month_day=date('Y-m-d',mktime(0,0,0,$month_year[1],$i,$month_year[0]));

            $in=$this->attendances()->where('date','like',$month_day)->where('status','like','C/In')->get();

            $out=$this->attendances()->where('date','like',$month_day)->where('status','like','C/Out')->get();

            if(count($in)!=0 || count($out)!=0)
                {$presents++;}

        }
           return $presents;
            

    }
   public function monthly_absents($month) //not in + not out 
    {
        $month_year=explode("-",$month);
        $days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);
        $f_month=$month.'-01';   //first date of month
        $l_month=$month.'-'.$days;   //last date of month
            
            $absents=0;

            $offDays= explode(',', $this->shift->offdays);
            $alterOffDays= explode(',', $this->shift->alter_offdays);
            $count_alter=0;

        for ($i=1; $i <= $days  ; $i++) { 
    
              $month_day=date('Y-m-d',mktime(0,0,0,$month_year[1],$i,$month_year[0]));

            $in=$this->attendances()->where('date','like',$month_day)->where(function ($query) {
               $query->where('status','like','C/In')->orWhere('status','like','C/Out');
           })->get();
            //$out=$this->attendances()->where('date','like',$month_day)->where('status','like','C/Out')->first();
            
            if(count($in)==0)
            {
                $day=strtolower( date('l',mktime(0,0,0,$month_year[1],$i,$month_year[0])) );
                    $have=in_array($day, $offDays);
                     
                if(in_array($day, $offDays))
                {
                
                
           
                     }
                     elseif(in_array($day, $alterOffDays))
                     {
                        if($count_alter<2)
                                    {
                                          $count_alter++;
                                    }
                                    else
                                    {
                                        $absents++; $count_alter++;
                                    }
                         
                     }
                     else
                     {
                        $leaves=$this->leaves()->where(function ($query ) use($month_day) {
                      $query->whereDate('from_date',$month_day)->orWhereDate('to_date',$month_day);
                         })->orWhere(function ($query ) use($month_day) {
                            //print_r($leave->from_date.' '.$month_day.' end ');die;
                            $query->whereDate('from_date','<',$month_day)->WhereDate('to_date','>',$month_day);
                         })->get();

                         if(count($leaves)==0)
                         {
                            $absents++;
                         }

                         //print_r($leaves.' '.$month_day.' end ');
                     }

            
            }
           
        }

        
        return $absents;


    }

    public function monthly_leaves($month)
    {
        //$absents=$this->monthly_absents($month);  //overall absents , not in + not out

        $raw_leaves=$this->leaves;
             
             $leaves=array();
        foreach ($raw_leaves as $le) {
            
            if($le['to_date']=='')
                     {
                        $type='unpaid';
                        if($le['paid_days']==1)
                            $type='paid';
                       $leave=array('id'=>$le['id'],'leave_type_id'=>$le['leave_type_id'],'leave_type'=>$le['leave_type']['value'],'application_no'=>$le['application_no'],'application_date'=>$le['application_date'],'date'=>$le['from_date'],'status'=>$le['status'],'type'=>$type);
                       array_push($leaves, $leave);
                     }
                     else
                     {
                         $date1=date_create($le['from_date']);
                         $date2=date_create($le['to_date'].'+1 days');
                         $diff=date_diff($date1,$date2,'absolute');
                         $days_diff=$diff->format("%a"); //diff of 2 dates

                         for ($i=0; $i < $days_diff; $i++) { 
                             $date3=date('Y-m-d',strtotime($le['from_date'] . "+".$i." days"));
                                 $type='unpaid';
                                 if($le['paid_days']==null || $i > $le['paid_days'])
                                    $type='unpaid';
                                 elseif($i < $le['paid_days'])
                                    $type='paid';
                             $leave=array('id'=>$le['id'],'leave_type_id'=>$le['leave_type_id'],'leave_type'=>$le['leave_type']['value'],'application_no'=>$le['application_no'],'application_date'=>$le['application_date'],'date'=>$date3,'status'=>$le['status'],'type'=>$type);
                             array_push($leaves, $leave);
                         }

                     }
                     
        }

        return $leaves;

       
    }



    public function monthly_leaves_count($month)
    {
        $leave_types=Configuration::leave_types();
           
           $count=array();
        foreach ($leave_types as $key ) {

            $let_count=$this->leaves->where('leave_type_id',$key['id'])->sum(function($leave) {
                  
                  if($leave->to_date==null)
                    {
                        $diff=1;
                        return $diff;
                    }
                   $diff=date_diff(date_create($leave->from_date),date_create($leave->to_date),'absolute')->format('%a');
                   
                 return $diff+1;
               });
            array_push($count, $let_count);
        }
    
        return  $count;
        
    }

    

    public function monthly_absents_leaves($month)
    {
        $absents=$this->monthly_absents($month);  //overall absents , not in + not out
        $leaves=$this->monthly_leaves($month);  //overall leaves , not in + not out
        $let_leaves=array();
for ($i=0; $i < count($absents) ; $i++) { 
    
    $status='not_avail';
        foreach ($leaves as $key ) {
            
            if($key['date']==$absents[$i])
            {
              $status='avail';
              break;
            }
        }
        if($status=='not_avail')
        {
            $leave=array('id'=>'','leave_type_id'=>'','leave_type'=>'','application_no'=>'','application_date'=>'','date'=>$absents[$i],'status'=>'','type'=>'');
            array_push($let_leaves, $leave);
        }

    }//end for loop

    $leaves=array_merge($leaves,$let_leaves);

    return $leaves;

    }// end function

     public function monthly_absents_leaves_profile($month) //leave w.r.t types 
    {
        $month_year=explode("-",$month);
        $month_days=cal_days_in_month(CAL_GREGORIAN,$month_year[1],$month_year[0]);

        $leave_types=Configuration::where('type','like','leave')->get();

        $total_days=array();   $total_deduct_amount=array();
        foreach ($leave_types as $key ) {
                $l1=[ $key['id'].'_days_'.$key['value'] => 0];
                $l2=[ $key['id'].'_amount_'.$key['value'] => 0 ];
                $l2=[ $key['id'].'_allowed_'.$key['value'] => 0 ];

                $total_days=array_merge($total_days,$l1,$l2);
            }

             $total_days=array_merge($total_days,['absents'=>0]);
            //print_r($total_days);die;
        $monthly_absents_leaves=$this->monthly_absents_leaves($month);
            
            foreach ($monthly_absents_leaves as $key ) {
                  
                  
                  

                if($key['leave_type_id']!='')
                {
                    $allowed = json_decode( $this->shift['leave_types'][0]['pivot']['attributes'] )->allowed_leave;
                 //$e=$total_days[ $key['leave_type_id'].'_allowed_'.$key['leave_type'] ];
                 $total_days[ $key['leave_type_id'].'_allowed_'.$key['leave_type'] ]=$allowed;

//print_r($e);die;
                  $d=$total_days[ $key['leave_type_id'].'_days_'.$key['leave_type'] ];
                 $total_days[ $key['leave_type_id'].'_days_'.$key['leave_type'] ]=$d+1;

                  }
                  else
                  {
                         $total_days['absents']+=1;
                  }
  
                 //print_r($d.' '.$a);die;
            }//end foreach
            $amount_total=0;
            foreach ($leave_types as $key ) {
              
              $allowed=$total_days[ $key['id'].'_allowed_'.$key['value']];
              $days=$total_days[ $key['id'].'_days_'.$key['value']];
              $d_amount=json_decode( $key['attributes'] )->deduction_amount;
               
               $amount_d=0;
               if($days!=0 && ($days-$allowed) >0 )
               {
               $perDay=($this->salary)/$month_days;
               $rem=($days-$allowed)*($perDay*($d_amount/100));
               $amount_d+=$rem;
               
                }
                  $amount_total+=$amount_d;

              $total_days[ $key['id'].'_amount_'.$key['value']]=$amount_d;


           

                //$total_days=array_merge($total_days,$l1,$l2);
            }

            

            $total_amount=array('total_amount'=>$amount_total);
            $total_days=array_merge($total_days,$total_amount);
       return $total_days;  //it will return all types of leave deduction 
        //print_r($total_days);die;


    }

    


}
