<html>
    <head>
        <title>{{$order['doc_no']}}</title>
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
            border-bottom: 1px solid black;
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

                width: 40% ;
                text-align: left;
                border-bottom: 1px solid black; 
             }

             .sign{
              
              border-top: 1px solid black !important;
              
              padding : 10px ;

            }

            .sign span{
                          }
             .from , .to{
                
                border:1px solid black;
                 width: 33%;
                  font-size: 9px;
                height: 100px;
                padding-left: 5 ;
                padding-right: 5;

             }
             .name{
                text-transform: uppercase;
             }
             .address{
                 text-align: center;
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
                <p class="top-heading"><strong>SALE ORDER</strong></p>
                <!-- <P class="top-heading"><strong>GATE PASS</strong></P> -->
            </td>
            <td align="right"  style="width: 33%;">

               <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="130">
                
            </td>
        </tr>

        <tr><td colspan="3"><hr></td></tr>
         
        <tr class="">
            <td align="" style="width: 34%;">
               
                 <p>The Following number must be appear on all related correspondence, shipping papers,and invoices</p>
                <p><b>Order No:</b>&nbsp;&nbsp;&nbsp;{{$order['doc_no']}}</p>
            </td>
            <td align="" style="width: 33%">
                
            </td>
            <td align=""  style="width: 33%;">

                <?php 
         $order_date=date_create($order['order_date'] );
           $order_date=date_format($order_date,"d-M-Y");

          
          ?>

               <table class="challan-detail">
                 <tr><th>Date:</th><td>{{$order_date}}</td></tr>
                 <tr><th>Mobile:</th><td>{{$order['customer']['mobile']}}</td></tr>
               </table>
                
            </td>
        </tr>

        <tr style="border-spacing: 0;">
            <td class="to" >
               
                 
                <p><b>TO:</b></p>
                <p class="name"><b>{{$order['customer']['name']}}</b></p>
                <p class="address"><b>{{$order['customer']['address']}}</b></p>
            </td>
            <td class="from" >
                <p><b>FROM:</b></p>
                <p class="name"><b>FAHMIR PHARMA PVT. LTD</b></p>
                <p class="address"><b>26- Km Lahore -Jaranwala Road, Main Stop Mandianwala, Tehsil Sharaqpur Sharif, District Sheikhupura.</b></p>
            </td>
            <td  style="">
                
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
            <th class="col1" style="width: 10%">#</th>
            <th class="item-name-th" style="width: 30%">Item</th>
            <th class="item-name-th" style="width: 30%">Generic</th>
            <th class="col1" style="width: 40%">Pack Size</th>
            <th class="col1" style="width: 40%">MRP</th>
            <th class="col1" style="width: 40%">TP</th>
            <th class="col1" style="width: 40%">Qty</th>
        </tr>
        </thead>
        <?php  $i=1; $total=0;  ?>
     @foreach($order['items'] as $item)
     <?php 
        

           $qty=$item['pivot']['qty'] * $item['pivot']['pack_size'] ;
           $total += $qty;

           $tp=round( 0.85 * $item['mrp'] , 2 );
          ?>
       <tr style="">
         <td class="col">{{$i}}</td>
         <td class="item-name-col">{{$item['item_name']}}</td>
         <td class="item-name-col">{{$item['generic']}}</td>
         <td class="col">{{$item['pack_size']}}</td>
         <td class="col">{{$item['mrp']}}</td>
         <td class="col">{{$tp}}</td>
      
         <td class="col"></td>
       </tr>
       <?php  $i++;  ?>
       @endforeach

       <tfoot style="">
        <tr >
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <th class=""></th>
       </tr>
     </tfoot>

   </table>

   <div style="margin: 20px;">
      <p><b>Remarks:</b></p>
   </div>

   <table class="" style="border-spacing:50px; width: 100%;">
      <tr >
         <th class="sign"><span>Prepared & Checked By</span></th>
         <th class="sign"><span >Verified By</span></th>
         <th class="sign"><span >Approved By</span></th>
         <th class="sign"><span>Received By</span></th>
      </tr>
   </table>


        </main>


        
    </body>
</html>