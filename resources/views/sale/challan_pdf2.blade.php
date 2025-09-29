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

              /*margin-left: 120px;*/
              
              /*padding : 10px ;*/

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
                <p class="top-heading"><strong>DELIVERY CHALLAN</strong></p>
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
                <p><b>DC NO:</b>&nbsp;&nbsp;&nbsp;{{$challan['doc_no']}}</p>
            </td>
            <td align="" style="width: 33%">
                
            </td>
            <td align=""  style="width: 33%;">

                <?php 
         $challan_date=date_create($challan['challan_date'] );
           $challan_date=date_format($challan_date,"d-M-Y");
           
           $po_date='';
           if(isset($challan['order'])&&$challan['order']['po_date'] !='')
           {
           $po_date=date_create($challan['order']['po_date'] );
           $po_date=date_format($po_date,"d-M-Y");
           }
          
          ?>

               <table class="challan-detail">
                <tr><th>DC Date:</th><td>{{$challan_date}}</td></tr>
                 <tr><th>PO NO #:</th><td>@if(isset($challan['order'])){{$challan['order']['po_no']}}@endif</td></tr>
                 <tr><th>PO Date:</th><td>{{$po_date}}</td></tr>
                 <tr><th>Mobile:</th><td>{{$challan['customer']['mobile']}}</td></tr>
               </table>
                
            </td>
        </tr>

        <tr style="border-spacing: 0;">
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
        </tr>

        

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
                <p style="text-align: justify;"><center><span>"FORM 2A"</span><br><span>(See Rules 19 and 30)</span><br></center>Warranty under section 23(1)(i)of the Drugs Act.1976 I,Muhammad Shahid as QCM of Fahmir Pharma PVT LTD.26km-Lahore-Jaranwa.Road,Main-Stop Mandianwala.Tehsil Sharaqpur,District Sheikhupura , under name of Prolife.Fahmir Pharma pvt ltd, do hereby give this warranty on the strength of warranty given to us by manufacturer/   supplier that the drugs herein described as sold  by us specified and contained in the  Invoice describining.the goods referred herein do not contravene in any way the provision of Section 23 of the Drugs Act 1976</p>
            </div>
            <div style="height:15px;background-color: #03a9f4;"></div>
    <div>
        <!-- <p>Page <span class="page_num"></span> of <span class="pages"></span> -->
            <div><p><span style="margin-left:60px;"></span><span style="margin-left:60px;"></span></p></div>
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
            <th class="col1">M.R.P</th>
            <th class="col1">Exp Date</th>
            <th class="col1">Qty</th>
        </tr>
        </thead>
        <?php  $i=1; $total=0;  ?>
     @foreach($challan['items'] as $item)
     <?php 

     $date='';
     if($item['pivot']['expiry_date'] !='')
     {
         $date=date_create($item['pivot']['expiry_date'] );

           $date=date_format($date,"M-Y");
           }
         
         $pack_qty=$item['pack_size_qty'];
          if($pack_qty=='')
            $pack_qty=1;

           $qty=$item['pivot']['qty'] * $item['pivot']['pack_size'] *$pack_qty ;
           $total += $qty;

           $category='';
              if($item['category']!='')
                $category=$item['category']['name'];
          ?>
       <tr style="">
         <td class="col">{{$i}}</td>
         <td class="item-name-col">{{$item['item_name']}}</td>
         <td class="col">{{$item['pivot']['batch_no']}}</td>
         <td class="col">{{$item['pivot']['mrp']}}</td>
         <td class="col">{{$date}}</td>
         <td class="col">{{$qty.' '.$category}}</td>
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
         <th class="col">{{$total}}</th>
       </tr>
     </tfoot>

   </table>

   <div style="margin: 20px;">
      <p><b>Remarks:</b> {{$challan['remarks']}}</p>
   </div>
<!-- style="border: 1px solid black;" -->
   <table class="" style="border-spacing: 50px; ;width: 100%;">
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
         <th class="sign"><span>Prepared & Checked By</span></th>
         <th class="sign"><span >Verified By</span></th>
         <th class="sign"><span >Received By</span></th>
         <th class="sign"><span>Approved By</span></th>
      </tr> 
   </table>

       <img style="float: right;" src="{{url('public/images/fahmir_stamp.png')}}" align="center" alt=" " width="200" >

        </main>


        
    </body>
</html>