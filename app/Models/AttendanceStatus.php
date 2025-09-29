<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceStatus extends Model
{
    use HasFactory;

    public function leavetype()
    {
        return $this->belongsTo('App\Models\LeaveType','leave_type_id','id');
    }

    public function Attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

}
