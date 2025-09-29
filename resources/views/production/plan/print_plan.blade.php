<html>
    <head>
        <title>{{$plan['plan_no']}}</title>
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
                font-size: 10px;
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
              
              padding : 10px ;

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
                <p class="top-heading-address">{{$address}}</p>

            </td>
            <td align="center" style="width: 33%">
                
            </td>
            <td align="right"  style="width: 33%;">

               <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="180">
                
            </td>
        </tr>

        <tr style="background-color:#03a9f4;color: white;"><td style="padding: 10px;" class="top-heading" colspan="3"><strong>PRODUCTION PLAN</strong></td></tr>
         
        <tr class="">

            <td align=""  style="width: 50%;">
             <?php 
         $d_date=date_create($plan['plan_date'] );
           $d_date=date_format($d_date,"d-M-Y");


          ?>
               <table class="challan-detail" style="width: 80%;">
                 <tr><th>Plan No:</th><td>{{$plan['plan_no']}}</td></tr>
                 <tr><th>Plan Date:</th><td>{{$d_date}}</td></tr>
                 <tr><th>Demand No:</th><td>@if($plan['demand']!=''){{$plan['demand']['doc_no']}}@endif</td></tr>
                 <tr><th>Batch No:</th><td>{{$plan['batch_no']}}</td></tr>
                

               </table>
                
            </td>

            
            <td align="" style="width: 40%">
               <?php $uom='';
                 if(isset($plan['product']['unit']['name']))
                    $uom=$plan['product']['unit']['name'];
                ?>
                <table class="challan-detail" style="width: 80%;">
                 <tr><th>Product:</th><td>{{$plan['product']['item_name']}}</td></tr>
                 <tr><th>Pack Size:</th><td>{{$plan['product']['pack_size']}}</td></tr>
                 <tr><th>Quantity:</th><td>{{$plan['batch_qty'].' '.$uom}}</td></tr>
                 <tr><th>Batch Size:</th><td>{{$plan['batch_size']}}</td></tr>
               </table>
                
            </td>
            <td align="" style="width: 10%;">
               <table class="challan-detail" style="width: 80%;">
                <?php 
                      $aq=0;
                      if($plan->transfer_note!='')
                $aq=$plan->transfer_note->actual_qty();
                     
                     $cl=0;
                     if($plan['batch_no']!='')
                     $cl=$plan['product']->closing_stock(['batch_no'=>$plan['batch_no']]);                     
                 ?>
                <tr><th>Transfered:</th><td>{{$aq}}</td></tr>
                <tr><th>Closing:</th><td>{{$cl}}</td></tr>
               </table>
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

     <thead style="background-color:#03a9f4;color: white;">
        <tr>
            <th class="col1">Sr No.</th>
        
            <th class="item-name-th">Item</th>
            <th class="col1">UOM</th>
            

            <th class="col1">Quantity</th>
            <th class="col1">Issued Quantity</th>
            
        </tr>
        </thead>
        <?php  $i=1; $net_total=0;
              
              $s=json_encode($plan['issued_items']);
          ?>
     
      @foreach($plan['items'] as $item)

      <?php   
              $total=$item['pivot']['qty'] * $item['pivot']['pack_size']; 
            $net_total=$total+$net_total; 

              $uom='';
              if(isset($item['unit']['name']))
              $uom=$item['unit']['name'];
          ?>

       <tr>
         <td class="col">{{$i}}</td>
         
         <td class="item-name-col">{{$item['item_name']}}</td>
         <td class="col">{{$uom}}</td>
         <td class="col">{{$total}}</td>
         <td class="col"></td>


       </tr>
        <?php $i++; ?>
        @endforeach

       <tfoot style="border-top: 1px solid black;">
        <tr >
         <td></td>
      
         <td></td>
         <td></td>
         <th class="col">{{$net_total}}</th>
         <th></th>
       </tr>
     </tfoot>

   </table>

   <div style="margin: 20px;">
      <p><b>Remarks:</b></p>
      <p>{{$plan['remarks']}}</p>
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


        
    </body>
</html>