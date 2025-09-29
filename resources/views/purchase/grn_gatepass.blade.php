@extends('layout.pdf-master')

    @section('title', $order['doc_no'])
    @section('header-title', 'Goods Received Note')


    @section('header-content')

 <?php 
         $date=date_create($order['doc_date'] );
           $date=date_format($date,"d-M-Y");

           

          ?>
    <div class="od-dt">

    <p><b>GRN No:</b>&nbsp;&nbsp;&nbsp;{{$order['doc_no']}} ({{$order['branch']['name']}})</p>

    <p><b>GRN Date: </b>{{$date}}</p>
   
    <p><b>Vendor: </b>{{$order['vendor']['account']['code'].' '.$order['vendor']['name']}}</p>
    
   

    </div>

    @endsection

    @section('content')

    <table class="item-table " cellspacing="0" style="margin-top: 5px;">

    <thead style="background-color:#03a9f4;">
    <tr>
    <th class="col1">#</th>
    <th class="col1">Cat</th>
    <th class="item-name-th">Item</th>


    <th class="col1">Qty</th>

   
    
    <th class="col1">Weight</th>
    <th class="col1">Feet</th>
    <!-- <th class="col1">M.R.P</th> -->

    <!--  <th class="col1">T.P</th>
    <th class="col1">Disc Type</th>
    <th class="col1">Disc</th>
    <th class="col1">Disc Value</th> -->

   
    </tr>
    </thead>
    <?php  $i=1; $total_qty=0; $total_amount=0;
    $items=$order['items'];


    ?>
    @foreach($items as $item)

    <?php  
   

    $qty=$item['pivot']['qty'];
    $weight=$qty* $item['pivot']['unit_weight'];
    $feet=$qty* $item['pivot']['unit_feet'];

   
    ?>
    <tr>
    <td class="col">{{$i}}</td>
    <td class="col">{{$item['category_name']}}</td>
    <td class="item-name-col">{{$item['item_code'].' '.$item['item_name']}}</td>


    <td class="col ">{{number_format($qty,2)}}</td>


   
    

    <td class="col ">{{number_format($weight,2)}}</td>
    <td class="col ">{{number_format($feet,2)}}</td>

    {{--<!-- <td class="col ">{{$item['mrp']}}</td> -->

    <!-- <td class="col ">{{$item['tp']}}</td> -->

    <!-- <td class="col ">{{$disc_type}}</td>
    <td class="col ">{{$item['discount_factor']}}</td>
    <td class="col ">{{$item['discounted_value']}}</td> -->--}}

    

    </tr>
    <?php  $i++;  ?>
    @endforeach

        <?php     ?>
    <tfoot style="">
    <!--<tr><td colspan="9"></td></tr>-->
    <tr>
    <td></td>
    <td></td>
    <td style="text-align: center; "><b></b></td>
    <th class="col">{{number_format($order->total_quantity(),2)}}</th>
    
    
    <th class="col" >{{number_format($order->total_weight(),2)}}</th>

    <td></td>
    <!---<td></td>
    <td></td>
    <td></td> -->

   


    </tr>
    </tfoot>

    </table>

    <table class="ctble">
    <tr>
    <td class="">
    <p><b>Remarks:</b>{{$order['remarks']}}</p>
    </td>
    <td >
    <?php
    

    

    ?>
    <table style="width: 100%;margin:10px;text-align: right;" cellpadding="0" cellspacing="5">
   

     <tr><th></th><td></td></tr>
      <tr><th></th><td></td></tr>
    <tr><th></th><td></td></tr>

   

   

    <!--<tr><td colspan="2"><hr></td></tr>-->
    <tr>
    <th></th>
    <td></td>
    </tr>
    </table>
    </td>
    </tr>
    </table>

    @include('layout.general-sign-box')
    
    @endsection







