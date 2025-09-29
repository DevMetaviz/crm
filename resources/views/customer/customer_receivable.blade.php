
@extends('layout.master')
@section('title', 'Customer Receivable')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Customer Receivable</h1>

            <?php 

            $f=''; $t=''; $id=""; $d='';

            if(isset($from))
              $f=$from;

            if(isset($to))
              $t=$to;

            if(isset($customer))
              $id=$customer['id'];

            if(isset($detail))
                  $d=$detail;


             ?>

            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" style="border: none;background-color: transparent;" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      @if($id!='')
                      <li><a href="{{url('print/customer/receivable?customer_id='.$id.'&from='.$f.'&to='.$t.'&detail='.$d)}}" class="dropdown-item">Print</a></li>
                      @endif
                    </ul>
                  </div>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Customer</a></li>
              <li class="breadcrumb-item active">Receivable</li>
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
                 
                    <form role="form" id="item_history_form" method="get" action="{{url('customer/receivable')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    

                  <div class="col-md-5">
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

              <div class="col-md-1">
                      <br>
                    <div class="custom-control custom-checkbox">
                          <input class="custom-control-input custom-control-input-info custom-control-input-outline" type="checkbox" name="detail" id="detail" value="1" >
                          <label for="detail" class="custom-control-label">Detail</label>
                        </div>

              </div>

                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="View">
                     </div>


                    </div>

                 </fieldset>
                 </form>

                  @if(isset($ledger))
                  <div style="float: right;"><b>Opening: {{number_format($ledger['opening'], 2)}}</b></div>

                  <div class="table-responsive p-0" style="height: 400px;">

                <table id="example1" class="table table-bordered table-hover " style="">
                  
                  <thead>
                    
                  <tr>  

                   <th>#</th>
                    <th>Date</th>
                    <th>Voucher No</th>
                    <th>Description</th>
                    <th>Cheque No</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Balance </th>

                  </tr>
                 </thead>
                  <tbody>
                  <?php $i=1;  $open=$ledger['opening'];  ?>
                  @foreach($ledger['transections'] as $record)
                 
                 


                  <?php 
                          $open += $record['debit'] - $record['credit'] ;
                           $date='';
                           if($record['date']!='')
                  {
                           $d=explode('-', $record['date']);
                          //$date=date_create($record['date'] );
                          $date=date("d-M-Y",mktime(0,0,0,$d[1],$d[2],$d[0]));
                 }
                   ?>
                  <tr>
                  
                   <td>{{$i}}</td>
                    <td>{{$date}}</td>
                   <td><a href="{{url($record['link'])}}">{{$record['voucher_no']}}</a></td>
                                     <!-- <td></td>
                   <td></td> -->
                   <td>{{$record['remarks']}}</td>
                   <td>{{$record['cheque_no']}}</td>
                   <td> {{number_format($record['debit'], 2)}} </td>
                   <td>{{number_format($record['credit'], 2)}}</td>
                   <td>{{number_format($open, 2)}}</td>
                  
               
                   </tr>
                   <?php $i++; ?>
                  @endforeach
                  
                  
                  
                  </tbody>
                  
                  <tfoot>
                     
                    <!--  <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td> -->
                  
                  </tfoot>
                </table>
                </div>
                   <div style="float: right;"><b>Balance: {{number_format($ledger['closing'], 2)}}</b></div>
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

  @if(isset($detail))
   
   var detail=<?php echo json_encode($detail); ?> ;
      if(detail==1)
      {
         $('#detail').prop('checked', true);
      }
      else if(detail==0)
      { 
        $('#detail').prop('checked', false);
      }

   @endif
  
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
  