<html>
    <head>
        <title>{{$ticket_process['process_name']}}</title>
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
                margin-top: 7.5cm;
                margin-left: 0.3cm;
                margin-right: 0.3cm;
                margin-bottom: 2cm;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10px;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 7.5cm;

                padding: 10px;

                /** Extra personal styles **/
                /*background-color: #03a9f4;*/
                /*color: white;*/
                /*text-align: center;*/
                /*line-height: 1.5cm;*/
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                /*background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;*/
                    }

                    #head_top_table{
                      width: 100%;
                      border: 2px solid black;
                 } 

                  #head_top_table tr{
                      width: 100%;
                 }  

                 #head_top_table tr td{
                 width: 25%;
                 border: 1px solid grey;
                 text-align: center;
                 }

                 #head_table{
                      width: 100%;
                      border: 2px solid black;
                 }    
                #main_top{
                    width: 100%;
                }

                #main_top tr td{
                 width: 25%;
                 
                 }

                  .blank{
                 border-bottom: 1px solid black;
                 
                 }

                 #main_heading{
                    text-transform: uppercase;
                    
                 }

                 #main_table,#main_table td{

                    border:1px dotted black;
                 }
             
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>

            <table class="" id="head_top_table" style="">

                <tr>
                    <td></td>
                    <td>Prepared By:</td>
                    <td>Reviewed By:</td>
                    <td>Approved By:</td>
                </tr>

                <tr>
                    <td>DESIGNATION</td>
                    <td>QA OFFICER</td>
                    <td>QC MANAGER</td>
                    <td>PRODUCTION MANAGER</td>
                </tr>
                <tr>
                    <td>SIGNATURE</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                
            </table>

            <table class="" id="head_table" style="">

                <tr>
                    <td rowspan="2" style="width: 20%"></td>
                    <td style="width: 80%">FAHMIR PHARMA (PVT) LTD</td>
                   
                </tr>

                <tr>
                    
                    <td style="width: 80%">BATCH MANUFACTURING RECORD</td>
                    
                </tr>

                <tr>
                    <td rowspan="2">{{'PRODUCT NAME:'.$ticket_process['ticket']['product']['item_name']}}</td>
                    <td>BATCH SIZE:{{$ticket_process['ticket']['batch_size']}}</td>
                    <td>BATCH NO:{{$ticket_process['ticket']['batch_no']}}</td>
                </tr>

                <tr>
                    <td>DOCUMENT NO:</td>
                    <td>REVISION NO:</td>
                </tr>

                <tr>
                    <td>FAHMIR M.LIC NO:000880</td>
                     <td>PRODUCT REG NO:</td>
                    <td>THEORETICAL WT =</td>
                </tr>
                
                
            </table>
               
        </header>

       <script type="text/php">
    if (isset($pdf)) {
    echo $PAGE_COUNT;
        $x =  $pdf->get_width() - 90;
        $y =  $pdf->get_height() - 50;
        $text = "page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);


    }
