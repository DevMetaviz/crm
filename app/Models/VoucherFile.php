<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherFile extends Model
{
    protected $fillable = [
        'voucher_id',
        'path'
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}





