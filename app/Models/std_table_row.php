<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class std_table_row extends Model
{
    use HasFactory;
    protected $table = 'std_table_rows';


public function table()
    {
        return $this->belongsTo(Table::class,'table_id','id');
    }

    public function column()
    {
        return $this->belongsTo(table_column::class,'table_column_id');
    }


    






}
