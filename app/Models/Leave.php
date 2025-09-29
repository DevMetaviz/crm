<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    
   public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    public function leave_type()
    {
        return $this->belongsTo('App\Models\Configuration','leave_type_id');
    }

    public function leave_dates()
    {
        return $this->hasMany('App\Models\Date_leave','leave_id');
    }


    
}
