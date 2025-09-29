
@extends('layout.master')
@section('title', 'Delivery Challan History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Delivery Challan List</h1>
            <a class="btn" href="{{url('delivery-challan/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('delivery-challan/history?status=1')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Pending Invoices</a>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
              <li class="breadcrumb-item active">Delivery Challans</li>
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
                <h3 class="card-title">Delivery Challan</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

               

                
               <div class="table-responsive p-0" style="height: 400px;">
              
                <table id="example1" class="table table-bordered table-hover mt-4 table-head-fixed text-nowrap" style="">
                  
                  <thead>
                  
                  <tr>
                    <th>Id</th>
                    <th>Doc No</th>
                    <th>Delivery Date</th>
                    <th>Order No</th>
                    <th>Order Date</th>
                    <th>Customer</th>
                    <th>Total Qty</th>
                    <th>Total Weight</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Action</th>
                  </tr>


                  </thead>
                  <tbody>
                  
                 

                  
                  <?php $i=1; ?>
                    @foreach($challans as $challan)
                      
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                     <td><a href="{{url('edit/delivery-challan/'.$challan['id'])}}">{{$challan['doc_no']}}</a></td>
                     <td>{{$challan['challan_date']}}</td>
                     <td>@if(isset($challan['order'])){{$challan['order']['doc_no']}}@endif</td>
                     <td>@if(isset($challan['order'])){{$challan['order']['order_date']}}@endif</td>
                    <td>{{$challan['customer']['name']}}</td>
                     <td>{{$challan->total_quantity()}}</td>
                     <td>{{$challan->total_weight()}}</td>
                     <?php $s=$challan['sale_invoice'];
                            
                             ?>
                     <td>
                       @if($challan['status']==0)
                       <span class="badge badge-warning">Draft</span>
                       @elseif($challan['status']==1)
                          @if($s=='')
                          <span class="badge badge-primary">Pending Invoice</span>
                           @else
                           <span class="badge badge-success">Delivered</span>
                          @endif
                       @endif
                     
                    </td>

                     <td>@if($challan['user']){{$challan['user']['name']}}@endif</td>
                    
                     <td>

                      @if($s=='' && $challan['status']==1)
                       <a class="btn btn-info btn-sm" href="{{url('sale/create?challan='.$challan['id'])}}">Invoice</a>
                      @endif
                      <a href="{{url('edit/delivery-challan/'.$challan['id'])}}"><span class="fa fa-edit"></span></a>
                    </td>
                   
                    
                 
                   
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
  