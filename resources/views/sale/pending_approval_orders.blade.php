
@extends('layout.master')
@section('title', 'Orders List')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Orders List</h1>
            <a class="btn" href="{{url('order/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('order/history?status=1')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Pending Orders</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
              <li class="breadcrumb-item active">Pending Approval Orders</li>
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
                <h3 class="card-title">Pending Approval Orders</h3>
              
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
                <table id="example1" class="table table-bordered table-hover mt-4 table-head-fixed" style="">
                  
                  <thead class="table-primary" >
                  
                  <tr>
                    <th>#</th>
                    <th>Customer Code</th>
                    <th>Customer</th>
                    <th>SO No</th>
                    <th>Order Date</th>
                    <th>Qty</th>
                    <th>Weight</th>
                    <th>Value</th>
                    <th>Closing Balance</th>
                    <th>Credit Limit</th>
                    <th>Remaining Limit</th>
                    <th>Balance Due</th>
                    <th>Status</th>
                     <th>Created By</th>
                    
                    <th>Action</th>
                  </tr>


                  </thead>
                  <tbody>
                  
                 
                  
            <?php $i=1; ?>
                    @foreach($orders as $order)
                      
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                    <td>@if(isset($order['customer'])){{$order['customer']['account']['code']}}@endif</td>
                    <td>{{$order['customer']['name']}}</td>
                    <td><a href="{{url('edit/order/'.$order['id'])}}">{{$order['doc_no']}}</a></td>
                     <td>{{$order['order_date']}}</td>
                     <td>{{$order->total_quantity()}}</td>
                      <td>{{number_format($order->total_weight(),2)}}</td>
                      <td>{{number_format($order->total_amount,2)}}</td>

                      <td>{{number_format($order->previous_balance,2)}}</td>
                      <td>{{number_format($order->credit_limits,2)}}</td>
                       <td>{{number_format($order->remaining_limit,2)}}</td>
                        <td>{{number_format($order->balance_due,2)}}</td>

                     <?php 

                     $st=$order->order_status();
                     $s=$order->order_status_text();

                            
                             ?>
                     <td><?php echo $s; ?></td>

                       <td>@if($order['user']){{$order['user']['name']}}@endif</td>
                     
                    
                     <td>
                    
                   
                       <button class="btn btn-success btn-sm action-btn" data-id="{{ $order->id }}" data-action="1">Approve</button>
                       <button class="btn btn-danger btn-sm action-btn" data-id="{{ $order->id }}" data-action="0">Reject</button>
                      
                      
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


      <!-- Modal -->
<div class="modal fade" id="orderActionModal" tabindex="-1" aria-labelledby="orderActionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderActionLabel">Confirm Action</h5>
        <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
      </div>
      <div class="modal-body">
        <p id="modalMessage"></p>
        <input type="hidden" id="modalOrderId">
        <input type="hidden" id="modalAction">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="confirmActionBtn" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script type="text/javascript">
	$(document).ready(function () {
    // Open modal with correct action
    $(".action-btn").on("click", function () {
        let orderId = $(this).data("id");
        let action = $(this).data("action");

        $("#modalOrderId").val(orderId);
        $("#modalAction").val(action);  

        let message = action == "1"
            ? "Are you sure you want to approve this order?"
            : "Are you sure you want to reject this order?";
        $("#modalMessage").text(message);

        $("#orderActionModal").modal("show");
    });

    // Confirm action
    $("#confirmActionBtn").on("click", function () {
        let orderId = $("#modalOrderId").val();
        let action = $("#modalAction").val();

        let url = "{{url('/orders/update-status')}}" +"/"+ orderId;

        $.ajax({
            url: url,
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status: action
            },
            success: function (response) {
                $("#orderActionModal").modal("hide");
                alert(response['message'] );
                location.reload(); // refresh to see updated status
            },
            error: function (xhr) {
                alert("Something went wrong!");
            }
        });
    });
});

</script>





@endsection  
  