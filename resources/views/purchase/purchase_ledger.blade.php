
@extends('layout.master')
@section('title', 'Purchase Ledger')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="{{asset('/public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <style type="text/css">
    [data-href] {
    cursor: pointer;
}
td
{
 
}
td{
  
  vertical-align: middle;

}
  </style>
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Purchase Detail</h1>

            <?php 

          //  $config=array( 'customer'=>$customer,'from'=>$from,'to'=>$to,'so_id'=>$so_id , 'manufactured_by'=>$manufactured_by, 'item_id'=>$item_id );


            $f=''; $t=''; $c_id=''; $m_b=''; $i_id=''; $so_id='';

            if(isset($config['from']))
              $f=$config['from'];

            if(isset($config['to']))
              $t=$config['to'];


            if(isset($config['customer']))
              $c_id=$config['customer']['id'];

            if(isset($config['manufactured_by']))
              $m_b=$config['manufactured_by'];

            if(isset($config['so_id']))
              $so_id=$config['so_id'];

            if(isset($config['item_id']))
              $i_id=$config['item_id'];


             ?>

            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" style="border: none;background-color: transparent;" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                
                      <!-- <li><a href="{{url('print/sale/ledger?customer_id='.$c_id.'&from='.$f.'&to='.$t.'&item_id='.$i_id.'&so_id='.$so_id.'&manufactured_by='.$m_b)}}" class="dropdown-item">Print</a></li>
 -->                  
                    </ul>
                  </div>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Purchase</a></li>
              <li class="breadcrumb-item active">Ledger</li>
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
                <h3 class="card-title">Purchase Ledger</h3>
                 
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                    <form role="form" id="item_history_form" method="get" action="{{url('purchase/ledger/')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    

                  <!-- <div class="col-md-4">
                 <div class="dropdown" id="customers_table_customer_dropdown">
        <label>Customer</label>
        <input class="form-control"  name="customer_id" id="customer_id" value="">
      
           </div>
           </div> -->

           
           
           <div class="col-md-2">
                    <div class="form-group">
                  <label>From</label>
                  <input type="date" class="form-control select2"  name="from" id="from" value="@if(isset($config['from'])){{$config['from']}}@endif">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>To</label>
                  <input type="date" class="form-control select2"  name="to" id="to"  value="@if(isset($config['to'])){{$config['to']}}@endif" >
                </div>
              </div>
              
             

                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="View">
                     </div>


                    </div>

                 </fieldset>
                 </form>
                 
                  @if(isset($lists))
                <table id="example1" class="table table-bordered table-hover " style="">
                  
                  <thead>
                    
                  <tr>             
                    <th>#</th>
                    <th>Invoice No</th>
                    <th>Invoice Date</th>
                    <th>Vendor</th>
                     <th>NTN No</th>
                      <th>CNIC</th>
                    <th>Total Qty</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>GST Tax</th>
                    <th>W.H Tax</th>
                    <th>Net Total</th>
                        </tr>
                 </thead>
                  <tbody>
                  <?php $i=1; $net_total_qty=0; $net_total_amount=0; ?>
                  @foreach($lists as $record)
                 
                  <?php 
                   $qty=$record->total_qty();
                   $amount=$record->total_amount();
                   $wa=$record->with_hold_tax_amount();
                   $gst=$record->gst_amount();

                   $net=$amount-$wa+$gst;
                  

                    $net_total_qty+=$qty; $net_total_amount+=$amount;

                    // $txt=$record['is_gst'];
                    // if($txt==1)
                    //   $txt='GST';
                    // else
                    //   $txt='Non-GST';
                   ?>
                  <tr>
                  
                   <td>{{$i}}</td>
                   <td><a href="{{url('edit/purchase/'.$record['id'])}}">{{$record['doc_no']}}</a></td>
                   <td>{{$record['doc_date']}}</td>
                   <td>@if($record['vendor']!=''){{$record['vendor']['name']}}@endif</td>
                    <td>@if($record['vendor']!=''){{$record['vendor']['ntn_number']}}@endif</td> 
                    <td>@if($record['vendor']!=''){{$record['vendor']['cnic']}}@endif</td>                                                                         
                   <td>{{$qty}}</td>
                   <td>{{$amount}}</td>
                   <td>{{$record['type']}}</td>
                   <td>{{$gst}}</td>
                   <td>{{$wa}}</td>
                   <td>{{$net}}</td>
                                  
                   </tr>
                   <?php $i++; ?>
                  @endforeach
                  
                  
                  
                  </tbody>
                  <tfoot>
                     
                                         
                  <tr>             
                    <th>#</th>
                    <th>Invoice No</th>
                    <th>Invoice Date</th>
                    <th>Vendor</th>
                    <th>NTN No</th>
                    <th>CNIC</th>
                    <th>Total Qty</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>GST Tax</th>
                    <th>W.H Tax</th>
                    <th>Net Total</th>
                        </tr>
                 
                  
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

<!-- DataTables  & Plugins -->
<script src="{{asset('public/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('public/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('public/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": false,
       "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});

</script>


<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script type="text/javascript">

 function setCustomers(customers)
 {
  
  
  var new_customers=[];

   var let={ customer:'Select Any Value', id:'' };
         new_customers.push(let);
 
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
  filterOpen: true,
  autoOpen:true
    });

 }

$(document).ready(function(){
  
  @if(isset($customers))
   var customers=<?php echo json_encode($customers); ?> ;
   setCustomers(customers);

   @endif

   @if(isset($config['customer']))
   
   var customer=<?php echo json_encode($config['customer']); ?> ;
   //alert(customer);
   $('#customer_id').val(customer['id']);
var s=$("#customers_table_customer_dropdown").find(".inputpicker-input");
   s.val(customer['name']);

   @endif

   @if(isset($config['so_id']))
   var so_id=<?php echo json_encode($config['so_id']); ?> ;
   $('#so_id').val(so_id);
   @endif

   @if(isset($config['manufactured_by']))
   var manufactured_by=<?php echo json_encode($config['manufactured_by']); ?> ;
   $('#manufactured_by').val(manufactured_by);
   @endif

    @if(isset($config['item_id']))
   var item_id=<?php echo json_encode($config['item_id']); ?> ;
   $('#item_id').val(item_id);
   @endif
     
      
     
   
});

 





</script>
@endsection  
  