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
       @include('production.granulation.header')

       

      @include('production.granulation.footer')
        
        <!-- Wrap the content of your PDF inside a main tag -->



        <main style="width: 100%;">
            
           <center><h3 id="main_heading">STANDARD MANUFACTURING PROCEDUTRE FOR COATING</h3></center>
         

         <table id="main_top">
           <tr>
             <td class="p1">Starting Date & Time:</td>
             <td class="p2">{{$plan['coating']['start_date']}}</td>
             <td class="p1">Completed Date & Time:</td>
             <td class="p2">{{$plan['coating']['comp_date']}}</td>  
           </tr>
           <tr>
             <td class="p1">Total Time:</td>
             <td class="p2"></td>
             <td class="p1">Standard Lead Time:</td>
             <td class="p2">{{$plan['coating']['lead_time']}}</td>  
           </tr>
           <tr>
             <td class="p1">Temprature:</td>
             <td class="p2">{{$plan['coating']['temprature']}}</td>
             <td class="p1">Humidity:</td>
             <td class="p2">{{$plan['coating']['humidity']}}</td>  
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
                   
                  <center><h4>{{'Coating Solution Preparation:'}}</h4></center>

                  <!--table start -->
                    

                     <!--end table-->
                     
                    <p>Dissolve Coat dry White in IPA and R.O Water mix for 45 min.</p>
                    <p>Total Mixing time:<span style="border-bottom: 1px solid black">{{$plan['coating']['mix_time']}}</span></p>
                      
                      <p>Apply the coating solution to the core tablet and adjust the following parameters:</p>

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    


            <!--table start -->
                    
                        <table style="border-spacing: 0;margin: 10;">
                             <tr>
                                
                                  <th>Parameters</th>
                                  <th>Required</th>
                                  <th>Actual</th>
                              
                             
                             </tr>
                            

                           <tbody>
                            
                          
                             <tr> 
                              <td>Inlet Temperature</td>
                              <td>75 – 85<sup>o</sup>C</td>
                               <td>{{$plan['coating']['inlet_temperature']}}</td>
                              </tr>

                              <tr> 
                              <td>Bed Temperature</td>
                              <td>40 – 50<sup>o</sup>C</td>
                               <td>{{$plan['coating']['bed_temperature']}}</td>
                              </tr>

                              <tr> 
                              <td>Outlet Temperature</td>
                              <td>65 – 75<sup>o</sup>C</td>
                               <td>{{$plan['coating']['outlet_temperature']}}</td>
                              </tr>

                              <tr> 
                              <td>Machine Speed</td>
                              <td>2 – 5 rpm</td>
                               <td>{{$plan['coating']['machine_speed']}}</td>
                              </tr>

                              <tr> 
                              <td>Distance between spray guns and tabs</td>
                              <td>10 – 18 inches</td>
                               <td>{{$plan['coating']['distance_spray_gun']}}</td>
                              </tr>


                              
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
                    
                

                       <p>Fill the in-process check sheet for coating after every hour.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>


               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    

                       <p>After completion of coating, Unload the batch in polythene lined S S container.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>



               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                   
                       <p>Intimate QA for sampling of coated tablet.</p>
                    <p>Quantity sampled by QA =<span style="border-bottom: 1px solid black"></span></p>
                      <p>Sampled By:<span style="border-bottom: 1px solid black"></span>Date & time:<span style="border-bottom: 1px solid black"></span></p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                

                       <p>After Sampling, weigh tablets and store in Quarantine with quarantine label till QC release</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               
               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    

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
                            
                            @foreach($plan['coating']['containers'] as $item)

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

                
                
                  <p>QC release date and time:<span style="border-bottom: 1px solid black"></span></p>
                  <p>Tailing Left:<span style="border-bottom: 1px solid black"></span>Kg</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

   
               
           </table>

           <center><h3 id="main_heading">YIELD CALCULATION AFTER COATING</h3></center>


          
          

          <p>Approximate No. of Coated Tablets:&nbsp;<span style="border-bottom:1px solid black ">&nbsp; </span>&nbsp;* 1000&nbsp;* 1000<br><span style="margin-left: 160px;"></span></p>

          <p>Approximate No. of Coated Tablets:&nbsp;<span style="border-bottom:1px solid black ">&nbsp; </span>&nbsp;* 1000&nbsp;* 1000<br><span style="margin-left: 160px;"></span></p>

         <p>Approximate No. of Coated Tablets: &nbsp;&nbsp;</p>
           
           <p>Process Loss at this stage:  &nbsp;<span style="border-bottom:1px solid black ">{{'('}}&nbsp; - &nbsp; {{')' }}&nbsp;x &nbsp; &nbsp;</span><br><span style="margin-left: 105px;">{{'1000 x 1000'}}</span></p>

         <p>Process Loss at this stage:  &nbsp;<span style="border-bottom:1px solid black ">{{'('}}&nbsp; - &nbsp; {{')' }}&nbsp;x &nbsp; &nbsp;</span><br><span style="margin-left: 105px;">{{'1000 x 1000'}}</span></p>


         <p>Process Loss at this stage: <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{' kg'}}&nbsp;&nbsp;</span></p>
    
         <p>%age Loss at this stage:  &nbsp;<span style="border-bottom:1px solid black ">&nbsp;</span>x 100<br><span style="margin-left: 105px;"></span></p>

         <p>%age Loss at this stage:  &nbsp;<span style="border-bottom:1px solid black ">&nbsp;</span>x 100<br><span style="margin-left: 105px;"></span></p>

         <p>%age Loss at this stage: <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{' kg'}}&nbsp;&nbsp;</span></p>


          <p>Total Loss(%): &nbsp;&nbsp;+&nbsp;&nbsp;+&nbsp;&nbsp;</p>
          <p>Total Loss(%): &nbsp;&nbsp;+&nbsp;&nbsp;+&nbsp;&nbsp;</p>
         <p>Total Loss(%): &nbsp;&nbsp;&nbsp;&nbsp;</p>
                


          
           <table style="width: 100%;">
             <tr>
               <td style="width: 20%;"><p>Remarks (if any) :</p></td>
               <td style="width: 80%;"><p style="border-bottom: 1px solid black;display: block;">&nbsp;&nbsp;</p></td>
             </tr>
           </table>

           

        </main>


        
    </body>
</html>