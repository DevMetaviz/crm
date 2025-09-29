
@extends('layout.master')
@section('title', 'Production Standard History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Production Standard History</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/finish-goods-production-standard')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Production Standard</a></li>
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
                <h3 class="card-title">Finish Goods Production Standards</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               

                

               <div class="table-responsive">
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>Id</th>
                    <th>Std No</th>
                    <th>Std Name</th>
                   
                    <th>Product</th>
                    <th>Batch Size</th>
                    <th>Active</th>
                    <th>Remarks</th>
                    
                    <th></th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $stds) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$stds[$i]['id']}}</td>
                     <td>{{$stds[$i]['std_no']}}</td>
                     <td>{{$stds[$i]['std_name']}}</td>
                    
                     <td>{{$stds[$i]['master_article']['item_name']}}</td>
                      <td>{{$stds[$i]['batch_size']}}</td>
                     <td>{{$stds[$i]['activeness']}}</td>
                      <td>{{$stds[$i]['remarks']}}</td>
                    
                   
                    <td><a href="{{url('finish-goods-production-standard/edit/'.$stds[$i]['std_no'])}}"><span class="fa fa-edit"></span></a></td>
                     
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


              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')







@endsection  
  