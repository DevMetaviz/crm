<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function employees()
    {
        return $this->hasMany(Employee::class,'department_id');
    }

    public function active_employees()
    {
        return $this->hasMany(Employee::class,'department_id')->where('status','1');
    }

    

    

    


}
