<html>
    <head>

        <?php
                 $code='';$account='';$city=''; $account_id=''; $detail=''; $from=''; $to='';

                if(isset($config['account']))
                  $account_id=$config['account']['id'];

                  if(isset($config['account']['customer']))
                  $city='';

                  if(isset($config['account']['semi_customer']))
                  $city='';

                  if(isset($config['account']['vendor']))
                  $city='';


                  if(isset($config['account']))
                  $account=$config['account']['name'];

                   if(isset($config['account']))
                  $code=$config['account']['code'];

                if(isset($config['detail']))
                  $detail=$config['detail'];

                if(isset($config['from']))
                  $from=$config['from'];

                if(isset($config['to']))
                  $to=$config['to'];
             ?>


        <title>{{$account}}</title>
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
                font-size: 11px;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 6cm;

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


                    .top-heading-name{ font-size: 12px;text-transform: uppercase; }

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
                border-bottom: 1px solid black;
             }

             .col1{
            padding: 4px;
            text-align: left;
            color: white;
             }

             .col-wt-1{
              width: 5%;
             }

             .col-wt-2{
              width: 15%;
             }

             .col-wt-3{
              width: 10%;
             }


             .center_txt{
                text-align: center;
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
    </table>

    <table width="100%" style="padding: 10px;" cellspacing="0">

        <tr  style="background-color: #03a9f4;"><td colspan="3"><p class="top-heading">LEDGER REPORT</p></td></tr>
         
        <tr class="">
            <td align="" style="width: 50%;">
               
                 
                <p style="" ><b>{{$account}}</b>&nbsp;&nbsp;&nbsp;{{$code}}</p>
            </td>
            <?php
                    if($from!='')
                    {
                    $from=date_create($from );
                     $from=date_format($from,"d-M-Y");
                     }
                     
                     if($to!='')
                    {
                     $to=date_create($to );
                     $to=date_format($to,"d-M-Y");
                     }
            ?>
            <td align="" style="width: 25%;">
                <p><b>From:</b>&nbsp;&nbsp;&nbsp;{{$from}}</p>
            </td>
            <td align=""  style="width: 25%;">
                 <p><b>To:</b>&nbsp;&nbsp;&nbsp;{{$to}}</p>
                               
            </td>
        </tr>

        <tr class="">
            <td align="" style="width: 50%;">
               
                 
                <p><b>City:</b>&nbsp;&nbsp;&nbsp;{{$city}}</p>
            </td>
            
            <td align="" style="width: 25%">
                <p><b>Opening:</b>&nbsp;&nbsp;&nbsp;{{number_format($ledger['opening'], 2)}}</p>
            </td>
            <td align=""  style="width: 25%;">
                 
                               
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
            <div><!-- <p><span style="margin-left:60px;">{{date('d-M-Y')}}</span><span style="margin-left:60px;">{{date('H:i:s A')}}</span></p> --></div>
    </div>
    <div style="height:30px;background-color: #03a9f4;"></div>
  </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main style="width: 100%;">
            <table class="item-table " cellspacing="0" style="margin-top: 5px;">

     <thead style="background-color:#03a9f4;">
        <tr>
            <th class="col1 col-wt-1">#</th>
            
            <th class="col1 col-wt-2">Date</th>
            <th class="col1 col-wt-2">Voucher No</th>
            <th class="item-name-th">Description</th>
            
            
            <th class="col1 col-wt-3">Cheque No</th>
            <th class="col1 col-wt-3">Debit</th>
            <th class="col1 col-wt-3">Credit</th>
            <th class="col1 col-wt-3">Balance</th>
            
        </tr>
        </thead>
        
          <?php $i=1; $open=$ledger['opening'];
             $net_debit=0; $net_credit=0;
                   ?>

     @foreach($ledger['transections'] as $item)
     <?php 
                          $open += $item['debit'] - $item['credit'] ;

                            $date='';
                           if($item['date']!='')
                  {
                        $d=explode('-', $item['date']);
                         // $date=date_create($record['date'] );
                          $date=date("d-M-Y",mktime(0,0,0,$d[1],$d[2],$d[0]));
                 }
                   ?>
     
        <tr>
         <td class="col bottom">{{$i}}</td>
    
         <td class="col bottom">{{$date}}</td>
         <td class="col bottom">{{$item['voucher_no']}}</td>
         <td class="item-name-col bottom">{{$item['remarks']}}</td>
         
          
         <td class="col bottom">{{$item['cheque_no']}}</td>
         <td class="col bottom">{{number_format($item['debit'], 2)}}</td>
         <td class="col bottom">{{number_format($item['credit'], 2)}}</td>
         <td class="col bottom">{{number_format($open, 2)}}</td>
         
         
       </tr> 
       

       <?php  $i++; $net_debit+=$item['debit']; $net_credit+=$item['credit'];  ?>
       @endforeach

       <tfoot style="border-top: 1px solid black;">
        <!-- <tr><td colspan="8"><hr></td></tr> -->
        <tr >
         <td></td>
         <!-- <td></td> -->
         <td style="text-align: center; "><b>Total:</b></td>
         
         
         <td></td>
         <td></td>
          <td></td>
           
         <th class="col">{{number_format($net_debit, 2)}}</th>
         <th class="col">{{number_format($net_credit, 2)}}</th>
          <td></td>
       </tr>
     </tfoot>

   </table>
   <?php //$words= numberTowords($ledger['closing']); ?>
    <div style="margin: 20px;">
     <!--  <p><b>Amount in words : </b></p> -->
   </div> 


   <table class="" style="border-spacing:50px; width: 100%;">
      <tr >
         <th class="sign"><span>Prepared & Checked By</span></th>
         <th class="sign"><span >Verified By</span></th>
         <!-- <th class="sign"><span >Received By</span></th> -->
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
  $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
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