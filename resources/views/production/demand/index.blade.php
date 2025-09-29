
@extends('layout.master')
@section('title', 'Demands History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Demand History</h1>
            
          <a class="btn" href="{{url('/production-demand')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Demand</a></li>
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
                <h3 class="card-title">Demand List</h3>
              
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
              
                    <th>Demand No</th>
                    <th>Demand Date</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $demands) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$demands[$i]['id']}}</td>
                     <td>{{$demands[$i]['doc_no']}}</td>
                     <td>{{$demands[$i]['doc_date']}}</td>
                     <td>{{$demands[$i]['product']['item_name']}}</td>
                    <td>{{$demands[$i]['qty']}}</td>
                         <td>{{$demands[$i]['remarks']}}</td>


                     <?php $s=$demands[$i]->status();
                            
                             ?>
                     <td>@if($s=='Pending')<span class="badge badge-warning">{{$s}}</span>@endif</td>
                   
                    <td><a href="{{url('edit/production-demand/'.$demands[$i]['id'])}}"><span class="fa fa-edit"></span></a></td>
                     
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
  