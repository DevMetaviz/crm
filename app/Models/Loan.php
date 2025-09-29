<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    public function authorizedBy()
    {
        return $this->belongsTo('App\Models\Employee','authorized_by');
    }


    public function installments()
    {
        return $this->hasMany(loan_installment::class,'loan_id','id');
    }

    public function activeness()
    {
        $act=$this->status;

        if($act==1)
        	return 'Active';
        else
        	return 'Inactive';
    }

    public function is_paid()
    {
        $act=$this->is_paid;

        if($act==1)
        	return 'Paid';
        else
        	return 'Unpaid';
    }

    public function status()
    {
        $act=$this->status;

        if($act==0)
        	return 'Pending';
        elseif($act==1)
        	return 'Approved';
        elseif($act==2)
        	return 'Rejected';

    }



}
