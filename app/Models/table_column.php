<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class table_column extends Model
{
    use HasFactory;

    public function table()
    {
        return $this->belongsTo(Table::class,'table_id');
    }

    public function rows()
    {
        return $this->hasMany(std_table_row::class,'table_column_id');
    }


    public function default_row_value($table_id,$std_id,$super_id,$row_sort_order)
    {
        $default='';

        $value=std_table_row::where('table_id',$table_id)->where('table_column_id',$this->id)->where('std_id',$std_id)->where('super_id',$super_id)->where('sort_order',$row_sort_order)->first();
        
        if($value!='')
        $default=$value->value;

        return $default;
    }

    public function default_col_sum($std_id,$super_id)
    {
       //die;
      //print_r(json_encode($this->table));die;
            //$tbl=$this->table; //print_r(json_encode($tbl));die;
        $value=std_table_row::where('table_id',$this->table_id)->where('table_column_id',$this->id)->where('std_id',$std_id)->where('super_id',$super_id)->sum('value');
        
     

        return $value;
    }



}
