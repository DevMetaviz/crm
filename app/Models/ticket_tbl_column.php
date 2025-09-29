<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_tbl_column extends Model
{
    use HasFactory;

    public function table()
    {
        return $this->belongsTo(ticket_table::class);
    }

    public function column()
    {
        return $this->belongsTo(table_column::class,'table_col_id');
    }

    public function rows()
    {
        return $this->hasMany(ticket_tbl_row::class,'ticket_table_column_id');
    }

    public function row_value($table_id,$col_id,$row_sort_order)
    {
        $default='';

        $value=ticket_tbl_row::where('ticket_table_id',$table_id)->where('ticket_table_column_id',$col_id)->where('sort_order',$row_sort_order)->first();
        
        if($value!='')
        $default=$value->value;

        return $default;
    }

    public function col_sum($table_id)
    {
       

        $value=ticket_tbl_row::where('ticket_table_id',$table_id)->where('ticket_table_column_id',$this->id)->sum('value');
        
     //print_r(json_encode($value));die;

        return $value;
    }


    
}
