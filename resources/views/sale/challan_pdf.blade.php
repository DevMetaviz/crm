<html>
    <head>
        <title>{{$challan['doc_no']}}</title>
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
                font-size: 14px;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 7.5cm;
                 padding-left: 15px;
                  font-size:16px;

                /** Extra personal styles **/
                /*background-color: #03a9f4;*/
                /*color: white;*/
                /*text-align: center;*/
                /*line-height: 1.5cm;*/
            }

            header p{
             margin-bottom: 5px;
             margin-top: 5px;
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

                    .top-heading{ font-size: 20px; font-weight:bold; }

                    .top-heading-name{ font-size: 12px; text-transform: uppercase; }

                    .top-heading-address{ text-align: left; }

                    .challan-detail td,.challan-detail th{

                      text-align: left;
                      padding-left: 15px;
                    }
             
                    .page_num:after { content: counter(page); }

            .pages:after { content:  counter(pages); }

            .item-table{
             
            width: 100%;
             }
             .item-table td,.item-table th{
             
                border: 1px solid black;
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

             	width: 30% ;
             	text-align: left;
                padding-left: 7%;
             }

             .item-name-col{

             	width: 30% ;
             	text-align: left;
                border-bottom: 1px solid black; 
             }

             .sign{
              
              border-top: 1px solid black !important;

              /*margin-left: 120px;*/
              
              /*padding : 10px ;*/

            }
             .sign-box{
    border-spacing:50px 0px;
     width: 100%;
     margin-top: 50px;
   }
   .sign-box th{
      padding:5px 0px;
      width: 25%;
   }

            .sign span{
                          }
             .from , .to{
                
                border:1px solid black;
                 width: 40%;
                  font-size: 12px;
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
               
                 {{--<!--<p class="top-heading-name"><strong>{{$challan['company']['name']}}</strong></p>
                <p class="top-heading-address"><b>{{$challan['branch']['name']}}</b></p>-->--}}
            </td>
            <td align="center" style="width: 33%">
                <p class="top-heading"><strong>DELIVERY CHALLAN</strong></p>
                <!-- <P class="top-heading"><strong>GATE PASS</strong></P> -->
            </td>
            <td align="right"  style="width: 33%;">

               <!---<img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="130">-->
                
            </td>
        </tr>

        <tr><td colspan="3"><hr></td></tr>
        
        {{--- 
        <tr class="">
            <td align="" style="width: 34%;">
               
                 <!----<p>The Following number must be appear on all related correspondence, shipping papers,and invoices</p>-->
                <p><b>DC NO:</b>&nbsp;&nbsp;&nbsp;{{$challan['doc_no']}}</p>
            </td>
            <td align="" style="width: 33%">
                
            </td>
            <td align=""  style="width: 33%;">

               

               <table class="challan-detail">
                 <tr><th>Sale Order #:</th><td>@if(isset($challan['order'])){{$challan['order']['doc_no']}}@endif</td></tr>
                 <tr><th>Delivery Date:</th><td></td></tr>
                 <tr><th>Mobile:</th><td>{{$challan['customer']['mobile']}}</td></tr>
               </table>
                
            </td>
        </tr>

        <tr style="border-spacing: 0;">
            <td class="to" >
               
                 
                <p><b>Customer:</b></p>
                <p class="name"><b>{{$challan['customer']['name']}}</b></p>
                <p class="address"><b>{{$challan['customer']['address']}}</b></p>
            </td>
            <!--<td class="from" >
                <p><b>FROM:</b></p>
                <p class="name"><b></b></p>
                <p class="address"><b></b></p>
            </td>-->
            <td  style="">
                
            </td>
        </tr>---}}

        

    </table>

 <?php 
         $challan_date=date_create($challan['doc_date'] );
           $challan_date=date_format($challan_date,"d-M-Y");

          $order_date='';

          if(isset($challan['order'])){
           $order_date=date_create($challan['order']['doc_date'] );
           $order_date=date_format($order_date,"d-M-Y");
          }
          
          ?>

     <div class="od-dt">

    <p><b>DC NO:</b>&nbsp;&nbsp;&nbsp;{{$challan['doc_no']}} ({{$challan['branch']['name']}})</p>
    <p><b>Delivery Date: </b>{{$challan_date}}</p>
    <p><b>Order No:</b>&nbsp;&nbsp;&nbsp;@if(isset($challan['order'])){{$challan['order']['doc_no']}}@endif </p>

    <p><b>Order Date: </b>{{$order_date}}</p>
    <p class="name"><b>Customer: </b>{{$challan['customer']['account']['code'].' '.$challan['customer']['name']}}</p>
    <p><b>Mobile: </b>{{$challan['customer']['mobile']}}</p>
    <!--<p class="address"><b>{{$challan['customer']['address']}}</b></p>-->

     </div>

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
             <th class="Col1">Cat</th>
            <th class="item-name-th">Item</th>
            <!--<th class="col1">Rack</th>
            <th class="col1">Rack Qty</th>-->
            <!--<th class="col1">Exp</th>-->
            <th class="col1">Qty</th>
            <th class="col1">Remarks</th>
        </tr>
        </thead>
        <?php  $i=1; $total=0; $total_weight=0; ?>
     @foreach($challan['items'] as $item)
     <?php 

     $date='';
     /*if($item['pivot']['expiry_date'] !='')
     {
         $date=date_create($item['pivot']['expiry_date'] );

           $date=date_format($date,"M-Y");
           }*/
             $weight=$item['pivot']['unit_weight'] ?? 0;
           $qty=$item['pivot']['qty'] ; //* $item['pivot']['pack_size'] ;
           $total += $qty;

           $total_weight += $qty * $weight;
          ?>
       <tr style="">
         <td class="col">{{$i}}</td>
         <td class="col">{{$item['category_name']}}</td>
         <td class="item-name-col">{{$item['item_code'].' '.$item['item_name']}}</td>
         <!--<td class="col">{{$item['pivot']['rack']}}</td>
         <td class="col">{{$item['pivot']['rack_qty']}}</td>-->
         <!--<td class="col">{{$date}}</td>-->
         <td class="col">{{number_format($qty,2)}}</td>
         <td class="col"></td>
       </tr>
       <?php  $i++;  ?>
       @endforeach

       <tfoot style="">
        <tr >
         <td></td>
         <td></td>
         <td></td>
         <!--<td></td>
         <td></td>-->
         <!---<td></td>-->
         <th class="col">{{number_format($total,2)}}</th>
         <th></th>
       </tr>
     </tfoot>

   </table>

   <div style="margin: 20px;">

    <p><b>=======RECEIVED THE ABOVE ITEM IN GOOD ORDER AND CONDITION=======</b></p>


      <p><b>Remarks:</b> {{$challan['remarks']}}</p>
   </div>
<!-- style="border: 1px solid black;" -->
   <table class="sign-box" style="">
     <!-- <tr style="">
         <th class="" style=""><span>Imran Ali</span></th>
         <th style="visibility: hidden;">343435</th>
         <th class=""><img src="{{url('public/images/bilal_qc.jpg')}}" width="70" height="70"></th>
         <th style="visibility: hidden;">343435</th>
         <th class=""></th>
         <th style="visibility: hidden;">527889</th>
         <th class=""><img src="{{url('public/images/irfan.jpg')}}" width="70" height="70"></th>
      </tr>
    <tr >
         <th class="sign"><span>Prepared & Checked By</span></th>
         <th></th>
         <th class="sign"><span >Verified By</span></th>
         <th></th>
         <th class="sign"><span >Received By</span></th>
         <th></th>
         <th class="sign"><span>Approved By</span></th>
      </tr> -->
      <tr >
         <th class=""><span>{{$total_weight}}</span></th>
         <th class=""><span >@if($challan['user']){{$challan['user']['name']}}@endif</span></th>
         <th class=""><span >{{Auth::user()->name}}</span></th>
         <th class=""><span></span></th>
      </tr>
       <tr >
         <th class="sign"><span>Estiamted Weight</span></th>
         <th class="sign"><span >Prepared By</span></th>
         <th class="sign"><span >Authorized By</span></th>
         <th class="sign"><span>Store Incharge</span></th>
      </tr> 
   </table>


        </main>


        
    </body>
</html>