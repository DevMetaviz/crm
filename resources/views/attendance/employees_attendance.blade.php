
@extends('layout.master')
@section('title', 'Employees Attendance')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Employee Daily Attendance</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Attendance</a></li>
              <li class="breadcrumb-item active">Employee Daily Attendance</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">Attendance</h3>
                 <button form="attendances_form" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
               <div class="card-tools">

                

                  <div class="btn-group">
                    <button type="button" class="btn btn-info btn-tool btn-sm dropdown-toggle" data-toggle="dropdown" >
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="{{url('/mark/leave')}}" class="dropdown-item">Mark Leave</a>
                      <a href="{{url('/leaves')}}" class="dropdown-item">Leaves</a>
                      <div class="dropdown-divider"></div>
                      <a href="{{url('employee/attendance/register-search')}}" class="dropdown-item">Employee Wise Attendance</a>
                    </div>
                  </div>

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                    <form role="form" method="get" action="{{url('employees/attendance/')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Select</legend>
                     <label>Date</label>
                     <input type="date" name="attendance_date" value="@if(isset($config)){{$config['attendance_date']}}@endif" />
                    <input type="submit" name="" value="Load Employees">

                 </fieldset>
                 </form>

                 
                @if(isset($config))
                <table id="example1" class="table table-bordered table-hover " style="">
                  
                  <thead>
                  <tr>             
                    <th>Name</th>
                  
                     <th>Attendance Status</th>
                     <th>C/In</th>
                     <th>C/Out</th>
                   </tr>
                 </thead>
                  <tbody>
                  <form role="form" id="attendances_form" method="post" action="{{url('save-daily-attendances')}}">
                    <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                    <input type="hidden" value="{{$config['attendance_date']}}" name="attendance_date"/>
                  @foreach($employees as $emp)
                 
                  <input type="hidden" value="{{ $emp['employee_id'] }}" name="emp_ids[]"/>
                  <tr>
                  <td style="padding:0px;"><input type="text" style="width: 100%;height: 100%;border: none;display:inline-block;position: relative;" name="" value="{{ $emp['employee_name'] }}"></td>
                  <td style="padding:0px;">
                    <select id="{{$emp['employee_id'].'_status'}}" name="statuses[]" style="width: 100%;height: 100%;border: none;display:inline-block;position: relative;">
                      <option value="none" selected>--select status--</option>
                      @foreach($config['statuses'] as $status)
                      <option value="{{$status['id']}}">{{$status['text']}}</option>
                      @endforeach
                      
                    </select>
                    
                  </td>
                  <td style="padding:0px;"><input type="time" style="width: 100%;height: 100%;border: none;display:inline-block;position: relative;" name="in_times[]" value="{{ $emp['in_time'] }}"></td>
                  <td style="padding:0px;"><input type="time" style="width: 100%;height: 100%;border: none;display:inline-block;position: relative;" name="out_times[]" value="{{ $emp['out_time'] }}"></td>
                
               
                   </tr>
                  @endforeach
                  
                  </form>
                  
                  </tbody>
                  <tfoot>
                  <tr>             
                    <th>Name</th>
                  
                     <th>Attendance Status</th>
                     <th>C/In</th>
                     <th>C/Out</th>
                   </tr>
                  </tfoot>
                </table>
                @endif

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')




<script type="text/javascript">

$(document).ready(function(){

@if(isset($employees))
 var employees=<?php echo json_encode($employees); ?> ;



for (var i = 0 ; i < employees.length ; i++) {
    
    value1=employees[i]['status']
    id=employees[i]['employee_id']
   
   if(value1!="")
   {
    
 
    $('#'+id+'_status').find('option[value="'+value1+'"]').attr("selected", "selected");
   
   }

  }

  @endif  


})


</script>


@endsection  
  