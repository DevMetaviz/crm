<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    use HasFactory;


     protected $fillable = [
        'customer_id',
        'account_id',
        'cheque_number',
        'cheque_date',
        'amount',
        'status',
        'received_date',
        'remarks',
        'user_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

     public function account()
    {
        return $this->belongsTo(Account::class);
    }

    

}
