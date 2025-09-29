
@extends('layout.master')
@section('title', 'Loan Requests')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Loan Request History</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('loan/request')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Loan Request</a></li>
              <li class="breadcrumb-item active">History</li>
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
                    <th>#</th>
                    <th>Request No</th>
                    <th>Request Date</th>
                    <th>Loan Type</th>
                    <th>Loan Amount</th>
                    <th>Employee</th>
                    <th>Active</th>
                    <th>Approved Amount</th>
                    <th>Authorized By</th>
                    <th>Paid</th>
                    <th>Status</th>
                    <th></th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $loans) ; $i++)

                   
                      
                        <tr>
                   
                     
                     <td>{{$i+1}}</td>
                     <td>{{$loans[$i]['doc_no']}}</td>
                     <td>{{$loans[$i]['request_date']}}</td>
                    <td>{{$loans[$i]['loan_type']}}</td>
                     <td>{{$loans[$i]['loan_amount']}}</td>
                      <td>{{$loans[$i]['employee']['name']}}</td>
                     <td>
                      @if($loans[$i]['activeness']=='1')
                      <span class="badge badge-info">
                         @elseif($loans[$i]['activeness']=='0')
                        <span class="badge badge-danger">
                          @endif
                     {{$loans[$i]->activeness()}}
                      </span>
                     </td>
                     <td>{{$loans[$i]['approved_amount']}}</td>
                     <td>@if($loans[$i]['authorizedBy']!=''){{$loans[$i]['authorizedBy']['name']}}@endif</td>
                     <td>
                      @if($loans[$i]['is_paid']=='1')
                      <span class="badge badge-info">
                         @elseif($loans[$i]['is_paid']=='0')
                        <span class="badge badge-warning">
                          @endif
                      {{$loans[$i]->is_paid()}}
                      </span>
                     </td>
                     <td>
                      @if($loans[$i]['status']=='0')
                      <span class="badge badge-warning">
                         @elseif($loans[$i]['status']=='1')
                        <span class="badge badge-success">
                          @elseif($loans[$i]['status']=='2')
                        <span class="badge badge-danger">
                          @endif
                      {{$loans[$i]->status()}}
                    </span>
                    </td>
                    <td><a href="{{url('edit/loan/request/'.$loans[$i]['doc_no'])}}"><span class="fa fa-edit"></span></a></td>
                     
                    </tr>
                   <!--  <tr><td colspan="8"></td></tr> -->

                    @endfor
                
                  
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
  