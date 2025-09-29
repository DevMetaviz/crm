
@extends('layout.master')
@section('title', 'Chart Of Accounts')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Chart Of Accounts</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Accounts</a></li>
              <li class="breadcrumb-item active">Chart Of Accounts</li>
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
                <h3 class="card-title">Chart Of Accounts</h3>
                 
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('chart-of-accounts/report')}}" class="dropdown-item">Print</a></li>
                    </ul>
                  </div>
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                 <table class="table">

                  <thead>
                    
                  <tr>             
                    <th>A/C Code</th>
                    <th>Main Account</th>
                    <th>Sub Account</th>
                    <th>Sub Sub Account</th>
                    <th>Detail Account</th>
                  </tr>
                 </thead>
                   <tbody>
                   @foreach($main_accounts as $main)
                   <tr class="text-success">
                     <td>{{$main['code']}}</td>
                     <td>{{$main['name']}}</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     </tr>

                       @foreach($main->sub_accounts as $sub)
                          <tr class="text-info">
                     <td>{{$sub['code']}}</td>
                     <td></td>
                     <td>{{$sub['name']}}</td>
                     <td></td>
                     <td></td>
                     </tr>

                        @foreach($sub->sub_sub_accounts as $sub_sub)

                        <tr class="text-danger">
                     <td>{{$sub_sub['code']}}</td>
                     <td></td>
                     <td></td>
                     <td>{{$sub_sub['name']}}</td>
                     <td></td>
                     </tr>

                        @foreach($sub_sub->detail_accounts as $detail)

                        <tr>
                     <td>{{$detail['code']}}</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td>{{$detail['name']}}</td>
                     </tr>
                        @endforeach


                        @endforeach

                        @endforeach
                   @endforeach

                   </tbody>

                   </table>
                 
                  

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script type="text/javascript">

 

$(document).ready(function(){
  
  
     
      
     
   
});

 





</script>
@endsection  
  