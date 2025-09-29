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


.page-break {
    page-break-after: always;
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
            
           <center><h3 id="main_heading">PACKAGING AND PRINTING INSTRUCTION</h3></center>
         <?php 
              $d=$top_parameters->where('parameter.identity','packing_start_date')->first()->value;
              $t=$top_parameters->where('parameter.identity','packing_start_time')->first()->value;
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
                   <th style="width: 50%;">WORKING INSTRUCTIONS</th>
                   <th style="width: 15%;">PERFORMED BY (OPERATOR)</th>
                   <th style="width: 15%;">CHECKED BY(PROD./QA OFFICER)</th>
                   <th style="width: 15%;">DATE</th>
               </tr>
             
             <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','printing1')->first() ;
                //$s= $p['ticket_parameters']->where('parameter.identity','qty_received')->first()->value;
                 //$t= $p['ticket_parameters']->where('parameter.identity','tablets')->first()->value;

             $s=''; $t='';
            ?>
                  
                       <p>{{$s }}</p>
                   
                      <p>Qty received = <span style="border-bottom: 1px solid black">{{$s}}&nbsp;</span>Kg =Tablets = <span style="border-bottom: 1px solid black">{{$t}}</span>&nbsp; Packs</p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','printing2')->first() ;
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
             $p=$sub_processes->where('process.identity','printing3')->first() ;

                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
                

            ?>
                  
                  <p>{{$s}}</p>
                  
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','printing4')->first() ;
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
             $p=$sub_processes->where('process.identity','printing5')->first() ;
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
             $p=$sub_processes->where('process.identity','printing6')->first() ; 
                $s1= $p['ticket_parameters']->where('parameter.identity','started_at')->first()->value;
                $s2= $p['ticket_parameters']->where('parameter.identity','completed_at')->first()->value;
                $s3= $p['ticket_parameters']->where('parameter.identity','total_time')->first()->value;
            
            ?>
                  
                       <p>{{$s1 }}</p>
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
          
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','printing8')->first() ;

                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
        
              

            ?>
                  
                  <p>{{$s}}</p>
                  

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','printing9')->first() ;
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
             $p=$sub_processes->where('process.identity','printing10')->first() ;

                $s= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
                //$c= $p['ticket_parameters']->where('parameter.identity','qty_per_shipper')->first()->value;
                 $c='';

            ?>
                  
                  <p>{{$s}}</p>
              
                   
                  <p>Qty of cartons packed per shipper:  <span style="border-bottom: 1px solid black">{{$c}}</span></p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>


               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','printing11')->first() ;
                
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
             $p=$sub_processes->where('process.identity','printing12')->first() ;
                
                $t= $p['ticket_parameters']->where('parameter.identity','method')->first()->value;
            ?>
                
                

                       <p>{{$t}}</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <th style="width: 5%;">SR #</th>
                   <th style="width: 50%;">WORKING INSTRUCTIONS</th>
                   <th style="width: 15%;">PERFORMED BY (OPERATOR)</th>
                   <th style="width: 15%;">CHECKED BY(PROD./QA OFFICER)</th>
                   <th style="width: 15%;">DATE</th>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','printing13')->first() ;
                
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
             $p=$sub_processes->where('process.identity','printing14')->first() ;

                $s= $p['ticket_parameters']->where('parameter.identity','test_sample')->first()->value;
                $c= $p['ticket_parameters']->where('parameter.identity','reference_sample')->first()->value;
                $s1= $p['ticket_parameters']->where('parameter.identity','stability_sample')->first()->value;
                $c1= $p['ticket_parameters']->where('parameter.identity','validation_sample')->first()->value;
                $s2= $p['ticket_parameters']->where('parameter.identity','others')->first()->value;
                
              

            ?>
                  
                  <p><b>Sample Quantity:</b></p>
                  
                   
                  <p>Test Samples: <span style="border-bottom: 1px solid black">{{$s}}</span> Packs</p>
                  <p>Reference Samples: <span style="border-bottom: 1px solid black">{{$c}}</span> Packs</p>
                  <p>Stability Samples: <span style="border-bottom: 1px solid black">{{$s1}}</span> Packs</p>
                  <p>Validation Samples: <span style="border-bottom: 1px solid black">{{$c1}}</span> Packs</p>
                  <p>Others (if any)<span style="border-bottom: 1px solid black">{{$s2}}</span> Packs</p>

                  <p>Sampled By: QAO (Sign & Date)<span style="border-bottom: 1px solid black">________</p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('process.identity','printing15')->first() ;
                
                $t= $p['ticket_parameters']->where('parameter.identity','date_time')->first()->value;
            ?>
                
                

                       <p>QC Release Date & Time:<span style="border-bottom: 1px solid black"> {{$t}}</span></p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

   
               
           </table>
            

            <div class="page-break"></div>
            <center><h3 id="main_heading">PACKING RECONCILIATION</h3></center>

            <?php
                $process=$sub_processes->where('process.identity','packing_reconciliation')->first() ;
                 
                 $tp=$process['ticket_parameters']->where('parameter.identity','total_packs')->first()->value;
                $qc=$process['ticket_parameters']->where('parameter.identity','qc_sample')->first()->value;

                $t=$process['ticket_parameters']->where('parameter.identity','tailing')->first()->value;

                $ty=$process['ticket_parameters']->where('parameter.identity','theoretical_yield')->first()->value;

                $py=$process['ticket_parameters']->where('parameter.identity','practical_yield')->first()->value;

               //name
                $t_ty=$process['ticket_parameters']->where('parameter.identity','theoretical_yield')->first()->parameter_name;
                $t_qc=$process['ticket_parameters']->where('parameter.identity','qc_sample')->first()->parameter_name;
                $t_t=$process['ticket_parameters']->where('parameter.identity','tailing')->first()->parameter_name;
                $t_py=$process['ticket_parameters']->where('parameter.identity','practical_yield')->first()->parameter_name;

                $yield=$process['ticket_parameters']->where('parameter.identity','yield')->first();
               
               $result=$yield->formula_result();


               $r=$process['ticket_parameters']->where('parameter.identity','remarks')->first()->value;

                    ?>
          

         <p>Total number of packs: <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$tp}}&nbsp;&nbsp;</span></p>

         <p>QC samples: <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$qc}}&nbsp;&nbsp;</span></p>

         <p>Tailing Left (if any): <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$t.' packs'}}&nbsp;&nbsp;</span></p>

         <p>Theoretical yield: <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$ty}}&nbsp;&nbsp;</span></p>

         <p>Practical yield: <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$py}}&nbsp;&nbsp;</span></p>



                

               

                <p>% Yield of batch= &nbsp;<span style="border-bottom:1px solid black ">{{$t_py}}&nbsp; + &nbsp; {{$t_qc }}&nbsp;+ &nbsp; {{$t_t }}&nbsp;</span>&nbsp;* 100<br><span style="margin-left: 135px;">{{$t_ty}}</span></p>

                 <p>% Yield of batch= &nbsp;<span style="border-bottom:1px solid black ">{{$py}}&nbsp; + &nbsp; {{$qc }}&nbsp;+ &nbsp; {{$t }}&nbsp;</span>&nbsp;* 100<br><span style="margin-left: 130px;">{{$ty}}</span></p>

                <p>% Yield = {{$result}}&nbsp;%</p>

                



          
           <table style="width: 100%;">
             <tr>
               <td style="width: 20%;"><p>Remarks (if any) :</p></td>
               <td style="width: 80%;"><p style="border-bottom: 1px solid black;display: block;">&nbsp;&nbsp;{{$r}}</p></td>
             </tr>
           </table>

           

        </main>


        
    </body>
</html>