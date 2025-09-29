
@extends('layout.master')
@section('title', $category.' History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="text-capitalize" style="display: inline;">{{$category}} List</h1>
            <a class="btn" href="{{url('voucher/'.$category.'/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item text-capitalize"><a href="#">{{$category}}</a></li>
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
                <h3 class="card-title text-capitalize">{{$category}}</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif



          <form method="GET" action="{{ url('voucher/'.$category.'/list') }}" class="">
             <div class="row">



        <div class="col-md-6">
             <label>Company</label>
           <select name="company_id" class="form-control" >
           
              <option value="">All</option>

              @foreach($companies as $comp)
              <option value="{{ $comp->id }}" @if(request('company_id')==$comp['id']) selected @endif >{{ $comp->name }}</option>  
              @endforeach
            </select>
        </div>


        <?php

                $branches=[];

                if(request('company_id')>0)
                {
                  $index = $companies->search(fn($item) => $item->id == 1);
                   $branches=$companies[$index]['branches'];
                }


         ?>

        <div class="col-md-6">
             <label>Branch</label>
           <select name="branch_id" class="form-control" >
           
              <option value="">All</option>
              
              @foreach($branches as $comp)
              <option value="{{ $comp->id }}" @if(request('branch_id')==$comp['id']) selected @endif >{{ $comp->name }}</option>  
              @endforeach
                  
              
            </select>
        </div>


         <div class="col-md-6">
                    <div class="form-group">
                  <label>From</label>
                  <input type="date" class="form-control"  name="from" id="from" value="@if(isset($from)){{$from}}@endif" >
                </div>
              </div>

              <div class="col-md-6">
                    <div class="form-group">
                  <label>To</label>
                  <input type="date" class="form-control"  name="to" id="to"  value="@if(isset($to)){{$to}}@endif" >
                </div>
              </div>

               <div class="col-md-6">
                    <div class="form-group">
                  <label>Voucher No</label>
                  <input type="text" class="form-control"  name="doc_no" id="doc_no"  value="{{ request('doc_no') }}" >
                </div>
              </div>


              <div class="col-md-6">
             <label>Status</label>
           <select name="status" class="form-control" >
           
                <option value=""  >All</option>
              <option value="0" @if(request('status')==0 && request('status')!='' ) selected @endif >Unpost</option>  
              <option value="1" @if(request('status')==1) selected @endif >Post</option>
                
              
            </select>
        </div>


        <div class="col-md-6">
             <label>Sort By</label>
           <select name="sort_by" class="form-control" >
           
              
              <option value="updated_at" @if(request('sort_by')=='updated_at') selected @endif >Update Date</option>
               <option value="created_at" @if(request('sort_by')=='created_at') selected @endif >Create Date</option> 
               <option value="doc_no" @if(request('sort_by')=='doc_no') selected @endif >Voucher No</option>
               <option value="doc_date" @if(request('sort_by')=='doc_date') selected @endif >Voucher Date</option>     
              
            </select>
        </div>


     
        
        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
        

    </div>
    </form>
               

                

              <div class="table-responsive p-0" style="height: 400px;">
                <table id="example1" class="table table-bordered table-hover mt-4 table-head-fixed text-nowrap" style="">
                  
                  <thead>
                  
                 <tr>
                    <th>#</th>
                    <th>Voucher No</th>
                    <th>Voucher Date</th>
                     <th>Pay Method</th>
                     <th>Cheque No</th>
                    <th>Amount</th>
                    
                    <th>Status</th>
                    <th>Created By</th>
                     <th>Created At</th>
                    <th>Updated By</th>
                     <th>Updated At</th>
                    <th></th>
                  </tr>



                  </thead>
                  <tbody>
                  
                
                  
                   <?php $i=1;  ?>
                    @foreach($vouchers as $order)
                      
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                     
                     <td><a href="{{url('voucher/'.$category.'/'.$order['id'].'/view')}}">{{$order['doc_no']}}</a></td>
                    <td>{{$order['doc_date']}}</td>
                    <td>{{$order['pay_method']}}</td>
                     <?php $let=$order['accounts']->where('pivot.credit','<>','0')->first();  ?>
                    <td>{{$let['pivot']['cheque_no']}}</td>
                     <td>{{number_format($order->amount(),2)}}</td>
                  
                     <?php $status='';
                            if($order['status']=='1')
                             $status='Post';
                           elseif($order['status']=='0')
                             $status='Unpost';
                             ?>
                     <td>{{$status}}</td>
                      <td>@if(isset($order['user'])){{ $order['user']['name'] }}@endif</td>

                      <td>@if($order['created_at']!=''){{date('d-m-Y h:i a',strtotime($order['created_at']))}}@endif</td>

                      <td>@if(isset($order['last_updated_by'])){{ $order['last_updated_by']['name'] }}@endif</td>

                      <td>@if($order['updated_at']!=''){{date('d-m-Y h:i a',strtotime($order['updated_at']))}}@endif</td>
                    
                     <td><a href="{{url('voucher/'.$category.'/'.$order['id'].'/view')}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')







@endsection  
  