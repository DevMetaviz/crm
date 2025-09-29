<html>
    <head>
        <title>{{$sale['doc_no']}}</title>
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

                    .top-heading{ font-size: 18px; }

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
                border-bottom: 1px solid black;
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
                <p class="top-heading"><strong>QUOTATION</strong></p>
                <!-- <P class="top-heading"><strong>GATE PASS</strong></P> -->
            </td>
            <td align="right"  style="width: 33%;">
              
               <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="140">
                
            </td>
        </tr>

        <tr><td colspan="3"><hr></td></tr>
         
        <tr class="">

            <td align=""  style="width: 50%;">

                 <?php 
         $date=date_create($sale['doc_date'] );
           $date=date_format($date,"d-M-Y");
          ?>

               <table class="challan-detail">
                <tr><th>Doc No:</th><td>{{$sale['doc_no']}}</td></tr>
                <tr><th>Date:</th><td>{{$date}}</td></tr>
                 <tr><th>Customer:</th><td>{{$sale['customer']['name']}}</td></tr>
                 <tr><th>Mobile:</th><td>{{$sale['customer']['mobile']}}</td></tr>
                 <tr><th>Address:</th><td>{{$sale['customer']['address']}}</td></tr>
               </table>
                
            </td>

            <td align="" style="width: 25%;">
               
            
            </td>
            <td align="" style="width: 25%">
                
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
            <th class="col1">#</th>
            <th class="item-name-th">Item</th>
         

            <th class="col1">Qty</th>
            <!-- <th class="col1">M.R.P</th> -->
            
           <!--  <th class="col1">T.P</th>
            <th class="col1">Disc Type</th>
            <th class="col1">Disc</th>
            <th class="col1">Disc Value</th> -->
            <th class="col1">Rate</th>
            <th class="col1">Amount</th>
            
            
        </tr>
        </thead>
        <?php  $i=1; $total_qty=0; $total=0;
           $items=$sale['items'];
          ?>
     @foreach($items as $item)
     
       <tr>
         <td class="col bottom">{{$i}}</td>
         <td class="item-name-col bottom">{{$item['item_name']}}</td>
         
         <td class="col bottom">{{$item['total_qty']}}</td>
         <!-- <td class="col bottom">{{$item['mrp']}}</td> -->
         
         
         <?php $disc_type='%'; 
                if($item['discount_type']=='flat')
                $disc_type='flat';
              ?>
         <!-- <td class="col bottom">{{$disc_type}}</td>
         <td class="col bottom">{{$item['discount_factor']}}</td>
         <td class="col bottom">{{$item['discounted_value']}}</td> -->
         <td class="col bottom">{{$item['rate']}}</td>
         <td class="col bottom">{{$item['total']}}</td>
         
         
       </tr>
       <?php  $i++; $total=$total + $item['total'];  ?>
       @endforeach

       <tfoot >
        
        <tr >
         <td></td>
         <td style="text-align: center; "><b>Total:</b></td>
         <th class="col">{{$sale['total_net_qty']}}</th>
         <!-- <td></td> -->
         
        <!--  <td></td>
         <td></td>
         <td></td>
         <td></td> -->
         <th class="col"></th>
         <th class="col">{{$total}}</th>
        
       </tr>
     </tfoot>

   </table>
   <div>
    
     <?php   $gst= ($sale['gst'] /100) * $total;  ?>
    <table style="float: right;margin:15px;width: 40%" cellpadding="0" cellspacing="5">
            <tr><th>Gst Amount:</th><td>{{$gst}}</td></tr>
            <?php   $total=$total + $gst;   ?>
            @foreach($sale['expenses'] as $ex)
            <tr><th>{{$ex['name'].':'}}</th><td>{{$ex['pivot']['amount']}}</td></tr>
            <?php   $total=$total + $ex['pivot']['amount'];   ?>
            @endforeach
            <tr><th>Total Amount:</th><td>{{$total}}</td></tr>

            <?php $bal=$sale['customer']['account']->closing_balance('');
                             
                             //if($bal<0)
                              //$bal=0;
                          $total=$total + $bal ;
            ?>
    
             <tr><th>Previous Balance:</th><td>{{$bal}}</td></tr>

             <tr><th>Total Balance:</th><td>{{$total}}</td></tr>
             
         </table>
   </div>
 
  <div style="margin: 20px;">
    <b>Remarks:</b>
      <pre style="font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: black;">{{$sale['remarks']}}</pre>
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