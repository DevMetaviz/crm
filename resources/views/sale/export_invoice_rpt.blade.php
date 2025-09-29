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
                margin-top: 4cm;
                margin-left: 1.5cm;
                margin-right: 1.5cm;
                margin-bottom: 3cm;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
               
               padding-top: 20px;

               background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
 
            background-image:url({{url('public/images/letter_head_center.jpg')}});

            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 4cm;
         
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
 
            background-image:url({{url('public/images/letter_head_top.jpg')}});

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
                height: 3cm;
               
                /** Extra personal styles **/
                /*background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;*/

                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
 
            background-image:url({{url('public/images/letter_head_bottom.jpg')}});

                    }

                    .top-heading{ font-size: 18px; text-transform: uppercase; /*margin-top: 60px;*/ }

                    .top-heading-name{ font-size: 12px;  }

                    .top-heading-address{ text-align: center; }

                    #info td,#binfo td,#infor td{ border: 1px solid #03a9f4; padding: 5px; }

                    #binfo table td,#infor table td{ border: none; padding: none; }

                    .bg{background-color:#03a9f4; color: white;  }
             
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
                border-bottom: 1px dotted #03a9f4;
                border-left: 1px solid #03a9f4;
             }

             .bottom-r{
                border-right: 1px solid #03a9f4;
             }


             .col1{
             
            padding: 4px;
            text-align: center;
             }

             .item-name-th{

             	width: 23% ;
             	text-align: center;
                
             }

             .item-name-col{

             	width: 23% ;
             	text-align: left;
             }

             .sign{
              
              border-top: 1px solid black !important;
              
              padding : 5px 50px;

            }

           
             

             
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
               
        </header>

       <script type="text/php">
    if (isset($pdf)) {
    echo $PAGE_COUNT;
        $x =  $pdf->get_width() - 92;
        $y =  $pdf->get_height() - 85;
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
        <!-- <p>Page <span class="page_num"></span> of <span class="pages"></span> -->
  </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main style="width: 100%;">

          <table width="100%" style="" cellspacing="0">
        <tr>
            <td align="" style="width: 30%;">
               
                 <p class="top-heading-name">Ref:<u>{{$sale['invoice_no']}}</u></p>
                
            </td>
            <td align="center" style="width: 40%">
                <p class="top-heading"><strong><u><i>Pro forma Invoice</i></u></strong></p>
            </td>
            <td align="right"  style="width: 30%;">
                <?php 
         $date=date_create($sale['invoice_date'] );
           $date=date_format($date,"d-m-Y");
          ?>
               <p class="top-heading-name">Date:<u>{{$date}}</u></p>
                
            </td>
        </tr>
  </table>
        
         <table id="info" width="100%" cellspacing="0" cellpadding="0">
        <tr>

            <td class="bg" align="center"  style="width: 50%;">
                 <h3 style="padding: 0px;margin: 0px;">BENEFICIARY</h3>
            </td>

            <td class="bg" align="center" style="width: 50%;">
                <h3 style="padding: 0px;margin: 0px;">CONSIGNEE / IMPORTER</h3>
            </td>
        </tr>


        <tr class="">

            <td align="" valign="top"  style="width: 50%;" >

                 <h3 style="text-transform: capitalize;margin:none;" ><center><u><i>Fahmir Pharma (Pvt.) Ltd</i></u></center></h3>

                 <p style="margin: none;"><i>26-KM Lahore Jaranwala Road Main Stop Mandianwala Sharaqpur Sharif, District Sheikhupura, Lahore Division, Punjab, Pakistan
                 <br>Zip Code: 39460
                 <br>Phone: +92-56-354100 , +923312030430 , +923085868383
                 <br>E.Mail: fahmirpharma@gmail.com , dr.hafizroy@fahmirpharma.com
                 <br>Website: fahmirpharma.com</i></p>                
            </td>

            <td align="" valign="top" style="width: 50%">

                <h3 style="text-transform: capitalize;" ><u><center><i>{{$sale['customer']['name']}}</center></i></u></h3>

                <p><i>{{$sale['customer']['address']}}
                 @if($sale['customer']['zip_code'])<br>Zip Code: {{$sale['customer']['zip_code']}}@endif
                 @if($sale['customer']['mobile'])<br>Phone: {{$sale['customer']['mobile']}}@endif
                 @if($sale['customer']['email'])<br>E.Mail: {{$sale['customer']['email']}}@endif
                 </p>
                
            </td>
        </tr>        

    </table>

     <table id="binfo" style="" width="100%" cellspacing="0" cellpadding="0">
        <tr>

            <td class="bg" align="center"  style="width: 30%;">
                 <h3 style="padding: 0px;margin: 0px;"></h3>
            </td>

            <td class="bg" align="center" style="width: 70%;">
                <h3 style="padding: 0px;margin: 0px;">Routing of incoming payment</h3>
            </td>
        </tr>


        <tr class="">

            <td align="" valign="top"  style="width: 30%;" >

                                
            </td>

            <td align="" valign="top" style="width: 70%">
            
              <table class="" style="width: 100%" cellspacing="0">
                <tr><td style="width: 40%;">BANK NAME</td><td style="width: 60%;">Meezan Bank Limited</td></tr>
                <tr><td>ADDRESS</td><td>Sharaqpur Sharif Branch, Sharaqpur Sharif</td></tr>
                 <tr><td>SWIFT CODE</td><td>MEZNPKKALH2</td></tr>
                 <tr><td>BRANCH CODE</td><td>1259</td></tr>
                 <tr><td>BENEFICIARY'S NAME</td><td>Fahmir Pharma (Pvt.) Ltd</td></tr>
                 <tr><td>BENEFICIARY'S IBAN</td><td>PK38MEZN0012590104615008</td></tr>
               </table>
                
                
            </td>
        </tr>        

    </table>


            <table class="item-table " cellspacing="0" style="">

     <thead class ="bg">
        <tr>
            <th class="col1">Ser No</th>
            <th class="item-name-th">Brand Name</th>
            <th class="item-name-th">Generic</th>
            <th class="col1">Packing</th>
            <th class="col1">Quantity</th>
            <th class="col1">Rate</th>
            <th class="col1"></th>
            <th class="col1">Amount</th>
            
            
        </tr>
        </thead>
        <?php  $i=1; $total_qty=0; $total=0;
           $items=$sale['sale_stock_list'];
          ?>
     @foreach($items as $item)
     
       <tr>
         <td class="col bottom">{{$i}}</td>
         <td class="item-name-col bottom">{{$item['item']['item_name']}}</td>
         
         <td class="item-name-col bottom">{{$item['item']['generic']}}</td>
         <td class="col bottom">{{$item['item']['pack_size']}}</td>
         
        <td class="col bottom">{{$item['total_qty']}}</td>
         
         <td class="col bottom">{{$item['rate']}}</td>
         <td class="col bottom">{{$sale['currency']['symbol']}}</td>
         <td class="col bottom bottom-r">{{$item['amount']}}</td>
         
         
       </tr>
       <?php  $i++; $total=$total + $item['amount'];  ?>
       @endforeach

       <tfoot >
        
        <tr >
         
         <td colspan="6" class="col bottom" style="text-align: right;padding-right: 20px; "><b>Total:</b></td>
        
         
         
         
         <th class="col bottom">{{$sale['currency']['symbol']}}</th>
         <th class="col bottom bottom-r">{{$total}}</th>
        
       </tr>
     </tfoot>

   </table>
   
    
    <table id="infor" width="100%" cellspacing="0" cellpadding="0">
        <tr>

            <td class="bg" align="center"  style="width: 50%;">
                 <h3 style="padding: 0px;margin: 0px;">TERMS OF SALE AND OTHER COMMENTS</h3>
            </td>

            <td class="bg" align="center" style="width: 50%;">
                <h3 style="padding: 0px;margin: 0px;">ADDITIONAL DETAILS</h3>
            </td>
        </tr>


        <tr class="">


            <td align="" valign="top" style="width: 50%">

           <pre style="font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: black;">{{$sale['remarks']}}</pre>
                
            </td>

            <td align="" valign="top"  style="width: 50%;" >

                <table class="" style="width: 100%" cellspacing="0">
            <tr><td style="width: 40%;">Country of Origin:</td><td style="width: 60%;">Pakistan</td></tr>
                <tr><td>Port of Shipment:</td><td>@if($sale['shipment_port']){{$sale['shipment_port']['text']}}@endif</td></tr>
                 <tr><td>Port of Discharge:</td><td>@if($sale['discharge_port']){{$sale['discharge_port']['text']}}@endif</td></tr>
                 <tr><td>Packing:</td><td>@if($sale['packing_type']){{$sale['packing_type']['text']}}@endif</td></tr>
                 <tr><td>Freight Type:</td><td>@if($sale['freight_type']){{$sale['freight_type']['text']}}@endif</td></tr>
                 <tr><td>Transportation:</td><td>@if($sale['transportation']){{$sale['transportation']['text']}}@endif</td></tr>
               </table>

                               
            </td>

            
        </tr>        

    </table>

  <p style="padding-left: 20px;">I certify the above to be true and correct to the best of my knowledge.</p>

  
   <table class="" style="margin-left: 60px;margin-top: 10px;">
    <tr>
        <th style="padding-top: 60px;"><img src="{{url('public/images/sir_umair.png')}}" align="center" alt=" " height="50" ></th>
        <th rowspan="2" valign="top" ><img src="{{url('public/images/fahmir_stamp.png')}}" align="center" alt=" " width="250" ></th>
    </tr>
      <tr >
         <th class="sign"><span  id="dig">Hafiz Roy Umair<br>Director</span></th>
      </tr>
   </table>


        </main>



        
    </body>
</html>