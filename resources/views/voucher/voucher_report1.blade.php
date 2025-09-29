<html>
    <head>
        <title>{{$voucher['voucher_no']}}</title>
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

        <tr  style="background-color: #03a9f4;"><td colspan="3"><p class="top-heading">{{$voucher['voucher_type']['name']}}</p></td></tr>
         
        <tr class="">
            <td align="" style="width: 34%;">
               
                 
                <p><b>Voucher No:</b>&nbsp;&nbsp;&nbsp;{{$voucher['voucher_no']}}</p>
            </td>
            <?php
                    $date=date_create($voucher['voucher_date'] );
                     $date=date_format($date,"d-M-Y");
            ?>
            <td align="" style="width: 33%">
                <p><b>Voucher Date:</b>&nbsp;&nbsp;&nbsp;{{$date}}</p>
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
            <!-- <th class="col1">Head</th> -->
            <th class="col1">Title</th>
            <!-- <th class="col1">Code</th> -->
            <th class="item-name-th">Description</th>
            
            
             <!-- <th class="col1">Cheque No</th> 
             <th class="col1">Cheque Date</th>  -->
            <th class="col1">Debit</th>
            <th class="col1">Credit</th>
            
            
        </tr>
        </thead>
        <?php  $i=1; $net_debit=0; $net_credit=0;
           $items=$voucher['accounts'];
          ?>
     @foreach($items->where('pivot.debit','!=','0') as $item)
     
        <tr>
         <td class="col bottom">{{$i}}</td>
        <!--  <td class="col bottom">{{$item['super_account']['name']}}</td> -->
         <td class="col bottom">{{$item['name']}}</td>
        <!--  <td class="col bottom">{{$item['code']}}</td> -->
         <td class="item-name-col bottom">{{$item['pivot']['remarks']}}</td>
         
          
          <!-- <td class="col bottom">{{$item['pivot']['cheque_no']}}</td> 
         <td class="col bottom">{{$item['pivot']['cheque_date']}}</td>  -->
         <td class="col bottom">{{number_format($item['pivot']['debit'])}}</td>
         <td class="col bottom">{{number_format($item['pivot']['credit'])}}</td>
         
         
       </tr> 
       

       <?php  $i++; $net_debit+=$item['pivot']['debit']; $net_credit+=$item['pivot']['credit'];  ?>
       @endforeach

       @foreach($items->where('pivot.credit','!=','0') as $item)
     
        <tr>
         <td class="col bottom">{{$i}}</td>
        <!--  <td class="col bottom">{{$item['super_account']['name']}}</td> -->
         <td class="col bottom">{{$item['name']}}</td>
         <!-- <td class="col bottom">{{$item['code']}}</td> -->
         <td class="item-name-col bottom">{{$item['pivot']['remarks']}}</td>
         <!--  <td class="col bottom">{{$item['pivot']['cheque_no']}}</td> 
          <td class="col bottom">{{$item['pivot']['cheque_date']}}</td>  -->
         <td class="col bottom">{{number_format($item['pivot']['debit'])}}</td>
         <td class="col bottom">{{number_format($item['pivot']['credit'])}}</td>
       </tr> 
       

       <?php  $i++; $net_debit+=$item['pivot']['debit']; $net_credit+=$item['pivot']['credit'];  ?>
       @endforeach

       <tfoot style="border-top: 1px solid black;">
        <tr><td colspan="5"><hr></td></tr>
        <tr >
         <td></td>
         <!-- <td></td> -->
         <td style="text-align: center; "><b>Total:</b></td>
         
         
         <!-- <td></td>-->
         <!-- <td></td>
          <td></td>  -->
           <td></td>
         <th class="col">{{number_format($net_debit,2)}}</th>
         <th class="col">{{number_format($net_credit,2)}}</th>
         
       </tr>
     </tfoot>

   </table>
   <?php $words= numberTowords($net_debit); ?>
    <div style="margin: 20px;">
      <p><b>Amount in words : </b>{{$words}}</p>
   </div> 


   <table class="" style="border-spacing:50px; width: 100%;">
      <tr >
         <th class="sign"><span>Prepared & Checked By</span></th>
         <th class="sign"><span >Verified By</span></th>
         <th class="sign"><span >Received By</span></th>
         <th class="sign"><span>Approved By</span></th>
      </tr>
   </table>


        </main>


<?php
// Create a function for converting the amount in words
function numberTowords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
  $here_digits = array('', 'Hundred','Thousand','Lac', 'Crore');
  while( $x < $count_length ) {
       $get_divider = ($x == 2) ? 10 : 100;
       $amount = floor($num % $get_divider);
       $num = floor($num / $get_divider);
       $x += $get_divider == 10 ? 1 : 2;
       if ($amount) {
         $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
         $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
         $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
         '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
         '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
         }else $string[] = null;
       }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}
 
?>
        
    </body>
</html>