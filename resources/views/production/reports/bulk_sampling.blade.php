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
       @include('production.reports.layout.header')

       

      @include('production.reports.layout.footer')
        
        <!-- Wrap the content of your PDF inside a main tag -->

        <?php 
           $top_parameters= $ticket_process['ticket_parameters'];
        $sub_processes= $ticket_process->sub_processes() ;
            ?>


        <main style="width: 100%;">
            
           <center><h3 id="main_heading">SAMPLING REQUEST SHEET FOR BULK</h3></center>
         <?php 
              $d=$top_parameters->where('identity','intimation_time')->first()->value;
              $t=$top_parameters->where('identity','sampling_time')->first()->value;
              
          ?>
            <h2>To be filled by Production:</h2>
          <div style="border:1px double black;padding: 10px;">
            <p>Stage: After Mixing</p>
            <p>Time / date of intimation:<span style="border-bottom: 1px solid black;padding:0 20; ">{{$d}}</span></p>
            <p>Production Supervisor:<span style="border-bottom: 1px solid black;padding:0 20; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></p>
          </div>

          <h2>To be filled by QA:</h2>
          <div style="border:1px double black;padding: 10 10 150 10;">
          
            <p>Time / date of sampling:<span style="border-bottom: 1px solid black;padding:0 20; ">{{$t}}</span></p>
            <p>QA Inspector:<span style="border-bottom: 1px solid black;padding:0 20; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></p>
          </div>

         
           

        </main>


        
    </body>
</html>