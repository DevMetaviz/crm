<html>
    <head>
        <title>{{$ticket_process['process']['process_name']}}</title>
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
                /*font-family: times new roman;*/
               
                font-family: sans-serif;
                font-size: 13px;
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

                 .short_table {

                    width: 100%;
                 }

                 .short_table tr{

                    min-height:  100px;
                 }

                 .short_table td , .short_table th{

                    border:0.5px solid black;
                    padding: 6px;
                    min-height: 120px;
                 }

                              
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
       @include('production.reports.layout.header')

       

      @include('production.reports.layout.footer')
        
        <!-- Wrap the content of your PDF inside a main tag -->

        <?php 

           $top_parameters= $ticket_process['ticket_parameters'];
           $sub_processes= $ticket_process->sub_processes ;
        
            ?>


        <main style="width: 100%;">
            
           <center><h2 id="main_heading">STANDARD MANUFACTURING PROCEDUTRE FOR {{$ticket_process['process']['process_name']}}</h2></center>
         <?php  
              $d=$top_parameters->where('parameter.identity','granulation_date')->first()->value;
              $t=$top_parameters->where('parameter.identity','granulation_date1')->first()->value;
              //$c_d=$top_parameters->where('parameter.identity','complete_date')->first()->value;
              //$c_t=$top_parameters->where('parameter.identity','complete_time')->first()->value;
              $t_t=$top_parameters->where('parameter.identity','total_time')->first()->formula_result();
              $l_t=$top_parameters->where('parameter.identity','standard_lead_time')->first()->value;
              $temp=$top_parameters->where('parameter.identity','temperature')->first()->value;
              $humi=$top_parameters->where('parameter.identity','humidity')->first()->value;
          ?>

         <table id="main_top">
           <tr>
             <td class="p1">Starting Date & Time:</td>
             <td class="p2">{{$d.' '}}</td>
             <td class="p1">Completed Date & Time:</td>
             <td class="p2">{{$t.' '}}</td>  
           </tr>
           <tr>
             <td class="p1">Total Time:</td>
             <td class="p2">{{$t_t}}</td>
             <td class="p1">Standard Lead Time:</td>
             <td class="p2">{{$l_t}}</td>  
           </tr>
           <tr>
             <td class="p1">Temprature:</td>
             <td class="p2">{{$temp}}</td>
             <td class="p1">Humidity:</td>
             <td class="p2">{{$humi}}</td>  
           </tr>
           </table>

           <table id="main_table" style="width: 100%;">

            <tr>
                   <th style="width: 5%;">SR #</th>
                   <th style="width: 50%;">MANUFACTURING OPERATION</th>
                   <th style="width: 15%;">PERFORMED BY (OPERATOR)</th>
                   <th style="width: 15%;">CHECKED BY(PROD./QA OFFICER)</th>
                   <th style="width: 15%;">DATE</th>
               </tr>
             
             <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','sieving')->first() ;

                $s= $p['ticket_parameters']->where('parameter.identity','start_time')->first()->value;
                $c= $p['ticket_parameters']->where('parameter.identity','completion_time')->first()->value;
                $t= $p['ticket_parameters']->where('parameter.identity','total_time')->first()->formula_result();

                $tab=$p['tables']->where('table.identity','sieve_material')->first() ;
            ?>    
                    <h4><span style="border-bottom: 1.5px solid black;">{{"STEP 1"}}</span></h4>
                  <h4>{{$p['process']['process_name']}}</h4>
                       <p>{{$p['ticket_parameters']->where('parameter.identity','sieving_text')->first()->value }}</p>
                       <p>{{$p['ticket_parameters']->where('parameter.identity','blending_method')->first()->value }}</p>
                       <p>{{"Mix the sieved material in cube mixer for ".$t." minutes."}}</p>

                       <p>Mixing started at:<span style="border-bottom: 1px solid black">{{$s}}</span></p>
                      <p>Mixing completed at:<span style="border-bottom: 1px solid black">{{$c}}</span></p>
                    <p>Total time:<span style="border-bottom: 1px solid black">{{$t}}</span></p>


                     <!--table start -->
                     <?php  $count=count($tab['columns']);
                            $row=$tab->default_row_count();
                       ?>
                        <table style="border-spacing: 0;margin: 10;">
                             <tr>
                                @for($i=0;$i<$count;$i++)
                                  <th>{{$tab['columns'][$i]['column']['heading']}}</th>
                                @endfor
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                            @for($j=1;$j<=$row;$j++)
                             <tr>
                               @for($i=0;$i<$count;$i++)

                                  <?php 

                                  $type=$tab['columns'][$i]['column']['type'];
                                        $head=$tab['columns'][$i]['column']['heading'];
                                         $value=$tab['columns'][$i]->row_value($tab['id'],$tab['columns'][$i]['id'],$j); 

                                         ?>
                              <td>

                               {{$value}}

                               </td>

                               
                                @endfor
                               
                             </tr>
                        
                             @endfor
                             </tbody>



                             <tr>
                               @foreach($tab['columns'] as $cl)
                                        <?php 
                                              if($cl['column']['footer_type']=='sum')
                                              {
                                          $sum=$cl->col_sum($tab['id']);
                                              }
                                         ?>
                               <th>
                                @if($cl['column']['footer_type']=='sum')
                               {{$sum}}
                               @else
                               {{$cl['column']['footer_text']}}
                               @endif
                             </th>
                                @endforeach
                               <!--  <th></th> -->
                             </tr>
                        </table>

                     <!--end table-->

                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <!-- <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
                    
             // $p=$sub_processes->where('process.identity','blending')->first() ;
             //    $s= $p['ticket_parameters']->where('parameter.identity','start_time')->first()->value;
             //    $c= $p['ticket_parameters']->where('parameter.identity','completion_time')->first()->value; 
             //    $t= $p['ticket_parameters']->where('parameter.identity','total_time')->first()->value;
            ?>
                  <center><h4></h4></center>
                       <p></p>
                    <p>Mixing started at:<span style="border-bottom: 1px solid black">{{$s}}</span></p>
                      <p>Mixing completed at:<span style="border-bottom: 1px solid black">{{$c}}</span></p>
                      <p>Total time:<span style="border-bottom: 1px solid black">{{$t}}</span></p>

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr> -->

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','wetting_and_wet_granulation')->first() ;
                
                $t= $p['ticket_parameters']->where('parameter.identity','text')->first()->value;

                $p1=$sub_processes->where('process.identity','paste_addition')->first() ;
            ?>
                  <h4><span style="border-bottom: 1.5px solid black;">STEP 2</span></h4>
                  <h4>{{'WETTING AND WET GRANULATION  '}}</h4>
                  <h4>{{$p['process']['process_name']}}</h4>
                  

                       <p>{{$t}}</p>
                    <h4>{{$p1['process']['process_name']}}</h4>
                     <p>{{$p1['ticket_parameters']->where('parameter.identity','wetting_text')->first()->value}}</p>

                     <?php
             $p=$sub_processes->where('process.identity','wet_granulation')->first() ;
                
                $t= $p['ticket_parameters']->where('parameter.identity','wet_granulation')->first()->value;
            ?>

            <h4>{{$p['process']['process_name']}}</h4>
                

                       <p>{{$t}}</p>

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>


               


               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','drying_1')->first() ;
                
                $c= $p['ticket_parameters']->where('parameter.identity','result_of_lod')->first()->value;
                

                $text= $p['ticket_parameters']->where('parameter.identity','drying_text')->first()->value;
                 

            ?>
                  <h4><span style="border-bottom: 1.5px solid black;">STEP 3</span></h4>
                  <h4>{{$p['process']['process_name']}}</h4>
                       <p>{{$text}}</p>
                    <p>Results of LOD:<span style="border-bottom: 1px solid black;">{{$c}}&nbsp;&nbsp;</span>(Limit NMT 3%).</p>
                      
                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

              

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','dry_granulation')->first() ;
                
               
                $text= $p['ticket_parameters']->where('parameter.identity','text')->first()->value;
                
                

            ?>
            <h4><span style="border-bottom: 1.5px solid black;">STEP 4</span></h4>
                 <h4>{{$p['process']['process_name']}}</h4>
                       <p>{{$text}}</p>
                    
                      
                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

                <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','final_mixing')->first() ;
                
                $s= $p['ticket_parameters']->where('parameter.identity','start_time')->first()->value;
                $c= $p['ticket_parameters']->where('parameter.identity','completion_time')->first()->value;
                $t= $p['ticket_parameters']->where('parameter.identity','total_time')->first()->value;
               
                $text= $p['ticket_parameters']->where('parameter.identity','mixing_text')->first()->value;
                $qt= $p['ticket_parameters']->where('parameter.identity','sampled_qty')->first()->value;
                 
                 $tab=$p['tables']->where('table.identity','mixer_material')->first() ;
                

            ?>
            <h4><span style="border-bottom: 1.5px solid black;">STEP 5</span></h4>
                  <h4>{{$p['process']['process_name']}}</h4>
                       <p>{{$text}}</p>

                       <!--table start -->
                     <?php $count=count($tab['columns']); $row=$tab->default_row_count(); ?>
                        <table style="border-spacing: 0;margin: 10;">
                             <tr>
                                @for($i=0;$i<$count;$i++)
                                  <th>{{$tab['columns'][$i]['column']['heading']}}</th>
                                @endfor
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                            @for($j=1;$j<=$row;$j++)
                             <tr>
                               @for($i=0;$i<$count;$i++)

                                  <?php 

                                  $type=$tab['columns'][$i]['column']['type'];
                                        $head=$tab['columns'][$i]['column']['heading'];
                                         $value=$tab['columns'][$i]->row_value($tab['id'],$tab['columns'][$i]['id'],$j); 

                                         ?>
                              <td>

                               {{$value}}

                               </td>

                               
                                @endfor
                               
                             </tr>
                        
                             @endfor
                             </tbody>



                             <tr>
                               @foreach($tab['columns'] as $cl)
                                        <?php 
                                              if($cl['column']['footer_type']=='sum')
                                              {
                                          $sum=$cl->col_sum($tab['id']);
                                              }
                                         ?>
                               <th>
                                @if($cl['column']['footer_type']=='sum')
                               {{$sum}}
                               @else
                               {{$cl['column']['footer_text']}}
                               @endif
                             </th>
                                @endforeach
                               <!--  <th></th> -->
                             </tr>
                        </table>

                     <!--end table-->
                  
                  <p>Mixing  started at:<span style="border-bottom: 1px solid black">{{$s}}</span></p>
                      <p>Mixing  completed at:<span style="border-bottom: 1px solid black">{{$c}}</span></p>
                      <p>Total time:<span style="border-bottom: 1px solid black">{{$t}}</span></p>
                      <p>Intimate QA for sampling of mixed material.</p>
                    <p>Quantity sampled by QA: <span style="border-bottom: 1px solid black">{{$qt}}</span></p>
                      
                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

              


              

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','transfer_material')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','method_text')->first()->value;
                
                
            ?>
                <h4><span style="border-bottom: 1.5px solid black;">STEP 6</span></h4>
                 <p>{{$s}}</p>
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>
               

            

               
           </table>


           <?php
             $p=$sub_processes->where('process.identity','sampling_request_sheet_granulation')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','intimation_time')->first()->value;

                $s1= $p['ticket_parameters']->where('parameter.identity','sampling_time')->first()->value;
                
                
            ?>

           <center><h2 id="main_heading">SAMPLING REQUEST SHEET FOR BULK</h2></center>

           <h3>To be filled by Production</h3>

           <div style="border: 1px solid black;padding: 15px;">

            <p> Stage : After Mixing </p>
              <p> Date / Time of Intimation : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;">{{$s}} </span> </p>

              <p> Production Supervisor : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;">{{$s1}} </span> </p>
           </div>

           <h3>To be filled by QA</h3>

           <div style="border: 1px solid black;padding: 15px;">
              <p> Date / Time of Sampling : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>

              <p> QA Inspector : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>
           </div>


           

            <center><h2 id="main_heading">YIELD CALCULATION AFTER FINAL MIXING</h2></center>   

                <p><b>Stage : </b> Final Mixing</p>


                <?php

                $sub_p=$sub_processes->where('process.identity','mixing_yield')->first() ;
                
                 $r=$sub_p['ticket_parameters']->where('parameter.identity','remarks')->first()->value;
                 

                 $aw=$sub_p['ticket_parameters']->where('parameter.identity','theoretical_grains')->first()->value;
              $qa=$sub_p['ticket_parameters']->where('parameter.identity','actual_grain')->first()->value;
              $t=$sub_p['ticket_parameters']->where('parameter.identity','wastage')->first();
              
             $t=$t->formula_result();
              
             ;

              $yield=$sub_p['ticket_parameters']->where('parameter.identity','yield')->first();
               
               $yield=$yield->formula_result();

                $tab=$sub_p['tables']->where('table.identity','after_sampling_material')->first() ;
  
                 ?>

                 <!--table start -->
                     <?php $count=count($tab['columns']); $row=$tab->default_row_count();  ?>
                        <table style="border-spacing: 0;margin: 10;" class="short_table">
                             <tr>
                                @for($i=0;$i<$count;$i++)
                                  <th>{{$tab['columns'][$i]['column']['heading']}}</th>
                                @endfor
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                            @for($j=1;$j<=$row;$j++)
                             <tr>
                               @for($i=0;$i<$count;$i++)

                                  <?php 

                                  $type=$tab['columns'][$i]['column']['type'];
                                        $head=$tab['columns'][$i]['column']['heading'];
                                         $value=$tab['columns'][$i]->row_value($tab['id'],$tab['columns'][$i]['id'],$j); 

                                         ?>
                              <td>

                               {{$value}}

                               </td>

                               
                                @endfor
                               
                             </tr>
                        
                             @endfor
                             </tbody>



                             <tr>
                               @foreach($tab['columns'] as $cl)
                                        <?php 
                                              if($cl['column']['footer_type']=='sum')
                                              {
                                          $sum=$cl->col_sum($tab['id']);
                                              }
                                         ?>
                               <th>
                                @if($cl['column']['footer_type']=='sum')
                               {{$sum}}
                               @else
                               {{$cl['column']['footer_text']}}
                               @endif
                             </th>
                                @endforeach
                               <!--  <th></th> -->
                             </tr>
                        </table>

                     <!--end table-->


                 <p>Theoretical weight of Grains =&nbsp;{{$aw }} </p>
                 <p>Actual weight of Grains =&nbsp;{{$qa }} </p>

                 <p>% Wastage : &nbsp;<span style="border-bottom:1px solid black ">{{'Theoratical Grains'}}&nbsp; - &nbsp;  {{'Actual Grains' }}&nbsp;  </span>&nbsp;* 100<br><span style="margin-left: 160px;">{{'Theoratical Grains'}}</span></p>


                 <p>% Wastage : {{$t}}&nbsp;%</p>

                 <p>% Yield : 100 - % Wastage</p>

                 <p>% Yield : {{$yield}}&nbsp;%</p>

                



                

          
           <table style="width: 100%;">
             <tr>
               <td style="width: 20%;"><p>Remarks (if any) :</p></td>
               <td style="width: 80%;"><p style="border-bottom: 1px solid black;display: block;">&nbsp;&nbsp;{{$r}}</p></td>
             </tr>
           </table>


           

        </main>
<?php //granulation parameters , final mixing parameter ?>

        
    </body>
</html>