<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\DailyAttendance;
use App\Models\AttendanceStatus;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendancesImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
      $date=''; $time='';
               if(strtotime($row['datetime'])){
                    $new_date_format = date('Y-m-d H:i:s', strtotime($row['datetime']));
                            $new_date=explode(" ", $new_date_format);
                        $date=$new_date[0];
                      $time=$new_date[1];
                     }
                     else
                     {
          $dt=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(  $row['datetime'] );
               $date=$dt->format('Y-m-d');
            $time=$dt->format('H:i:s');
             }

             $emp=Employee::where('zk_id',$row['name'])->first();

             if($emp=='')
              return;

                      $att_status=AttendanceStatus::where('text','like','present')->first();
                      $att=DailyAttendance::where('employee_id','like',$emp['id'])->where('date','like',$date)->first();
                      if($att=='')
                      {
                      $att=new DailyAttendance;
                      $att->employee_id=$emp['id'];
                      //$att->name=$row['name'];
                      //$att->no=$row['no'];
                      $att->date=$date;
                      $att->status=$att_status['id'];

                      $att->save();
                      }

                      $a=Attendance::where('dailyattendance_id','like',$att['id'])->where('status','like',$row['status'])->first();
                      if($a=='')
                      $a=new Attendance;
                       $a->dailyattendance_id=$att['id'];
                      $a->time=$time;
                      $a->status=$row['status'];

                      $a->save();

                      return ;
    }
    public function model1(array $row)
    {
          

          //print_r($row['datetime']);die;
            $date=''; $time='';
               if(strtotime($row['datetime'])){
                    $new_date_format = date('Y-m-d H:i:s', strtotime($row['datetime']));
                            $new_date=explode(" ", $new_date_format);
                        $date=$new_date[0];
                      $time=$new_date[1];
                     }
                     else
                     {
          $dt=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(  $row['datetime'] );
               $date=$dt->format('Y-m-d');
            $time=$dt->format('H:i:s');
             }

            $emp=Employee::where('zk_id',$row['name'])->first();

            $att=Attendance::where('employee_id','like',''.$emp['id'])->where('date','like',$date)->where('status','like',$row['status'])->get();
            foreach ($att as $at) {

                 $t =explode(":",  $at['time'] ) ;
                 $time1=date('H:i:s',mktime($t[0],$t[1],$t[2],0,0,0));
                  $mins = (strtotime($time) - strtotime($time1)) / 60 ;
                  
                  if($mins<30)
                  {

                   if(strcmp($row['status'],'C/In'))
                   {
                         return ;
                   }
                   else if(strcmp($row['status'],'C/Out'))
                   {
                      $a=Attendance::find($at['id']);

                      $a->date=$date;
                      $a->time=$time;

                      $a->save();
                        
                         return ;

                   }

                  }
                  //print_r( $mins ); die;
            }

        
           //print_r( $date ); die;


        return new Attendance([
            'department'     => $row['department'],
            'name'    => $row['name'], 
            'no'    => $row['no'], 
            'date'    =>  $date,
            'time'    =>  $time, 
            'status'    => $row['status'], 
        ]);
    }
}
