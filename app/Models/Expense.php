<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public function account()
    {
        return $this->belongsTo(Account::class,'account_id');
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class,'purchase_expense','expense_id','purchase_id')->withPivot('amount')->withTimestamps();
    }


}
