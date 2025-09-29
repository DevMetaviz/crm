
@extends('layout.master')
@section('title', 'Purchase Orders History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Purchase Orders History</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/purchase/order')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Purchase Orders</a></li>
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
                <h3 class="card-title">Purchase Orders</h3>
              
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
                    <th>#</th>
                    <th>PO No</th>
                    <th>PO Date</th>
                    <th>Due Date</th>
                    <th>Vendor</th>
                    <th>Booking</th>
                   <!--- <th>Demand Doc No</th>
                    <th>Demand Date</th>-->
                    <th>Qty</th>
                    <th>Weight</th>
                    <th>Amount</th>
                    <!--<th>PO Type</th>
                    <th>Received Date</th>
                    <th>Dispatched Status</th>-->
                    
                    <th>Status</th>
                     <th>Created By</th>
                    <th>Action</th>
                  </tr>

                  
                   <?php $i=1; ?>
                    @foreach($orders as $order)

                   <?php 
                           $qty=$order->total_quantity();
                           $weight=$order->total_weight();
                           $total=$order->total_amount();
                   ?>
                      
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                     <td>{{$order['doc_no']}}</td>
                     <td>{{$order['doc_date']}}</td>
                     <td>{{$order['due_date']}}</td>
                    <td>@if(isset($order['vendor'])){{$order['vendor']['name']}}@endif</td>
                    <td>@if(isset($order['booking'])){{$order['booking']['doc_no']}}@endif</td>
                    <!-- <td>{{$order['demand_doc_no']}}</td>
                      <td>{{$order['demand_date']}}</td>-->
                     <td>{{number_format($qty,2)}}</td>
                      <td>{{number_format($weight,2)}}</td>
                      <td>{{number_format($total,2)}}</td>
                      <!---<td>{{$order['po_type']}}</td>
                     <td>{{$order['received_date']}}</td>
                      <td>{{$order['dispatched_status']}}</td>-->
                     
                     <td>
                     
                        @if(isset($order['grn']))
                         <span class="badge badge-success">Received</span>
                         @else
                         <span class="badge badge-info">Pending</span>
                         @endif
                      
                     </td>

                      <td>@if($order['user']){{$order['user']['name']}}@endif</td>
                   
                    <td>

                      @if($order['status']==1 && !isset($order['grn']))
                        <a class="btn btn-info btn-sm" href="{{url('purchase/goods-receiving-note?order='.$order['id'])}}" >Receiving</a>
                      @endif

                      <a href="{{url('edit/purchase/order/'.$order['doc_no'])}}"><span class="fa fa-edit"></span></a>
                    </td>
                     
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
  