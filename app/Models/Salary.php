<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    

    public function salary_list()
    {
        return $this->hasMany(employee_salary::class,'salary_id','id');
    }

    public function salary($employee_id)
    {
      
            $s=$this->salary_list->where('employee_id',$employee_id)->first();
        return $s;
    }   

    public function transections()
    {
        return $this->morphMany(Transection::class, 'account_voucherable');
    }





}
