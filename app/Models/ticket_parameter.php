<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_parameter extends Model
{
    use HasFactory;
    protected $table = 'ticket_parameter';

    public function ticket_process()
    {
        return $this->belongsTo(ticket_process::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function formula_result()
    {
    

               $formula=explode(',',$this['parameter']['formula']);
                           
                            if(is_numeric($formula[0])==1)
                                    {
                                      //$first=$formula[0];
                 
                                       $value1=$formula[0];

                                    }
 
                        else{   
                    $pr1=$this->ticket_process['ticket_parameters']->where('parameter.identity',$formula[0])->first();
                 // $first=$pr1['parameter_name'];
                 
                 $value1=$pr1['value'];
                  if($pr1['parameter']['type']=='formula_show' || $pr1['parameter']['type']=='formula_text')
                     $value1=$pr1->formula_result();
               }

                        if($value1=='')
                          $value1=0;

                        $result=$value1;

                        //$first=str_replace(" ","\ ",$first);
                            //$term=''; 
                            //$term1=''; 
                                for ($i=1;$i< count($formula)-1; $i++ ) {
                                  
                                  
                            //$sec='';
                                   if(is_numeric($formula[$i+1])==1)
                                    {
                                      //$sec=$formula[$i+1];
                                      $value2=$formula[$i+1];
                                    }
                              
                                     else
                                    { 
                                      $let=$this->ticket_process['ticket_parameters']->where('parameter.identity',$formula[$i+1])->first();


                                      if($let!='')
                                       {
                                        //$sec=$let['parameter_name']; 
                                      
                                        $value2=$let['value'];
                                        if($let['parameter']['type']=='formula_show' ||$let['parameter']['type']=='formula_text')
                                           $value2=$let->formula_result();
                                        if($value2=='')
                                          $value2=0;
                                      }
                                     else
                                      { //$sec=''; 
                                       $value2=0;}

                                   

                                    //$sec=str_replace(" ","\ ",$sec);
                                        }
                               
                                      
                               if($formula[$i]=='+' || $formula[$i]=='-' || $formula[$i]=='*' )
                                {   
                                  //$term='{' .$first.$formula[$i].$sec.' }';
                                  //$term1='{' .$value1.$formula[$i].$value2.' }';
                                  if($formula[$i]=='+')
                                  $result=$result + $value2 ;
                                  if($formula[$i]=='-')
                                  { 
                                    //$result=$result - $value2 ;
      //print_r($result.' '.$value2.' '.$this);die; 
                                    if($let['parameter']['type']=='date' || $let['parameter']['type']=='time' || $let['parameter']['type']=='datetime-local')
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

                                  }//end - if
                                if($formula[$i]=='*')
                                  $result=$result * $value2 ;
                                 }
                               elseif($formula[$i]=='/')
                                 {
                                  //$term='\frac {' .$first.'}'.'{'.$sec.' }';
                                  //$term1='\frac {' .$value1.'}'.'{'.$value2.' }';

                                  if($value2==0)
                                    $result=0;
                                  else
                                  $result=round( (float)$result / $value2 , 4) ;
                                    }
                                
                                //$first=$term;
                                //$value1=$term1;
                                 
                                }

                                //$result=round($result);

                                //$name=str_replace(' ', '\ ', $prmtr['parameter_name'] );
                                //$name=str_replace('%', '\%', $prmtr['parameter_name'] );

            return $result;
                            
    }



    public function formula_result1()
    {
    

               $formula=explode(',',$this['formula']);
                           
                            if(is_numeric($formula[0])==1)
                                    {
                                      //$first=$formula[0];
                 
                                       $value1=$formula[0];
                                    }
 
                        else{   
                    $pr1=$this->ticket_process['ticket_parameters']->where('identity',$formula[0])->first();
                 // $first=$pr1['parameter_name'];
                 
                 $value1=$pr1['value'];
               }

                        if($value1=='')
                          $value1=0;

                        $result=$value1;

                        //$first=str_replace(" ","\ ",$first);
                            //$term=''; 
                            //$term1=''; 
                                for ($i=1;$i< count($formula)-1; $i++ ) {
                                  
                                  
                            //$sec='';
                                   if(is_numeric($formula[$i+1])==1)
                                    {
                                      //$sec=$formula[$i+1];
                                      $value2=$formula[$i+1];
                                    }
                              
                                     else
                                    { 
                                      $let=$this->ticket_process['ticket_parameters']->where('identity',$formula[$i+1])->first();


                                      if($let!='')
                                       {
                                        //$sec=$let['parameter_name']; 
                                      
                                        $value2=$let['value'];
                                        if($value2=='')
                                          $value2=0;
                                      }
                                     else
                                      { //$sec=''; 
                                       $value2=0;}

                                   

                                    //$sec=str_replace(" ","\ ",$sec);
                                        }
                                 
                                      
                               if($formula[$i]=='+' || $formula[$i]=='-' || $formula[$i]=='*' )
                                {   
                                  //$term='{' .$first.$formula[$i].$sec.' }';
                                  //$term1='{' .$value1.$formula[$i].$value2.' }';
                                  if($formula[$i]=='+')
                                  $result=$result + $value2 ;
                                  if($formula[$i]=='-')
                                  $result=$result - $value2 ;
                                if($formula[$i]=='*')
                                  $result=$result * $value2 ;
                                 }
                               elseif($formula[$i]=='/')
                                 {
                                  //$term='\frac {' .$first.'}'.'{'.$sec.' }';
                                  //$term1='\frac {' .$value1.'}'.'{'.$value2.' }';

                                  if($value2==0)
                                    $result=0;
                                  else
                                  $result=$result / $value2 ;
                                    }
                                
                                //$first=$term;
                                //$value1=$term1;
                                 
                                }

                                $result=round($result);

                                //$name=str_replace(' ', '\ ', $prmtr['parameter_name'] );
                                //$name=str_replace('%', '\%', $prmtr['parameter_name'] );

            return $result;
                            
    }

}
