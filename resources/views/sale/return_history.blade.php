
@extends('layout.master')
@section('title', 'Sale Return History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Sale Return List</h1>
            <a class="btn" href="{{url('sale/return')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
              <li class="breadcrumb-item active">Return List</li>
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
                <h3 class="card-title">Sale Returns</h3>
              
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
                    <th>Return No</th>
                    <th>Return Date</th>
                    <th>Invoice No</th>
                    <th>Invoice Date</th>
                    <th>Customer</th>
                    <th>Total Qty</th>
                    <th>Status</th>
                    <th></th>
                  </tr>

                  
            
                    @foreach($sales as $sale)
                      
                        <tr>
                   
                     
                     <td>{{$sale['id']}}</td>
                     <td>{{$sale['doc_no']}}</td>
                     <td>{{$sale['doc_date']}}</td>
                     <td>@if($sale['sale']){{$sale['sale']['invoice_no']}}@endif</td>
                     <td>@if($sale['sale']){{$sale['sale']['invoice_date']}}@endif</td>
                    <td>{{$sale['customer']['name']}}</td>
                     <td></td>
                     <?php $active='Unpost';
                            if($sale['status']=='1')
                             $active='Post';
                             ?>
                     <td>{{$active}}</td>
                    
                     <td><a href="{{url('edit/sale/return/'.$sale['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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
  