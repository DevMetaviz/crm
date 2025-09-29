
@extends('layout.master')
@section('title', 'Pending Orders')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Orders List</h1>
            <a class="btn" href="{{url('order/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('order/history')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
              <li class="breadcrumb-item active">Orders</li>
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
                <h3 class="card-title">Orders</h3>
              
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
                <table id="example1" class="table table-bordered table-hover mt-4 table-head-fixed text-nowrap" style="">
                  
                  <thead>
                  
                  <tr>
                    <th>Id</th>
                    <th>Doc No</th>
                    <th>Order Date</th>
                    <th>Customer</th>
                    <th>Total Qty</th>
                    <th>Total Weight</th>
                    <th>Status</th>
                    <th>Active</th>
                    <th></th>
                  </tr>


                  </thead>
                  <tbody>
                  
                 
                  
            <?php $i=1; ?>
                    @foreach($orders as $order)
                      
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                     <td><a href="{{url('edit/order/'.$order['id'])}}">{{$order['doc_no']}}</a></td>
                     <td>{{$order['order_date']}}</td>
                    <td>{{$order['customer']['name']}}</td>
                     <td>{{$order->total_quantity()}}</td>
                      <td>{{$order->total_weight()}}</td>

                     <?php $s=$order->order_status();
                            
                             ?>
                     <td>@if($s=='Pending')<span class="badge badge-warning">{{$s}}</span>@endif</td>

                     <?php $active='Active';
                            if($order['activeness']=='0')
                             $active='Inactive';
                             ?>
                     <td>{{$active}}</td>
                    
                     <td>

                      <a class="btn btn-info btn-sm" href="{{url('/delivery-challan/create?order='.$order['id'])}}">Deliver</a>
                      <a href="{{url('edit/order/'.$order['id'])}}"><span class="fa fa-edit"></span></a>
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
  