@extends('attendance.register')
@section('title', $attendance_month.' | Attendance')
@section('attendance_month', $attendance_month)

@section('month-register')

<?php 
$a=explode("-", $attendance_month);
$days=cal_days_in_month(CAL_GREGORIAN,$a[1],$a[0]); ?>
<tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>P/A</th>
                    
                    @for($i=1;$i<=$days;$i++)
                    <?php 
                    $sun=date('l',mktime(0,0,0,$a[1],$i,$a[0]));
                    $s='';
                    if($sun=='Sunday')
                    {
                      $s='Sun';
                    }
                    ?>
                    <th>{{$i}}
                      <br>
                      {{$s}}
                    </th>
                    @endfor
                    
                  </tr>

                  @if(isset($employees))
                    @foreach($employees as $emp)
                      
                        <tr>
                   
                     <td>{{$emp['id']}}</td>
                     <td>{{$emp['name']}}</td>
                     <td>{{$emp['present'].'/'.$emp['absent']}}</td>
                    @foreach($emp['attendances'] as $x=>$x_value)
                    <td>{{$x_value}}</td>
                    @endforeach                    
                   
                    
                 
                   
                  </tr>

                    @endforeach
                  @endif

@endsection