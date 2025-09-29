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
                margin-top: 7.7cm;
                margin-left: 42px;
                margin-right: 42px;
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
                height: 7.7cm;
                 
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


                    .top-heading-name{ text-transform: uppercase;padding: none;margin: none;}

                    
                    .challan-detail td,.challan-detail th{

                      text-align: left;
                      padding-left: 0px;
                    }
             
                    .page_num:after { content: counter(page); }

            .pages:after { content:  counter(pages); }

            .item-table{
             
            width: 100%;
             }

           .col{
             
            padding: 5px;
            text-align: center;
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

             .table-boarder1 tbody td{
              

                border-bottom: 1px solid black;
            

             }

             .table-boarder td,.table-boarder th{
               border-left: 1px solid black;

                border-bottom: 1px solid black;
                padding: 5px;

             }

             .table-boarder th{
              

                border-top: 1px solid black;

             }

             .table-boarder td:last-child,.table-boarder th:last-child{
               border-right: 1px solid black;

             }


             .table-boarder {
             
               border-spacing: none;
              
             }

             
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
               <table width="100%" style="padding: 45px;" cellspacing="0">
        <tr>
            <td align="" style="width: 40%;padding-right: 15px; ;margin: none;">
               
                 <h2 class="top-heading-name"><strong>{{$name}}</strong></h2>
                 <p style="padding: none;margin: none;"><strong><i>{{$tag_line}}</i></strong></p>
                 <p style="padding: none;margin: none;"><strong>Head Office: </strong>{{$head_office}}</p>
                <p style="margin: none;"><strong>Factory: </strong>{{$address}}</p>

                <p style="margin: none;">{{'Phone: '.$phone.',Mobile No: '.$mobile}}</p>

            </td>
            <td align="center" style="width: 20%;vertical-align: top;">
                <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" width="70%">
            </td>
            <td align=""  style="width: 40%;vertical-align: top;">

               <h2 style="padding: none;margin: none;">PURCHASE ORDER</h2>
                
            </td>
        </tr>

        <tr >
          <td style="padding-top: 30px;">
            <p style="margin-bottom: none;">The Following number must appear on all related correspondence and Purhase Order.</p>
            <h4 style="margin: none;padding: none;">QUOTATION NO: NIL</h4>
             <h4 style="margin: none;">ORDER NO: {{$order['doc_no']}}</h4>
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
        
        <table style="width: 100%;">
          <tr class="" style="vertical-align: top;">

            <td align="" class="challan-detail"  style="width: 50%;padding-right: 50px;">

             
               <p><strong style="text-transform: uppercase;">Vendor:<br>@if($order['vendor_id']!=''){{$order['vendor']['name']}}@endif</strong>
                <br>@if($order['vendor_id']!=''){{$order['vendor']['address']}}@endif
                <br><strong>Phone: </strong>@if($order['vendor_id']!=''){{$order['vendor']['phone']}}@endif
                <br><strong>Mobile: </strong>@if($order['vendor_id']!=''){{$order['vendor']['mobile']}}@endif
                <br><strong>Email: </strong>@if($order['vendor_id']!=''){{$order['vendor']['email']}}@endif
              </p>
                 
               

                
            </td>

            
           
            <td align="" class="challan-detail" style="width: 50%;padding-right: 50px;">

              <p><strong style="text-transform: uppercase;">Request From:<br>{{$name}}
                <br>@if($order['order_by']!=''){{$order['ordered_by']['name']}}@endif</strong>
                <br>{{$address}}
                <br><strong>Phone: </strong>{{$phone}}
                <br><strong>Mobile: </strong>{{$mobile}}, <strong>Fax: </strong>{{$fax}}
                <br><strong>Email: </strong>{{$email}}
              </p>

               
            </td>
        </tr>

      </table>

      <table class="table-boarder" style="width: 100%;" cellspacing="none" cellpadding="none">

          <tr>
            <th>P.O DATE</th>
            <th>REQUISITIONER</th>
            <th>SHIPPED VIA</th>
            <th>F.O.B. POINT</th>
            <th>TERMS</th>
          </tr>

          <?php 
         $date=date_create($order['doc_date'] );
           $date=date_format($date,"d-M-Y");

          ?>

          <tr>
             <td>{{$date}}</td>
             <td></td>
             <td>@if($order['transport_via']!=''){{$order['transport_via']['name']}}@endif</td>
             <td>{{$order['fob_point']}}</td>
             <td>{{$order['payment_type']}}</td>
           </tr>

      </table>

            <table class="item-table table-boarder1" cellspacing="0" style="margin-top: 5px;">

     <thead style="background-color:#03a9f4;color: white;">
        <tr>
            <th class="col1">Sr No.</th>
            
            <th class="item-name-th">Description</th>
            <th class="col1">Unit</th>
            <th class="col1">Qty</th>
            <th class="col1">Unit Price</th>
            <th class="col1">Total</th>
           

        </tr>
        </thead>
        <?php  $i=1; $total_qty=0; $net_total=0; $net_amount=0;  ?>
     @foreach($order['items'] as $item)
     <?php 
           $uom='';
           if($item['unit']!='')
            $uom=$item['unit']['name'];
           
           $qty=$item['pivot']['quantity'] * $item['pivot']['pack_size'] ;
           $total_qty += $qty;
             
             $rate=$order->rate_exclusive_tax($item['id'],$item['pivot']['id']);
             $total=$rate * $qty;
             $net_total += $total;

             $t_rate=$order->rate_inclusive_tax($item['id'],$item['pivot']['id']);
             $amount=$t_rate * $qty;
             $net_amount += $amount;

             $tax=$amount - $total;

          ?>
       <tr>
         <td class="col">{{$i}}</td>
         
         <td class="item-name-col">{{$item['item_name']}}</td>
         <td class="col">{{$uom}}</td>
         <td class="col">{{$qty}}</td>
         <td class="col">{{$rate}}</td>
         
         <td class="col">{{$amount}}</td>
       </tr>
       <?php  $i++;  ?>
       @endforeach

       <tfoot>
        <tr >
         <td></td>
         <td></td>
         <td></td>
         
         <th class="col">{{$total_qty}}</th>
        
         <td></td>
         <th class="col">{{$net_amount}}</th>
       </tr>
     </tfoot>

   </table>
  <?php 

   $wh=$order['with_holding_tax'];
    $wh_amount= round( ( ($wh / 100 ) * $net_amount ),2) ;

   // $d=$order['net_discount'];
   // if($d=='')
   //  $d=0;
   //   $discount= round( ( ($d / 100 ) * $net_amount ),2) ;

  //$expenses=$order->expenses_amount();
     //$expenses=0;
      
      $net=($net_amount  - $wh_amount )  ; 

     
   ?>

   <table style="width: 100%;">

      <tr>

        <td style="width: 50%;vertical-align: top; padding-right : 44px;">

          
         <p>Send all correspondence to:<br><br><strong style="text-transform: uppercase;">{{$name}}</strong>
                <br>{{$address}}
                <br><strong>Phone: </strong>{{$phone}}, <strong>Fax: </strong>{{$fax}}
                <br><strong>Whatsapp: </strong>{{$whats_app}}
                
              </p>
   
            
          </td>

          <td style="width: 50%;">

            <table style="width: 80%;float: right;text-align: right;padding-right: 20px;">
    <tr><th style="width:50% ;text-align: right;">WH Tax {{$wh.'%'}} :</th> <td style="width: 50%">{{$wh_amount}}</td> </tr>
    <!-- <tr><th style="width:50% ">Expenses:</th> <td style="width: 50%"></td> </tr> -->

    <tr><th style="width:50%;text-align: right; ">TOTAL:</th> <td style="width: 50%">{{$net}}</td> </tr>
       
   </table>
            
          </td>
          
      </tr>
     
   </table>


   

   

   <table class="" style="border-spacing:50px; width: 100%;">
      <tr >
         <th class="sign"><span>Prepared & Checked By</span></th>
         <th class="sign"><span >Verified By</span></th>
         <th class="sign"><span >Received By</span></th>
         <th class="sign"><span>Approved By</span></th>
      </tr>
   </table>


        </main>


        
    </body>
</html>