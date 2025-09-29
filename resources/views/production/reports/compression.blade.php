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
                font-family: sans-serif;
                font-size: 12px;
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
            
           <center><h3 id="main_heading">STANDARD MANUFACTURING PROCEDUTRE FOR {{$ticket_process['process']['process_name']}}</h3></center>
         <?php 
              $d=$top_parameters->where('parameter.identity','date')->first()->value;
              $t=$top_parameters->where('parameter.identity','time')->first()->value;
              $c_d=$top_parameters->where('parameter.identity','complete_date')->first()->value;
              $c_t=$top_parameters->where('parameter.identity','completion_time')->first()->value;
              $t_t=$top_parameters->where('parameter.identity','total_time')->first()->value;
              $l_t=$top_parameters->where('parameter.identity','lead_time')->first()->value;
              $temp=$top_parameters->where('parameter.identity','temperature')->first()->value;
              $humi=$top_parameters->where('parameter.identity','humidity')->first()->value;

              $pun=$top_parameters->where('parameter.identity','punch_size')->first()->value;
              $gw=$top_parameters->where('parameter.identity','granules_weight')->first()->value;

          ?>

         <table id="main_top">
           <tr>
             <td class="p1">Starting Date & Time:</td>
             <td class="p2">{{$d.' '.$t}}</td>
             <td class="p1">Completed Date & Time:</td>
             <td class="p2">{{$c_d.' '.$c_t}}</td>  
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

           <tr>
             <td class="p1">Weight of Granules Received:</td>
             <td class="p2">{{$gw}}</td>
             <td class="p1">Punch Size Used:</td>
             <td class="p2">{{$pun}}</td>  
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
             $p=$sub_processes->where('process.identity','compression1')->first() ;
             
                    ?>
                    
                    <p>{{$p['ticket_parameters']->where('parameter.identity','text')->first()->value }}</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','compression2')->first() ;
                    ?>
                    
                    <p>{{$p['ticket_parameters']->where('parameter.identity','text')->first()->value }}</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','compression3')->first() ;
                    ?>
                    
                    <p>{{$p['ticket_parameters']->where('parameter.identity','text')->first()->value }}</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','compression4')->first() ;
                    ?>
                    
                    <p>{{$p['ticket_parameters']->where('parameter.identity','text')->first()->value }}</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','compression5')->first() ;
                    ?>
                    
                    <p>{{$p['ticket_parameters']->where('parameter.identity','text')->first()->value }}</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','compression6')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','sampled_qty')->first()->value;
                $c= $p['ticket_parameters']->where('parameter.identity','sampled_by')->first()->value;
                $t= $p['ticket_parameters']->where('parameter.identity','date_time')->first()->value;
            ?>
                  
                       <p>{{$p['ticket_parameters']->where('parameter.identity','text')->first()->value }}</p>
                    <p>Quantity Sampled By QA:<span style="border-bottom: 1px solid black">{{$s}}</span></p>
                      <p>Sampled By:<span style="border-bottom: 1px solid black">{{$c}}</span>Date & time:<span style="border-bottom: 1px solid black">{{$t}}</span></p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','compression7')->first() ;
                
                $c= $p['ticket_parameters']->where('parameter.identity','Tailing_left')->first()->value;

                $tab=$p['tables']->where('table.identity','compression_material')->first() ;
              
            ?>
                  
                       <p>{{$p['ticket_parameters']->where('parameter.identity','text')->first()->value }}</p>

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



                            
                        </table>

                     <!--end table-->

                    
                      

                      <p>Tailing Left:<span style="border-bottom: 1px solid black">{{$c}}</span>Kg</p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

              
           </table>
          
             <center><h3 id="main_heading">COMPRESSION START UP ANALYSIS SHEET</h3></center>
             <center><h3>IN PROCESS WEIGHT MONITORING OF TABLETS</h3></center>

             <?php

                $sub_p=$sub_processes->where('process.identity','compression_startup_analysis')->first() ;
                
                

                $tab=$sub_p['tables']->where('table.identity','tablet_monitoring')->first() ;
  
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



                                                        
                        </table>

                     <!--end table-->

                     <?php

                $p=$sub_processes->where('process.identity','friability_test')->first() ;
                
                $c= $p['ticket_parameters']->where('parameter.identity','initial_weight')->first()->value;
                $c1= $p['ticket_parameters']->where('parameter.identity','final_weight')->first()->value;
                $c2= $p['ticket_parameters']->where('parameter.identity','result')->first();
                $c2=$c2->formula_result();
  
                 ?>

                     <h4>A. Test of Friability</h4>

                     <p>Initial Weight: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$c}} </span></p>
                      <p>Final Weight: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$c1}} </span></p>
                      <p>Calculation : &nbsp;<span style="border-bottom:1px solid black ">{{'Initial Weight'}}&nbsp; - &nbsp;  {{'Final Weight' }}&nbsp;   </span>&nbsp;X 100<br><span style="margin-left: 130px;">{{'Initial Weight'}}</span></p>
                       <p>Calculation: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$c2}} </span></p>

                       <h4>B. Weight Variation</h4>

                       <?php

                $p=$sub_processes->where('process.identity','weight_variation')->first() ;
                
                $c= $p['ticket_parameters']->where('parameter.identity','recommended_weight')->first()->value;
                $c1= $p['ticket_parameters']->where('parameter.identity','lower_weight')->first()->value;
                $c2= $p['ticket_parameters']->where('parameter.identity','upper_weight')->first()->value;
               

                $tab=$p['tables']->where('table.identity','weight_variation')->first() ;
  
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



                              </table>

                     <!--end table-->

                     <p>RECOMMENDED WEIGHT: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$c}} </span></p>
                      <p>LOWER WEIGHT: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$c1}} </span></p>
                      
                       <p>UPPER WEIGHT: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$c2}} </span></p>


                       <h4>C. Hardness</h4>

                       <?php

                $p=$sub_processes->where('process.identity','hardness')->first() ;
                
                $c= $p['ticket_parameters']->where('parameter.identity','average_hardness')->first()->value;
                $c1= $p['ticket_parameters']->where('parameter.identity','remarks')->first()->value;
                
               

                $tab=$p['tables']->where('table.identity','hardness')->first() ;
  
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



                              </table>

                     <!--end table-->

                     <p>Average Hardness: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$c}} </span></p>
                      <p>Remarks: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$c1}} </span></p>
                      
                      

                       <h4>E. Thickness</h4>

                       <?php

                $p=$sub_processes->where('process.identity','thickness')->first() ;
                
                $c= $p['ticket_parameters']->where('parameter.identity','average_thickness')->first()->value;
                $c1= $p['ticket_parameters']->where('parameter.identity','remarks')->first()->value;
                
               

                $tab=$p['tables']->where('table.identity','thickness')->first() ;
  
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



                              </table>

                     <!--end table-->

                     <p>Average Thickness: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$c}} </span></p>
                      <p>Remarks: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$c1}} </span></p>


 <center><h2 id="main_heading">IN PROCESS CONTROL SHEET FOR COMPRESSION</h2></center> 

                <?php

                $p=$sub_processes->where('process.identity','control_sheet_compression')->first() ;
                
               $c= $p['ticket_parameters']->where('parameter.identity','start_date')->first()->value;
                $c1= $p['ticket_parameters']->where('parameter.identity','complete_date')->first()->value;
                $c2= $p['ticket_parameters']->where('parameter.identity','average_thickness')->first()->value;
                $c3= $p['ticket_parameters']->where('parameter.identity','average_hardness')->first()->value;

                $c4= $p['ticket_parameters']->where('parameter.identity','disintegration_time')->first()->value;
                $c5= $p['ticket_parameters']->where('parameter.identity','punch_size')->first()->value;
                $c6= $p['ticket_parameters']->where('parameter.identity','weight_of_granules_received')->first()->value;
                $c7= $p['ticket_parameters']->where('parameter.identity','upper_punch')->first()->value;

                $c8= $p['ticket_parameters']->where('parameter.identity','theoretical_compression_weight')->first()->value;
                $c9= $p['ticket_parameters']->where('parameter.identity','lower_punch')->first()->value;
                $c10= $p['ticket_parameters']->where('parameter.identity','average_weight')->first()->value;
                $c11= $p['ticket_parameters']->where('parameter.identity','weight_limit')->first()->value;
                
               

                $tab=$p['tables']->where('table.identity','control_sheet')->first() ;
  
                 ?>

                 <table class="short_table" style="border-spacing: 0;">
                 
                 <tbody>
                  <tr>
                     <td style="width:30% ;">Compression Start Date:</td>
                     <td style="width:20% ;">{{$c}}</td>
                     <td style="width:30% ;">Compression Complete Date:</td>
                     <td style="width:20% ;">{{$c1}}</td>
                  </tr>

                  <tr>
                     <td>Average Thickness:</td>
                     <td>{{$c2}}</td>
                     <td>Average Hardness:</td>
                     <td>{{$c3}}</td>
                  </tr>

                  <tr>
                     <td>Disintegration Time:</td>
                     <td>{{$c4}}</td>
                     <td>Punch Size:</td>
                     <td>{{$c5}}</td>
                  </tr>

                  <tr>
                     <td>Weight of granules received:</td>
                     <td>{{$c6}}</td>
                     <td>Upper Punch:</td>
                     <td>{{$c7}}</td>
                  </tr>

                  <tr>
                     <td>Theoretical Compression Weight:</td>
                     <td>{{$c8}}</td>
                     <td>Lower Punch:</td>
                     <td>{{$c9}}</td>
                  </tr>

                  <tr>
                     <td>Average Weight / 10 Tablets:</td>
                     <td>{{$c10}}</td>
                     <td>Weight limit / 10 Tablets:</td>
                     <td>{{$c11}}</td>
                  </tr>

                  

                  </tbody>
                   
                 </table>


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



                              </table>

                     <!--end table-->
           

            <?php
             $p=$sub_processes->where('process.identity','sampling_request_sheet_compression')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','intimation_time')->first()->value;

                $s1= $p['ticket_parameters']->where('parameter.identity','sampling_time')->first()->value;
                
                
            ?>

           <center><h2 id="main_heading">SAMPLING REQUEST SHEET AFTER COMPRESSION</h2></center>

           <h3>To be filled by Production</h3>

           <div style="border: 1px solid black;padding: 15px;">

            <p> Stage : After Compression</p>
              <p> Date / Time of Intimation : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;">{{$s}} </span> </p>

              <p> Production Supervisor : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;">{{$s1}} </span> </p>
           </div>

           <h3>To be filled by QA</h3>

           <div style="border: 1px solid black;padding: 15px;">
              <p> Date / Time of Sampling : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>

              <p> QA Inspector : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>
           </div>


            <?php
             $p=$sub_processes->where('process.identity','storage_compressed_tablet')->first() ;

              $s1= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;

            $s2= $p['ticket_parameters']->where('parameter.identity','stage')->first()->value;

            $s3= $p['ticket_parameters']->where('parameter.identity','container_no')->first()->value;

            $s4= $p['ticket_parameters']->where('parameter.identity','container_weight')->first()->value;
            $s5= $p['ticket_parameters']->where('parameter.identity','total_container')->first()->value;
                
                
            ?>

           <center><h2 id="main_heading">STORAGE OF COMPRESSED TABLETS</h2></center>

           <p>{{$s1}}</p>

           <div style="border: 1px solid black;padding: 15px;">

              <table style="width: 100%;">

                <tr>
                   <td>Product Name:</td>
                   <td colspan="3" style="border-bottom: 1px dotted black;"></td>
                </tr>

                 <tr>
                   <td>Batch #:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
                    <td>Batch Size:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
                 </tr>

                 <tr>
                   <td>Mfg Date:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
                    <td>Exp Date:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
                 </tr>

                 <tr>
                   <td>Stage:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;">{{$s2}}</td>
                    <td>Container No:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;">{{$s3}}</td>
                 </tr>

                 <tr>
                   <td>Total weight of container:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;">{{$s4}}</td>
                    <td>Total No of container:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;">{{$s5}}</td>
                 </tr>


                 <tr>
                   <td>Batch #:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
                    <td>Batch Size:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
                 </tr>
                   
                   <tr>
                   <td>Production Officer:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
                    <td>QA Officer:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
                 </tr>




              </table>
           </div>

                      
                       

              <center><h2 id="main_heading">YIELD CALCULATION AFTER COMPRESSION</h2></center> 

                <?php

                $sub_p=$sub_processes->where('process.identity','compression_yield_calculation')->first() ;
                
                 $r=$sub_p['ticket_parameters']->where('parameter.identity','remarks')->first()->value;
                 

                 $aw=$sub_p['ticket_parameters']->where('parameter.identity','received_weight')->first()->value;
              $qa=$sub_p['ticket_parameters']->where('parameter.identity','total_weight')->first()->value;
              
              $tw=$sub_p['ticket_parameters']->where('parameter.identity','theoretical_tab')->first()->value;

              $n_aw=$sub_p['ticket_parameters']->where('parameter.identity','actual_tab')->first()->value;
              $n_qa=$sub_p['ticket_parameters']->where('parameter.identity','qa_sample')->first()->value;
              $n_t=$sub_p['ticket_parameters']->where('parameter.identity','qc_sample')->first()->value;
              $n_tw=$sub_p['ticket_parameters']->where('parameter.identity','tailing_left')->first()->value;

              $yield=$sub_p['ticket_parameters']->where('parameter.identity','yield')->first();
               
               $yield=$yield->formula_result();

                $loss=$sub_p['ticket_parameters']->where('parameter.identity','loss')->first();
               
               $loss=$loss->formula_result();

                 ?>

                 <p>Weight of Granules Received(Kg) : &nbsp;{{$aw }} </p>
                 <p>Total Weight of Compressed tablets(kg) : &nbsp;{{$qa }} </p>
                 <p>Theoretical no of tablets : &nbsp;{{$tw }} </p>
                 <p>Actual no of Tablets : &nbsp;{{$n_aw }} </p>

                 <p>% Yield : &nbsp;<span style="border-bottom:1px solid black ">{{'Actual no of Tabs'}}&nbsp; + &nbsp;  {{'QA Sample' }} + &nbsp; {{'QC Sample' }}&nbsp; + &nbsp;  {{'Tailing Left' }}&nbsp;  </span>&nbsp;* 100<br><span style="margin-left: 160px;">{{'Theoratical no of Tabs'}}</span></p>


                 <p>% Yield : {{$yield}}&nbsp;%</p>

                 <p>% Loss : 100 - % Yield</p>

                 <p>% Loss : {{$loss}}&nbsp;%</p>

          
           <table style="width: 100%;">
             <tr>
               <td style="width: 20%;"><p>Remarks (if any) :</p></td>
               <td style="width: 80%;"><p style="border-bottom: 1px solid black;display: block;">&nbsp;&nbsp;{{$r}}</p></td>
             </tr>
           </table>
           

        </main>


        
    </body>
</html>