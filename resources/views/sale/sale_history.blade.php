
@extends('layout.master')
@section('title', 'Sale History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Sale List</h1>
            <a class="btn" href="{{url('sale/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
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
              <div class="card-header">
                <h3 class="card-title">Sales</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               

                

              <div class="table-responsive p-0" style="height: 400px;">
                <table id="example1" class="table table-bordered table-hover mt-4 table-head-fixed " style="">
                  
                  <thead>
                  
                <tr>
                    <th>Id</th>
                    <th>Invoice No</th>
                    <th>Invoice Date</th>
                    <th>Delivery No</th>
                    <th>Delivery Date</th>
                    <th>Customer</th>
                    <th>Total Qty</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Action</th>
                  </tr>


                  </thead>
                  <tbody>
                  
                 

                  
               <?php $i=1; ?>
                    @foreach($sales as $sale)
                      
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                     <td><a href="{{url('edit/sale/'.$sale['id'])}}">{{$sale['doc_no']}}</a></td>
                     <td>{{$sale['doc_date']}}</td>
                     <td>@if(isset($sale['challan'])){{$sale['challan']['doc_no']}}@endif </td>
                     <td>@if(isset($sale['challan'])){{$sale['challan']['doc_date']}}@endif</td>
                    <td>{{$sale['customer']['name']}}</td>
                     <td>{{$sale->total_quantity()}}</td>
                     <td>{{$sale->total_amount}}</td>
                    <td>
                       @if($sale['status']==0)
                       <span class="badge badge-warning">Unpost</span>
                       @elseif($sale['status']==1)
                          <span class="badge badge-success">Post</span>
                       @endif
                     </td>

                     <td>@if($sale['user']){{$sale['user']['name']}}@endif</td>
                    
                     <td>
                      <a href="{{url('edit/sale/'.$sale['id'])}}"><span class="fa fa-edit"></span></a>


                           @if(!isset($sale['return']))
                          <span class="dropdown">
                          <button class="btn btn-default btn-sm dropdown-toggle" type="button"  data-toggle="dropdown">Action
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                          <li role="presentation"><a role="menuitem" href="{{url('sale/return?sale='.$sale['id'])}}">Return</a></li>
                          </ul>
                          </span>
                          @endif 

                    </td>
                   
                    
                 
                   
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

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')







@endsection  
  