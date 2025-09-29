
@extends('layout.master')
@section('title', 'Customer Store Summary')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Customer Store Summary</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Customer</a></li>
              <li class="breadcrumb-item active">Store Summary</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">Store</h3>
                 
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                    <form role="form" id="item_history_form" method="get" action="{{url('customer/store/summary')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    

                  <div class="col-md-6">
                 <div class="dropdown" id="customers_table_customer_dropdown">
        <label>Customer</label>
        <input class="form-control"  name="customer_id" id="customer_id" value="">
      
           </div>
           </div>

           <div class="col-md-2">
                    <div class="form-group">
                  <label>From</label>
                  <input type="date" class="form-control select2"  name="from" id="from" value="@if(isset($from)){{$from}}@endif">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>To</label>
                  <input type="date" class="form-control select2"  name="to" id="to"  value="@if(isset($to)){{$to}}@endif" >
                </div>
              </div>

                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="View">
                     </div>


                    </div>

                 </fieldset>
                 </form>

                  @if(isset($challans))
                <table id="example1" class="table table-bordered table-hover " style="">
                  
                  <thead>
                    
                  <tr>             
                    <th>#</th>
                    <th>Doc No</th>
                    <th>Doc Date</th>
                    <!-- <th>Order No</th>
                    <th>Order Date</th> -->
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th>Remarks</th>
                  </tr>
                 </thead>
                  <tbody>
                  <?php $i=1; ?>
                  @foreach($challans as $record)
                 
                  
                  <tr>
                  
                   <td>{{$i}}</td>
                   <td><a href="{{url($record['link'])}}">{{$record['doc_no']}}</a></td>
                   <td>{{$record['doc_date']}}</td>
                   <!-- <td></td>
                   <td></td> -->
                   <td>{{$record['total_quantity']}}</td>
                   <td>{{$record['total_amount']}}</td>
                   <td>{{$record['item_names']}}</td>
                   <td>{{$record['status']}}</td>
                   <td>{{$record['remarks']}}</td>
                  
               
                   </tr>
                   <?php $i++; ?>
                  @endforeach
                  
                  
                  
                  </tbody>
                  <tfoot>
                    
                  
                  </tfoot>
                </table>
                @endif

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script type="text/javascript">

 function setCustomers(customers)
 {
  
  
  var new_customers=[];
 
 for(var i = 0 ; i < customers.length ; i++)
 {
  

         var let={ mobile:customers[i]['mobile'],customer:customers[i]['name'],id:customers[i]['id'],address:customers[i]['address'] };
         //alert(let);
         new_customers.push(let);
 }


$('#customer_id').inputpicker({
    data:new_customers,
    fields:[
        {name:'customer',text:'Customer'},
        {name:'mobile',text:'Mobile'},
        {name:'address',text:'Address'}
        
    ],
    headShow: true,
    fieldText : 'customer',
    fieldValue: 'id',
  filterOpen: true
    });

 }

$(document).ready(function(){
  
  @if(isset($customers))
   var customers=<?php echo json_encode($customers); ?> ;
   setCustomers(customers);

   @endif

   @if(isset($customer))
   
   var customer=<?php echo json_encode($customer); ?> ;
   $('#customer_id').val(customer['id']);
var s=$("#customers_table_customer_dropdown").find(".inputpicker-input");
   s.val(customer['name']);

   @endif
     
      

  
   
});

 





</script>
@endsection  
  