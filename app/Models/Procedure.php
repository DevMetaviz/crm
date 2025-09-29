<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','name', 'remarks', 'activeness',
    ];
    
    public function processes()
    {
        return $this->belongsToMany(Process::class,'procedure_process','procedure_id','process_id')->withPivot('sort_order','qc_required')->withTimestamps()->orderBy('pivot_sort_order');
    }

    public function get_processes()
    {
      $proces=[];
        foreach ($this->processes as $key ) {
             array_push($proces ,  $key['identity']);
         } 

         return $proces;
    }


    public function production_standards()
    {
        return $this->hasMany('App\Models\ProductionStandard');
    }

    public static function getProcedureForStd($procedure_id,$std_id)
    {
      $procedure=Procedure::find($procedure_id);
           // print_r($procedure_id);die;

      if($procedure=='')
        return [];
      
              $processes=array();
           foreach ($procedure->processes as $key ) {
                 
                 $id=$key['id'];
                 $sort_order=$key['pivot']['sort_order'];
                 $qc_required=$key['pivot']['qc_required'];

                 $process_detail=Process::process_detail1($id,$std_id);

                 $process=array('id'=>$id,'process_name'=>$process_detail['process_name'],'identity'=>$process_detail['identity'],'sort_order'=>$sort_order,'qc_required'=>$qc_required,'remarks'=>$process_detail['remarks'],'parameters'=>$process_detail['parameters'],'sub_processes'=>$process_detail['sub_processes']);
                array_push($processes, $process);
           }
           $procedure=array('id'=>$procedure['id'],'name'=>$procedure['name'],'remarks'=>$procedure['remarks'],'processes'=>$processes);

           return $procedure;
    }


    
    

    
}
