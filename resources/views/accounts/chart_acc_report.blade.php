<html>
    <head>
        <title>{{'Chart Of Accounts'}}</title>
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
                  CHART OF ACCOUNTS
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
                    <th>A/C Code</th>
                    <th>Main Account</th>
                    <th>Sub Account</th>
                    <th>Sub Sub Account</th>
                    <th>Detail Account</th>
                  </tr>
                 </thead>
                   <tbody>
                   @foreach($main_accounts as $main)
                   <tr class="text-success">
                     <td>{{$main['code']}}</td>
                     <td>{{$main['name']}}</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     </tr>

                       @foreach($main->sub_accounts as $sub)
                          <tr class="text-info">
                     <td>{{$sub['code']}}</td>
                     <td></td>
                     <td>{{$sub['name']}}</td>
                     <td></td>
                     <td></td>
                     </tr>

                        @foreach($sub->sub_sub_accounts as $sub_sub)

                        <tr class="text-danger">
                     <td>{{$sub_sub['code']}}</td>
                     <td></td>
                     <td></td>
                     <td>{{$sub_sub['name']}}</td>
                     <td></td>
                     </tr>

                        @foreach($sub_sub->detail_accounts as $detail)

                        <tr>
                     <td>{{$detail['code']}}</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td>{{$detail['name']}}</td>
                     </tr>
                        @endforeach


                        @endforeach

                        @endforeach
                   @endforeach

                   </tbody>

                   </table>
   


   


        </main>

        
    </body>
</html>