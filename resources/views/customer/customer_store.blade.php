
@extends('layout.master')
@section('title', 'Customer Store')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Customer Store</h1>

            <?php 

            $f=''; $t=''; $id="";

            if(isset($from))
              $f=$from;

            if(isset($to))
              $t=$to;

            if(isset($customer))
              $id=$customer['id'];


             ?>

            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" style="border: none;background-color: transparent;" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      @if($id!='')
                      <li><a href="{{url('print/customer/store/stock?customer_id='.$id.'&from='.$f.'&to='.$t)}}" class="dropdown-item">Print</a></li>
                      @endif
                    </ul>
                  </div>

            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
              <li class="breadcrumb-item active">Customer Store</li>
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
                 
                    <form role="form" id="item_history_form" method="get" action="{{url('customer/store/stock')}}">
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

                  @if(isset($products))
                <table id="example1" class="table table-bordered table-hover " style="">
                  
                  <thead>
                    
                  <tr>             
                    <th>#</th>
                    <!-- <th>Item Code</th> -->
                    <th>Item name</th>
                    <th>Opening</th>
                    <th>Opening Value</th>
                    <th>Dispatch Qty</th>
                    <th>Dispatch Value</th>
                    <th>Sale Qty</th>
                    <th>Sale Value</th>
                     <th>Return/Transfer Qty</th>
                     <th>Return Value</th>
                    <!-- <th>Balance</th> -->
                    <th>Closing Stock</th>
                    <th>Closing Value</th>
                  </tr>
                 </thead>
                  <tbody>
                  <?php $i=1; ?>
                  @foreach($products as $record)
                 
                  
                  <tr>
                  
                   <td>{{$i}}</td>
                   <!-- <td>{{$record['item_code']}}</td> -->
                   <td>{{$record['item_name']}}</td>
                   <td>{{$record['opening']}}</td>
                   <td>{{$record['opening_value']}}</td>
                   <td>{{$record['purchase']}}</td>
                   <td>{{$record['purchase_amount']}}</td>
                   <td>{{$record['sale']}}</td>
                   <td>{{$record['sale_amount']}}</td>
                    <td>{{$record['return']}}</td>
                    <td>{{$record['return_amount']}}</td>
                   <!-- <td>{{$record['current']}}</td> -->
                   <td>{{$record['closing']}}</td>
                   <td>{{$record['closing_value']}}</td>
               
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
  