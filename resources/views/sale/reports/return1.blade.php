<html>
    <head>
        <title>{{$return['doc_no']}}</title>
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
                margin-top: 6cm;
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
                height: 6cm;
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

                    .top-heading{ font-size: 20px; }

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
             .item-table td,.item-table th{
             
                border: 1px solid black;
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
               .sign-box{
    border-spacing:50px 0px;
     width: 100%;
     margin-top: 50px;
   }
   .sign-box th{
      padding:5px 0px;
      width: 25%;
   }
             .sign{
              
              border-top: 1px solid black !important;
              
              padding : 15px ;

            }

            .sign span{
                          }
             
             .ctble{
    width: 100%;
    margin: 0px;
}
.ctble td:nth-child(1){
    width: 60%;
}
.ctble td:nth-child(2){
    width: 60%;
}
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
               <table width="100%" style="padding: 10px;" cellspacing="0">
        <tr>
            <td align="" style="width: 34%;">
               
                 <!--<p class="top-heading-name"><strong>{{$name}}</strong></p>
                <p class="top-heading-address"><b>{{$address}}</b></p>-->
            </td>
            <td align="center" style="width: 33%">
                <p class="top-heading"><strong>SALE RETURN</strong></p>
                <!-- <P class="top-heading"><strong>GATE PASS</strong></P> -->
            </td>
            <td align="right"  style="width: 33%;">

               <!---<img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="130">-->
                
            </td>
        </tr>

        <tr><td colspan="3"><hr></td></tr>
         
       {{-- <tr class="">
            <td align="" style="width: 34%;">
               <table class="challan-detail">
                <tr><th>DC NO:</th><td>{{$return['doc_no']}}</td></tr>
                <tr><th>Return Date:</th><td>{{$return['doc_date']}}</td></tr>
                 <tr><th>Customer:</th><td>{{$return['customer']['name']}}</td></tr>
                 <tr><th>Mobile:</th><td>{{$return['customer']['mobile']}}</td></tr>
                 <tr><th>Address:</th><td>{{$return['customer']['address']}}</td></tr>
               </table>

                
            </td>
            <td align="" style="width: 33%">
                
            </td>
            <td align=""  style="width: 33%;">

                               
            </td>
        </tr>--}}

</table>

        <div class="od-dt">

     <p><b>Return No:</b>&nbsp;&nbsp;&nbsp;{{$return['doc_no']}}</p>

    <p><b>Return Date: </b>{{$return['doc_date']}}</p>

@if($return['sale'])
    <p><b>Invoice No:</b>&nbsp;&nbsp;&nbsp;{{$return['sale']['invoice_no']}}</p>

    <p><b>Invoice Date: </b>{{$return['sale']['invoice_date']}}</p>
  @endif
    <p class="name"><b>Customer: </b>{{$return['customer']['account']['code'].' '.$return['customer']['name']}}</p>
   


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
            <th class="col1">Cat</th>
            <th class="item-name-th">Item</th>
         

            <th class="col1">Qty</th>
            <!-- <th class="col1">M.R.P</th> -->
            
           <!--  <th class="col1">T.P</th>-->
            <th class="col1">Price</th>
            <th class="col1">Weight</th>
            <th class="col1">Feet</th>
             <th class="col1">Rack</th>
            <th class="col1">Rack Qty</th>
            <th class="col1">Amount</th>
        </tr>
        </thead>
        <?php  $i=1; $total_qty=0; $total_amount=0;
                
          ?>
     @foreach($return['items'] as $item)
     <?php  
                 

           $amount=$return->item_amount($item['id'],$item['pivot']['id']); 
            $price=$return->rate($item['id'],$item['pivot']['id']); 

            $qty=$item['pivot']['qty'];
            $weight=$qty* $item['pivot']['unit_weight'];
            $feet=$qty* $item['pivot']['unit_feet'];

            $per_pc=$amount / $qty;
          ?>
       <tr>
         <td class="col ">{{$i}}</td>
         <td class="col">{{$item['category_name']}}</td>
         <td class="item-name-col ">{{$item['item_code'].' '.$item['item_name']}}</td>
         
         <td class="col ">{{$qty}}</td>
         <!-- <td class="col ">{{$item['mrp']}}</td> -->
         
         <!-- <td class="col "></td> -->
        
          <td class="col ">{{number_format($price,2)}}</td>
        
         <td class="col">{{number_format($weight,2)}}</td>
         <td class="col">{{number_format($feet,2)}}</td>
         <td class="col ">{{$item['pivot']['rack']}}</td>
         <td class="col ">{{$item['pivot']['rack_qty']}}</td>
         <td class="col ">{{number_format($amount,2)}}</td>
        
       </tr>
       <?php  $i++;  ?>
       @endforeach

       <tfoot style="">
        <!--<tr><td colspan="9"><hr></td></tr>-->
        <tr >
         <td></td>
         <th></th>
         <td style=""><b></b></td>
         <th class="col">{{$return->total_qty()}}</th>
         <!-- <td></td> -->
         
         <td></td>
         <td class="col">{{number_format($return->total_weight(),2)}}</td>
         <td></td>
         
         <th class="col"></th>
          <th class="col"></th>
         <th class="col">{{number_format($return->total_items_amount(),2)}}</th>
                </tr>
     </tfoot>

   </table>
 

   <table class="ctble">
    <tr>
    <td class="">
      <p><b>Remarks:</b>{{$return['remarks']}}</p>
   </td>
   <td >
    <?php
                  $total_amount=$return->total_items_amount();

                  $previous_balance=$return['previous_balance'];

                  $total_balance=$previous_balance-$total_amount;

                ?>
         <table style="width: 100%;margin:10px;text-align: right;" cellpadding="0" cellspacing="5">
            
             <tr><th>Total Amount:</th><td>{{number_format($total_amount,2)}}</td></tr>
             <tr><th>Previous Balance:</th><td>{{number_format($previous_balance,2)}}</td></tr>
             
             <tr><td colspan="2"><hr></td></tr>
             <tr>
                <th>Total Amount:</th>
                <td>{{number_format($total_balance,2)}}</td>
             </tr>
         </table>
   </td>
</tr>
</table>

   <table class="sign-box" style="">

    <tr>
         <th class=""><span>@if($return['user']){{$return['user']['name']}}@endif</span></th>
         <th class=""><span ></span></th>
         <th class=""><span ></span></th>
         <th class=""><span>{{Auth::user()->name}}</span></th>
      </tr>
      <tr >
         <th class="sign"><span>Prepared By</span></th>
         <th class="sign"><span >Verified By</span></th>
         <th class="sign"><span>Approved By</span></th>
         <th class="sign"><span>Printed By</span></th>
      </tr>
   </table>


        </main>


        
    </body>
</html>