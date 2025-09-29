<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;
       
       //process have not 2 same sub process
       //procedutre have not 2 same process 

    public function tables()
    {
        return $this->hasMany(Table::class,'process_id');
    }

    public function parameters()
    {
        return $this->morphMany(Parameter::class, 'parameterable')->orderBY('sort_order','asc');
    }
    
    public function sub_stages()
    {
        return $this->belongsToMany(Process::class,'sub_process','process_id','sub_process_id')->withPivot('sort_order','qc_required','active')->withTimestamps()->orderBy('pivot_sort_order');
    }

    // 
    

    public function procedures()
    {
        return $this->belongsToMany(Procedure::class,'procedure_process','process_id','procedure_id')->withPivot('sort_order','qc_required')->withTimestamps()->orderBY('sort_order','asc'); 
    }

    public function attributes()
    {     
        return $this->parameters()->where('activeness','like','active')->get();
        //$parameters=array();
          // foreach ($lets as $key ) {
               
          //      $parameter=array('id'=>$key['id'],'name'=>$key['name'],'identity'=>$key['identity'],'description'=>$key['description'],'type'=>$key['type'],'formula'=>$key['formula'],'sort_order'=>$key['sort_order']);
          //      array_push($parameters, $key);
          //  }
          //  return $parameters; 
    }


   public function sub_processes()
    {
        $stages=$this->sub_stages;
            $process=array();
        foreach ($stages as $key ) {
            
            $sub_processes=$key->sub_processes();
             $parameters=$key->attributes();
            $stage=array('id'=>$key['id'],'process_name'=>$key['process_name'],'identity'=>$key['identity'],'remarks'=>$key['remarks'],'sort_order'=>$key['pivot']['sort_order'],'qc_required'=>$key['pivot']['qc_required'],'active'=>$key['pivot']['active'],'parameters'=>$parameters,'sub_processes'=>$sub_processes,'tables'=>$key['tables']);
            array_push($process, $stage);
        }

        $sort_col  = array_column($process, 'sort_order');
          array_multisort($sort_col,SORT_ASC,$process);

        return $process;  
    }
    
  

    public static function process_detail1($procees_id,$std_id)
    {
      $let=Process::find($procees_id);
      $sub_processes=$let->active_sub_processes1($std_id);
      $parameters=$let->attributes_with_value($std_id);
        $process=array('id'=>$let['id'],'process_name'=>$let['process_name'],'identity'=>$let['identity'],'remarks'=>$let['remarks'],'parameters'=>$parameters,'sub_processes'=>$sub_processes);

        return $process;
    }

    public function attributes_with_value($std_id)
    {     
        $lets=$this->parameters->where('activeness','like','active');
        $parameters=array();
          foreach ($lets as $key ) {

              $value='';
            $let=std_parameter::where('std_id',$std_id)->where('process_id',$this->id)->where('parameter_id',$key['id'])->first();
            if($let!='')
                $value=$let['value'];

               
               $parameter=array('id'=>$key['id'],'name'=>$key['name'],'identity'=>$key['identity'],'description'=>$key['description'],'type'=>$key['type'],'formula'=>$key['formula'],'sort_order'=>$key['sort_order'],'value'=>$value);
               array_push($parameters, $parameter);
           }
           return $parameters; 
    }

    public function active_sub_processes1($std_id)
    {
        $stages=$this->sub_stages;

            $process=array();
        foreach ($stages as $key ) {

            if($key['pivot']['active']==0)
                continue;
            
             //$parameters=$key->attributes();
             $parameters=$key->attributes_with_value($std_id);

              $sub_processes=$key->active_sub_processes1($std_id);

            $stage=array('id'=>$key['id'],'process_name'=>$key['process_name'],'identity'=>$key['identity'],'remarks'=>$key['remarks'],'sort_order'=>$key['pivot']['sort_order'],'qc_required'=>$key['pivot']['qc_required'],'active'=>$key['pivot']['active'],'parameters'=>$parameters,'sub_processes'=>$sub_processes);
            array_push($process, $stage);
        }

        $sort_col  = array_column($process, 'sort_order');
          array_multisort($sort_col,SORT_ASC,$process);

        return $process;  
    }
     

     
    
   


    

   

    

}
