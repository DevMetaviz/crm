
@extends('layout.master')
@section('title', 'Payable List')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Vendors Payables</h1>
            <!-- <a class="btn" href="{{url('customer/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a> -->
            <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('/print/vendors/payable')}}" class="dropdown-item">List</a></li>
                    </ul>
                  </div>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Vendor</a></li>
              <li class="breadcrumb-item active">List</li>
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
                <h3 class="card-title">Vendors</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               

                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>NTN No</th>
                    <th>Address</th>
                     <th>Balance</th>
                    <th>View</th>
                  
                  </tr>

                  
            <?php $i=1; ?>
                    @foreach($customers as $customer)
                      
                  <?php 
                     
                     $date=date("Y-m-d");

                  $bal=$customer['account']->closing_balance($date);
                             
                             if($bal==0)
                              continue;
                        ?>
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                     <td>{{$customer['name']}}</td>
                     
                     <td>{{$customer['mobile']}}</td>
                  
                     <td>{{$customer['email']}}</td>
                     <td>{{$customer['ntn']}}</td>
                    <td>{{$customer['address']}}</td>
                    <td>{{$bal}}</td>
                                        
                     <td><a href="{{url('account/ledger?account_id='.$customer['account']['id'].'&to='.$date.'&detail=1')}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
                  </tr>
                    
                    <?php $i++; ?>

                    @endforeach
                    
                  
                  </tbody>
                  <tfoot>
                  <tr>
                  
                  </tr>
                  </tfoot>
                </table>


              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')







@endsection  
  