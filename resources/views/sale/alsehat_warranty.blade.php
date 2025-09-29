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
                margin-bottom: 3.5cm;
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
                height: 3.5cm;

                /** Extra personal styles **/
                /*background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;*/
                    }

                    .top-heading{ font-size: 26px; }

                    .top-heading-name{ font-size: 16px; text-transform: uppercase; }

                    .top-heading-address{ 
                        font-size: 11px;
                         }

                    .challan-detail td,.challan-detail th{

                      text-align: left;
                      padding: 5 0 0 15;
                    
                    }

                    .challan-detail{
                      position: absolute;

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

             .bottom{
                border-bottom: 1px dotted black;
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
              .to{
                
                border:1px solid black;
                 width: 100%;
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
        <!-- Factory: K-229, Sector K Super HighwayIndustrial Area.S.I.T.E  Phase II Karachi. -->
        <header>
               <table width="100%" style="padding:0 10;border-bottom: 1.5px solid black;" cellspacing="0">
        <tr style="border-bottom: 1px solid red;">
            <td align="" style="width: 34%;">
               
                 <p class="top-heading-name"><strong>{{$name}}</strong></p>
                <p class="top-heading-address"><b>{{'K-229, Sector K Super HighwayIndustrial Area.S.I.T.E  Phase II Karachi.'}}</b></p>
            </td>
            <td align="center" style="width: 33%">
                <img src="{{url('public/images/alsehat-logo.jpg')}}" alt="Logo Image" height="65" width="130">
            </td>
            <td align="right"  style="width: 33%;">

               
                <p class="top-heading"><strong>WARRANTY INVOICE</strong></p>
            </td>
        </tr>
        <!-- <tr style="margin:0px;padding: 0px;"><td style="margin:0px;padding: 0px;" colspan="3"><hr></td></tr> -->
    </table>
      
      <table width="100%" style="padding:0 10;" >
        
        <tr class="">
            <td align="" style="width: 50%;">
               
                 <p>The Following number must be appear on all related correspondence, shipping papers,and invoices</p>
                <p><b>DC NO:</b>&nbsp;&nbsp;&nbsp;{{$challan['doc_no']}}</p>
                 <div class="to">
                     <p><b>TO:</b></p>
                <p class="name"><b>{{$challan['customer']['name']}}</b></p>
                <p class="address"><b>{{$challan['customer']['address']}}</b></p>
                 </div>
            </td>
            <td align="" style="width: 15%;">
                
            </td>
            <td align=""  style="width: 35%;">
              <?php
              $order_date='';
              if(isset($challan['order'])) 
             {
                $order_date=date_create($challan['order']['order_date'] );
           $order_date=date_format($order_date,"d-M-Y");
           }

           $challan_date=date_create($challan['challan_date'] );
           $challan_date=date_format($challan_date,"d-M-Y");

          ?>
               <table class="challan-detail">
                 <tr><th>Sale Order #:</th><td>@if(isset($challan['order'])){{$challan['order']['doc_no']}}@endif</td></tr>
                 <tr><th>Order Date:</th><td>{{$order_date}}</td></tr>
                 <tr><th>Delivery No:</th><td>{{$challan['doc_no']}}</td></tr>
                 <tr><th>Delivery Date:</th><td>{{$challan_date}}</td></tr>
                 <!-- <tr><th>Mobile:</th><td>{{$challan['customer']['mobile']}}</td></tr> -->
               </table>
                
            </td>
        </tr>

        <!-- <tr style="border-spacing: 0;">
            <td class="to" >
               
                 
                <p><b>TO:</b></p>
                <p class="name"><b>{{$challan['customer']['name']}}</b></p>
                <p class="address"><b>{{$challan['customer']['address']}}</b></p>
            </td>
            <td class="from" >
                <p><b>FROM:</b></p>
                <p class="name"><b>FAHMIR PHARMA PVT. LTD</b></p>
                <p class="address"><b>26- Km Lahore -Jaranwala Road, Main Stop Mandianwala, Tehsil Sharaqpur Sharif, District Sheikhupura.</b></p>
            </td>
            <td  style="">
                
            </td>
        </tr> -->

        

    </table>
        </header>

       <script type="text/php">
    if (isset($pdf)) {
    echo $PAGE_COUNT;
        $x =  $pdf->get_width() - 90;
        $y =  $pdf->get_height() - 20;
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

        <footer style="padding:0 10;">
            <div>
                <p style="text-align: justify;"><center><span>"FORM 2A"</span><br><span>(See Rules 19 and 30)</span><br></center>Warranty under section 23(1)(i)of the Drugs Act.1976 I,Allah bakhsh soomro as QCM of Al-Sehat Laboratories.Plot # 229, sector K, SITE II Industrial Area, adjacent to Gulshan e Maymar, Karachi, under name of Prolife Al-Sehat Labouratories, do hereby give this warranty on the strength of warranty given to us by manufacturer/   supplier that the drugs herein described as sold  by us specified and contained in the  Invoice describining.the goods referred herein do not contravene in any way the provision of Section 23 of the Drugs Act 1976</p>
            </div>
            <div style="height:15px;background-color: #03a9f4;"></div>
    <div>
        <!-- <p>Page <span class="page_num"></span> of <span class="pages"></span> -->
            <div><p><span style="margin-left:60px;">{{date('d-M-Y')}}</span><span style="margin-left:60px;">{{date('H:i:s A')}}</span></p></div>
    </div>
    
  </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main style="width: 100%;">
            <table class="item-table " cellspacing="0" style="margin-top: 5px;">

     <thead style="background-color:#03a9f4;">
        <tr>
            <th class="col1">#</th>
            <th class="item-name-th">Item</th>
            <th class="col1">Batch No</th>
            
            <th class="col1">Exp</th>

            <th class="col1">Qty</th>
            <th class="col1">M.R.P</th>
            <th class="col1">Disc%</th>
            <th class="col1">T.P</th>
            <th class="col1">TOTAL AMOUNT</th>
        </tr>
        </thead>
        <?php  $i=1; $total_qty=0; $total_amount=0;
           $items=$challan['items']->where('manufactured_by','alsehat');
          ?>
     @foreach($items as $item)
     <?php 
         $date=date_create($item['pivot']['expiry_date'] );
           $date=date_format($date,"M-Y");

           $qty=$item['pivot']['qty'] * $item['pivot']['pack_size'] ;
           $total_qty += $qty;

           $tp=0.85 * $item['pivot']['mrp'];
           $tp=round($tp,2);
           $amount= $tp * $qty;
           $total_amount += $amount;
          ?>
       <tr>
         <td class="col bottom">{{$i}}</td>
         <td class="item-name-col bottom">{{$item['item_name']}}</td>
         <td class="col bottom">{{$item['pivot']['batch_no']}}</td>
         
         <td class="col bottom">{{$date}}</td>
         <td class="col bottom">{{$qty}}</td>
         <td class="col bottom">{{$item['pivot']['mrp']}}</td>
         <td class="col bottom">{{'15%'}}</td>
         <td class="col bottom">{{$tp}}</td>
         <td class="col bottom">{{$amount}}</td>
       </tr>
       <?php  $i++;  ?>
       @endforeach

       <tfoot style="border-top: 1px solid black;">
        <tr><td colspan="9"><hr></td></tr>
        <tr >
         <td></td>
         <td style="text-align: center; "><b>Total:</b></td>
         <td></td>
         <td></td>
         
         <th class="col">{{$total_qty}}</th>
         <td></td>
         <td></td>
         <td></td>
         <th class="col">{{$total_amount}}</th>
       </tr>
     </tfoot>

   </table>

   <div style="margin: 20px;">
      <p><b>Remarks:</b></p>
   </div>

   <table class="" style="border-spacing:0px; padding-left: 70px; width: 30%;">
      <tr >
         <th class="" ><img src="{{url('public/images/sehat_qcm.jpeg')}}" align="center" alt=" " height="70" width="70"></th>
      </tr>
      <tr >
         <th class="sign"><span >Verified By Quality Control Manager</span></th>
      </tr>
   </table>


        </main>


        
    </body>
</html>