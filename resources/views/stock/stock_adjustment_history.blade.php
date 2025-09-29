
@extends('layout.master')
@section('title', 'Stock Adjustment History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Stock Adjustment</h1>
            
            <a class="btn" href="{{url('/stock-adjustment/')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Stock Adjustment</a></li>
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
                <h3 class="card-title">Stock Adjustment</h3>
              
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
                    <th>No.</th>
                    <th>Adjustment No</th>
                    <th>Adjustment Date</th>
                    
                    <th>Remarks</th>
                    <th>Status</th>
                    <th></th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $stocks) ; $i++)

          
                      
                        <tr>
                   
                     <td>{{$i+1}}</td>
                     <td>{{$stocks[$i]['doc_no']}}</td>
                     <td>{{$stocks[$i]['doc_date']}}</td>
                     <td>{{$stocks[$i]['remarks']}}</td>
                    
                                     
                     <td>
                      @if($stocks[$i]['status']==1)
                      <span class="text-success">Active</span>
                      @elseif($stocks[$i]['status']==4)
                      <span class="text-danger">Inactive</span>
                     @endif
                     </td>
                     <th><a href="{{url('stock-adjustment/edit/'.$stocks[$i]['id'])}}"><span class="fa fa-edit"></span></a></th>
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
  