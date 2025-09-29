<html>
    <head>
        <title>{{$pass['doc_no']}}</title>
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
                margin-top: 5.5cm;
                margin-left: 0.3cm;
                margin-right: 0.3cm;
                margin-bottom: 2cm;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 5.5cm;

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

                    .top-heading{ font-size: 14px; }

                    .top-heading-name{ font-size: 12px; text-transform: uppercase; }

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
            border: 1px solid black;
             }

             .col1{
             
            padding: 7px;
            text-align: center;
             border: 1px solid black;
             }

             .sr-th{

                width: 10% ;
             }

             .qty-th{

                width: 10% ;
             }
             .item-th{

                width: 30% ;
             }
             .unit-th{

                width: 10% ;
             }
             .rmk-th{

                width: 40% ;
             }

             
             .sign{
              
              border-top: 1px solid black !important;
              

            }

            
             
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
               <table width="100%" style="padding: 10px;" cellspacing="0">
        <tr>
            <td align="" style="width: 34%;">
               
                 <p class="top-heading-name"><strong>{{$name}}</strong></p>
                <p class="top-heading-address"><b>{{$address}}</b></p>
            </td>
            <td align="center" style="width: 33%">
                @if($pass['type']=='inward')
                <p class="top-heading"><strong>INWARD GATE PASS</strong></p>
                @elseif($pass['type']=='outward')
                <p class="top-heading"><strong>OUTWARD GATE PASS</strong></p>
                @endif

                @if($pass['returnable']=='1')
                 <P class="top-heading">Returnable</P> 
                 @elseif($pass['returnable']=='0')
                 <P class="top-heading">Non Returnable</P>
                 @endif 
            </td>
            <td align="right"  style="width: 33%;">

               <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="130">
                
            </td>
        </tr>

        <tr><td colspan="3"><hr></td></tr>
         
        <tr class="">
            <td align="" style="width: 34%;">
               
               <table class="challan-detail">
                 <tr><th>Pass No:</th><td>{{$pass['doc_no']}}</td></tr>
                 <tr><th>Name:</th><td>{{$pass['name']}}</td></tr>
                 <tr><th>Vehicle #:</th><td>{{$pass['vehicle']}}</td></tr>
                
               </table>
                
                
            </td>
            <td align="" style="width: 33%">
                
                <?php 
         $order_date=date_create($pass['doc_date'] );
           $order_date=date_format($order_date,"d-M-Y");
            
            $out=''; $in='';
            if($pass['time_out']!=''){
          $out=date_create($pass['time_out'] );
           $out=date_format($out,"h:i A");}

             if($pass['time_in']!=''){
           $in=date_create($pass['time_in'] );
           $in=date_format($in,"h:i A");}

          ?>

               <table class="challan-detail">
                 <tr><th>Date:</th><td>{{$order_date}}</td></tr>
                 <tr><th>Time Out:</th><td>{{$out}}</td></tr>
                 <tr><th>Time In:</th><td>{{$in}}</td></tr>
                
               </table>

            </td>
            <td align=""  style="width: 33%;">
                
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

            <table class="item-table " cellspacing="0" style="margin-top: 5px;">

     <thead style="background-color:#03a9f4;">
        <tr>
            <th class="col1 sr-th">Sr #</th>
            <th class="col1 item-th" >Item</th>
            <th class="col1 qty-th">Qty</th>
            <th class="col1 unit-th">Unit</th>
            <th class="col1 rmk-th" >Remarks</th>

        </tr>
        </thead>
        <?php  $i=1;   ?>
     @foreach($pass['items'] as $item)
   
       <tr style="">
         <td class="col">{{$i}}</td>
         <td class="col">{{$item['item']}}</td>
         <td class="col">{{$item['qty']}}</td>
         <td class="col">{{$item['unit']}}</td>
         <td class="col">{{$item['remarks']}}</td>
       </tr>
       <?php  $i++;  ?>
       @endforeach

      

   </table>

   <div style="">
      <p><b>Remarks:</b></p>
   </div>

   <table class="" style="border-spacing:50px; width: 100%;">
      <tr >
         <th class="sign"><span>Prepared & Checked By</span></th>
         <th class="sign"><span >Head of Dept.</span></th>
         <th class="sign"><span>Approved By</span></th>
         <th class="sign"><span >Received By</span></th>
      </tr>
   </table>


        </main>


        
    </body>
</html>