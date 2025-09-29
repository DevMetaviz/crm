<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date_leave extends Model
{
    use HasFactory;

    protected $table = 'date_leave';
    protected $fillable = ['leave_date','leave_id'];

     public function leave()
    {
        return $this->belongsTo('App\Models\Leave');
    }
    
}
