
@extends('layout.master')
@section('title', 'Customer Aging')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Customer Aging</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Accounts</a></li>
              <li class="breadcrumb-item active">Customer Aging</li>
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
                <h3 class="card-title">Customer Aging</h3>
                 
            
               <div class="card-tools">

                

                  

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                 
                 
                  @if(isset($customers))
                  <div class="table-responsive1 p-0" style="">
                <table id="example1" class="table table-bordered table-hover table-head-fixed text-nowrap1" style="">
                  
                  <thead>

                   
                    
                  <tr>             
                  
                    <th>Code</th>
                    <th>Account</th>
                    <!---<th>Balance</th>-->
                    <th>Current</th>
                    <th>01-30</th>
                    <th>31-60</th>
                    <th>61-90</th>
                    <th>Over 90</th>
                    <th>Advance</th>
                    <th>Total</th>
                    <th>Credit Limits</th>
                    <!--<th>Over Credit Limits</th>--->
                    <th>Credit Days</th>
                  </tr>
                 </thead>
                  <tbody>
                  <?php $i=1; 
                   ?>
                  @foreach($customers as $customer)
                 
                  
                  <tr>
                  
                  
                   
                   <td>{{$customer['name']}}</td>
                   <td class="text-uppercase">{{$customer['name']}}</td>
                 
                 <!---<td>{{$customer['balance']}}</td>-->

                   <td>{{$customer['aging']['current']}}</td>
                   
                   <td>{{$customer['aging']['1_30']}}</td>
                   <td>{{$customer['aging']['31_60']}}</td>
                   <td>{{$customer['aging']['61_90']}}</td>
                   <td>{{$customer['aging']['90_plus']}}</td>
                   <td>
                     @if($customer['balance']<0)
                     {{$customer['balance']}}
                     @endif
                   </td>
                   
                   <td>{{$customer['aging']['total']}}</td>
                   <td>{{$customer['credit_limits']}}</td>
                   <!---<td></td>-->
                   
                   <td>{{$customer['credit_days']}}</td>
                   
               
                   </tr>
                   <?php $i++; ?>
                  @endforeach
          
                  
                  </tbody>
                  <tfoot>
                     
                     
                    
                

                  
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

<script type="text/javascript">

  

 





</script>
@endsection  
  