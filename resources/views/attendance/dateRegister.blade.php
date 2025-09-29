@extends('attendance.register')
@section('title', $attendance_date.' | Attendance')
@section('attendance_date', $attendance_date)
@section('date-register-errors')

<h3 class="card-title mr-1"><span class="fa fa-stop text-info" style=""></span>{{$attendance_in_errors}}</h3>
<h3 class="card-title mr-1"><span class="fa fa-stop text-warning" style=""></span>{{$attendance_out_errors}}</h3>
<h3 class="card-title mr-1"><span class="fa fa-stop text-danger" style=""></span>{{$attendance_errors}}</h3>
 

  <span data-toggle="tooltip" data-placement="bottom" title="Out but not in!" class="badge badge-info">{{$attendance_in_errors}}</span>
  <span data-toggle="tooltip" data-placement="bottom" title="In but not out!" class="badge badge-warning">{{$attendance_out_errors}}</span>
  <span data-toggle="tooltip" data-placement="bottom" title="Dupplication in In-time or Out-time!" class="badge badge-danger">{{$attendance_errors}}</span>

@endsection
@section('date-register')
<tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                    <th>Action</th>
                  </tr>

                  @if(isset($employees))
                    @foreach($employees as $emp)
                      
                        <tr>
                   
                     <td>{{$emp['id']}}</td>
                     <td>{{$emp['name']}}</td>
                     <td>{{$emp['status']}}</td>
                    <td>
                      @if(count($emp['in'])>1)
                          @foreach($emp['in'] as $i)
                          <span class="bg-danger">{{$i}}</span>
                          <br>
                          @endforeach
                      @else
                       @foreach($emp['in'] as $i)
                        {{$i}}
                      @endforeach
                      @endif

                      @if(count($emp['out'])>0 && count($emp['in'])==0)
                      <span class="fa fa-stop text-info" style=""></span>
                      @endif
                      
                    </td>
                    <td>
                      @if(count($emp['out'])>1)
                          @foreach($emp['out'] as $i)
                          <span class="bg-danger">{{$i}}</span>
                          <br>
                          @endforeach
                      @else
                       @foreach($emp['out'] as $i)
                        {{$i}}
                      @endforeach
                      @endif

                      @if(count($emp['in'])>0 && count($emp['out'])==0)
                      <span class="fa fa-stop text-warning" style=""></span>
                      @endif
                    </td>

                    <td>
                        <a href="{{url('/edit/employee/attendance/'.$emp['id'].'/'.$attendance_date)}}"><span class="fa fa-edit"></span></a>
                    </td>
                    
                    
                   
                    
                 
                   
                  </tr>

                    @endforeach
                  @endif
@endsection

  

@section('jquery-code')

<script type="text/javascript">

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

</script>

@endsection 