<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transection extends Model
{
    use HasFactory;

    protected $table = 'account_voucher';

    public function account_voucherable()
    {
        return $this->morphTo();
    }

    public function account()
    {
        return $this->belongsTo(Account::class,'account_id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class,'account_voucherable_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class,'account_voucherable_id');
    }

    public function challan()
    {
        return $this->belongsTo(Deliverychallan::class,'account_voucherable_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class,'account_voucherable_id');
    }

    public function issuance()
    {
        return $this->belongsTo(Issuance::class,'account_voucherable_id');
    }

    public function issue_return()
    {
        return $this->belongsTo(issue_return::class,'account_voucherable_id');
    }


    public function purchasereturn()
    {
        return $this->belongsTo(Purchasereturn::class,'account_voucherable_id');
    }

    public function salereturn()
    {
        return $this->belongsTo(Salereturn::class,'account_voucherable_id');
    }

    public function stock_transfer()
    {
        return $this->belongsTo(stock_transfer::class,'account_voucherable_id');
    }

    public function salary()
    {
        return $this->belongsTo(Salary::class,'account_voucherable_id');
    }

    public function transfer_note()
    {
        return $this->belongsTo(yield_detail::class,'account_voucherable_id');
    }

    


}
