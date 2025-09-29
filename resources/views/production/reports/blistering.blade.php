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

                      .page-break {
    page-break-after: always;
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
              $temp='';$humi='';
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
             $p=$sub_processes->where('process.identity','blistering1')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            
            ?>
                  
                       <p>{{$s }}</p>
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering2')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            
            ?>
                  
                       <p>{{$s }}</p>
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering3')->first() ;

                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
                $c= $p['ticket_parameters']->where('parameter.identity','temperature')->first()->value;
                $t= $p['ticket_parameters']->where('parameter.identity','humidity')->first()->value;

            ?>
                  
                  <p>{{$s}}</p>
                   
                  <p>Actual Temprature:<span style="border-bottom: 1px solid black">{{$c}}</span>Humidity:<span style="border-bottom: 1px solid black">{{$t}}</span></p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering4')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            
            ?>
                  
                       <p>{{$s }}</p>
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering5')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            
            ?>
                  
                       <p>{{$s }}</p>
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering6')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            
            ?>
                  
                       <p>{{$s }}</p>
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering7')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            $tab=$p['tables']->where('table.identity','blistering7_table')->first() ;
            ?>
                  
                       <p>{{$s }}</p>
                   
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
                     
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering8')->first() ;

                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
                $c= $p['ticket_parameters']->where('parameter.identity','result')->first()->value;
              

            ?>
                  
                  <p>{{$s}}</p>
                  <p>Limit of Leakage test is NMT 2%.</p>
                   
                  <p>Result is <span style="border-bottom: 1px solid black">{{$c}}</span></p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering9')->first() ;
                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            
            ?>
                  
                       <p>{{$s }}</p>
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;">SR #</td>
                   <td style="width: 50%;">MANUFACTURING OPERATION</td>
                   <td style="width: 15%;">PERFORMED BY (OPERATOR)</td>
                   <td style="width: 15%;">CHECKED BY(PROD./QA OFFICER)</td>
                   <td style="width: 15%;">DATE</td>
               </tr>


               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering10')->first() ;

                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
                $c= $p['ticket_parameters']->where('parameter.identity','result')->first()->value;
              

            ?>
                  
                  <p>{{$s}}</p>
                  <p>Limit of Leakage test is NMT 2%.</p>
                   
                  <p>Result is <span style="border-bottom: 1px solid black">{{$c}}</span></p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>


               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering11')->first() ;
                
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
             $p=$sub_processes->where('process.identity','blistering12')->first() ;
                
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
             $p=$sub_processes->where('process.identity','blistering13')->first() ;
                
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
             $p=$sub_processes->where('process.identity','blistering14')->first() ;

                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
                $c= $p['ticket_parameters']->where('parameter.identity','rejected_blisters')->first()->value;
              

            ?>
                  
                  <p>{{$s}}</p>
                  
                   
                  <p>Number of defective/rejected blisters <span style="border-bottom: 1px solid black">{{$c}}</span></p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering15')->first() ;
                
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
             $p=$sub_processes->where('process.identity','blistering16')->first() ;
                
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
             $p=$sub_processes->where('process.identity','blistering17')->first() ;

                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
                $c= $p['ticket_parameters']->where('parameter.identity','tailing_left')->first()->value;
              

            ?>
                  
                  <p>{{$s}}</p>
                  
                   
                  <p>Tailing Left <span style="border-bottom: 1px solid black">{{$c}}</span> Kg.</p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>



               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','blistering18')->first() ;
                
                $t= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            ?>
                
                

                       <p>{{$t}}</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>
   
               
           </table>

           <div class="page-break"></div>

           <center><h3 id="main_heading">EMBOSSING CONTROL SHEET</h3></center>

           <?php
             $p=$sub_processes->where('process.identity','embossing_control_sheet')->first() ;
                
                $m= $p['ticket_parameters']->where('parameter.identity','machine')->first()->value;
                $i= $p['ticket_parameters']->where('parameter.identity','id')->first()->value;
                $d= $p['ticket_parameters']->where('parameter.identity','date_time')->first()->value;
                $o= $p['ticket_parameters']->where('parameter.identity','operator')->first()->value;
            ?>
            <table style="width: 100%;">
              <tr>
                <td style="width: 50%;">Machine Name: <span style="border-bottom: 1px solid black">{{$m}}</span></td>
                <td style="width: 50%;">ID # <span style="border-bottom: 1px solid black">{{$i}}</span></td>
              </tr>
              <tr>
                <td>Date/time:<span style="border-bottom: 1px solid black">{{$d}}</span></td>
                <td>Operator:<span style="border-bottom: 1px solid black">{{$o}}</span></td>
              </tr>
            </table>

           <center><h3 id="main_heading">EMBOSSING INFORMATION ON BLISTER</h3></center>

           <?php
             $p=$sub_processes->where('process.identity','embossing_info')->first() ;
                
                $t= $p['ticket_parameters']->where('parameter.identity','stamp')->first()->value;
                $s= $p['ticket_parameters']->where('parameter.identity','supervisor')->first()->value;

            ?>

            <p>Embossing Stamp: <span style="border-bottom: 1px solid black">{{$t}}</span></p>

            <p>Packaging Supervisor: <span style="border-bottom: 1px solid black">{{$s}}</span></p>

            <table style="width: 100%;">
              <tr>
                <td style="width:30%;"></td>
                <td style="width:40%;"></td>
                <td style="width:30%;"></td>
              </tr>
            </table>

        </main>


        
    </body>
</html>