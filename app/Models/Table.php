<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    public function columns()
    {
        return $this->hasMany(table_column::class,'table_id','id');
    }

    
    public function rows()
    {
        return $this->hasMany(std_table_row::class,'table_id');
    }

    
    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function default_row_count($std_id,$super_id)
    {
        $max=std_table_row::where('table_id',$this->id)->where('std_id',$std_id)->where('super_id',$super_id)->max('sort_order');

        return $max;
    }


}
