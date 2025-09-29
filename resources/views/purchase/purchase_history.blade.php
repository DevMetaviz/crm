
@extends('layout.master')
@section('title', 'Invoice History')
@section('header-css')
<link rel="stylesheet" href="{{asset('public/own/tabel/jquery.dataTables.min.css')}}">
<style type="text/css">

tfoot input {
      

        margin: 0px;
  border: none;
  display: table-cell;
  width: 100%;
  background-color: transparent;
  box-sizing:border-box;
    }

    tfoot {
    display: table-header-group;
    
}

 #me  tr  th{
    padding: 0px;
    
}

.table  tr  th,.table  tr  td,#history tr td{
    padding: 0px;
    
}




  </style>
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Invoice History</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/purchase/')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Purchase</a></li>
              <li class="breadcrumb-item active">Invoice History</li>
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
                <h3 class="card-title">Invoices</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               

                

              
               <div class="table-responsive">
      <table id="history" class="table table-bordered table-hover table-striped display" style="width:100%">
                  
                  <thead class="">
                  
                   <tr>
                    <th>Sr No</th>
                    <th>Purchase No</th>
                    <th>Date</th>
                    <th>Vendor</th>
                    
                    <th>GRN No</th>
                    <th>GRN Date</th>
                   <th>Qty</th>
                    <th>Weight</th>
                    <th>Amount</th>
                  
                   <th>Status</th>
                    <th>Action</th>
                  </tr>


                  </thead>

                  <tfoot id="me">
                  <tr>
                  <th>Sr No</th>
                    <th>Purchase No</th>
                    <th>Date</th>
                    <th>Vendor</th>
                    
                    <th>GRN No</th>
                    <th>GRN Date</th>
                   <th>Qty</th>
                    <th>Weight</th>
                    <th>Amount</th>
                  
                   <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>

                  <tbody>
                  
                   

                  
            <?php $k=1; ?>
                    @foreach($purchases as $pur)

                  <?php 

                  $qty=$pur->total_qty();
                  $weight=$pur->total_weight();
                  $total=$pur->total_amount(); 

                  $status='';

                  if($pur['status']==0){
                      $status='Unpost';
                  }
                  elseif($pur['status']==1){
                    $status='Post';
                  }

                   ?> 
                      
                        <tr>
                   
                     
                     <td>{{$k}}</td>
                     <td>{{$pur['doc_no']}}</td>
                     <td>{{$pur['doc_date']}}</td>
                    <td>@if($pur['vendor']!=''){{$pur['vendor']['name']}}@endif</td>
                  
                     <td>@if($pur['grn']!=''){{$pur['grn']['doc_no']}}@endif</td>
                      <td>@if($pur['grn']!=''){{$pur['grn']['doc_date']}}@endif</td>
                    <td>{{$qty}}</td>
                     <td>{{$weight}}</td> 
                     <td>{{$total}}</td>
                     

                    <td>{{$status}}</td>
                   
                    <td>
                        <a href="{{url('edit/purchase/'.$pur['id'])}}"><span class="fa fa-edit"></span></a>

                           

                          
                          @if(!isset($pur['purchasereturn']))
                          <span class="dropdown">
                          <button class="btn btn-default btn-sm dropdown-toggle" type="button"  data-toggle="dropdown">Action
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                          <li role="presentation"><a role="menuitem" href="{{url('purchase/return?purchase='.$pur['id'])}}">Return</a></li>
                          </ul>
                          </span>
                          @endif 

                    </td>
                     
                    </tr>
                  <?php    $k++;   ?>
                    @endforeach
                
                  
                  </tbody>
                  
                </table>
                </div><!--tabel div-->

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')


<script src="{{asset('public/own/tabel/jquery.dataTables.min.js')}}"></script>



<script type="text/javascript">


$(document).ready(function() {


    // Setup - add a text input to each footer cell
    $('#history tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text"  />' );
    } );
 
    // DataTable
    var table = $('#history').DataTable({

     

        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }//
    });//end datatabel function

        var count=<?php echo json_encode(count( $purchases)); ?> ;

        $('#history_length select[name=history_length]').append('<option value="'+count+'">All</option>');
     $('#history_length select[name=history_length]').val('50').trigger('change');
     
 
} );//end ready
</script>
@endsection  
  