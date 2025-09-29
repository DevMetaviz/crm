
@extends('layout.master')
@section('title', 'Trail Balance')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{asset('/public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Trail Balance</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Accounts</a></li>
              <li class="breadcrumb-item active">Trail Balance</li>
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
                <h3 class="card-title">Trail Balance</h3>
                 
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <?php  
                           $from=''; $to=''; $exclude_zero=''; $level='';
                             if(isset($config['from']))
                             $from=$config['from'];

                           if(isset($config['to']))
                             $to=$config['to'];

                           if(isset($config['exclude_zero']))
                             $exclude_zero=$config['exclude_zero'];

                           if(isset($config['level']))
                             $level=$config['level'];


                     ?>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('trail/balance/report/?from='.$from.'&to='.$to.'&exclude_zero='.$exclude_zero.'&level='.$level)}}" class="dropdown-item">print</a></li>
                    </ul>
                  </div>
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                    <form role="form" id="item_history_form" method="get" action="{{url('trail/balance/')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    

                  
           
           <div class="col-md-2">
                    <div class="form-group">
                  <label>From</label>
                  <input type="date" class="form-control"  name="from" id="from" value="@if(isset($config['from'])){{$config['from']}}@endif" required>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>To</label>
                  <input type="date" class="form-control"  name="to" id="to"  value="@if(isset($config['to'])){{$config['to']}}@endif" required>
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>A/C Level</label>
                  <select class="form-control" name="level" id="level" style="width: 100%;">
                    <option value="detail" selected>Detail A/C</option>
                    <option value="sub_sub">Sub Sub A/C</option>
                    <option value="sub">Sub A/C</option>
                    <option value="main">Main A/C</option>
                    
                  </select>
                </div>
              </div>

              <div class="col-md-2">
              
                <div class=" custom-control custom-switch" style="margin-top: 40px;">

                      <input type="checkbox" class="custom-control-input" value="1" name="exclude_zero" id="exclude_zero" >
                      <label class="custom-control-label" for="exclude_zero"></label>
                    </div>

                    <!-- <div class="form-group">
                  <label>
                  <input type="checkbox" class=" select2"  name="to" id="to"  value="1" >
                  Exclude 0 value account</label>
                </div> -->
              </div>
              
              

                    <div class="col-md-2">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="View">
                     </div>


                    </div>

                 </fieldset>
                 </form>
                 
                  @if(isset($accounts))
                  <div class="table-responsive p-0" style="height: 400px;">
                <table id="example1" class="table table-bordered table-hover table-head-fixed text-nowrap" style="">
                  
                  <thead>

                    <tr>             
                  
                    <th></th>
                    <th></th>
                    <!-- <th></th> -->
                    <th colspan="2">Opening Balance</th>
            
                    <th colspan="2">Transection</th>
          
                  
                    <th colspan="2">Closing Balance</th>
                   
                  </tr> 
                    
                  <tr>             
                  
                    <th>Code</th>
                    <th>Account</th>
                    <!-- <th>Sub A/C</th> -->
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Credit</th>
                   
                  </tr>
                 </thead>
                  <tbody>
                  <?php $i=1; $net_open_debit=0; $net_open_credit=0; $net_debit=0; $net_credit=0; 
                      $net_balance_debit=0; $net_balance_credit=0;
                   ?>
                  @foreach($accounts as $record)
                 
                  <?php 
                   
                     
                       

                       $opening=$record['opening_balance'] ;
                       $closing=$record['closing_balance'] ;  
                       
                       $opening_debit=0; $opening_credit=0;
                       $closing_debit=0; $closing_credit=0;

                         if($opening>0)
                            $opening_debit=$opening;

                          if($opening<0)
                            {$opening_credit=$opening; $opening_credit=$opening_credit* -1;}

                       if($closing>0)
                            $closing_debit=$closing;

                          if($closing<0)
                          { $closing_credit=$closing; $closing_credit=$closing_credit * -1;}

                         // $current_trail_credit=$record['current_trail_credit'] * -1 ;
                          $current_trail_credit=$record['current_trail_credit']  ;

                        $net_open_debit+=$opening_debit; 
                     $net_open_credit+=$opening_credit;

                     $net_debit+=$record['current_trail_debit']; 
                     $net_credit+=$current_trail_credit;
                     
                    $net_balance_debit+=$closing_debit; 
                      $net_balance_credit+=$closing_credit;
                    

                   ?>
                  <tr>
                  
                  
                   
                   <td>{{$record['code']}}</td>
                   <td class="text-uppercase">{{$record['name']}}</td>
                   <!-- <td class="text-uppercase"></td> -->
                   <td>{{$opening_debit}}</td>
                   <td>{{$opening_credit}}</td>
                   <td>{{$record['current_trail_debit']}}</td>
                   <td>{{$current_trail_credit}}</td>
                   <td>{{$closing_debit}}</td>
                   <td>{{$closing_credit}}</td>
                  
                   
               
                   </tr>
                   <?php $i++; ?>
                  @endforeach
                  
                  <tr>
                    
                       <th></th>
                       <th></th>
                       <!-- <th></th> -->
                       <th>{{$net_open_debit}}</th>
                       <th>{{$net_open_credit}}</th>
                       <th>{{$net_debit}}</th>
                       <th>{{$net_credit}}</th>
                       <th>{{$net_balance_debit}}</th>
                       <th>{{$net_balance_credit}}</th>
                       
                     </tr>

                     <tr style="display: none;">             
                  
                    <th>Code</th>
                    <th>Account</th>
                    <!-- <th>Sub A/C</th> -->
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Credit</th>
                   
                  </tr>

                  
                  
                  </tbody>
                  <tfoot>
                     
                     
                    
                  
                  <tr style="display: none;">             
                  
                    <th></th>
                    <th></th>
                    <!-- <th></th> -->
                    <th colspan="2">Opening Balance</th>
            
                    <th colspan="2">Transection</th>
          
                  
                    <th colspan="2">Closing Balance</th>
                   
                  </tr> 

                  
                  </tfoot>
                </table>
              </div>
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


<script src="{{asset('public/own/inputpicker/jquery.inputpicker.js')}}"></script>
<script type="text/javascript">

  $(function () {
    $("#example1").DataTable({
      "responsive": false, 
      "lengthChange": false,
       "autoWidth": false,
       "paging": false,
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


 

$(document).ready(function(){
  
  @if(isset($config['level'])) 
       var ex=`<?php echo $config['level']  ?>`;


        $('#level').val(ex);
       
     @endif 

     
     @if(isset($config['exclude_zero']))
       var ex=<?php echo $config['exclude_zero']  ?>;

       if(ex==1)
       {
        $('#exclude_zero').prop('checked', true);
       }
     @endif 
     
   
});

 





</script>
@endsection  
  