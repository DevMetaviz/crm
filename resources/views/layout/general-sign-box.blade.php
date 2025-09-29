  <table class="sign-box" style="">

    <tr >
    <th class=""><span>@if($order['user']){{$order['user']['name']}}@endif</span></th>
    <th class=""><span ></span></th>
    <th class=""><span ></span></th>
    <th class=""><span>{{Auth::user()->name}}</span></th>
    </tr>
    <tr >
    <th class="sign"><span>Prepared By</span></th>
    <th class="sign"><span >Verified By</span></th>
    <th class="sign"><span>Approved By</span></th>
    <th class="sign"><span>Printed By</span></th>
    </tr>
    </table>