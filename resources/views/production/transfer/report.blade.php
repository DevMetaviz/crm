<html>
    <head>
        <title>{{$plan['transfer_note']['id']}}</title>
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
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 4.5cm;
                font-family: times new roman;
                font-size: 14px;
            }

            

            
                    



                 #main_heading{
                    text-transform: uppercase;
                    background-color: grey;
                    color: white;
                    padding: 3px;
                    font-size: 14px;
                 }

                 #yield{
                    text-align: center;
                  border: 1px solid black; 
                    border-spacing: 0px; 
                    margin-top: 30px;
                 }

                 #yield thead {
                
                  border-bottom: 1px solid black; 
                 }

                 #yield thead tr th{
                
                  border-left: 1px solid black; 
                 }

                 #yield tbody{
                
                   
                 }

                 #yield tbody tr td,#yield tfoot tr th{
                  
                  border-left: 1px solid black;
                  height: 40px;
                 }

                .yield-sp{
                
                  border-left: none;
                 }
                 

                  #sign{
                    width: 100%;
                    padding-top: 50px;
                     text-align: center;
                  }

                  #sign tr td{
                    
                    
                  }

                  .pl-col{
                    border-bottom: 1px solid black; 
                    text-align: center;
                  }

                  .pl-col1{
                    
                    width: 13%;
                  }
                

                              
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
       @include('production.granulation.header')

       

      @include('production.granulation.footer')
        
        <!-- Wrap the content of your PDF inside a main tag -->

      


        <main style="width: 100%;">
            
           <center><h3 id="main_heading">FINISHED GOODS TRANSFER NOTE</h3></center>

           <table id="plan_detail" style="width: 100%;">
                <tr>
                    <td class="pl-col1">Product Name:</td>
                    <td class="pl-col">{{$plan['product']['item_name']}}</td>
                    <td class="pl-col1">Batch No:</td>
                    <td  class="pl-col">{{$plan['batch_no']}}</td>
                    
                </tr>

                <tr>
                    <td>Pack Size:</td>
                    <td  class="pl-col">{{$plan['product']['pack_size']}}</td>
                    <td>Batch Size:</td>
                    <td  class="pl-col">{{$plan['batch_size']}}</td>
                </tr>

                <tr>
                    <td>Mfg Date:</td>
                    <td  class="pl-col">{{$plan['mfg_date']}}</td>
                    <td>Exp Date:</td>
                    <td  class="pl-col">{{$plan['exp_date']}}</td>
                </tr>
              
              <tr>
                    <td>MRP:</td>
                    <td  class="pl-col">{{$plan['mrp']}}</td>
                    <td></td>
                    <td></td>
                </tr>

           </table>
        
        
      <table style="width: 100%;" id="yield">
          
          <thead>
          <tr>
            <th style="border-left: none;">Sr No</th>
            <th>Date</th>
            <th>No of outer carton</th>
            <th>Number of Pack one Carton</th>
            <th>Total Number of Pack Transfer </th>
            </tr>
            </thead>
          
          <tbody style="min-height: 500px;">
            <?php $i=1; $total=0; ?>
            @foreach($plan['transfer_note']['yield_items'] as $item)
            <?php $t=$item['qty'] * $item['pack_size']; $total=$total+$t; ?>

            <tr>
                <td style="border-left: none;">{{$i}}</td>
                <td>{{$item['transfer_date']}}</td>
                @if($item['unit']=='loose')
                <td>{{$item['pack_size']}}</td>
                <td>{{$item['qty'].' (Loose)'}}</td>
                @else
                <td>{{$item['qty']}}</td>
                <td>{{$item['pack_size']}}</td>
                @endif
                <td>{{$t}}</td>
            </tr>
             <?php $i++; ?>
            @endforeach
            </tbody>

            <tfoot style="border-top:1px solid black; ">
                <tr>
                    <th style="border-left: none;" colspan="4">Total Quantity:</th>
                    <th>{{$total}}</th>
                </tr>
            </tfoot>

      </table>
           
           <table id="sign">
                <tr>
                    <td></td>
                    <td style="width: 10%">Issued By:</td>
                    <td style="border-bottom: 1px solid black;"></td>
                    <td></td>
                    <td style="width: 12%">Received By:</td>
                    <td style="border-bottom: 1px solid black;"></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td>(Production Manager)</td>
                    <td></td>
                    <td></td>
                    <td>(Store In-Charge)</td>
                    <td></td>
                </tr>
           </table>

        </main>


        
    </body>
</html>