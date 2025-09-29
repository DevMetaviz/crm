<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    public function employees()
    {
        return $this->belongsToMany(Employee::class,'allowance_employee');
    }


    public function salaries()
    {
        return $this->belongsToMany(employee_salary::class,'salary_allowance');
    }



}
