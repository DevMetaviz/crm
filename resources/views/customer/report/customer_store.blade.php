<html>
    <head>
        <title>{{$customer['name']}}</title>
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

                    .top-heading{ font-size: 14px; }

                    .top-heading-name{ font-size: 12px; text-transform: uppercase;}

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
             }

             .col1{
             
            padding: 3px 4px;
            text-align: center;
             }

             .item-name-th{

             	width: 25% ;
             	text-align: left;
                padding-left: 7%;
             }

             .item-name-col{

             	width: 25% ;
             	text-align: left;
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
                <p class="top-heading"><strong>SALES & STOCK REPORT</strong></p>
                <!-- <P class="top-heading"><strong>GATE PASS</strong></P> -->
            </td>
            <td align="right"  style="width: 33%;">

               <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="180">
                
            </td>
        </tr>

        <tr><td colspan="3"><hr></td></tr>

        <?php 
         $from=date_create($from );
           $from=date_format($from,"d-M-Y");

            $to=date_create($to );
           $to=date_format($to,"d-M-Y");

          ?>
         
        <tr class="">
            <td align="" style="width: 34%;">
               
                 <p><b>Customer:</b> {{$customer['name']}}</p>
                <p><b>From:</b>&nbsp;&nbsp;&nbsp;{{$from}}&nbsp;&nbsp;&nbsp;<b>To:</b>&nbsp;&nbsp;&nbsp;{{$to}}</p>
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
            <th class="col1">Opening</th>
            <th class="col1">Dispatch Qty</th>
            <th class="col1">Sale Qty</th>
            <th class="col1">Sale Value</th>
            <th class="col1">Return/Transfer Qty</th>
            <th class="col1">Closing Stock</th>
            <th class="col1">Closing Stock Value</th>
        </tr>
        </thead>
        <?php  $i=1; $total=0;  ?>
     @foreach($products as $item)
     <?php 
         $date=date_create($from );
           $date=date_format($date,"m-Y");

           
           $total += 0;
          ?>
       <tr>
         <td class="col">{{$i}}</td>
         <td class="item-name-col">{{$item['item_name']}}</td>
         <td class="col">{{$item['opening']}}</td>
         <td class="col">{{$item['purchase']}}</td>
         <td class="col">{{$item['sale']}}</td>
         <td class="col">{{$item['sale_amount']}}</td>
         <td class="col">{{$item['return']}}</td>
         <td class="col">{{$item['closing']}}</td>
        <td class="col">{{$item['closing_value']}}</td>
       
         
       </tr>
       <?php  $i++;  ?>
       @endforeach

       <tfoot style="border-top: 1px solid black;">
        <tr >
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
          <td></td>
         <td></td>
         <td></td>
         <th class="col">{{$total}}</th>
       </tr>
     </tfoot>

   </table>

  


        </main>


        
    </body>
</html>