<html>
    <head>
        <title>{{$order['doc_no']}}</title>
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
                margin-top: 6.4cm;
                margin-left: 0.3cm;
                margin-right: 0.3cm;
                margin-bottom: 2cm;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                 padding: 15px;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 6.4cm;

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


                    .top-heading-name{  text-transform: uppercase;}

                    
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
                  /*font-size: 9px;*/
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
               <table width="100%" style="padding: 30px;" cellspacing="0">
        <tr>
            <td align="" style="width: 40%;">
               
                 <h2 class="top-heading-name" style="margin: none;">{{$name}}</h2>
                 
                  <p style="margin: none;padding: 0px;"><strong><i>{{$tag_line}}</i></strong><br><strong>Head Office: </strong>{{$head_office}}
                 <br><strong>Factory : </strong>{{$address}}<br>{{'Phone: '.$phone.',Mobile No: '.$mobile}}</p>

            </td>
            <td align="center" style="width: 30%;vertical-align: top;">
                <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" >
            </td>
            <td align="right"  style="width: 30%;vertical-align: top;">

               <h2>SALES ORDER</h2>
                
            </td>
        </tr>

        <tr>
          <td>
             <p><b>ORDER NO: {{$order['doc_no']}}</b></p>
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
          <tr class="">

            <td align=""  style="width: 20%;padding-right: 20px;">

                 <b>CUSTOMER:<br>
                 {{$order['customer']['name']}}<br>
                 {{$order['customer']['contact']}}<br></b>
                  {{$order['customer']['address']}}<br>
                  Mobile:{{$order['customer']['mobile']}}<br>
                  Phone:{{$order['customer']['phone']}}<br>
                  Email:{{$order['customer']['email']}}<br>
                      
            </td>

            
           
            <td align="" style="width: 20%;padding-right: 20px;">
                              
                 <b>DELIVER TO:<br>
                    @if($order['dispatch_to_id']!='' || $order['dispatch_to_id']!=0)
                 {{$order['dispatch_to']['name']}}<br>
                 {{$order['dispatch_to']['contact']}}<br></b>
                  {{$order['dispatch_to']['address']}}<br>
                  Mobile:{{$order['dispatch_to']['mobile']}}<br>
                  Phone:{{$order['dispatch_to']['phone']}}<br>
                  Email:{{$order['dispatch_to']['email']}}<br>
                 @endif
            </td>
        </tr>

      </table>

            <table class="item-table " cellspacing="0" style="margin-top: 5px;">

     <thead style="background-color:#03a9f4;color: white;">
        <tr>
            <th class="col1">Sr No.</th>
            
            <th class="item-name-th">PRODUCT NAME</th>
            <th class="col1">ORDERED QTY</th>
            
          
          
           

        </tr>
        </thead>
        <?php  $i=1; $total_qty=0;   ?>
     @foreach($order['items'] as $item)
     <?php 
            $qty=$item['pivot']['qty'] * $item['pivot']['pack_size'] ;
           $total_qty += $qty;

          ?>
       <tr>
         <td class="col">{{$i}}</td>
         
         <td class="item-name-col">{{$item['item_name']}}</td>
        
         <td class="col">{{$qty}}</td>

       </tr>
       <?php  $i++;  ?>
       @endforeach

       <tfoot style="border-top: 1px solid black;">
        <tr >
         <td></td>
         <td></td>
        
         
         <th class="col">{{$total_qty}}</th>
        
       
       </tr>
     </tfoot>

   </table>
  


   <div style="margin: 20px;">
      <p><b>Remarks:</b></p>
      <p>{{$order['remarks']}}</p>
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


        
    </body>
</html>