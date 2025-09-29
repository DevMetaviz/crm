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

                      .page-break {
    page-break-after: always;
}        
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
       @include('production.granulation.header')

       

      @include('production.granulation.footer')
        
        <!-- Wrap the content of your PDF inside a main tag -->

        


        <main style="width: 100%;">
            
           <center><h3 id="main_heading">STANDARD MANUFACTURING PROCEDUTRE FOR BLISTERING</h3></center>
        

         <table id="main_top">
           <tr>
             <td class="p1">Starting Date & Time:</td>
             <td class="p2">{{$plan['blistering']['start_date']}}</td>
             <td class="p1">Completed Date & Time:</td>
             <td class="p2">{{$plan['blistering']['comp_date']}}</td>  
           </tr>
           <tr>
             <td class="p1">Total Time:</td>
             <td class="p2"></td>
             <td class="p1">Standard Lead Time:</td>
             <td class="p2">{{$plan['blistering']['lead_time']}}</td>  
           </tr>
           <tr>
             <td class="p1">Temprature:</td>
             <td class="p2">{{$plan['blistering']['temprature']}}</td>
             <td class="p1">Humidity:</td>
             <td class="p2">{{$plan['blistering']['humidity']}}</td>  
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
                    
                  
                       <p>Set and adjust blister machine according to set change and cleaning procedure.</p>
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                   
                  
                       <p>Check the general cleanliness of area, personnel and machine and ensure the proper working of the machine.</p>
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                     
                  <p>After taking line clearance certificate from QA department, bring released batch material and primary packaging material in blistering area.</p>
                   
                 
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                  
                       <p>Load the roll of primary packaging material on machine.</p>
                   
                      <p>Start the machine according to its operational procedure and make empty blisters.</p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                  
                       <p>Check initially sealing, printing, embossing of blisters (Batch # & Expiry date) of all empty blisters according to 2up, 3up or 5up blister machine.</p>
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                  
                       <p>Production and QA in-charges check and verify the embossing of empty blisters, sign them and attached with the BMR as specimens.</p>
                   
                      
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

              
               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                  
                  <p>Perform leakage test on 2 consecutive strokes of empty blisters.</p>
                  <p>Limit of Leakage test is NMT 2%.</p>
                   
                  <p>Result is <span style="border-bottom: 1px solid black">{{$plan['blistering']['empty_result']}}</span></p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                  
                       <p>After passing leakage test on empty blisters, fill the tray of blister machine with product and start blistering according to operational procedure.</p>
                   
                      
                      

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
                    
                  
                  <p>Perform leakage test on 2 consecutive strokes of filled blisters.</p>
                  <p>Limit of Leakage test is NMT 2%.</p>
                   
                  <p>Result is <span style="border-bottom: 1px solid black">{{$plan['blistering']['filled_result']}}</span></p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>


               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                   
                
                

                       <p>After getting release of leakage test from QA, start the normal blistering of product.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>


               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                  
                

                       <p>Perform in-process checks of blistering on In-process checks during blistering after every hour or whenever necessary.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                   
                

                       <p>Blisters are transferred to packaging area through S.S trolley.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                  
                  <p>Collect the defective/ rejected blisters received from packaging hall and kept in polythene bags.</p>
                  
                   
                  <!-- <p>Number of defective/rejected blisters <span style="border-bottom: 1px solid black"></span></p> -->
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                
                

                       <p>De-blister the defected blisters and collect the de-blistered tablets in polythene bag and re-blistered it.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                   
                

                       <p>After blistering of whole batch, stop the blister machine.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>


              <!--  <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    
                  
                  <p></p>
                  
                   
                  <p>Tailing Left <span style="border-bottom: 1px solid black"></span> Kg.</p>
                      

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr> -->



               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                                    
                

                       <p>Do the reconciliation after completion of batch.</p>
                    

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>
   
               
           </table>

           <div class="page-break"></div>

           <center><h3 id="main_heading">EMBOSSING CONTROL SHEET</h3></center>

          
            <table style="width: 100%;">
              <tr>
                <td style="width: 50%;">Machine Name: <span style="border-bottom: 1px solid black">{{$plan['blistering']['machine']}}</span></td>
                <td style="width: 50%;">ID # <span style="border-bottom: 1px solid black">{{$plan['blistering']['machine_id']}}</span></td>
              </tr>
              <tr>
                <td>Date/time:<span style="border-bottom: 1px solid black">{{$plan['blistering']['embossing_date']}}</span></td>
                <td>Operator:<span style="border-bottom: 1px solid black">{{$plan['blistering']['embossing_operator']}}</span></td>
              </tr>
            </table>

           <center><h3 id="main_heading">EMBOSSING INFORMATION ON BLISTER</h3></center>

          

            <p>Embossing Stamp: <span style="border-bottom: 1px solid black">{{$plan['blistering']['embossing_stamp']}}</span></p>

            <p>Packaging Supervisor: <span style="border-bottom: 1px solid black">{{$plan['blistering']['packaging_supervisor']}}</span></p>

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