<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_process extends Model
{
    use HasFactory;

     protected $table = 'ticket_process';

     public function ticket_parameters()
    {
        return $this->hasMany(ticket_parameter::class,'ticket_process_id');
    }
    public function parameter_value($parameter_id)
    {
        
        $pr=$this->hasMany(ticket_parameter::class,'ticket_process_id')->where('parameter_id',$parameter_id)->first();
        if($pr!='')
            return $pr['value'];
        
        return '';
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function process()
    {
        return $this->belongsTo(Process::class);
    }


    public function sub_processes()
    {
        return $this->hasMany(ticket_process::class,'super_id','id');
    }

    public function tables()
    {
        return $this->hasMany(ticket_table::class,'ticket_process_id');
    }

}
