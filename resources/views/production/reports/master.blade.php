<html>
    <head>
        <title>{{$ticket['batch_no']}}</title>
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
                    <td rowspan="2">{{'PRODUCT NAME:'.$ticket['product']['item_name']}}</td>
                    <td>BATCH SIZE:{{$ticket['batch_size']}}</td>
                    <td>BATCH NO:{{$ticket['batch_no']}}</td>
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



        <main style="width: 100%;">
            
           <center><h3 id="main_heading">MASTER FORMULATION FOR RAW MATERIAL</h3></center>
         

         <!-- <table id="main_top">
           <tr>
             <td class="">Starting Date & Time:</td>
             <td class="blank"></td>
             <td class="">Completed Date & Time:</td>
             <td class="blank"></td>  
           </tr>
           
           </table> -->

           <table id="main_table" style="width: 100%;">

            <tr>
                   <td style="width: 5%;">SR #</td>
                   <td style="width: 35%;">RAW MATERIAL</td>
                   <td style="width: 30%;">EACH TABLET CONTAINS(mg)</td>
                   <td style="width: 30%;">STANDARD BATCH SIZE {{$ticket['batch_size']}} TABLETS(KG)</td>
                   
               </tr>
             
             
               @foreach($ticket['ticket_estimated']->where('mo','1') as $item)

               <tr>
                   <td style="width: 5%;"></td>
                   <td style="width: 35%;">{{$item['item']['item_name']}}</td>
                   <td style="width: 30%;"></td>
                   <td style="width: 30%;"> {{$item['quantity']*$item['pack_size']}} </td>
                   
               </tr>
               @endforeach
               
               

               



               
           </table>

           

        </main>


        
    </body>
</html>