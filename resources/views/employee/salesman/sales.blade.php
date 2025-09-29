
@extends('layout.master')
@section('title', 'Salesman Sales')
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
            <h1 style="display: inline;">Salesman Sale</h1>

            <?php 

          //  $config=array( 'customer'=>$customer,'from'=>$from,'to'=>$to,'so_id'=>$so_id , 'manufactured_by'=>$manufactured_by, 'item_id'=>$item_id );


            $f=''; $t=''; $s_id='';

            if(isset($config['from']))
              $f=$config['from'];

            if(isset($config['to']))
              $t=$config['to'];



            if(isset($config['salesman_id']))
              $s_id=$config['salesman_id'];


             ?>

            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" style="border: none;background-color: transparent;" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                
                      <li><a href="{{url('salesman/sale/report?salesman_id='.$s_id.'&from='.$f.'&to='.$t)}}" class="dropdown-item">Print</a></li>
                  
                    </ul>
                  </div>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Salesman</a></li>
              <li class="breadcrumb-item active">Sales</li>
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
                <h3 class="card-title">Sales</h3>
                 
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                    <form role="form" id="item_history_form" method="get" action="{{url('salesman/sale/')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    

                  
           

           <div class="col-md-2">
                    <div class="form-group">
                  <label>Sales Person</label>
                  <select class="form-control select2"  name="salesman_id" id="salesman_id">
                    <option value="">Select Sale Person</option>
                    @foreach($men as $so)
                    <option value="{{$so['id']}}">{{$so['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

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
                   @if(isset($salesman))<!--Start sale man-->
                    <div style="margin-top: 6px;"> <!--Start sale man div-->
                       <h2 class="bg-info p-2">{{$salesman['name']}}</h2>

                       @foreach($salesman->sales as $sale) <!--start sale-->
                          Invoice No: <b>{{$sale['invoice_no']}}</b><br>
                          Invoice Date: <b>{{$sale['invoice_date']}}</b><br>
                          Customer: <b>{{$sale['customer']['name']}}</b><br>

                          <table class="table table-bordered">
                             <thead>
                                <tr>
                                   <th></th>
                                   <th>Item</th>
                                   <th>Qty</th>
                                   <th>MRP</th>
                                   <th>Disc</th>
                                   <th>Rate</th>
                                   <th>Amount</th>
                                   <th>Com</th>
                                   <th>Commission</th>
                                </tr>
                             </thead>
                             <tbody>
                              <?php $total_qty=0; $total_amount=0; $total_commission=0; ?>
                              @foreach($sale['sale_stock_list'] as $item)
                              <?php 

                              
                              $type=$item['commission_type']; $value=$item['commission_factor'];

                                     $t='';
                                       if($type=='percentage')
                                         { $t='%';}
                                      $commission=$item->commission();

                              $total_amount+=$item['amount']; $total_commission+=$commission;
                              $total_qty+=$item['total_qty'];
                               ?>
                                  <tr>
                                      <td></td>
                                      <td>{{$item['item']['item_name']}}</td>
                                      <td>{{$item['total_qty']}}</td>
                                      <td>{{$item['mrp']}}</td>
                                      <td>{{$item['discount']}}</td>
                                      <td>{{$item['rate']}}</td>
                                      <td>{{$item['amount']}}</td>
                                      <td>{{$value.$t}}</td>
                                      <td>{{$commission}}</td>
                                  </tr>
                                  @endforeach
                             </tbody>
                             <tfoot>
                                   <tr>
                                   <th></th>
                                   <th>Total:</th>
                                   <th>{{$total_qty}}</th>
                                   <th></th>
                                   <th></th>
                                   <th></th>
                                   <th>{{$total_amount}}</th>
                                   <th></th>
                                   <th>{{$total_commission}}</th>
                                </tr>
                             </tfoot>
                          </table>

                             
                               
                             
                       @endforeach<!--end sale-->

                    </div><!--End sale man div-->
                   @endif<!--End sale man-->


                 

              
                  
                  
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

   @if(isset($config['salesman_id']))
   var salesman_id=<?php echo json_encode($config['salesman_id']); ?> ;
   $('#salesman_id').val(salesman_id);
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
  