<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyAttendance extends Model
{
    use HasFactory;
     protected $table = 'dailyattendances';
    

     public function employee()
    {
        return $this->belongsTo('App\Models\Employee','employee_id');
    }

    public function attendances()
    {
        return $this->hasMany('App\Models\Attendance','dailyattendance_id','id');
    }

    public function AttendanceStatus()
    {
        return $this->hasOne(AttendanceStatus::class,'status','id');
    }



}
