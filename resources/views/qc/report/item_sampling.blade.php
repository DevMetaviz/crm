<html>
    <head>
        <title>{{$request['sampling_no']}}</title>
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
                margin-top: 4cm;
                margin-left: 0.7cm;
                margin-right: 0.7cm;
                /*margin-bottom: 4.5cm;*/
                /*font-family: times new roman;*/
               
                font-family: sans-serif;
                font-size: 10pt;
            }

            
             /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 3cm;
                  padding-top: 20px;
                /** Extra personal styles **/
                /*background-color: #03a9f4;*/
                /*color: white;*/
                /*text-align: center;*/
                /*line-height: 1.5cm;*/
            }
            
           
        .bord{
            border: 1px solid black;
        }

        .bord1{
            border: 1px solid black;
            /*border-top : 1px solid black;*/
            text-align: center;
        } 

        
        .head-span{
            width: 40%;
             padding-top: 10px;
           }
          .bord-span{
    
            border-bottom: 2px solid black;
             text-align: center;
           }

           .result{
            border: 1px solid black;
            width: 30px;
            height: 30px;
        }
                              
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header style="">
         
        <table class="" style="width: 100%;margin: 15px;" cellspacing ="3" cellpadding="2">

                <tr>
                    <td style="width: 20%"><img src="{{url('public/images/logo.jpg')}}" style="max-height:100px; max-width: 250px " ></td>

                    <td style="width: 57%" class="text-center">
                        <h2 style="text-align: center;"><b>REQUEST FOR ANALYSIS OF<br> RAW AND PACKAGING MATERIAL</b></h2>
                        
                    </td>
                    <td style="width: 23%">
                        <p>Doc # QD10B-WH-002<br>Issue # 01<br>Page 1 of 1</p>
                        
                    </td>
                </tr>
                
                
            </table>
            
               
        </header>

       

      
        
        <!-- Wrap the content of your PDF inside a main tag -->


        <main style="width: 100%;">
            

          

           <table class="main-table" style="width: 100%;border:1px solid black;">
               
               <tr>
                   <td colspan="2" class="bord">
                       
                       <table style="width: 100%;">
                           <tr>
                               <td style="width: 10%; padding-top: 10px;"><b>GRN NO :</b></td>
                               <td class="head-span bord-span"></td>
                               <td style="width: 10%; padding-top: 10px;"><b>Date :</b></td>
                               <td class="head-span bord-span"></td>
                           </tr>

                           <tr>
                               <td style=" padding-top: 10px;"><b>Time :</b></td>
                               <td class="head-span bord-span"></td>
                               <td></td>
                               <td></td>
                           </tr>
                       </table>
                   </td>
               </tr>

               <tr>
                   <td class="bord" style="width:50%;text-align: center;"><h3>FOR STORE</h3></td>
                   <td class="bord" style="width: 50%;text-align: center;"><h3>FOR QUALITY ASSURANCE</h3></td>
               </tr>

               <tr>
                   <td class=""  style="vertical-align: top;">
                      <div class="bord">

                      <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 10%;"><b>Item:</b></td><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 22%;"><b>Item Type:</b></td><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 31%;"><b>Material Name:</b></td><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 22%;"><b>Barch No:</b></td><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 22%;"><b>Mfg Date:</b></td><td class="bord-span"></td><td style="width: 22%;"><b>Exp Date:</b></td><td class="bord-span"></td></tr>
                      </table>


                      <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 22%;"><b>Quantity:</b></td><td class="bord-span"></td></tr>
                      </table>


                      <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 22%;"><b>Origin:</b></td><td class="bord-span"></td></tr>
                      </table>

                      </div>


                      <table style="width: 100%;margin: 0px;text-align: center;padding: 0px;" cellspacing="1">
                          <tr><td class="bord" style="width: 25%"><b>No. Of Containers</b></td><td class="bord" style="width: 25%"><b>Type of Container</b></td><td class="bord" style="width: 25%"><b>Contents of Container</b></td><td class="bord" style="width: 25%"><b>Total Qty.<br>No. / Wt</b></td></tr>

                          <tr><td class="bord" style="width: 25%; height: 30px;"></td><td class="bord" style="width: 25%"></td><td class="bord" style="width: 25%"></td><td class="bord" style="width: 25%"></td></tr>
                      </table>

                    <div class="bord">
                     <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 22%;"><b>Source:</b></td><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 22%;"><b>Remarks:</b></td><td class="bord-span"></td></tr>
                      </table>


                      <table style="width: 100%;margin: 15px;">
                          <tr><td class="bord-span"></td></tr>
                      </table>


                      <table style="width: 100%;margin: 15px;padding-top: 184px;">
                          <tr><td style="width: 34%;border-top:2px solid black;"><b>STORE OFFICER<br>DATE:</b></td><td></td><td  style="width: 39%;border-top:2px solid black;"><b>STORE INCHARGE<br>DATE:</b></td></tr>
                      </table>

                        </div>

                    
                   </td>
                   <td class="bord"  style="vertical-align: top;">
                    
                    
                    <div style="margin: 15px;">
                    <b>Date / Time of Sampling:</b>
                    <p class="bord-span"></p>
                    </div>

                      <table style="width: 100%;margin: 25px;">
                          <tr><td style="width: 22%;"><b>Remarks:</b></td><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td class="bord-span"></td></tr>
                      </table>

                      <div style="margin: 15px;">
                    <b>Quality Assurance Officer:</b>
                    <p class="bord-span"></p>
                    </div>

                    <div style="margin: 15px;">
                    <b>Date</b>
                    <p class="bord-span"></p>
                    </div>

                    <table style="width: 100%;margin-top: 15px;">
                          <tr><td class="bord1"><h3>FOR QUALITY CONTROL</h3></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 22%;"><b>Date/Time Received:</b></td><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 22%;"><b>Date/Time Released:</b></td><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td style="width: 22%;"><b>Q.C. NO:</b></td><td class="bord-span"></td></tr>
                      </table>

                   <table style="width: 100%;margin: 25px;">
                          <tr><td style="width: 22%;"><b>Remarks:</b></td><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;">
                          <tr><td class="bord-span"></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;" >
                          <tr><td><b>RELEASED:</b></td><td><b>REJECTED:</b></td></tr>
                          <tr><td><div class="result"></div></td><td><div class="result"></div></td></tr>
                      </table>

                      <table style="width: 100%;margin: 15px;padding-top: 40px;">
                          <tr><td style="width: 34%;border-top:2px solid black;"><b>Q.C. ANALYST<br>DATE:</b></td><td></td><td  style="width: 39%;border-top:2px solid black;"><b>Q.C. MANAGER<br>DATE:</b></td></tr>
                      </table>


                       
                   </td>
               </tr>



           </table>
           

           

          


           

        </main>


        
    </body>
</html>