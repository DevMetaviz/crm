
@extends('layout.master')
@section('title', 'Account Ledger')
@section('header-css')
<link href="{{asset('public/own/inputpicker/jquery.inputpicker.css')}}" rel="stylesheet" type="text/css">
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Account Ledger</h1>

            <?php
                 $account_id=''; $detail=''; $from=''; $to='';

                if(isset($config['account']))
                  $account_id=$config['account']['id'];

                if(isset($config['detail']))
                  $detail=$config['detail'];

                if(isset($config['from']))
                  $from=$config['from'];

                if(isset($config['to']))
                  $to=$config['to'];
             ?>

            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" style="border: none;background-color: transparent;" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('/account/ledger/report/?account_id='.$account_id.'&from='.$from.'&to='.$to.'&detail='.$detail)}}" class="dropdown-item">Print</a></li>
                    </ul>
                  </div>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Accounts</a></li>
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
                <h3 class="card-title">Account Ledger</h3>
                 
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                    <form role="form" id="item_history_form" method="get" action="{{url('account/ledger/')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Criteria</legend>

                       <div id="item_error" style="display: none;"><p class="text-danger" id="item_error_txt"></p></div>

                        <div class="row">

                    
           <div class="col-md-6">
           <div class="dropdown" id="accounts_table_account_dropdown">
                <label>Account</label>
              <input class="form-control"  name="account_id" id="account_id" required>
                </div>
           </div>
                  
           
           <div class="col-md-2">
                    <div class="form-group">
                  <label>From</label>
                  <input type="date" class="form-control select2"  name="from" id="from" value="@if(isset($config['from'])){{$config['from']}}@endif" >
                </div>
              </div>

              <div class="col-md-2">
                    <div class="form-group">
                  <label>To</label>
                  <input type="date" class="form-control select2"  name="to" id="to"  value="@if(isset($config['to'])){{$config['to']}}@endif" >
                </div>
              </div>
              


              <div class="col-md-1">
                      <br>
                    <div class="custom-control custom-checkbox">
                          <input class="custom-control-input custom-control-input-info custom-control-input-outline" type="checkbox" name="detail" id="detail" value="1" >
                          <label for="detail" class="custom-control-label">Detail</label>
                        </div>

              </div>

              

                    <div class="col-md-1">
                      <br>
                    <input type="submit" class="btn btn-info" name="" value="View">
                     </div>


                    </div>

                 </fieldset>
                 </form>
                 <div></div>
                  @if(isset($ledger))
                  <div style="float: right;"><b>Opening: {{number_format($ledger['opening'], 2)}}</b></div>
                  
                  <div class="table-responsive p-0" style="height: 400px;">
                <table class="table table-bordered table-hover table-head-fixed text-nowrap" id="" style="">
                    
                 
                 </thead>
                  
                  <thead>
                    
                  <tr>             
                    <th>#</th>
                    <th>Date</th>
                    <th>Voucher No</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Cheque No</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Balance </th>
                    
                   
                  </tr>
                 </thead>
                  <tbody>
                  <?php $i=1; $open=$ledger['opening'];
                   ?>
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


                      $status=0;

                      if($record['status']==0)
                        $status='Unpost';
                      elseif($record['status']==1)
                        $status='Post';
                   ?>
                  <tr>
              
                   <td>{{$i}}</td>
                   <td>
                      
                        {{$date}}
                    
                   </td>
                   <td>
                  <a href="{{url($record['link'])}}">{{$record['voucher_no']}}</a>
                     
                   </td>
                    <td>{{$status}}</td>
                    
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
                     
                     <tr>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                       <th></th>
                      
                       
                     </tr>
                  
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

function setAccounts(accounts)
 {
  
  
  var new_accounts=[];
 
 for(var i = 0 ; i < accounts.length ; i++)
 {
  
     
         var let={ account:accounts[i]['name'],code:accounts[i]['code'],sub_sub_ac:accounts[i]['super_account']['name'],id:accounts[i]['id'],type:accounts[i]['super_account']['account_type']['name'],city:accounts[i]['id'] };
         //alert(let);
         new_accounts.push(let);
 }


$('#account_id').inputpicker({
    data:new_accounts,
    fields:[
        {name:'account',text:'Account'},
        {name:'code',text:'Code'},
        {name:'type',text:'Type'},
        {name:'sub_sub_ac',text:'Sub Sub Acc'},
        {name:'city',text:'City'}
        
    ],
    headShow: true,
    fieldText : 'account',
    fieldValue: 'id',
  filterOpen: true
    });

 }
 

$(document).ready(function(){
  

  @if(isset($config['detail']))
   
   var detail=<?php echo json_encode($config['detail']); ?> ;
      if(detail==1)
      {
         $('#detail').prop('checked', true);
      }
      else if(detail==0)
      { 
        $('#detail').prop('checked', false);
      }

   @endif


  
     var accounts=<?php echo json_encode($accounts) ?>;
      setAccounts(accounts);
      
      @if(isset($config['account']))
   
   var account=<?php echo json_encode($config['account']); ?> ;
   $('#account_id').val(account['id']);
    var s=$("#accounts_table_account_dropdown").find(".inputpicker-input");
   s.val(account['name']);

   @endif
     
   
});

 





</script>
@endsection  
  