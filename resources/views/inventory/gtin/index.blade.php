
@extends('layout.master')
@section('title', 'GTIN List')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">GTIN No</h1>
          
            
            <a class="btn" href="{{url('gtin/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">GTIN</a></li>
              <li class="breadcrumb-item active">List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          

         <div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">Process Parameters</h3>
              
              </div>
 -->              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

            

                     
                  

          

                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  
                    <tr>
                    <th>#</th>
                    
                    <th>GTIN No</th>
                    <th>Product</th>
                  
                   <th>Remarks</th>
                  
                    <th>Status</th>
                    <th>Action</th>
                  </tr>


                  </thead>
                  <tbody>
                  
   
                        
                    <?php $i=1; ?>
                    @foreach($gtins as $acc)
                    <tr>
                     <td>{{$i}}</td>
                     
                     <td>{{$acc['gtin_no']}}</td>
                    <td>@if($acc['product']!=''){{$acc['product']['item_name']}}@endif</td>
                    
                    <td>{{$acc['remarks']}}</td>
                 
                    <td>
                      @if($acc['product']!='')
                      <span class="badge badge-success">Allocated</span>
                      @else
                      <span class="badge badge-warning">Available</span>
                      @endif
                    </td>
                    
                      <td><a href="{{url('edit/gtin/'.$acc['id'])}}"><span class="fa fa-edit"></span></a></td>
                      </tr>
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
  