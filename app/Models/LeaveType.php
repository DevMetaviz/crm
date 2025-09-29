<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    

    public function attendance_statuses()
    {
        return $this->hasMany('App\Models\AttendanceStatus');
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class,'leavetype_shift')->withPivot('allowed_leave')->withTimestamps();
    }
    public function Leaveadjustment()
    {
        return $this->hasMany(Leaveadjustment::class,'leave_type_id','id');
    }


}
