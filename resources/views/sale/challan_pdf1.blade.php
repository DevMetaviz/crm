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
                margin-top: 7.7cm;
                margin-left: 42px;
                margin-right: 42px;
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
                height: 7.7cm;
                 
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


                    .top-heading-name{ text-transform: uppercase;padding: none;margin: none;}

                    
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
             .from , .to{
                
                border:1px solid black;
                 width: 33%;
               
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

             .table-boarder1 tbody td{
              

                border-bottom: 1px solid black;
            

             }

             .table-boarder td,.table-boarder th{
               border-left: 1px solid black;

                border-bottom: 1px solid black;
                padding: 5px;

             }

             .table-boarder th{
              

                border-top: 1px solid black;

             }

             .table-boarder td:last-child,.table-boarder th:last-child{
               border-right: 1px solid black;

             }


             .table-boarder {
             
               border-spacing: none;
              
             }

             
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
               <table width="100%" style="padding: 45px;" cellspacing="0">
        <tr>
            <td align="" style="width: 40%;padding-right: 15px; ;margin: none;">
               
                 <h2 class="top-heading-name"><strong>{{$name}}</strong></h2>
                 <p style="padding: none;margin: none;"><strong><i>{{$tag_line}}</i></strong></p>
                 <p style="padding: none;margin: none;"><strong>Head Office: </strong>{{$head_office}}</p>
                <p style="margin: none;"><strong>Factory: </strong>{{$address}}</p>

                <p style="margin: none;">{{'Phone: '.$phone.',Mobile No: '.$mobile}}</p>

            </td>
            <td align="center" style="width: 20%;vertical-align: top;">
                <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" width="70%">
            </td>
            <td align="right"  style="width: 40%;vertical-align: top;">

               <h2 style="padding: none;margin: none;">DELIVERY CHALLAN</h2>
                
            </td>
        </tr>

        <tr >
          <td style="padding-top: 30px;">
            <h4 style="margin: none;padding: none;">ORDER NO: @if($challan['order']!=''){{$challan['order']['doc_no']}}@endif</h4>
             <h4 style="margin: none;">DC NO: {{$challan['doc_no']}}</h4>
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
        
        <table style="width: 100%;">
          <tr class="" style="vertical-align: top;">

            <td align="" class="challan-detail"  style="width: 50%;padding-right: 50px;">

             
              <?php
              
                $deliver='';

                if(isset($challan['order']['dispatch_to']))
                $deliver=$challan['order']['dispatch_to'];
                else
                $deliver=$challan['customer'];
               
               ?>

                <p><strong style="text-transform: uppercase;">deliver to:<br>{{$deliver['name']}}
                <br>@if($deliver!=''){{$deliver['contact']}}@endif</strong>
                <br>{{$deliver['address']}}
                <br><strong>Phone: </strong>{{$deliver['phone']}}
                <br><strong>Mobile: </strong>{{$deliver['mobile']}}
                <br><strong>Email: </strong>{{$deliver['email']}}
              </p>

                 
               

                
            </td>

            
           
            <td align="" class="challan-detail" style="width: 50%;padding-right: 50px;">

            
               
            </td>
        </tr>

      </table>

      <table class="table-boarder" style="width: 100%;" cellspacing="none" cellpadding="none">

          <tr>
            <th>S.O DATE</th>
            <th>D.C DATE</th>
            <th>DELIVER THROUGH</th>
            <th>BILTY NO.</th>
            <th>B.PAID/UNPAID</th>
          </tr>

          <?php 
         $date=date_create($challan['doc_date'] );
           $date=date_format($date,"d-M-Y");
          
          $date1='';
          if($challan['order']!='')
          {
            $date1=date_create($challan['order']['doc_date'] );
           $date1=date_format($date1,"d-M-Y");
         }

          ?>

          <tr>
             <td>{{$date1}}</td>
             <td>{{$date}}</td>
             <td>@if($challan['deliver_via']!=''){{$challan['delivered_via']['name']}}@endif</td>
             <td>{{$challan['bilty_no']}}</td>
             <td>{{$challan['bilty_type']}}</td>
           </tr>

      </table>

          <table class="item-table table-boarder1" cellspacing="0" style="margin-top: 5px;">

     <thead style="background-color:#03a9f4;">
        <tr>
            <th class="col1">#</th>
            <th class="item-name-th">Item</th>
            <th class="col1">Batch No</th>
            <th class="col1">M.R.P</th>
            <th class="col1">Exp</th>
            <th class="col1">Qty</th>
        </tr>
        </thead>
        <?php  $i=1; $total=0;  ?>
     @foreach($challan['items'] as $item)
     <?php 
         $date=date_create($item['pivot']['expiry_date'] );
           $date=date_format($date,"M-Y");

           $qty=$item['pivot']['qty'] * $item['pivot']['pack_size'] ;
           $total += $qty;
          ?>
       <tr style="">
         <td class="col">{{$i}}</td>
         <td class="item-name-col">{{$item['item_name']}}</td>
         <td class="col">{{$item['pivot']['batch_no']}}</td>
         <td class="col">{{$item['pivot']['mrp']}}</td>
         <td class="col">{{$date}}</td>
         <td class="col">{{$qty}}</td>
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
  <?php 

 
     
   ?>

   <table style="width: 100%;">

      <tr>

        <td style="width: 50%;vertical-align: top; padding-right : 70px;">

          
         <p><strong>Dear Customer / Receiver,</strong>
                <br>Company has send you two copies of D.C. Please sign them and resend one to the company address. This document will ensure us that you have received the goods in good condition. You can also give remarks on bottom of this statment. We are thankful to you for your corporation.
                <br><strong>Remarks: </strong>
                
              </p>
   
            
          </td>

          <td style="width: 30%;">
            
          </td>
          
      </tr>
     
   </table>


   

   

   <table class="" style="border-spacing:50px; width: 100%;">
      <tr >
         <th class="sign"><span>Prepared & Checked By</span></th>
         <th class="sign"><span >Verified By</span></th>
         <th class="sign"><span >Received By</span></th>
         <th class="sign"><span>Approved By</span></th>
      </tr>
   </table>


        </main>


        
    </body>
</html>