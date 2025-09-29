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
                font-size: 14px;
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
            
           <center><h3 id="main_heading">YIELD CALCULATION AT FINAL STAGE</h3></center>
        


                   
            <?php 

              $ap=$top_parameters->where('parameter.identity','actual_packs')->first()->value;
              $qa=$top_parameters->where('parameter.identity','sample_qa')->first()->value;
              $qc=$top_parameters->where('parameter.identity','qc_sample')->first()->value;
              $tp=$top_parameters->where('parameter.identity','theoretical_packs')->first()->value;

              $n_ap=$top_parameters->where('parameter.identity','actual_packs')->first()->parameter->name;
              $n_qa=$top_parameters->where('parameter.identity','sample_qa')->first()->parameter->name;
              $n_qc=$top_parameters->where('parameter.identity','qc_sample')->first()->parameter->name;
               $n_tp=$top_parameters->where('parameter.identity','theoretical_packs')->first()->parameter->name;

               $r=$top_parameters->where('parameter.identity','remarks')->first()->value;

                $yield=$top_parameters->where('parameter.identity','yield')->first();
               
               $result=$yield->formula_result();

               $loss=$top_parameters->where('parameter.identity','loss')->first();
               
               $loss=$loss->formula_result();

                ?>



                <p>% Yield = &nbsp;<span style="border-bottom:1px solid black ">{{$n_ap}}&nbsp; + &nbsp; {{$n_qa }}&nbsp; + &nbsp; {{$n_qc }}&nbsp;</span>&nbsp;* 100<br><span style="margin-left: 160px;">{{$n_tp}}</span></p>

                <p>% Yield = &nbsp;<span style="border-bottom:1px solid black ">{{$ap}}&nbsp; + &nbsp; {{$qa }}&nbsp;+ &nbsp; {{$qc }}&nbsp;</span>&nbsp;* 100<br><span style="margin-left: 105px;">{{$tp}}</span></p>

                <p>% Yield = {{$result}}&nbsp;%</p>

                <p>% Loss = &nbsp;<span>100&nbsp; - &nbsp; % Yield&nbsp; </span></p>

                <p>% Loss = &nbsp;<span>100&nbsp; - &nbsp; {{$result}}&nbsp; </span></p>

                

                <p>% Loss = {{$loss}}&nbsp;%</p>

               

          
           <table style="width: 100%;">
             <tr>
               <td style="width: 20%;"><p>Remarks (if any) :</p></td>
               <td style="width: 80%;"><p style="border-bottom: 1px solid black;display: block;">&nbsp;&nbsp;{{$r}}</p></td>
             </tr>
           </table>

          

        </main>


        
    </body>
</html>