<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_tbl_row extends Model
{
    use HasFactory;

    public function table()
    {
        return $this->belongsTo(ticket_table::class,'ticket_table_id','id');
    }

    public function column()
    {
        return $this->belongsTo(ticket_tbl_column::class,'ticket_table_column_id');
    }


}
