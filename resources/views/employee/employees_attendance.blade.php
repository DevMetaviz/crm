
@extends('layout.master')
@section('title', 'Employee Attendance')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Employee Attendance</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employees</a></li>
              <li class="breadcrumb-item active">Attendance</li>
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
                <h3 class="card-title">Employees Attendance</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <form role="form" method="get" action="{{url('employee/search-attendance')}}">
                  

                <label>From</label>
                <input type="date" name="from_date" value="@if($from_date){{$from_date}}@endif">

                <label>To</label>
                <input type="date" name="to_date" value="@if($to_date){{$to_date}}@endif">

                <input type="submit" name="" value="Search">


                  </form>

                
                   @foreach($attendances as $att)
                   @endforeach
                <table id="example1" class="table table-bordered table-hover" style="">
                  
                  <thead>
                  <tr>
                    <th>ZK Id</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                  </tr>



                  </thead>
                  <tbody>
                  
                  @foreach($attendances as $att)
                  <!--  <tr class='clickable-row'  data-href="./employee/+{{$att['id']}}" > -->
                    <tr>
                   
                  
                    <td>{{$att['name']}}</td>
                    
                    <td>
                      @if($att['employee']!=null)
                    {{$att['employee']['name']}}
                    @endif
                  </td>
                   
                    
                    <td>{{$att['date']}}</td>
                    <td>{{$att['time']}}</td>
                    <td>{{$att['status']}}</td>
                   
                  </tr>
                  @endforeach
                  
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







@endsection  
  