<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_salary extends Model
{
    use HasFactory;
     protected $table = 'salary_employee';

     public function salary()
    {
        return $this->belongsTo('App\Models\Salary','salary_id');
    }


    public function employee()
    {
        return $this->belongsTo('App\Models\Employee','employee_id');
    }


    public function allowances()
    {
        
        return $this->belongsToMany(Allowance::class,'salary_allowance')->withPivot( 'amount')->withTimestamps()->where('type','allowance');
    }

    public function deductions()
    {
        
        return $this->belongsToMany(Allowance::class,'salary_allowance')->withPivot( 'amount')->withTimestamps()->where('type','deduction');
    }


}
