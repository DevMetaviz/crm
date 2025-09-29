
@extends('layout.master')
@section('title', 'Shifts')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Shifts</h1>
            <a class="btn" href="{{url('define/shift')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Shifts</li>
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
                <h3 class="card-title">Shift</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>Id</th>
                    <th>Shift</th>
                    <th>Start Time</th>
                   
                    <th>End Time</th>
                    <th>Action</th>
                  </tr>

            
                    @foreach($shifts as $shift)
                      
                        <tr>
                   
                     
                     <td>{{$shift['id']}}</td>
                     <td>{{$shift['shift_name']}}</td>
                    <td>{{$shift['start_time']}}</td>
                
                
                    <td>{{$shift['end_time']}}</td>
                     
                   <td><a href="{{url('/edit/shift/'.$shift['id'])}}"><span class="fa fa-edit"></span></a></td>
                    
                 
                   
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
  