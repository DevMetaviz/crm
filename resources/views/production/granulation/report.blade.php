<html>
    <head>
        <title>{{$plan['granulation']['id']}}</title>
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
                    border-spacing: 0;
                    margin: 10;
                 }

                 .short_table tr{

                    min-height:  500px;
                 }

                 .short_table td , .short_table th{

                    border-left:0.5px solid black;
                    border-top:0.5px solid black;
                    padding: 6px;
                    /*min-height: 220px;*/
                 }

                 .short_table .last-row td,.short_table .last-row th{
                    border-bottom:0.5px solid black;
                 }

                 .short_table tr last-td,.short_table .last-row last-th{
                    border-right:0.5px solid black;
                 }

                              
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
       @include('production.granulation.header')

       

      @include('production.granulation.footer')
        
        <!-- Wrap the content of your PDF inside a main tag -->


        <main style="width: 100%;">
            
           <center><h2 id="main_heading">STANDARD MANUFACTURING PROCEDUTRE FOR GRANULATION</h2></center>
         

         <table id="main_top">
           <tr>
             <td class="p1">Starting Date & Time:</td>
             <td class="p2">{{$plan['granulation']['grn_start']}}</td>
             <td class="p1">Completed Date & Time:</td>
             <td class="p2">{{$plan['granulation']['grn_comp']}}</td>  
           </tr>
           <tr>
             <td class="p1">Total Time:</td>
             <td class="p2">{{$plan['granulation']->grn_total_time()}}</td>
             <td class="p1">Standard Lead Time:</td>
             <td class="p2">{{$plan['granulation']['lead_time']}}</td>  
           </tr>
           <tr>
             <td class="p1">Temprature:</td>
             <td class="p2">{{$plan['granulation']['temprature']}}<sup>o</sup>C</td>
             <td class="p1">Humidity:</td>
             <td class="p2">{{$plan['granulation']['humidity'].' %'}}</td>  
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
                    

                    <h4><span style="border-bottom: 1.5px solid black;">{{"STEP 1"}}</span></h4>
                  <h4>Sieving & Blending:</h4>
                       <p>Pass the following materials through sieve number {{$plan['granulation']['sev_num']}}.</p>
                       <p>Load the ribbon blade mixer with the sifted materials.</p>
                       <p>{{"Mix the sieved material in cube mixer for ".$plan['granulation']->sev_total_time()." minutes."}}</p>

                       <p>Mixing started at:<span style="border-bottom: 1px solid black">{{$plan['granulation']['sev_start']}}</span></p>
                      <p>Mixing completed at:<span style="border-bottom: 1px solid black">{{$plan['granulation']['sev_complete']}}</span></p>
                    <p>Total time:<span style="border-bottom: 1px solid black">{{$plan['granulation']->sev_total_time()}}</span></p>


                     <!--table start -->
                    
                        <table style="border-spacing: 0;margin: 10;" class="short_table">
                             <tr>
                               
                                  <th>Material</th>
                                  <th>Quantity</th>
                             </tr>
                            

                           <tbody>
                            
                           @foreach($plan['granulation']->sevied_items() as $it)
                             <tr>

                              
                                <td>{{$it['name']}}</td>
                                  <td>{{$it['qty'].' ' .$it['uom']}}</td>
                               
                               
                             </tr>
                        @endforeach
                        
                             </tbody>



                             <!-- <tr>
                              <th>
                                
                             </th>
                             
                                <th></th>
                             </tr> -->
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
                    
                  <h4><span style="border-bottom: 1.5px solid black;">STEP 2</span></h4>
                  <h4>{{'WETTING AND WET GRANULATION  '}}</h4>
                  <h4>Preparation of Paste</h4>
                  

                    <p>Take  following material, add them and stirr continuously till it completely dissolves.</p>

                    <!--table start -->
                    
                        <table style="border-spacing: 0;margin: 10;" class="short_table">
                             <tr>
                               
                                  <th>Material</th>
                                  <th>Quantity</th>
                             </tr>
                            

                           <tbody>
                            
                           @foreach($plan['granulation']->paste_items() as $it)
                             <tr>

                              
                                <td>{{$it['name']}}</td>
                                  <td>{{$it['qty'].' ' .$it['uom']}}</td>
                               
                               
                             </tr>
                        @endforeach
                        
                             </tbody>



                             <!-- <tr>
                              <th>
                                
                             </th>
                             
                                <th></th>
                             </tr> -->
                        </table>

                     <!--end table-->


                    <h4>Addition of Paste (Wetting)</h4>
                     <p>Add the prepared binding solution to the bulk in ribbon blade mixer and mix it till wet mass of desired level attains.</p>

                     

            <h4>{{'Wet Granulation'}}</h4>
                

                       <p>Pass the wet mass through wet granulator to get the wet grain as per requirement so that after drying proper sized grain should be obtained.</p>

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>


               


               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                  <h4><span style="border-bottom: 1.5px solid black;">STEP 3</span></h4>
                  <h4>Drying</h4>
                       <p>{{'After granulation through Rotary Granulator, shift material in trays for IPA to evaporate. Load the wet mass in FBD and Dry for '.$plan['granulation']['dry_time'].' at temperature '.$plan['granulation']['dry_temp'].'. And send sample for LOD.'}}</p>
                    <!-- <p>Results of LOD:<span style="border-bottom: 1px solid black;">&nbsp;&nbsp;</span>(Limit NMT 3%).</p> -->
                      
                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

              

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
            <h4><span style="border-bottom: 1.5px solid black;">STEP 4</span></h4>
                 <h4>{{'Dry Granulation (Crushing)'}}</h4>
                       <p>Then fitted the dry granulator (oscillating granulator/crusher) with the S.S.Sieve of required mesh size. Crush the dried grain through dry granulator.</p>
                    
                      
                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

                <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
            <h4><span style="border-bottom: 1.5px solid black;">STEP 5</span></h4>
                  <h4>Final Mixing & Lubrication:</h4>
                       <p>{{'Add following materials to above sieved material and mix for '.$plan['granulation']->mix_total_time().' in multidimensional mixer.'}}</p>

                       <!--table start -->
                    
                        <table style="border-spacing: 0;margin: 10;" class="short_table">
                             <tr>
                               
                                  <th>Material</th>
                                  <th>Quantity</th>
                             </tr>
                            

                           <tbody>
                            
                           @foreach($plan['granulation']->mixing_items() as $it)
                             <tr>

                              
                                <td>{{$it['name']}}</td>
                                  <td>{{$it['qty'].' ' .$it['uom']}}</td>
                               
                               
                             </tr>
                        @endforeach
                        
                             </tbody>



                             <!-- <tr>
                              <th>
                                
                             </th>
                             
                                <th></th>
                             </tr> -->
                        </table>

                     <!--end table-->
                  
                  <p>Mixing  started at:<span style="border-bottom: 1px solid black">{{$plan['granulation']['mixing_start_time']}}</span></p>
                      <p>Mixing  completed at:<span style="border-bottom: 1px solid black">{{$plan['granulation']['mixing_complete_time']}}</span></p>
                      <p>Total time:<span style="border-bottom: 1px solid black">{{$plan['granulation']->mix_total_time()}}</span></p>
                      <p>Intimate QA for sampling of mixed material.</p>
                    <p>Quantity sampled by QA: <span style="border-bottom: 1px solid black"></span></p>
                      
                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

              


              

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                <h4><span style="border-bottom: 1.5px solid black;">STEP 6</span></h4>
                 <p>Transfer the material to compression area after release from QC.</p>
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>
               

            

               
           </table>


           
           <center><h2 id="main_heading">SAMPLING REQUEST SHEET FOR BULK</h2></center>

           <h3>To be filled by Production</h3>

           <div style="border: 1px solid black;padding: 15px;">

            <p> Stage : After Mixing </p>
              <p> Date / Time of Intimation : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>

              <p> Production Supervisor : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>
           </div>

           <h3>To be filled by QA</h3>

           <div style="border: 1px solid black;padding: 15px;">
              <p> Date / Time of Sampling : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>

              <p> QA Inspector : <span style="display: inline-block;border-bottom: 1px solid black;text-align: center; width: 25em;"> </span> </p>
           </div>


           

            <center><h2 id="main_heading">YIELD CALCULATION AFTER FINAL MIXING</h2></center>   

                <p><b>Stage : </b> Final Mixing</p>


               

                 <!--table start -->
                   
                        <table class="short_table">
                             <tr>
                                <th>Container #</th>
            
                                 <th>Gross Weight (kg)</th>
                                 <th>Tare Weight (kg)</th>
                                 <th>Net Weight (kg)</th>
                                 <th>Performed By</th>
                             </tr>
                            

                           <tbody>
                             <?php $t=0; $t1=0; $t2=0; ?>
                            @foreach($plan['granulation']['containers'] as $item)

                             <tr>
                              <?php $t=$t+$item['gross']; $t1=$t1+$item['tare']; $t2=$t2+$item['net']; ?>


                               
                                <td>{{$item['no']}}</td>
    
                                 <td>{{$item['gross']}}</td>
                               <td>{{$item['tare']}}</td>
                              <td>{{$item['net']}}</td>
                               <td>{{$item['performed_by']}}</td>

                               
                             </tr>
                        
                             @endforeach
                             </tbody>



                             <tr class="last-row">
                               
                            <th>Total:</th>
                             <th>{{$t}}</th>
                             <th>{{$t1}}</th>
                             <th>{{$t2}}</th>
                             <th></th>
                             </tr>
                        </table>

                     <!--end table-->


                 <p>Theoretical weight of Grains =&nbsp; </p>
                 <p>Actual weight of Grains =&nbsp; </p>

                 <p>% Wastage : &nbsp;<span style="border-bottom:1px solid black ">{{'Theoratical Grains'}}&nbsp; - &nbsp;  {{'Actual Grains' }}&nbsp;  </span>&nbsp;* 100<br><span style="margin-left: 160px;">{{'Theoratical Grains'}}</span></p>


                 <p>% Wastage : &nbsp;%</p>

                 <p>% Yield : 100 - % Wastage</p>

                 <p>% Yield : &nbsp;%</p>

                



                

          
           <table style="width: 100%;">
             <tr>
               <td style="width: 20%;"><p>Remarks (if any) :</p></td>
               <td style="width: 80%;"><p style="border-bottom: 1px solid black;display: block;">&nbsp;&nbsp;</p></td>
             </tr>
           </table>


           

        </main>


        
    </body>
</html>