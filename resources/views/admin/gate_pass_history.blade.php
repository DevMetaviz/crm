
@extends('layout.master')
@section('title', 'Gate Pass List')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Gate Pass History</h1>
            <a class="btn" href="{{url('gate-pass/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Gate Pass</a></li>
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
                <h3 class="card-title">Gate Passes</h3>
              
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
                    <th>Sr No</th>
                    <th>Pass No</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Time Out</th>
                    <th>Time in</th>
                    <th>Remarks</th>
                    
                    <th></th>
                  </tr>

                  <?php $i=1; ?>
            
                    @foreach($passes as $pass)

                   
                      
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                     <td>{{$pass['doc_no']}}</td>
                     <td>{{$pass['doc_date']}}</td>
                     <td>{{$pass['name']}}</td>
                     <td>{{$pass['time_out']}}</td>
                     <td>{{$pass['time_in']}}</td>
                     <td>{{$pass['remarks']}}</td>
                   
                    <td><a href="{{url('/edit/gate-pass/'.$pass['id'])}}"><span class="fa fa-edit"></span></a></td>
                     
                    </tr>
                   <!--  <tr><td colspan="8"></td></tr> -->
                      <?php $i++; ?>
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
  