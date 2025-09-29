<html>
    <head>
        <title>{{$ticket_process['process_name']}}</title>
        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;


            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 6cm;
                margin-left: 2cm;
                margin-right: 1.5cm;
                margin-bottom: 4.5cm;
                font-family: times new roman;
                font-size: 14px;
            }

            

            
                    

                  
                #main_top{
                    width: 100%;
                }

                #main_top .p1{
                 width: 20%;
                 
                 }

                 #main_top .p2{
                 width: 30%;
                 border-bottom: 1px solid black;
                 
                 }


                 #main_heading{
                    text-transform: uppercase;
                    background-color: grey;
                    color: white;
                    padding: 3px;
                    font-size: 14px;
                 }


                 #main_table {

                    border:0.5px solid black;
                    margin-top: 10px;

                 }


                 #main_table td{

                    border:0.5px solid black;
                    padding: 6px;

                 }

                 #main_table th{

                    border:0.5px solid black;
                    padding: 6px;

                 }

                 #main_table td p, #main_table td h4{

                    margin: 0px;

                 }

                              
            
        </style>

       <!-- <link rel="stylesheet" href="{{url('public/own/formula/katex.min.css')}}" integrity="sha384-D+9gmBxUQogRLqvARvNLmA9hS2x//eK1FhVb9PiU86gmcrBrJAQT8okdJ4LMp2uv" crossorigin="anonymous">

  

    <script src="{{url('public/own/formula/katex.min.js')}}" integrity="sha384-483A6DwYfKeDa0Q52fJmxFXkcPCFfnXMoXblOkJ4JcA8zATN6Tm78UNL72AKk+0O" crossorigin="anonymous"></script>

   

        <script defer src="{{url('public/own/formula/auto-render.min.js')}}" integrity="sha384-yACMu8JWxKzSp/C1YV86pzGiQ/l1YUfE8oPuahJQxzehAjEt2GiQuy/BIvl9KyeF" crossorigin="anonymous"
        onload="renderMathInElement(document.body);"></script>

        <script src='{{url("public/own/formula/MathJax.js?config=TeX-AMS-MML_HTMLorMML")}}'></script>
  <script>
  MathJax.Hub.Config({
  tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
});
  </script> -->


    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
       @include('production.reports.layout.header')

       

      @include('production.reports.layout.footer')
        
        <!-- Wrap the content of your PDF inside a main tag -->

        <?php 
           $top_parameters= $ticket_process['ticket_parameters'];
        $sub_processes= $ticket_process->sub_processes() ;
            ?>


        <main style="width: 100%;">
            
           <center><h3 id="main_heading">YIELD CALCULATION AFTER MIXING</h3></center>
         <?php 

              $th=$top_parameters->where('identity','theoretical_grains')->first()->value;
              $ag=$top_parameters->where('identity','actual_grain')->first()->value;
              $qa=$top_parameters->where('identity','qa_sample_qty')->first()->value;
            
            
          ?>

          <p><b>Stage : </b>&nbsp;&nbsp;Mixing</p>

         <p>Theoretical weight of Grains = <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$th}}&nbsp;&nbsp;</span>Kg</p>

         <p>Actual weight of Grains = <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$ag}}&nbsp;&nbsp;</span>Kg</p>


                   <?php 

                   $prmtr=$top_parameters->where('identity','yield_percent')->first();

                           $formula=explode(',',$prmtr['formula']);
                            
                           
                    $pr1=$ticket_process['ticket_parameters']->where('identity',$formula[0])->first();

                  $first=$pr1['parameter_name'];
                 
                 $value1=$pr1['value'];

                        if($value1=='')
                          $value1=0;

                        $result=$value1;

                        $first=str_replace(" ","\ ",$first);
                            $term=''; $term1=''; 
                                for ($i=1;$i< count($formula)-1; $i++ ) {
                                  
                                  
                            $sec='';
                                   if(is_numeric($formula[$i+1])==1)
                                    {
                                      $sec=$formula[$i+1];
                                      $value2=$formula[$i+1];
                                    }
                              
                                     else
                                    { 
                                      $let=$ticket_process['ticket_parameters']->where('identity',$formula[$i+1])->first();


                                      if($let!='')
                                       {
                                        $sec=$let['parameter_name']; 
                                      
                                        $value2=$let['value'];
                                        if($value2=='')
                                          $value2=0;
                                      }
                                     else
                                      {$sec=''; $value2=0;}

                                   

                                    $sec=str_replace(" ","\ ",$sec);
                                        }
                                 
                                      
                               if($formula[$i]=='+' || $formula[$i]=='-' || $formula[$i]=='*' )
                                {   
                                  $term='{' .$first.$formula[$i].$sec.' }';
                                  $term1='{' .$value1.$formula[$i].$value2.' }';
                                  if($formula[$i]=='+')
                                  $result=$result + $value2 ;
                                  if($formula[$i]=='-')
                                  $result=$result - $value2 ;
                                if($formula[$i]=='*')
                                  $result=$result * $value2 ;
                                 }
                               elseif($formula[$i]=='/')
                                 {
                                  $term='\frac {' .$first.'}'.'{'.$sec.' }';
                                  $term1='\frac {' .$value1.'}'.'{'.$value2.' }';

                                  if($value2==0)
                                    $result=0;
                                  else
                                  $result=$result / $value2 ;
                                    }
                                
                                $first=$term;
                                $value1=$term1;
                                 
                                }

                                $result=round($result);

                                $name=str_replace(' ', '\ ', $prmtr['parameter_name'] );
                                $name=str_replace('%', '\%', $prmtr['parameter_name'] );
                            ?>

                     <!--  <p>\( {{ $name.' = '.$term}} \)</p>

                       <p>\( {{$name.'  = '.$term1}} \)</p>
                        
                        <p>\( {{$name.'  = '.$result }} \)</p>
 -->