</script>

        <footer style="">
    
       </footer>
        <!-- Wrap the content of your PDF inside a main tag -->

        <?php 
           $top_parameters= $ticket_process['ticket_parameters'];
        $sub_processes= $ticket_process->sub_processes() ;
            ?>


        <main style="width: 100%;">
            
           <center><h3 id="main_heading">STANDARD MANUFACTURING PROCEDUTRE FOR {{$ticket_process['process_name']}}</h3></center>
         <?php 
              $d=$top_parameters->where('identity','granulation_date')->first()->value;
              $t=$top_parameters->where('identity','granulation_time')->first()->value;
              $c_d=$top_parameters->where('identity','complete_date')->first()->value;
              $c_t=$top_parameters->where('identity','complete_time')->first()->value;
              $t_t=$top_parameters->where('identity','total_time')->first()->value;
              $l_t=$top_parameters->where('identity','standard_lead_time')->first()->value;
              $temp=$top_parameters->where('identity','tempratue')->first()->value;
              $humi=$top_parameters->where('identity','humidity')->first()->value;
          ?>

         <table id="main_top">
           <tr>
             <td class="">Starting Date & Time:</td>
             <td class="blank">{{$d.' '.$t}}</td>
             <td class="">Completed Date & Time:</td>
             <td class="blank">{{$c_d.' '.$c_t}}</td>  
           </tr>
           <tr>
             <td class="">Total Time:</td>
             <td class="blank">{{$t_t}}</td>
             <td class="">Standard Lead Time:</td>
             <td class="blank">{{$l_t}}</td>  
           </tr>
           <tr>
             <td class="">Temprature</td>
             <td class="blank">{{$temp}}</td>
             <td class="">Humidity:</td>
             <td class="blank">{{$humi}}</td>  
           </tr>
           </table>

           <table id="main_table" style="width: 100%;">

            <tr>
                   <td style="width: 5%;">SR #</td>
                   <td style="width: 50%;">MANUFACTURING OPERATION OF MIXING</td>
                   <td style="width: 15%;">PERFORMED BY (OPERATOR)</td>
                   <td style="width: 15%;">CHECKED BY(PRODUCTION OFFICER)</td>
                   <td style="width: 15%;">5</td>
               </tr>
             
             <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('identity','sieving')->first() ;
                $s= $p['ticket_parameters']->where('identity','start_time')->first()->value;
                $c= $p['ticket_parameters']->where('identity','completion_time')->first()->value;
                $t= $p['ticket_parameters']->where('identity','total_time')->first()->value;
            ?>
                  <center><h4>{{$p['process_name']}}</h4></center>
                       <p>Sieve Omeprazole powder, Sodium bicarbonate through sieve # 30, dextose, mint flavor and sucralose through sieve # 14.</p>
                    <p>Sieving start time:<span style="border-bottom: 1px solid black">{{$s}}</span></p>
                      <p>Sieving complete time:<span style="border-bottom: 1px solid black">{{$c}}</span></p>
                      <p>Total time:<span style="border-bottom: 1px solid black">{{$t}}</span></p>

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('identity','geometric_mixing')->first() ;
                $s= $p['ticket_parameters']->where('identity','start_time')->first()->value;
                $c= $p['ticket_parameters']->where('identity','completion_time')->first()->value;
                $t= $p['ticket_parameters']->where('identity','total_time')->first()->value;
            ?>
                  <center><h4>{{$p['process_name']}}</h4></center>
                       <p>Geometrical mix Omeprazole powder and dextose in S. S container manually for 10 minutes (Mixture A). Mix half quantity of dextrose and mint flavor manually for 5 minutes (Mixture B). Mix half quantity of Sodium Bicarbonate with Sucralose manually for 5 minutes (Mixture C).</p>
                    <p>Manual Mixing  start time:<span style="border-bottom: 1px solid black">{{$s}}</span></p>
                      <p>Mixing  complete time:<span style="border-bottom: 1px solid black">{{$c}}</span></p>
                      <p>Total time:<span style="border-bottom: 1px solid black">{{$t}}</span></p>

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>


               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 50%;">
                    <?php
             $p=$sub_processes->where('identity','final_mixing')->first() ;
                $s= $p['ticket_parameters']->where('identity','mixing_start_time')->first()->value;
                $c= $p['ticket_parameters']->where('identity','mixing_complete_time')->first()->value;
                $t= $p['ticket_parameters']->where('identity','total_time')->first()->value;
            ?>
                  <center><h4>{{$p['process_name']}}</h4></center>
                       <p>Add following materials to sigma mixerand mix for 40 minutes.</p>
                    <p>Mixing  start time:<span style="border-bottom: 1px solid black">{{$s}}</span></p>
                      <p>Mixing  complete time:<span style="border-bottom: 1px solid black">{{$c}}</span></p>
                      <p>Total time:<span style="border-bottom: 1px solid black">{{$t}}</span></p>

                   </td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
                   <td style="width: 15%;"></td>
               </tr>

               
           </table>

           

        </main>


        
    </body>
</html>