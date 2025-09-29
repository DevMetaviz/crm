<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

      public function ticket()
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }

    public function item()
    {
        return $this->belongsTo(inventory::class,'item_id');
    }

    public function transections()
    {
        return $this->morphMany(Transection::class, 'account_voucherable');
    }
    

}
