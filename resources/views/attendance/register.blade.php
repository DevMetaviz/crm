
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
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
               <div class="card-tools">

                @yield('date-register-errors')

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

                <div class="row">
                   <div class="col-md-5">

                    <form role="form" method="get" action="{{url('attendance/register/')}}">
                  

                <label>Date</label>
                
                 <input type="date" name="attendance_date" value="@yield('attendance_date')"/>
                

                <input type="submit" name="" value="Search">


                  </form>
                     
                   </div>
                   <div class="col-md-5">

                    <form role="form" method="get" action="{{url('attendance/register/')}}">
                  

                <label>Month</label>
                
                <input type="month" name="attendance_month" value="@yield('attendance_month')"/>

                

                <input type="submit" name="" value="Search">


                  </form>
                     
                   </div>

                </div>
                

                  


              
                <table id="example1" class="table table-bordered table-hover" style="">
                  
                  <thead>

                    @yield('date-register')

                    @yield('month-register')

                

                  



                  </thead>
                  <tbody>
                  
                 
                  
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
  