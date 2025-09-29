
@extends('layout.master')
@section('title', 'Doctor Sales')
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
            <h1 style="display: inline;">Doctor Sale</h1>

            <?php 

          //  $config=array( 'customer'=>$customer,'from'=>$from,'to'=>$to,'so_id'=>$so_id , 'manufactured_by'=>$manufactured_by, 'item_id'=>$item_id );


            $f=''; $t=''; $c_id=''; $m_b=''; $i_id=''; $so_id='';

            if(isset($config['from']))
              $f=$config['from'];

            if(isset($config['to']))
              $t=$config['to'];


            if(isset($config['doctor']))
              $d_id=$config['doctor']['id'];

            if(isset($config['customer']))
              $c_id=$config['customer']['id'];

            if(isset($config['so_id']))
              $so_id=$config['so_id'];

            if(isset($config['item_id']))
              $i_id=$config['item_id'];


             ?>

            <!-- <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" style="border: none;background-color: transparent;" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                
                      <li><a href="{{url('print/sale/ledger?customer_id='.$c_id.'&from='.$f.'&to='.$t.'&item_id='.$i_id.'&so_id='.$so_id.'&manufactured_by='.$m_b)}}" class="dropdown-item">Print</a></li>
                  
                    </ul>
                  </div> -->
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Doctor</a></li>
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
                 
                    <form role="form" id="item_history_form" method="get" action="{{url('doctor/sales/')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    
           <div class="col-md-3">
                    <div class="form-group">
                  <label>Customer</label>
                  <select class="form-control select2"  name="customer_id" id="customer_id" onchange="setDoctors()">
                    <option value="">Select any customer</option>
                    @foreach($customers as $c)
                       <?php 
                       
                        $s='';
                        if(isset($config['customer_id']))
                         if($c['id']==$config['customer_id'])
                          $s='selected';
                     ?>
                    <option value="{{$c['id']}}" {{$s}}>{{$c['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

                  
           

           <div class="col-md-2">
                    <div class="form-group">
                  <label>Doctor</label>
                  <select class="form-control select2"  name="doctor_id" id="doctor_id">
                    <option value="">Select any doctor</option>
                    <?php 
                         $ds=$doctors;
                         if(isset($config['customer_id']))
                          $ds=$customer['doctors'];
                     ?>
                    @foreach($ds as $so)
                     <?php 
                       
                        $se='';
                        if(isset($config['doctor_id']))
                         if($so['id']==$config['doctor_id'])
                          $se='selected';
                     ?>
                    <option value="{{$so['id']}}" {{$se}}>{{$so['name']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

           <div class="col-md-2">
                    <div class="form-group">
                  <label>From</label>
                  <input type="date" class="form-control"  name="from" id="from" value="@if(isset($config['from'])){{$config['from']}}@endif">
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>To</label>
                  <input type="date" class="form-control"  name="to" id="to"  value="@if(isset($config['to'])){{$config['to']}}@endif" >
                </div>
              </div>
              
              

                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="View">
                     </div>


                    </div>

                 </fieldset>
                 </form>
                   @if(isset($customer))<!--Start sale man-->
                    <div style="margin-top: 6px;"> <!--Start doctor div-->
                      @foreach($customer->doctors as $doctor)
                       <h2 class="bg-info p-2">{{$doctor['name']}}</h2>

                       @foreach($doctor['points'] as $point) <!--start point-->
                          Point: <b>{{$point['name']}}</b><br>
                       
                          <table class="table table-bordered">
                             <thead>
                                <tr>
                                   <th></th>
                                   <th>Item</th>
                                   <th>Qty</th>
                                   <th>MRP</th>
                                   <th>Batch No</th>
                                   <th>Rate</th>
                                   <th>Amount</th>
                                
                                </tr>
                             </thead>
                             <tbody>
                              <?php $ts=$point->d_items(); ?>
                              
                            
                            
                              @foreach($ts as $item)
                             <tr>
                                      
                                    <td></td> 
                                    <td>{{$item['item']['item_name']}}</td> 
                                    <td>{{$item['qty']}}</td> 
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                  </tr>
                                  @endforeach
                                  
                             </tbody>
                          </table>

                             
                               
                             
                       @endforeach<!--end sale-->

                       @endforeach<!--end doctor loop-->


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

  $(document).ready(function(){

$('.select2').select2(); 

$(function () {
  $('[data-tooltip="tooltip"]').tooltip({
    trigger : 'hover'
     });
});

});

 
$(document).ready(function(){
  
  
   

   @if(isset($config['manufactured_by']))
   var manufactured_by=<?php echo json_encode($config['manufactured_by']); ?> ;
   $('#manufactured_by').val(manufactured_by);
   @endif

    @if(isset($config['item_id']))
   var item_id=<?php echo json_encode($config['item_id']); ?> ;
   $('#item_id').val(item_id);
   @endif
     
      
     
   
});

 
function setDoctors()
{

  var customer_id=$('#customer_id').val();
  
  var customers=JSON.parse( '<?php echo json_encode(  $customers) ; ?>' );
  
   let point = customers.findIndex((item) => item.id == customer_id);
    var doctors=customers[point]['doctors'];
    
    $('#doctor_id').empty().append('<option value="">Select any doctor</option>');
     
     var txt='';
    for (var i =0; i< doctors.length ;  i++) {
       txt +=`<option value="${doctors[i]['id']}">${doctors[i]['name']}</option>`;
    }
    $('#doctor_id').append(txt);
  
}



</script>
@endsection  
  