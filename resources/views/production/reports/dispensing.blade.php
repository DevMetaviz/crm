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
                margin-top: 6cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 4.5cm;
                font-family: times new roman;
                font-size: 12px;
            }

            

            
                    

                  
                #main_top{
                    width: 100%;
                }

                #main_top .p1{
                 width: 25%;
                 
                 }

                 #main_top .p2{
                 width: 25%;
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
                    width: 100%;
                    table-layout: fixed;

                 }


                 #main_table td{

                    border:0.5px solid black;
                    padding: 6px;
                     word-wrap: break-word;
                 }

                 #main_table th{

                    border:0.5px solid black;
                    padding: 6px;
                    word-wrap: break-word;
                    
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
            
           <center><h3 id="main_heading">DISPENSING SHEET</h3></center>
         <?php 
              $d=$top_parameters->where('parameter.identity','start_date')->first();
              $d=$d->value;
              $t=$top_parameters->where('parameter.identity','start_time')->first();
              $t=$t->value;
              $c_d=$top_parameters->where('parameter.identity','complete_date')->first();
              $c_d=$c_d->value;
              $c_t=$top_parameters->where('parameter.identity','complete_time')->first();
              $c_t=$c_t->value;
            
            
              $temp=$top_parameters->where('parameter.identity','dispensing_temperature')->first();
              $temp=$temp->value;
              $humi=$top_parameters->where('parameter.identity','dispensing_humidity')->first();
              $humi=$humi->value;
          ?>

         <table id="main_top">
           <tr>
             <td class="p1">DISPENSING Start Date & Time:</td>
             <td class="p2">{{$d.' / '.$t}}</td>
             <td class="p1">DISPENSING Completed Date & Time:</td>
             <td class="p2">{{$c_d.' / '.$c_t}}</td>  
           </tr>
           <tr>
             <td class="p1">Temprature:</td>
             <td class="p2">{{$temp}}</td>
             <td class="p1">Humidity:</td>
             <td class="p2">{{$humi}}</td>  
           </tr>
           </table>

           <table id="main_table">

            <tr>
                   <th style="width: 5%;">SR #</th>
                   <th style="width: 25%;">MATERIAL NAME</th>
                   <th style="width: 12%;">ASSAY ADJUSTMENT (IF ANY)</th>
                   <th style="width: 12%;">QUANTITY (KG)</th>
                   <th style="width: 12%;">GRN #</th>
                   <th style="width: 12%;">QC #</th>
                   <th style="width: 12%;">WEIGHED BY</th>
                   <th style="width: 12%;">CHECKED BY (QA)</th>
                   
               </tr>

               <?php $items=$ticket_process['ticket']['estimated_material']->where('department_id','2'); ?>
            @foreach($items as $it)
             <tr>
                   <td ></td>
                   <td >
                    {{$it['item_name']}}

                   </td>
                   <td ></td>
                   <td >{{$it['pivot']['quantity']}}</td>
                   <td ></td>
                   <td ></td>
                   <td ></td>
                   <td ></td>
               </tr>

              
            @endforeach

              



               
               

              

               
           </table>

           

        </main>


        
    </body>
</html>