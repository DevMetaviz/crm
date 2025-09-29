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
                font-family: times new roman;
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
              $d=$top_parameters->where('parameter.identity','start_date')->first()->value;
              $t=$top_parameters->where('parameter.identity','start_time')->first()->value;
              $c_d=$top_parameters->where('parameter.identity','complete_date')->first()->value;
              $c_t=$top_parameters->where('parameter.identity','completion_time')->first()->value;
              $t_t=$top_parameters->where('parameter.identity','total_time')->first()->value;
              $l_t=$top_parameters->where('parameter.identity','lead_time')->first()->value;
              $temp=$top_parameters->where('parameter.identity','temperature')->first()->value;
              $humi=$top_parameters->where('parameter.identity','humidity')->first()->value;
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
             $p=$sub_processes->where('process.identity','coating1')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','mixing_time')->first()->value;
                $tab=$p['tables']->where('table.identity','coating_material')->first() ;
            
            ?>
                  <center><h4>{{'Coating Solution Preparation:'}}</h4></center>

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
                     
                       <p>{{$p['ticket_parameters']->where('parameter.identity','method')->first()->value }}</p>
                    <p>Total Mixing time:<span style="border-bottom: 1px solid black">{{$s}}</span></p>
                      
                      <p>Apply the coating solution to the core tablet and adjust the following parameters:</p>

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                    <?php
             $p=$sub_processes->where('process.identity','coating2')->first() ;
            
                $tab=$p['tables']->where('table.identity','coating_parameters')->first() ;
            
            ?>


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


                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','coating3')->first() ;
                
                $t= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            ?>
                
                

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
             $p=$sub_processes->where('process.identity','coating4')->first() ;
                
                $t= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            ?>
                
                

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
             $p=$sub_processes->where('process.identity','coating5')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','sampled_qty')->first()->value;
                $c= $p['ticket_parameters']->where('parameter.identity','sampled_by')->first()->value;
                $t= $p['ticket_parameters']->where('parameter.identity','date_time')->first()->value;
            ?>
                
                       <p>Intimate QA for sampling of coated tablet.</p>
                    <p>Quantity sampled by QA =<span style="border-bottom: 1px solid black">{{$s}}</span></p>
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
             $p=$sub_processes->where('process.identity','coating6')->first() ;
                
                $t= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            ?>
                
                

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
             $p=$sub_processes->where('process.identity','coating7')->first() ;
                
                $t= $p['ticket_parameters']->where('parameter.identity','date_time')->first()->value;
                 $t1= $p['ticket_parameters']->where('parameter.identity','tailing_left')->first()->value;

                    $tab=$p['tables']->where('table.identity','coating7_material')->first() ;
            ?>

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
                
                
                  <p>QC release date and time:<span style="border-bottom: 1px solid black">{{$t}}</span></p>
                  <p>Tailing Left:<span style="border-bottom: 1px solid black">{{$t1}}</span>Kg</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

   
               
           </table>

           <center><h3 id="main_heading">YIELD CALCULATION AFTER COATING</h3></center>


           <?php
                $process=$sub_processes->where('process.identity','coating_yield')->first() ;

                $wcr=$process['ticket_parameters']->where('parameter.identity','w_cores_received')->first()->value;
                $awc=$process['ticket_parameters']->where('parameter.identity','average_weight_cores')->first()->value;

                $cr=$process['ticket_parameters']->where('parameter.identity','cores_received')->first()->value;

                $tw=$process['ticket_parameters']->where('parameter.identity','total_weight')->first()->value;

                $awct=$process['ticket_parameters']->where('parameter.identity','average_weight_coated_tab')->first()->value;

                $act=$process['ticket_parameters']->where('parameter.identity','approximate_coated_tabs')->first();
                $act=$act->formula_result();

                $pl=$process['ticket_parameters']->where('parameter.identity','process_loss')->first();
                $pl=$pl->formula_result();

                $pl1=$process['ticket_parameters']->where('parameter.identity','percent_loss')->first();
                $pl1=$pl1->formula_result();

                $ml=$process['ticket_parameters']->where('parameter.identity','mix_loss')->first()->value;

                $cl=$process['ticket_parameters']->where('parameter.identity','compression_loss')->first()->value;

                $tl=$process['ticket_parameters']->where('parameter.identity','total_loss')->first();
                $tl=$tl->formula_result();

                $r=$process['ticket_parameters']->where('parameter.identity','remarks')->first()->value;
               //name

                  $t_wcr=$process['ticket_parameters']->where('parameter.identity','w_cores_received')->first()->parameter->name;
                $t_awc=$process['ticket_parameters']->where('parameter.identity','average_weight_cores')->first()->parameter->name;

                $t_cr=$process['ticket_parameters']->where('parameter.identity','cores_received')->first()->parameter->name; 

                $t_tw=$process['ticket_parameters']->where('parameter.identity','total_weight')->first()->parameter->name;

                $t_awct=$process['ticket_parameters']->where('parameter.identity','average_weight_coated_tab')->first()->parameter->name;

                $t_act=$process['ticket_parameters']->where('parameter.identity','approximate_coated_tabs')->first()->parameter->name;
              

                $t_pl=$process['ticket_parameters']->where('parameter.identity','process_loss')->first()->parameter->name;
                

                $t_pl1=$process['ticket_parameters']->where('parameter.identity','percent_loss')->first()->parameter->name;
              

                $t_ml=$process['ticket_parameters']->where('parameter.identity','mix_loss')->first()->parameter->name;

                $t_cl=$process['ticket_parameters']->where('parameter.identity','compression_loss')->first()->parameter->name;

                $t_tl=$process['ticket_parameters']->where('parameter.identity','total_loss')->first()->parameter->name;
              

                $t_r=$process['ticket_parameters']->where('parameter.identity','remarks')->first()->parameter->name;

                    ?>
          
          

          <p>Approximate No. of Coated Tablets:&nbsp;<span style="border-bottom:1px solid black ">{{$t_tw}}&nbsp; </span>&nbsp;* 1000&nbsp;* 1000<br><span style="margin-left: 160px;">{{$t_awct}}</span></p>

          <p>Approximate No. of Coated Tablets:&nbsp;<span style="border-bottom:1px solid black ">{{$tw}}&nbsp; </span>&nbsp;* 1000&nbsp;* 1000<br><span style="margin-left: 160px;">{{$awct}}</span></p>

         <p>Approximate No. of Coated Tablets: {{$act}}&nbsp;&nbsp;</p>
           
           <p>Process Loss at this stage:  &nbsp;<span style="border-bottom:1px solid black ">{{'('.$t_cr}}&nbsp; - &nbsp; {{$t_act.')' }}&nbsp;x &nbsp; {{$t_awc }}&nbsp;</span><br><span style="margin-left: 105px;">{{'1000 x 1000'}}</span></p>

         <p>Process Loss at this stage:  &nbsp;<span style="border-bottom:1px solid black ">{{'('.$cr}}&nbsp; - &nbsp; {{$act.')' }}&nbsp;x &nbsp; {{$awc }}&nbsp;</span><br><span style="margin-left: 105px;">{{'1000 x 1000'}}</span></p>


         <p>Process Loss at this stage: <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$pl.' kg'}}&nbsp;&nbsp;</span></p>
    
         <p>%age Loss at this stage:  &nbsp;<span style="border-bottom:1px solid black ">{{$t_pl}}&nbsp;</span>x 100<br><span style="margin-left: 105px;">{{$t_cr}}</span></p>

         <p>%age Loss at this stage:  &nbsp;<span style="border-bottom:1px solid black ">{{$pl}}&nbsp;</span>x 100<br><span style="margin-left: 105px;">{{$cr}}</span></p>

         <p>%age Loss at this stage: <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$pl1.' kg'}}&nbsp;&nbsp;</span></p>


          <p>Total Loss(%): &nbsp;{{$t_ml}}&nbsp;+&nbsp;{{$t_cl}}&nbsp;+&nbsp;{{$t_pl1}}&nbsp;</p>
          <p>Total Loss(%): &nbsp;{{$ml}}&nbsp;+&nbsp;{{$cl}}&nbsp;+&nbsp;{{$pl1}}&nbsp;</p>
         <p>Total Loss(%): &nbsp;&nbsp;{{$tl}}&nbsp;&nbsp;</p>
                


          
           <table style="width: 100%;">
             <tr>
               <td style="width: 20%;"><p>Remarks (if any) :</p></td>
               <td style="width: 80%;"><p style="border-bottom: 1px solid black;display: block;">&nbsp;&nbsp;{{$r}}</p></td>
             </tr>
           </table>

           

        </main>


        
    </body>
</html>