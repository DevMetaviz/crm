
@extends('layout.master')
@section('title', 'Invoice Return History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Invoice Return History</h1>
           <!--  <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button> -->
            <a class="btn" href="{{url('/purchase/return')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Invoice Return</a></li>
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
                <h3 class="card-title">Invoice Return</h3>
              
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
                    <th>Return No</th>
                    <th>Return Date</th>
                    <th>Purchase No</th>
                    <th>Vendor</th>
                    <th>Qty</th>
                    <th>Weight</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>

                  
            
                    @for($i=0;$i< count( $returns) ; $i++)
                   <?php
                      $post='Unpost';
                      if($returns[$i]['status']=='1')
                        $post='Post';

                      $qty=$returns[$i]->total_qty();
                      $weight=$returns[$i]->total_weight();
                      $total=$returns[$i]->total_amount();
                    ?>
                   
                      
                        <tr>
                   
                     
                     <td>{{$i+1}}</td>
                     <td>{{$returns[$i]['doc_no']}}</td>
                     <td>{{$returns[$i]['doc_date']}}</td>
                     <td>@if($returns[$i]['purchase']!=''){{$returns[$i]['purchase']['doc_no']}}@endif</td>
                     <td>@if($returns[$i]['vendor']!=''){{$returns[$i]['vendor']['name']}}@endif</td>
                     <td>{{$qty}}</td>
                     <td>{{$weight}}</td>
                     <td>{{$total}}</td>
                     <td>{{$post}}</td>
                   
                    <td><a href="{{url('edit/purchase/return/'.$returns[$i]['id'])}}"><span class="fa fa-edit"></span></a></td>
                     
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
  