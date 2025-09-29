<html>
    <head>
        <title>{{'TRAIL BALANCE'}}</title>
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
                        font-size: 12px;
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
            text-align: center;
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
                  TRAIL BALANCE
            </td>
            <td align="right"  style="width: 33%;">

               <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="180">
                
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
            
            <table class="table">

                  <thead>
                    <tr style="background-color: #03a9f4;padding: 15px 5px;color: white;" class="top-heading">
                      <th style="width: 15%;"></th>
                      <th></th>
                      <!-- <th></th> -->
                      <th colspan="2">Opening Balance</th>
                      <th colspan="2">Transection</th>
                      <th colspan="2">Closing Balance</th>
                    </tr>
                    
                  <tr style="background-color: #03a9f4;padding: 15px 5px;color: white;" class="top-heading">             
                    
                      <th style="width: 15%;">Code</th>
                    <th>Account</th>
                    <!-- <th>Sub A/C</th> -->
                    <th>Opening Debit</th>
                    <th>Opening Credit</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Balance Debit</th>
                    <th>Balance Credit</th>
                  </tr>

                 </thead>
                   <tbody>
                  <?php $i=1; $net_open_debit=0; $net_open_credit=0; $net_debit=0; $net_credit=0; 
                      $net_balance_debit=0; $net_balance_credit=0;
                   ?>
                  @foreach($accounts as $record)
                 
                  <?php 
                   
                      $opening=$record['opening_balance'] ;
                       $closing=$record['closing_balance'] ;  
                       
                       $opening_debit=0; $opening_credit=0;
                       $closing_debit=0; $closing_credit=0;

                         if($opening>0)
                            $opening_debit=$opening;

                          if($opening<0)
                            {$opening_credit=$opening; $opening_credit=$opening_credit* -1;}

                       if($closing>0)
                            $closing_debit=$closing;

                          if($closing<0)
                            { $closing_credit=$closing; $closing_credit=$closing_credit * -1;} 

                          //$current_trail_credit=$record['current_trail_credit'] * -1 ;
                          $current_trail_credit=$record['current_trail_credit']  ;

                        $net_open_debit+=$opening_debit; 
                     $net_open_credit+=$opening_credit;
                     $net_debit+=$record['current_trail_debit']; 
                     $net_credit+=$current_trail_credit;
                    $net_balance_debit+=$closing_debit; 
                      $net_balance_credit+=$closing_credit;

                            ?>
                  <tr>
                  
                   
                  
                   <td>{{$record['code']}}</td>
                   <td style="text-transform: uppercase;">{{$record['name']}}</td>
                    <!-- <td style="text-transform: uppercase;"></td> -->
                    <td>{{$opening_debit}}</td>
                   <td>{{$opening_credit}}</td>
                   <td>{{$record['current_trail_debit']}}</td>
                   <td>{{$current_trail_credit}}</td>
                   <td>{{$closing_debit}}</td>
                   <td>{{$closing_credit}}</td>
                  
                   
               
                   </tr>
                   <?php $i++; ?>
                  @endforeach
                  
                  
                  
                  </tbody>
                  <tfoot>
                     
                     <tr>
                    
                       <th></th>
                       <th></th>
                       <!-- <th></th> -->
                       <th>{{$net_open_debit}}</th>
                       <th>{{$net_open_credit}}</th>
                       <th>{{$net_debit}}</th>
                       <th>{{$net_credit}}</th>
                       <th>{{$net_balance_debit}}</th>
                       <th>{{$net_balance_credit}}</th>
                       
                     </tr>
                  
                  </tfoot>
                   </table>
   


   


        </main>

        
    </body>
</html>