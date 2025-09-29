<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    public function leave_types1()
    {
        return $this->belongsToMany(Configuration::class,'configuration_type','type_id','configuration_id',)->withPivot('attributes')->withTimestamps();
      
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function leave_types()
    {
        return $this->belongsToMany(LeaveType::class,'leavetype_shift','shift_id','leave_type_id')->withPivot('allowed_leave')->withTimestamps();
    }


}
