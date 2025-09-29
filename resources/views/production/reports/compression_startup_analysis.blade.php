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


                 #main_table td,td{

                    border:0.5px solid black;
                    padding: 6px;

                 }

                 #main_table th,th{

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
        $sub_processes= $ticket_process->sub_processes() ;
            ?>


        <main style="width: 100%;">
            
           <center><h3 id="main_heading">TABLET COMPRESSION START UP ANALYSIS SHEET BY QA</h3></center>

           <center><h3>IN PROCESS WEIGHT MONITORING OF TABLETS</h3></center>
         
                <?php 
                $tab=$ticket_process['tables']->where('identity','tablet_monitoring')->first() ; ?>


                <!--table start -->
                     <?php $count=count($tab['columns']); ?>
                        <table style="border-spacing: 0;margin: 10;">
                             <tr>
                                @for($i=0;$i<$count;$i++)
                                  <th>{{$tab['columns'][$i]['heading']}}</th>
                                @endfor
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                            @for($j=1;$j<=$tab['no_of_rows'];$j++)
                             <tr>
                               @for($i=0;$i<$count;$i++)

                                  <?php 

                                  $type=$tab['columns'][$i]['type'];
                                        $head=$tab['columns'][$i]['heading'];
                                         $value=$tab['columns'][$i]->row_value($tab['id'],$tab['columns'][$i]['id'],$j); 

                                         ?>
                              <td>

                               {{$value}}

                               </td>

                               
                                @endfor
                               
                             </tr>
                        
                             @endfor
                             </tbody>



                             <tr>
                               @foreach($tab['columns'] as $cl)
                                        <?php 
                                              if($cl['footer_type']=='sum')
                                              {
                                          $sum=$cl->col_sum($tab['id']);
                                              }
                                         ?>
                               <th>
                                @if($cl['footer_type']=='sum')
                               {{$sum}}
                               @else
                               {{$cl['footer_text']}}
                               @endif
                             </th>
                                @endforeach
                               <!--  <th></th> -->
                             </tr>
                        </table>

                     <!--end table-->


               <?php
                $process=$sub_processes->where('identity','friability_test')->first() ;

                $iw=$process['ticket_parameters']->where('identity','initial_weight')->first()->value;

                $fw=$process['ticket_parameters']->where('identity','final_weight')->first()->value;

                $t_iw=$process['ticket_parameters']->where('identity','initial_weight')->first()->parameter_name;

                $t_fw=$process['ticket_parameters']->where('identity','final_weight')->first()->parameter_name;

                $yield=$process['ticket_parameters']->where('identity','calculation')->first();
               
               $result=$yield->formula_result();

                    ?>
          <p><b>{{'A: ' .$process['process_name']}} </b></p>

         <p>Initial Weight : <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$iw.' gm'}}&nbsp;&nbsp;</span></p>

         <p>Final weight : <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$fw.' gm'}}&nbsp;&nbsp;</span></p>



                

                <p>Calculation : &nbsp;<span style="border-bottom:1px solid black ">{{$t_iw}}&nbsp; - &nbsp; {{$t_fw }}&nbsp;</span>&nbsp;* 100<br><span style="margin-left: 160px;">{{$t_iw}}</span></p>

                <p>Calculation : &nbsp;<span style="border-bottom:1px solid black ">{{$iw}}&nbsp; - &nbsp; {{$fw }}&nbsp;</span>&nbsp;* 100<br><span style="margin-left: 115px;">{{$iw}}</span></p>

                <p>Result : {{$result}}&nbsp;%</p>

                <?php
                $process=$sub_processes->where('identity','weight_variation')->first() ;

                $r=$process['ticket_parameters']->where('identity','recommended_weight')->first()->value;

                $l=$process['ticket_parameters']->where('identity','lower_weight')->first()->value;

                $u=$process['ticket_parameters']->where('identity','upper_weight')->first()->value;

                $tab=$process['tables']->where('identity','weight_variation')->first() ;

                    ?>

               <p><b>{{'B: Weight Variation'}} </b></p>

                <!--table start -->
                     <?php $count=count($tab['columns']); ?>
                        <table style="border-spacing: 0;margin: 10;">
                             <tr>
                                @for($i=0;$i<$count;$i++)
                                  <th>{{$tab['columns'][$i]['heading']}}</th>
                                @endfor
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                            @for($j=1;$j<=$tab['no_of_rows'];$j++)
                             <tr>
                               @for($i=0;$i<$count;$i++)

                                  <?php 

                                  $type=$tab['columns'][$i]['type'];
                                        $head=$tab['columns'][$i]['heading'];
                                         $value=$tab['columns'][$i]->row_value($tab['id'],$tab['columns'][$i]['id'],$j); 

                                         ?>
                              <td>

                               {{$value}}

                               </td>

                               <td>
                                 
                               </td>

                               
                                @endfor
                               
                             </tr>
                        
                             @endfor
                             </tbody>



                             <tr>
                               @foreach($tab['columns'] as $cl)
                                        <?php 
                                              if($cl['footer_type']=='sum')
                                              {
                                          $sum=$cl->col_sum($tab['id']);
                                              }
                                         ?>
                               <th>
                                @if($cl['footer_type']=='sum')
                               {{$sum}}
                               @else
                               {{$cl['footer_text']}}
                               @endif
                             </th>
                                @endforeach
                               <!--  <th></th> -->
                             </tr>
                        </table>

                     <!--end table-->

            <p>Recommended Weight : <span style="border-bottom: 1px solid black;">&nbsp;&nbsp;{{$r.' mg'}}&nbsp;&nbsp;</span></p>

         <p>Lower weight : <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$l.' mg'}}&nbsp;&nbsp;</span></p>
          
          <p>Upper Weight : <span style="border-bottom: 1px solid black">&nbsp;&nbsp;{{$u.' mg'}}&nbsp;&nbsp;</span></p>
          
          

           <div></div>

        </main>


        
    </body>
</html>