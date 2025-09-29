<html>
    <head>
        <title>{{$sale['invoice_no']}}</title>
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
             
            padding: 3px;
            text-align: center;
             }

             .bottom{
                border-bottom: 1px dotted black;
             }

             .col1{
             
            padding: 4px;
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
             }

             .sign{
              
              border-top: 1px solid black !important;
              
              padding : 15px ;

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
                <p class="top-heading"><strong>ESTIMATED INVOICE</strong></p>
                <!-- <P class="top-heading"><strong>GATE PASS</strong></P> -->
            </td>
            <td align="right"  style="width: 33%;">

               <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="140">
                
            </td>
        </tr>

        <tr><td colspan="3"><hr></td></tr>
         
        <tr class="">
            <td align="" style="width: 34%;">
               
                 <p>The Following number must be appear on all related correspondence, shipping papers,and invoices</p>
                <p><b>DC NO:</b>&nbsp;&nbsp;&nbsp;{{$sale['invoice_no']}}</p>
            </td>
            <td align="" style="width: 33%">
                
            </td>
            <td align=""  style="width: 33%;">

               <table class="challan-detail">
                <tr><th>Invoice Date:</th><td>{{$sale['invoice_date']}}</td></tr>
                 <tr><th>Delivery Challan #:</th><td>@if($sale['challan']!=null){{$sale['challan']['doc_no']}}@endif</td></tr>
                 <tr><th>Delivery Date:</th><td>@if($sale['challan']!=null){{$sale['challan']['challan_date']}}@endif</td></tr>
                 <tr><th>Mobile:</th><td>{{$sale['customer']['mobile']}}</td></tr>
               </table>
                
            </td>
        </tr>

        <tr style="border-spacing: 0;">
            <td class="to" >
               
                 
                <p><b>TO:</b></p>
                <p class="name"><b>{{$sale['customer']['name']}}</b></p>
                <p class="address"><b>{{$sale['customer']['address']}}</b></p>
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
            <div><p><span style="margin-left:60px;visibility: hidden;">{{date('d-M-Y')}}</span><span style="margin-left:60px;visibility: hidden;">{{date('H:i:s A')}}</span></p></div>
    </div>
    <div style="height:30px;background-color: #03a9f4;"></div>
  </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main style="width: 100%;">
            <table class="item-table " cellspacing="0" style="margin-top: 5px;">

     <thead style="background-color:#03a9f4;">
        <tr>
            <th class="col1">#</th>
            <th class="item-name-th">Item</th>
         

            <th class="col1">Qty</th>
            <!-- <th class="col1">M.R.P</th> -->
            
            <th class="col1">T.P</th>
            
            <th class="col1">Disc %</th>
            <th class="col1">Disc Value</th>
            <th class="col1">Rate</th>
            <th class="col1">Exc. Tax Amount</th>
            <th class="col1">Tax %</th>
            <th class="col1">Inc. Tax Amount</th>
        </tr>
        </thead>
        <?php  $i=1; $total_qty=0; $total_amount=0;
           $items=$sale['items'];
          ?>
     @foreach($items as $item)
     
       <tr>
         <td class="col bottom">{{$i}}</td>
         <td class="item-name-col bottom">{{$item['item_name']}}</td>
         
         <td class="col bottom">{{$item['total_qty']}}</td>
         <!-- <td class="col bottom">{{$item['mrp']}}</td> -->
         
         <td class="col bottom">{{$item['tp']}}</td>
         <?php $disc_type='%'; 
                if($item['discount_type']=='flat')
                $disc_type='flat';
              ?>
         <td class="col bottom">{{$item['discount_factor']}}</td>
         <td class="col bottom">{{$item['discounted_value']}}</td>
         <td class="col bottom">{{$item['rate']}}</td>
         <td class="col bottom">{{number_format($item['total'],2)}}</td>
         <td class="col bottom">{{$item['tax']}}</td>
         <td class="col bottom">{{number_format($item['net_amount'],2)}}</td>
       </tr>
       <?php  $i++;  ?>
       @endforeach

       <tfoot style="border-top: 1px solid black;">
        <tr><td colspan="10"><hr></td></tr>
        <tr >
         <td></td>
         <td style="text-align: center; "><b>Total:</b></td>
         <th class="col">{{$sale['total_net_qty']}}</th>
         <!-- <td></td> -->
         
         <td></td>
        
         <td></td>
         <td></td>
         <th class="col"></th>
         <th class="col">{{number_format($sale['total_amount'],2)}}</th>
         <td></td>
         <th class="col">{{number_format($sale['total_net_amount'],2)}}</th>
       </tr>
     </tfoot>

   </table>
   <div>
    <?php
           $type=$sale['net_discount_type'];
           if( $type=='percentage' )
             $type='%';
            else
                $type='';
     ?>
         <table style="float: right;margin:10px;" cellpadding="0" cellspacing="5">
            <tr><th>Total Amount:</th><td>{{$sale['total_net_amount']}}</td></tr>
             <tr><th>Discount:</th><td>{{$sale['net_discount'].$type}}</td></tr>
             <tr><td colspan="2"><hr></td></tr>
             <tr>
                <th>Net Amount:</th>
                <td>{{$sale['net_bill']}}</td>
             </tr>
         </table>
   </div>
   <div style="margin: 20px;">
      <p><b>Remarks:</b>{{$sale['remarks']}}</p>
   </div>

   <table class="" style="border-spacing:90px; width: 90%;">
      <tr >
         <th class="sign"><span>Prepared By</span></th>
         <th class="sign"><span >Verified By</span></th>
         <th class="sign"><span>Approved By</span></th>
      </tr>
   </table>


        </main>


        
    </body>
</html>