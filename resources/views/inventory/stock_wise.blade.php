
@extends('layout.master')
@section('title', 'Items Stock1')
@section('header-css')

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
            <h1 style="display: inline;">Items Stock  Batch Wise</h1>
           <!--  <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('#')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Items</a></li>
              <li class="breadcrumb-item active">Stock</li>
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
                <h3 class="card-title">Stock List</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <form role="form" id="item_history_form" method="get" action="{{url('inventory/stock-wise')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    <div class="col-md-2">
                    <div class="form-group">
                  <label>Department</label>
                  <select class="form-control select2" name="department" id="department" style="width: 100%;">
                    <option value="">Select any department</option>
                    @foreach($departments as $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
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
                    <div class="form-group">
                  <label>Select</label>
                  <select class="form-control select2" name="stock_type" id="stock_type" style="width: 100%;">
                    <option value="batch_no">Batchwise</option>
                    <option value="grn_no">GRN No wise</option>
                    
                  </select>
                </div>
              </div>

              <!-- <div class="col-md-2">
                    <div class="form-group">
                  <label>Select</label>
                  <select class="form-control select2" name="expired" id="expired" style="width: 100%;">
                    <option value="">Select</option>
                    <option value="expired">Expired</option>
                    <option value="near_expiry">Near Expiry</option>
                    
                  </select>
                </div>
              </div> -->

              <div class="col-md-2">
                    <div class="form-group">
                  <label>Expire Within</label>
                  <div class="row input-group">
                  <select class="form-control col-md-4" name="expiry_num" id="expiry_num" style="">
                    <option value="">----</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    
                  </select>
                  <select class="form-control col-md-7" name="expiry_type" id="expiry_type" style="">
                    <option value="">----</option>
                    <option value="Month">Month</option>
                    <option value="Year">Year</option>
                    
                  </select>
                    </div>
                </div>
              </div>

              <div class="col-md-2">
                    <label><br><input type="checkbox" class="" name="is_expired" id="is_expired" value="1">&nbsp;&nbsp;Expired Stocks</label>
                     </div>



                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="Search">
                     </div>


                    </div>

                 </fieldset>
                 </form>

                 <table id="example11" class="table table-bordered table-hover" style="">
                  
                  <thead>
                  
                    <tr>
                    <th>No.</th>
                    <th>Item Discription</th>
                          
                          @if($config['stock_type']=='grn_no')
                          <th>{{'Grn No'}}</th>
                         @elseif($config['stock_type']=='batch_no')
                         <th>{{'Batch No'}}</th>
                         @endif

                                               
                    
                    <th>Expiry Date</th>
                    <th>MRP</th>
                     <th>Opening</th>
                     <!-- <th>Total</th> -->
                    <th>Purchase Qty</th>
                    <th>Production</th>
                     <th>Issue Qty</th>
                    <th>Sale Qty</th>
                    <th>Purchase Return</th>
                    <th>Sale Return</th>
                    <th>Issue Return</th>
                    <th>- Ad</th> 
                    <th>Closing</th>
                    <!-- <th>Total</th> -->
                  
                  </tr>


                  </thead>
                  <tbody>
                    
                     <?php $i=1; ?>
                    @foreach($items as $item) 

                         <?php 
                      
                           $no=count($item['batches']); 
                             
                           ?>

                      

                      
                  
                        @if($no==0)
                       <tr>
                     <td>{{$i}}</td>
                    
                    
                    <td>{{$item['item']['item_name']}}</td>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      <!-- <td></td>
 -->                       <td></td>
                     <td></td>
                      <td></td>                
                     <td></td>
                     <td></td>
                      <td></td>                
                     <td></td> 
                     <td></td>                
                     <td></td> 
                     <!-- <td></td> -->
                     </tr>
                     @else
                         
                     
                        
                        <?php $k=1; $closing_total=0; ?>

                     @foreach($item['batches'] as $stk) 
                     <tr>
                           <td >{{$i}}</td>
                    
                    
                    <td>{{$item['item']['item_name']}}</td>
                     <?php      
                             //$let=$item->item_batch_detail($stk,$expired);
                             $exp='';
                             if($stk['exp_date']!='')
                             {
                              $exp=date_create($stk['exp_date'] );
                             $exp=date_format($exp,"M-Y");
                             }
                         ?>
                      
                      @if($k!=1)
                      <!-- <tr> -->
                        @endif
                      
                        <td>{{$stk['batch_no']}}</td>
                        <td>{{$exp}}</td>
                        <td>{{$stk['mrp']}}</td>
                      <td>{{$stk['opening']}}</td>
                       
                        <!-- <td>{{$item['opening_total']}}</td> -->
                      @if($k==1)
                     
                      @endif

                      <td>{{$stk['detail']['grn_qty']}}</td>
                   <td>{{$stk['detail']['production_qty']}}</td>
                      <td>{{$stk['detail']['issue_qty']}}</td>
                       <td>{{$stk['detail']['dc_qty']}}</td>
                     <td>{{$stk['detail']['purchase_return']}}</td>
                     <td>{{$stk['detail']['sale_return']}}</td>
                      <td>{{$stk['detail']['issue_return_qty']}}</td>  
                       <td>{{$stk['detail']['less_adjustment']}}</td>               
                     <td>{{$stk['closing']}}</td>


                     @if($k!=1)
                      <!-- </tr> -->
                      @else
                      
                        @endif
                          <!-- <td>{{$item['closing_total']}}</td> -->
                     <?php $k++; ?>
                      <?php $i++; ?>
                     </tr>
                    @endforeach <!--end batch loop-->
                         
                     
                     @endif
                     
                     
                     
                     
                     @endforeach<!--end item loop-->

                
                  
                  </tbody>
                  
                  <tfoot> 
                  
                    <tr>
                    <th>No.</th>
                    <th>Item Discription</th>
                          
                          @if($config['stock_type']=='grn_no')
                          <th>{{'Grn No'}}</th>
                         @elseif($config['stock_type']=='batch_no')
                         <th>{{'Batch No'}}</th>
                         @endif

                            
                    <th>Expiry Date</th>
                    <th>MRP</th>
                     <th>Opening</th>
                     <!-- <th>Total</th> -->
                    <th>Purchase Qty</th>
                    <th>Production</th>
                     <th>Issue Qty</th>
                    <th>Sale Qty</th>
                    <th>Purchase Return</th>
                    <th>Sale Return</th>
                    <th>+ Ad</th>
                    <th>- Ad</th> 
                    <th>Closing</th>
                    <!-- <th>Total</th> -->
                  
                  </tr>


                  </tfoot>

                </table>


        
                @if(isset($items1))
                
                  <table id="example1" class="table table-bordered table-hover" style="">
                  
                  <thead>
                  
                    <tr>
                    <th>No.</th>
                    <th>Item Discription</th>
                          
                          @if($config['stock_type']=='grn_no')
                          <th>{{'Grn No'}}</th>
                         @elseif($config['stock_type']=='batch_no')
                         <th>{{'Batch No'}}</th>
                         @endif

                                               
                    
                    <th>Expiry Date</th>
                     <th>Opening</th>
                     <th>Total</th>
                    <th>Purchase Qty</th>
                    <th>Production</th>
                     <th>Issue Qty</th>
                    <th>Sale Qty</th>
                    <th>Purchase Return</th>
                    <th>Sale Return</th>
                    <th>+ Ad</th>
                    <th>- Ad</th> 
                    <th>Closing</th>
                    <th>Total</th>
                  
                  </tr>


                  </thead>
                  <tbody>
                    
                  
                   <?php $i=1; ?>
                    @foreach($items as $item) 

                         <?php 
                      
                           $no=count($item['batches']); 
                             
                           ?>

                      

                      <tr>
                  
                        @if($no==0)

                     <td>{{$i}}</td>
                    
                    
                    <td>{{$item['item']['item_name']}}</td>

                        <td></td>
                        <td></td>
                        <td></td>
                      <td></td>
                       <td></td>
                     <td></td>
                      <td></td>                
                     <td></td>
                     <td></td>
                      <td></td>                
                     <td></td> 
                     <td></td>                
                     <td></td> 
                     <td></td>

                     @else
                         
                     <td rowspan="{{$no}}">{{$i}}</td>
                    
                    
                    <td  rowspan="{{$no}}">{{$item['item']['item_name']}}</td>
                        
                        <?php $k=1; $closing_total=0; ?>

                     @foreach($item['batches'] as $stk) 

                     <?php      
                             //$let=$item->item_batch_detail($stk,$expired);
                      
                          $exp='';
                             if($stk['exp_date']!='')
                             {
                              $exp=date_create($stk['exp_date'] );
                             $exp=date_format($exp,"M-Y");
                             }
                         ?>
                      
                      @if($k!=1)
                      <tr>
                        @endif
                        
                        <td>{{$stk['batch_no']}}</td> 
                        <td>{{$exp}}</td>
                      <td>{{$stk['opening']}}</td>

                      @if($k==1)
                      <td rowspan="{{$no}}">{{$item['opening_total']}}</td>
                      @endif

                      <td>{{$stk['detail']['grn_qty']}}</td>
                   <td>{{$stk['detail']['production_qty']}}</td>
                      <td>{{$stk['detail']['issue_qty']}}</td>
                       <td>{{$stk['detail']['dc_qty']}}</td>
                     <td>{{$stk['detail']['purchase_return']}}</td>
                     <td>{{$stk['detail']['sale_return']}}</td>
                      <td>{{$stk['detail']['add_adjustment']}}</td>  
                       <td>{{$stk['detail']['less_adjustment']}}</td>               
                     <td>{{$stk['closing']}}</td>


                     @if($k!=1)
                      </tr>
                      @else
                      <td rowspan="{{$no}}">{{$item['closing_total']}}</td>
                        @endif
                     
                     <?php $k++; ?>
                    @endforeach <!--end batch loop-->
                         
                     
                     @endif
                     </tr>
                     
                     
                     <?php $i++; ?>
                     @endforeach<!--end item loop-->
                
                  
                  </tbody>
                  
                  <tfoot> 
                  
                    <tr>
                    <th>No.</th>
                    <th>Item Discription</th>
                          
                          @if($config['stock_type']=='grn_no')
                          <th>{{'Grn No'}}</th>
                         @elseif($config['stock_type']=='batch_no')
                         <th>{{'Batch No'}}</th>
                         @endif

                            
                    <th>Expiry Date</th>
                     <th>Opening</th>
                     <th>Total</th>
                    <th>Purchase Qty</th>
                    <th>Production</th>
                     <th>Issue Qty</th>
                    <th>Sale Qty</th>
                    <th>Purchase Return</th>
                    <th>Sale Return</th>
                    <th>+ Ad</th>
                    <th>- Ad</th> 
                    <th>Closing</th>
                    <th>Total</th>
                  
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

<script type="text/javascript">

$(document).ready(function(){

@if($config['department']!='')
$('#department').val(<?php echo json_encode($config['department']) ?>);
@endif

@if($config['stock_type']!='')
$('#stock_type').val(<?php echo json_encode($config['stock_type']) ?>);
@endif

@if($config['expiry_num']!='')
$('#expiry_num').val(<?php echo json_encode($config['expiry_num']) ?>);
@endif

@if($config['expiry_type']!='')
$('#expiry_type').val(<?php echo json_encode($config['expiry_type']) ?>);
@endif

@if($config['is_expired']=='1')
$('#is_expired').prop('checked',true);
@endif

});

</script>

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
    $("#example11").DataTable({
      "responsive": false,
      "paging": false, 
      "lengthChange": false,
       "autoWidth": false,
       "ordering": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example11_wrapper .col-md-6:eq(0)');


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





@endsection  
  