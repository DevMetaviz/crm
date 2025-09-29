
@extends('layout.master')
@section('title', 'Payment History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Payment List</h1>
            <a class="btn" href="{{url('payment/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Payment</a></li>
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
                <h3 class="card-title">Payments</h3>
              
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
                <table id="example1" class="table table-bordered table-hover table-head-fixed text-nowrap">
                  
                  <thead>
                  

                   <tr>
                    <th>#</th>
                    <th>Voucher No</th>
                    <th>Voucher Date</th>
                     <th>Pay Method</th>
                     <th>Cheque No</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th></th>
                  </tr>

                  </thead>
                  <tbody>
                  
                 

                  
                   <?php $i=1;  ?>
                    @foreach($vouchers as $order)
                      
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                     
                     <td><a href="{{url('edit/payment/'.$order['id'])}}">{{$order['voucher_no']}}</a></td>
                    <td>{{$order['voucher_date']}}</td>
                    <td>{{$order['pay_method']}}</td>
                     <?php $let=$order['accounts']->where('pivot.credit','<>','0')->first();  ?>
                    <td>{{$let['pivot']['cheque_no']}}</td>
                     <td>{{$order->amount()}}</td>
                     <td>{{$order['remarks']}}</td>
                   <?php $status='Unpost';
                            if($order['status']=='1')
                             $status='Post';
                             ?>
                     <td>{{$status}}</td>
                    
                     <td><a href="{{url('edit/payment/'.$order['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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
  