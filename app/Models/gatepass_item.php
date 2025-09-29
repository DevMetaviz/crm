<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gatepass_item extends Model
{
    use HasFactory;

    protected $table = 'gatepasses_item';

    public function gatepass()
    {
        return $this->belongsTo(Gatepass::class);
    }

}
