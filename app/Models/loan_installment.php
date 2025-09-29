<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loan_installment extends Model
{
    use HasFactory;
    protected $table = 'loan_installment';

    public function loan()
    {
        return $this->belongsTo('App\Models\Loan');
    }
    
}
