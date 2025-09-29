<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc_parameter extends Model
{
    use HasFactory;

    protected $table = 'qc_parameter';

    public function qc_report()
    {
        return $this->belongsTo(qc_report::class,'report_id');
    }


}
