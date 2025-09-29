<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;
    


    public function parameterable()
    {
        return $this->morphTo();
    }

    public function item()
    {
        return $this->belongsTo('App\Models\inventory','item_id','id');
    }

    public function process()
    {
        return $this->belongsTo('App\Models\Process','process_id','id');
    }


    public function qc_reports()
    {
        return $this->belongsToMany(qc_report::class,'report_id','qc_parameter','parameter_id')->withPivot('value')->withTimestamps();
    }

    public function default_value($std_id,$process_id,$super_id)
    {
        $default='';
            
             if($this->type == 'formula_show' || $this->type == 'formula_text')
             {
                    $formula=explode(',',$this['formula']);

                    if(is_numeric($formula[0])==1)
                                    {
                                       $value1=$formula[0];
                                    }
                      else{
                 $pr1=$this->parameterable->parameters->where('identity',$formula[0])->first();
                 $value1=$pr1->default_value($std_id,$process_id,$super_id);
                         }

                         if($value1=='')
                          $value1=0;

                        $result=$value1;

                         for ($i=1;$i< count($formula)-1; $i++ ) {   
                                  
                        
                                   if(is_numeric($formula[$i+1])==1)
                                    {
                                
                                      $value2=$formula[$i+1];
                                    }
                                     else
                                    { 
                                      $let=$this->parameterable->parameters->where('identity',$formula[$i+1])->first();


                                      if($let!='')
                                       {
                                
                                        $value2=$let->default_value($std_id,$process_id,$super_id);
                                        if($value2=='')
                                          $value2=0;
                                      }
                                     else
                                      { $value2=0;}

                                   
                                        }
                                 
                                      
                                                                
                                  if($formula[$i]=='+')
                                  $result=$result +  $value2 ;
                                  if($formula[$i]=='-')
                                  {  
                                    if($let['type']=='date' || $let['type']=='time' || $let['type']=='datetime-local')
                                    {
                                        
                                         //start

                                      if($result!=0 && $value2!=0 )       
                                     {
                                      $date1 = date_create($result);
                                      $date2 = date_create($value2);
                                      $result =date_diff($date1, $date2);
                                      
                                       $y=''; $m=''; $d=''; $h=''; $m1=''; $s=''; 
                                       if($result->format('%y'))
                                        $y=$result->format('%y year ');
                                      if($result->format('%m'))
                                        $m=$result->format('%m month ');
                                      if($result->format('%d'))
                                        $d=$result->format('%d day ');
                                      if($result->format('%h'))
                                        $h=$result->format('%h hours ');
                                      if($result->format('%i'))
                                        $m1=$result->format('%i mins ');
                                      if($result->format('%s'))
                                        $s=$result->format('%s secs ');
                                       
                                      $result=$y.$m.$d.$h.$m1.$s;
                                     }

                                      //end
                                     
                                   }
                                   else
                                    $result=floatval( $result) - floatval( $value2 );
                                  }
                                if($formula[$i]=='*')
                                  $result=$result * (double) $value2 ;
                                 
                               if($formula[$i]=='/')
                                {
                                  if($value2==0)
                                    $result=0;
                                  else
                                  $result= (float) $result / (float) $value2 ;
                                }
                                    
                                 
                                }

                             //$result=round(  $result ,2 );
                         return $result;
             }


        $value=std_parameter::where('std_id',$std_id)->where('process_id',$process_id)->where('super_id',$super_id)->where('parameter_id',$this->id)->first();
        
        if($value!='')
        $default=$value->value;

        return $default;
    }

    

    

   

}
