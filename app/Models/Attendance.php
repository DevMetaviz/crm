<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    
    protected $fillable = ['department','name','no','date','time','status'];

    public function employee()
    {
        //return $this->belongsTo('App\Models\Employee','name','zk_id');
    }

    public function DailyAttendance()
    {
        return $this->belongsTo('App\Models\DailyAttendance','dailyattendance_id','id');
    }

    

    public static function first_attendance_date()
    {
        
        $first_attendance_date = Attendance::min('date');
        return $first_attendance_date;
        
    }

    public static function last_attendance_date()
    {
        
        
        $last_attendance_date = Attendance::max('date');
        return $last_attendance_date;        
    }


}