<!-- <math>
  H(s) = ∫<sub>0</sub><sup>∞</sup> e<sup>-st</sup> h(t) dt
</math>

<math>
  C <box>dV<sub>out</sub><over>dt</box> = I<sub>b</sub>
  &tanh;(<box>κ(V<sub>in</sub>-V<sub>out</sub>)<over>2</box>)
</math>
 -->
            <?php 

              $th=$top_parameters->where('identity','theoretical_grains')->first()->value;
              $ag=$top_parameters->where('identity','actual_grain')->first()->value;
              $qa=$top_parameters->where('identity','qa_sample_qty')->first()->value;

              $n_th=$top_parameters->where('identity','theoretical_grains')->first()->parameter_name;
              $n_ag=$top_parameters->where('identity','actual_grain')->first()->parameter_name;
              $n_qa=$top_parameters->where('identity','qa_sample_qty')->first()->parameter_name;
            
            
                ?>



                <p>Yield Calculation : &nbsp;<span style="border-bottom:1px solid black ">{{$n_ag}}&nbsp; + &nbsp; {{$n_qa }}&nbsp;</span>&nbsp;* 100<br><span style="margin-left: 160px;">{{$n_th}}</span></p>

                <p>Yield Calculation : &nbsp;<span style="border-bottom:1px solid black ">{{$ag}}&nbsp; + &nbsp; {{$qa }}&nbsp;</span>&nbsp;* 100<br><span style="margin-left: 135px;">{{$th}}</span></p>

                <p>Yield Calculation : {{$result}}&nbsp;%</p>

                <?php
                    $r=$top_parameters->where('identity','remarks')->first()->value;
                 ?>

          
           <table style="width: 100%;">
             <tr>
               <td style="width: 20%;"><p>Remarks (if any) :</p></td>
               <td style="width: 80%;"><p style="border-bottom: 1px solid black;display: block;">&nbsp;&nbsp;{{$r}}</p></td>
             </tr>
           </table>

          

        </main>


        
    </body>
</html>