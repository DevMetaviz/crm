<html>
    <head>
        <title>{{$result['id']}}</title>
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
                margin-top: 6.2cm;
                margin-left: 0.3cm;
                margin-right: 0.3cm;
                margin-bottom: 2cm;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;

                padding: 0px 30px 0px 30px;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 4.5cm;

                padding: 20px 30px 20px 30px;

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

                    #header-table tr td{
                   border: 1px solid black;
                    }

                     #sub-table{
                   border-spacing: none;
                    }

                    .sub-table tr td,.sub-table tr th{
                   border-top: 1px solid black;
                   border-left: 1px solid black;
                   text-align: left;
                   padding: 5px;
                    }

                    .right {
                   border-right: 1px solid black;
                   
                    }

                    .bottom {
                   border-bottom: 1px solid black;
                   
                    }

                    
                     .top-heading{ font-size: 17px; }
                    .top-heading1{ font-size: 20px; }

                    #top-sub-table tr td{border:none; 
                     border-bottom: 1px solid  black;
                     padding: 5px 2px 5px 2px;
                    }

                    .top-heading-name{ font-size: 12px; }

                    .top-heading-address{ text-align: center; }

                    .challan-detail td,.challan-detail th{

                      text-align: left;
                      padding-left: 15px;
                    }
             
                    .page_num:after { content: counter(page); }

            .pages:after { content:  counter(pages); }

            .item-table{
             
            width: 100%;
             }

           .col{
             
            padding: 5px;
            text-align: center;
            text-transform: capitalize;
             }

             .col1{
             
            padding: 7px;
            text-align: center;
             }

             .item-name-th{

             	width: 40% ;
             	text-align: left;
                padding-left: 7%;
             }

             .item-name-col{
               text-transform: capitalize;
             	width: 40% ;
             	text-align: left;
             }

             .sign{
              
              border-top: 1px solid black !important;
              
              padding : 10px ;

            }

           

             
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
        <table id="header-table" width="100%" style="padding: 10px;" cellspacing="0">

        <tr>
            <td colspan="3"><center><h1>FAHMIR PHARMA (PVT.) LTD</h1></center></td>
        </tr>
        <tr>

            <td align="center"  style="width: 25%;">

               <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="180">
                
            </td>

            
            <td align="center" style="width: 50%">
                <p class="top-heading"><strong>Quality Control Department
                <br><span class="top-heading1">CERTIFICATE OF ANALYSIS</span><br>RAW MATERIALS</strong></P>
            </td>

            <td  style="width: 25%;padding: 0px;">
               
               <table id="top-sub-table" style="width: 100%;border-spacing:none;">
                   <tr align="center"><td>Document Number<br>FP/QC/COA-RM/107</td></tr>
                   <tr align="center"><td>Effective Date:<br>05-2021</td></tr>
                   <tr align="center"><td style="border-bottom: none;">Review Date:<br>05-2024</td></tr>
               </table>
                 
            </td>
            
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
    <div>
        <!-- <p>Page <span class="page_num"></span> of <span class="pages"></span> -->
            <div><p><span style="margin-left:60px;">{{date('d-M-Y')}}</span><span style="margin-left:60px;">{{date('H:i:s A')}}</span></p></div>
    </div>
    <div style="height:30px;background-color: #03a9f4;"></div>
  </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main style="width: 100%;">

<table style="width: 100%;" class="sub-table" cellspacing="0" >
         <tr>
            <th class="right" colspan="4">Product / Material Name:&nbsp;&nbsp;&nbsp;&nbsp;<span style="text-transform: uppercase;">{{$result['request']['stock']['item_name']}}</span></th>
        </tr>
         <tr>
            <th>Batch No:</th><td>{{$result['request']['stock']['batch_no']}}</td><th>Testing Specs:</th><td class="right" >{{$result['testing_specs']}}</td>
        </tr>
        <tr>
            <th>Mfg. Date:</th><td>{{$result['request']['stock']['mfg_date']}}</td><th>Exp. Date:</th><td class="right" >{{$result['request']['stock']['exp_date']}}</td>
        </tr>
        <tr>
            <th>GRN No.:</th><td>{{$result['request']['stock']['grn_no']}}</td><th>Date Tested:</th><td class="right" >{{$result['tested_date']}}</td>
        </tr>
        <tr>
            <th>QC Ref: No.</th><td>{{$result['qc_number']}}</td><th>Retest Date:</th><td class="right" >{{$result['retest_date']}}</td>
        </tr>
        <tr>
            <th>Quantity Received</th><td>{{$result['request']['stock']['rec_qty']}}</td><th>Received On:</th><td class="right" >{{$result['request']['stock']['rec_date']}}</td>
        </tr>
        <tr>
            <th colspan="4" class="right bottom">Name of Manufacturer/Supplier:-&nbsp;&nbsp;<span style="text-transform: uppercase;">{{$result['request']['stock']['vendor_name']}}</span></th>
        </tr>
</table>
 
 <h2>PHYSICAL TESTS / DETERMINATIONS</h2>

            <table class="item-table sub-table"  cellspacing="0" style="margin-top: 5px;">

     <thead style="background-color:#03a9f4;">
        <tr>
            <th class="col1"><center>PARAMETERS</center></th>
    
            <th class="col1"><center>SPECIFICATIONS</center></th>
            <th class="col1 right"><center>RESULT</center></th>
           
        </tr>
        </thead>
        
        <?php $n=count($result['parameters']); $i=1; ?>
     @foreach($result['parameters'] as $prtm)
          <?php $s='';
             if($i==$n)
                $s='bottom';
           ?>   
       <tr>
        
         <th class="item-name-col {{$s}}">{{$prtm['name']}}</th>
         <td class="col {{$s}}">{{$prtm['specification']}}</td>
         <td class="col right {{$s}}"><center>{{$prtm['value']}}</center></td>
       
       </tr>
       <?php $i++; ?>
       @endforeach

   

   </table>

   <div style="margin-top: 30px;">

    <table style="width: 100%;">
        <tr><th align="left" style="width: 5%;">Remarks:</th>
            <td align="center" style="width: 90%;"><u>{{$result['remarks']}}</u></td>
        </tr>
    </table>
      
   </div>

   <table class="" style="border-spacing:50px; width: 100%;margin-top: 15px;">
      <tr >
         <th class="sign"><span>QC Analyst</span></th>
         <th class=""></th>
         <th class="sign"><span >QC Manager</span></th>
         
      </tr>
   </table>


        </main>


        
    </body>
</html>