
@extends('layout.master')
@section('title', 'Dispensing History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Dispensing History</h1>
            
          <a class="btn" href="{{url('/dispensing')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production</a></li>
              <li class="breadcrumb-item active">Dispensing</li>
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
                <h3 class="card-title">Dispensing List</h3>
              
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
              
                    <th>Plan No</th>
                    <th>Product</th>
                     <th>Dispensing Start</th>
                    <th>Dispensing Complete</th>
                    <th>Action</th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $dispenses) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$dispenses[$i]['id']}}</td>
                     <td>{{$dispenses[$i]['plan']['plan_no']}}</td>
                     <td>{{$dispenses[$i]['plan']['product']['item_name']}}</td>
                     <td>{{$dispenses[$i]['dispense_start']}}</td>
                     <td>{{$dispenses[$i]['dispense_comp']}}</td>
                  
                   
                    <td><a href="{{url('edit/dispensing/'.$dispenses[$i]['id'])}}"><span class="fa fa-edit"></span></a></td>
                     
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
  