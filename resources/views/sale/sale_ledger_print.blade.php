<html>
    <head>
        <title>{{'Sale Ledger'}}</title>
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
                margin-top: 5cm;
                margin-left: 0.3cm;
                margin-right: 0.3cm;
                margin-bottom: 2cm;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 11px;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 5cm;

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


                    .top-heading-name{ font-size: 12px; text-transform: uppercase; }

                    .top-heading-address{ text-align: center; }

                    .top-heading{ 
                        font-size: 14px;
                        text-transform: uppercase;
                        color: white;
                        padding-left: 15px;
                        font-weight: bolder;
                         }

                   
             
                    .page_num:after { content: counter(page); }

            .pages:after { content:  counter(pages); }

            .item-table{
             
            width: 100%;
             }

           .col{
             
            padding: 3px;
            text-align: left;
             }

             .bottom{
                border-bottom: 1px dotted black;
             }

             .col1{
             
            padding: 4px;
            text-align: left;
            color: white;
             }

             .item-name-th{

             	width: 25% ;
             	text-align: left;
                padding-left: 7%;
                color: white;
             }

             .item-name-col{

             	width: 25% ;
             	text-align: left;
             }

             .sign{
              
              border-top: 1px solid black !important;
              
              padding : 10px ;

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
                <p class="top-heading-address">{{$address}}</p>
            </td>
            <td align="center" style="width: 33%">
              
            </td>
            <td align="right"  style="width: 33%;">

               <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="180">
                
            </td>
        </tr>

        <tr  style="background-color: #03a9f4;"><td colspan="3"><p class="top-heading">SALE LADGER</p></td></tr>
         
        <tr class="">
            <?php
                $from=''; $to='';
                  if($config['from']!='')
                   { $from=date_create($config['from'] );
                     $from=date_format($from,"d-M-Y");
                 }

                    if($config['to']!='')
                   {
                    $to=date_create($config['to'] );
                     $to=date_format($to,"d-M-Y");
                 }
            ?>
            <td align="" style="width: 34%;">
               
                 
                <p><b>From:</b>&nbsp;&nbsp;&nbsp;{{$from}}</p>
            </td>
            
            <td align="" style="width: 33%">
                <p><b>To:</b>&nbsp;&nbsp;&nbsp;{{$to}}</p>
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
        $y =  $pdf->get_height() - 70;
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
            <div><p><span style="margin-left:60px;"><!-- {{date('d-M-Y')}} --></span><span style="margin-left:60px;"><!-- {{date('H:i:s A')}} --></span></p></div>
    </div>
    <div style="height:30px;background-color: #03a9f4;"></div>
  </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main style="width: 100%;">
            <table class="item-table " cellspacing="0" style="margin-top: 5px;">

     <thead style="background-color:#03a9f4;">
        <tr>
            <th class="col1">#</th>
             <th class="col1">Doc No</th>
             <th class="col1">Doc Date</th> 
            <th class="col1">Item</th>
        
            <th class="item-name-th">Customer</th>
            
            
             <th class="col1">MRP</th> 
             <th class="col1">TP</th>
            <th class="col1">Qty</th>
            <th class="col1">Batch No</th>
            <th class="col1">Rate</th>
            <th class="col1">Total</th>
            
            
        </tr>
        </thead>
        <?php  $i=1; $net_total_qty=0; $net_total_amount=0;
    
          ?>
     @foreach($sales as $item)

     <?php 
                   $rate=$item->rate();
                   $qty=$item->total_qty();
                  $total= $rate * $qty;

                    $net_total_qty+=$qty; $net_total_amount+=$total;
                   ?>

     
        <tr>
         <td class="col bottom">{{$i}}</td>
         <td class="col bottom">{{$item['sale']['invoice_no']}}</td>
          <td class="col bottom">{{$item['sale']['invoice_date']}}</td>
          <td class="col bottom">{{$item['item']['item_name']}}</td>

         <td class="item-name-col bottom">{{$item['sale']['customer']['name']}}</td>
         
          
         <td class="col bottom">{{$item['mrp']}}</td> 
         <td class="col bottom">{{$item->tp()}}</td>
         <td class="col bottom">{{$qty}}</td>
         <td class="col bottom">{{$item['batch_no']}}</td>
         <td class="col bottom">{{$rate}}</td>
         <td class="col bottom">{{$total}}</td>
         
         
       </tr> 
       

       <?php  $i++;   ?>
       @endforeach

       

       <tfoot style="border-top: 1px solid black;">
        <tr><td colspan="11"><hr></td></tr>
        <tr >
         <td></td>
         <td></td>
         <td ></td>
         
         
          <td></td>
          <td></td>
          <td></td>  
           <td></td>
         <th class="col">{{$net_total_qty}}</th>
         <td></td>  
           <td></td>
         <th class="col">{{$net_total_amount}}</th>
         
       </tr>
     </tfoot>

   </table>
  


   <!-- <table class="" style="border-spacing:50px; width: 100%;">
      <tr >
         <th class="sign"><span>Prepared & Checked By</span></th>
         <th class="sign"><span >Verified By</span></th>
         <th class="sign"><span >Received By</span></th>
         <th class="sign"><span>Approved By</span></th>
      </tr>
   </table> -->


        </main>


        
    </body>
</html>