
@extends('layout.master')
@section('title', 'Process History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Process History</h1>
            
          <a class="btn" href="{{url('configuration/production/process')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Process</a></li>
              <li class="breadcrumb-item active">History</li>
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
                <h3 class="card-title">Process List</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
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
              
                    <th>Process name</th>
                    <th>Identity</th>
                    <th>Active</th>
                    <th>QC Required</th>
                    <th>No. Of Parameters</th>
                    <th>No. Of Sub-Process</th>
                    <th>Remarks</th>
                    <th>Action</th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $processes) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$processes[$i]['id']}}</td>
                     <td>{{$processes[$i]['process_name']}}</td>
                     <td>{{$processes[$i]['identity']}}</td>
                     <td>{{$processes[$i]['activeness']}}</td>
                    <td>{{$processes[$i]['qc_required']}}</td>
                     <td>{{$processes[$i]['parameters_count']}}</td>
                     <td>{{$processes[$i]['sub_process_count']}}</td>
                     <td>{{$processes[$i]['remarks']}}</td>
                     
                   
                    <td><a href="{{url('configuration/production/process/edit/'.$processes[$i]['id'])}}"><span class="fa fa-edit"></span></a></td>
                     
                    </tr>
                   <!--  <tr><td colspan="8"></td></tr> -->

                    @endfor
                
                  
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
  