
@extends('layout.master')
@section('title', 'Attendance Register')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Attendance Register</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Attendance</a></li>
              <li class="breadcrumb-item active">Register</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">Attendance Register</h3>
                <a href="#" class="float-sm-right">Employee Wise Attendance</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                   
                   

                   <div class="col-md-12">

                    <form role="form" method="get" action="{{url('employee/attendance/register/')}}">
                  

                <label>Employee</label>
                <select  name="employee" id="employee" style="">
                    <option value="">------Select any value-----</option>
                    
                    @foreach($emps as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                    @endforeach
                  </select>

                <label>To</label>
                <input type="date" name="to_date" value="@if(isset($config['to_date'])){{$config['to_date']}}@endif"/>

                <label>From</label>
                <input type="date" name="from_date" value="@if(isset($config['from_date'])){{$config['from_date']}}@endif"/>

                

                <input type="submit" name="" value="Search">


                  </form>
                     
                   </div>

                </div>
                

                  


              
                <table id="example1" class="table table-bordered table-hover" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>Id</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                  </tr>

                  @if(isset($attendances))
                    @foreach($attendances as $att)
                      
                        <tr>
                   
                     <td></td>
                     <td>{{$att['date']}}</td>
                     <td>{{$att['status']}}</td>
                    <td>{{$att['in']}}</td>
                    <td>{{$att['out']}}</td>
                    
                   
                    
                 
                   
                  </tr>

                    @endforeach
                  @endif
                  
                  </tbody>
                  <tfoot>
                  <tr>
                  
                  </tr>
                  </tfoot>
                </table>


              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script type="text/javascript">
 
 value1="{{$config['emp_id'] }}"
   
   if(value1!="")
   {
    
  $('#employee').find('option[value="{{$config['emp_id']}}"]').attr("selected", "selected");
   
   }



</script>


@endsection  
  