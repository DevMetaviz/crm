<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor','doctor_id');
    }
    public function invest_through()
    {
        return $this->belongsTo('App\Models\Employee','invested_through');
    }
}
