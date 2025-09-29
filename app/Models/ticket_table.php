<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_table extends Model
{
    use HasFactory;

    public function table()
    {
        return $this->belongsTo(Table::class,'table_id');
    }


    public function columns()
    {
        return $this->hasMany(ticket_tbl_column::class,'ticket_table_id')->orderBy('sort_order');
    }

    
    public function rows()
    {
        return $this->hasMany(ticket_tbl_row::class,'ticket_table_id')->orderBy('sort_order');
    }

    
    public function process()
    {
        return $this->belongsTo(ticket_process::class,'ticket_process_id');
    }

        public function default_row_count()
    {
        $max=ticket_tbl_row::where('ticket_table_id',$this->id)->max('sort_order');

        return $max;
    }

}
