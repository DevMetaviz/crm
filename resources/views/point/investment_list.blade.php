
@extends('layout.master')
@section('title', 'Investment List')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Investment List</h1>
            <a class="btn" href="{{url('investment/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Investment</a></li>
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
                <h3 class="card-title">List</h3>
              
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
                    <th>Id</th>
                    <th>Doc No</th>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Distributor</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Invested Through</th>
                                      
                    <th>Active</th>
                    <th></th>
                  </tr>

                  
            
                    @foreach($invests as $customer)
                      
                        <tr>
                   
                     
                     <td>{{$customer['id']}}</td>
                     <td>{{$customer['doc_no']}}</td>
                     <td>{{$customer['investment_date']}}</td>
                     <td>@if(isset($customer['doctor'])){{$customer['doctor']['name']}}@endif</td>
                     <td>@if(isset($customer['doctor'])){{$customer['doctor']['distributor']['name']}}@endif</td>
                     <td>{{$customer['type']}}</td>
                     <td>{{$customer['amount']}}</td>
                     <td>@if(isset($customer['invest_through'])){{$customer['invest_through']['name']}}@endif</td>
                    
                     <?php $active='Active';
                            if($customer['activeness']=='0')
                             $active='Inactive';
                             ?>
                     <td>{{$active}}</td>
                    
                     <td><a href="{{url('edit/investment/'.$customer['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
                  </tr>

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
  