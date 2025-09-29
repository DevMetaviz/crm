    @extends('layout.pdf-master')

    @section('title', $order['doc_no'])
    @section('header-title', 'Purchase Booking')


    @section('header-content')


    <div class="od-dt">

    <p><b>Purchase Booking:</b>&nbsp;&nbsp;&nbsp;{{$order['doc_no']}} ({{$order['branch']['name']}})</p>

    <p><b>Purchase Booking Date: </b>{{$order['doc_date']}}</p>
  
    <p class="name"><b>Vendor: </b>{{$order['vendor']['account']['code'].' '.$order['vendor']['name']}}</p>
    

    </div>

    @endsection

    @section('content')

    <table class="item-table " cellspacing="0" style="margin-top: 5px;">

    <thead style="background-color:#03a9f4;">
    <tr>
    <th class="col1">#</th>
    <th class="item-name-th">Category</th>
    <th class="col1">Disc/Gain %</th>
    <th class="col1">Weight</th>
     <th class="col1">Remarks</th>
    </tr>
    </thead>
    <?php  $i=1; $total=0; 
    $items=$order['categories'];


    ?>
    @foreach($items as $item)

    <?php  
    

    
    $weight= $item['pivot']['weight'];
    $disc= $item['pivot']['discount'];

        $total+=$weight; 
    ?>
    <tr>
    <td class="col">{{$i}}</td>
    <td class="item-name-col">{{$item['name']}}</td>
     <td class="col">{{number_format($disc,2)}}</td>
    

    <td class="col ">{{number_format($weight,2)}}</td>

    <td class="col ">{{$item['remarks']}}</td>

    </tr>
    <?php  $i++;  ?>
    @endforeach

    <tfoot style="">
   
    <tr>
    <td></td>
    <td></td>
    <td></td>
    <th class="col">{{$total}}</th>
    
    <td class="col" ></td>

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
    <!----<table style="width: 100%;margin:10px;text-align: right;" cellpadding="0" cellspacing="5">
   <tr><th>Total Amount:</th><td></td></tr> 
    <tr><td colspan="2"><hr></td></tr>
    <tr>
    <th>Total Amount:</th>
    <td></td>
    </tr>
    </table>----->

    </td>
    </tr>
    </table>

    @include('layout.general-sign-box')
    
    @endsection






