<?php

namespace App\Imports;

use App\Models\Attendance;
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
         $date_time=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(  $row['datetime'] );
         //$date=$date_time->format('Y-m-d');
         //$time=$date_time->format('H:i:s');
         //$date1=$date->format('Y-m-d H:i:s');
        //$date1=explode(' ', $date);
        // print_r( $date_time ); die;
        //  $att=Attendance::where('name','like',''.$row['name'])->where('date','like',$date)->where('status','like',$row['status'])->get();

        //  foreach ($att as $at) {
        //      $t =explode(":",  $at['time'] ) ;
        //     // $time1=$date_time->format('H:i:s',mktime($t[0],$t[1],$t[2],0,0,0));
        //      //$mins = ($time - $time1) ;
        //          //$mins=$time1->diff(new DateTime());
        //      //print_r($mins); die;

        //      $time1 = new DateTime($at['time']);
        //         $time2 = new DateTime($time);
        //           //$interval = $time1->diff($time2);
        //           //echo $interval->format('%s second(s)');
        //           //print_r($interval); die;




        //  }


        return new Attendance([
            'department'     => $row['department'],
            'name'    => $row['name'], 
            'no'    => $row['no'], 
            'date'    =>  $date_time->format('Y-m-d'),
            'time'    =>  $date_time->format('H:i:s'), 
            'status'    => $row['status'], 
        ]);
    }
}
