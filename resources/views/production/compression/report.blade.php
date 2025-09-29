<html>
    <head>
        <title>{{$plan['plan_no']}}</title>
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

                 #control-sheet tr td {
                     /*height: 60px
                    max-height : 20px;*/
                    
                 }

             .col{
                  display:inline-block;
                  border: 1px solid black;
                  margin: 0px;
                  height: 20px; 
                  text-align: center;
                      
             }

             .c1{
                  width: 8%;
                  min-height: 60px;
             }

             .c2{
                  width: 8%;
             }

             .c3{
                  width: 5.5%; /*60*/
             }

             .c4{
                  width: 8%;
             }

             .c5{
                  width: 10%;
             }
                              
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
      @include('production.granulation.header')

       

      @include('production.granulation.footer')
        
        <!-- Wrap the content of your PDF inside a main tag -->



        <main style="width: 100%;">
          

          <div>
                  <div class="row">
                                
                        <div class="col c1">Date</div>
                        <div class="col c2">Time</div>
                        @for($i=1;$i<=10;$i++)
                        <div class="col c3">{{$i}}</div>
                         @endfor
                         <div class="col c4">Average</div>
                          <div class="col c5">Verified By (QA)</div>
                                
                  </div>
            </div>
            
           <center><h3 id="main_heading">STANDARD MANUFACTURING PROCEDUTRE FOR COMPRESSION</h3></center>
         
           <?php 
         $de=date_create($plan['compression']['start_date'] );
           $de=date_format($de,"d-M-Y h:i a");

           $de1=date_create($plan['compression']['comp_date'] );
           $de1=date_format($de1,"d-M-Y h:i a");

          
          ?>
         <table id="main_top">
           <tr>
             <td class="p1">Starting Date & Time:</td>
             <td class="p2">{{$de}}</td>
             <td class="p1">Completed Date & Time:</td>
             <td class="p2">{{$de1}}</td>  
           </tr>
           <tr>
             <td class="p1">Total Time:</td>
             <td class="p2">{{$plan['compression']->total_time()}}</td>
             <td class="p1">Standard Lead Time:</td>
             <td class="p2">{{$plan['compression']['lead_time']}}</td>  
           </tr>
           <tr>
             <td class="p1">Temprature:</td>
             <td class="p2">{{$plan['compression']['temprature']}}</td>
             <td class="p1">Humidity:</td>
             <td class="p2">{{$plan['compression']['humidity']}}</td>  
           </tr>

           <tr>
             <td class="p1">Weight of Granules Received:</td>
             <td class="p2">{{$plan['compression']['granules_weight']}}</td>
             <td class="p1">Punch Size Used:</td>
             <td class="p2">{{$plan['compression']['punch_size']}}</td>  
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
                    
                    
                    <p>Fix the punch set of Rotary machine and adjust the machine according to the specification.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                    
                    <p>After machine adjustment, provide sample to QA for Physical testing.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                    
                    <p>After physical testing release, start the compression machine.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                    
                    <p>Fill In-process check sheet for compression after every half an hour.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                  
                    
                    <p>Sieve the underweight tablets through oscillating granulator using desired sieve.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                   
                  
                       <p>After completion of batch, intimate QA for sampling of compressed tablet.</p>
                    <p>Quantity Sampled By QA:<span style="border-bottom: 1px solid black"></span></p>
                      <p>Sampled By:<span style="border-bottom: 1px solid black"></span>Date & time:<span style="border-bottom: 1px solid black"></span></p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                  
                       <p>After Sampling, weigh tablets and store in Quarantine with quarantine label till QC release.</p>

                         <!--table start -->
                   
                        <table style="border-spacing: 0;margin: 10;" class="short_table">
                             <tr>
                                <th>Container #</th>
            
                                 <th>Gross Weight (kg)</th>
                                 <th>Tare Weight (kg)</th>
                                 <th>Net Weight (kg)</th>
                                 <th>Performed By</th>
                             </tr>
                            

                           <tbody>
                            
                            @foreach($plan['compression']['containers'] as $item)

                             <tr>
                              

                               
                                <td>{{$item['no']}}</td>
    
                                 <td>{{$item['gross']}}</td>
                               <td>{{$item['tare']}}</td>
                              <td>{{$item['net']}}</td>
                               <td>{{$item['performed_by']}}</td>

                               
                             </tr>
                        
                             @endforeach
                             </tbody>



                             <tr>
                               
                               <th>
                                
                             </th>
                            
                               <!--  <th></th> -->
                             </tr>
                        </table>

                     <!--end table-->

                    
                      

                      <p>Tailing Left:<span style="border-bottom: 1px solid black"></span>Kg</p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

              
           </table>
          
             <center><h3 id="main_heading">COMPRESSION START UP ANALYSIS SHEET</h3></center>
             <center><h3>IN PROCESS WEIGHT MONITORING OF TABLETS</h3></center>

             

                 <!--table start -->
                     
                        <table style="border-spacing: 0;margin: 10;" class="short_table">
                             <tr>
                               
                                  <th></th>
                            
                             </tr>
                            

                           <tbody>
                            
                         
                             <tr>
                              
                              <td>

                           

                               </td>

                               
                            
                               
                             </tr>
                       
                             </tbody>



                                                        
                        </table>

                     <!--end table-->

                    

                     <h4>A. Test of Friability</h4>

                     <p>Initial Weight: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$plan['compression']['initial_weight']}} </span></p>
                      <p>Final Weight: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$plan['compression']['final_weight']}} </span></p>
                      <p>Calculation : &nbsp;<span style="border-bottom:1px solid black ">{{'Initial Weight'}}&nbsp; - &nbsp;  {{'Final Weight' }}&nbsp;   </span>&nbsp;X 100<br><span style="margin-left: 130px;">{{'Initial Weight'}}</span></p>
                       <p>Calculation: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;"> </span></p>

                       <h4>B. Weight Variation</h4>

                       


                       <!--table start -->
                    
                        <table style="border-spacing: 0;margin: 10;" class="short_table">
                             <tr>
                              
                                  <th></th>
                             
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                           
                             <tr>
                              
                              <td>

                        

                               </td>

                         
                               
                             </tr>
                        
                        
                             </tbody>



                              </table>

                     <!--end table-->

                     <p>RECOMMENDED WEIGHT: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$plan['compression']['recommended_weight']}} </span></p>
                      <p>LOWER WEIGHT: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;"> </span></p>
                      
                       <p>UPPER WEIGHT: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;"> </span></p>


                       <h4>C. Hardness</h4>

                      


                       <!--table start -->
                     
                        <table style="border-spacing: 0;margin: 10;" class="short_table">
                             <tr>
                             
                                  <th></th>
                             
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                          
                             <tr>
                              
                              <td>

                             

                               </td>

                          
                               
                             </tr>
                        
                        
                             </tbody>



                              </table>

                     <!--end table-->

                     <p>Average Hardness: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;"> </span></p>
                      <p>Remarks: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$plan['compression']['hardness_remarks']}} </span></p>
                      
                      

                       <h4>E. Thickness</h4>

                       

                       <!--table start -->
                     
                        <table style="border-spacing: 0;margin: 10;" class="short_table">
                             <tr>
                                
                                  <th></th>
                                
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                            
                             <tr>
                               
                              <td>

                              

                               </td>

                             
                               
                             </tr>
                        
                             </tbody>



                              </table>

                     <!--end table-->

                     <p>Average Thickness: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;"> </span></p>
                      <p>Remarks: <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 10em;">{{$plan['compression']['thickness_remarks']}} </span></p>


 <center><h2 id="main_heading">IN PROCESS CONTROL SHEET FOR COMPRESSION</h2></center> 

                

                 <table class="short_table" style="border-spacing: 0;">
                 
                 <tbody>
                  <tr>
                     <td style="width:30% ;">Compression Start Date:</td>
                     <td style="width:20% ;"></td>
                     <td style="width:30% ;">Compression Complete Date:</td>
                     <td style="width:20% ;"></td>
                  </tr>

                  <tr>
                     <td>Average Thickness:</td>
                     <td></td>
                     <td>Average Hardness:</td>
                     <td></td>
                  </tr>

                  <tr>
                     <td>Disintegration Time:</td>
                     <td></td>
                     <td>Punch Size:</td>
                     <td></td>
                  </tr>

                  <tr>
                     <td>Weight of granules received:</td>
                     <td></td>
                     <td>Upper Punch:</td>
                     <td></td>
                  </tr>

                  <tr>
                     <td>Theoretical Compression Weight:</td>
                     <td></td>
                     <td>Lower Punch:</td>
                     <td></td>
                  </tr>

                  <tr>
                     <td>Average Weight / 10 Tablets:</td>
                     <td></td>
                     <td>Weight limit / 10 Tablets:</td>
                     <td></td>
                  </tr>

                  

                  </tbody>
                   
                 </table>


                       <!--table start -->
                    
                        <table style="border-spacing: 0;margin: 10;" class="short_table" id="control-sheet">
                             <tr>
                                
                                  <th>Date</th>
                                  <th>Time</th>
                                  @for($i=1;$i<=10;$i++)
                                  <th>{{$i}}</th>
                                   @endfor
                                   <th>Average</th>
                                    <th>Verified By (QA)</th>
                                
                             </tr>
                            

                           <tbody>
                            
                            @foreach($plan['compression']['control_sheet'] as $con)
                             <tr style="min-height: 100px;">
                               
                              <td>{{$con['date']}}</td>
                              <td>{{$con['time']}}</td>
                              @for($i=1;$i<=10;$i++)
                              <td>{{$con['num'.$i]}}</td>
                              @endfor
                              <td></td>
                              <td style="height: 30px;" ></td>

                               
                             
                               
                             </tr>
                             @endforeach
                            
                             </tbody>



                              </table>

                     <!--end table-->
           

           
           

           <center><h2 id="main_heading">SAMPLING REQUEST SHEET AFTER COMPRESSION</h2></center>

           <h3>To be filled by Production</h3>

           <div style="border: 1px solid black;padding: 15px;">

            <p> Stage : After Compression</p>
              <p> Date / Time of Intimation : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>

              <p> Production Supervisor : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>
           </div>

           <h3>To be filled by QA</h3>

           <div style="border: 1px solid black;padding: 15px;">
              <p> Date / Time of Sampling : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>

              <p> QA Inspector : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>
           </div>


            

           <center><h2 id="main_heading">STORAGE OF COMPRESSED TABLETS</h2></center>

           <p></p>

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
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
                    <td>Container No:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
                 </tr>

                 <tr>
                   <td>Total weight of container:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
                    <td>Total No of container:</td>
                   <td style="border-bottom: 1px dotted black;width:25%;"></td>
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

               

                 <p>Weight of Granules Received(Kg) : &nbsp;{{''}} </p>
                 <p>Total Weight of Compressed tablets(kg) : &nbsp;{{'' }} </p>
                 <p>Theoretical no of tablets : &nbsp;{{'' }} </p>
                 <p>Actual no of Tablets : &nbsp;{{'' }} </p>

                 <p>% Yield : &nbsp;<span style="border-bottom:1px solid black ">{{'Actual no of Tabs'}}&nbsp; + &nbsp;  {{'QA Sample' }} + &nbsp; {{'QC Sample' }}&nbsp; + &nbsp;  {{'Tailing Left' }}&nbsp;  </span>&nbsp;* 100<br><span style="margin-left: 160px;">{{'Theoratical no of Tabs'}}</span></p>


                 <p>% Yield : {{'$'}}&nbsp;%</p>

                 <p>% Loss : 100 - % Yield</p>

                 <p>% Loss : {{'$loss'}}&nbsp;%</p>

          
           <table style="width: 100%;">
             <tr>
               <td style="width: 20%;"><p>Remarks (if any) :</p></td>
               <td style="width: 80%;"><p style="border-bottom: 1px solid black;display: block;">&nbsp;&nbsp;</p></td>
             </tr>
           </table>
           

        </main>


        
    </body>
</html>