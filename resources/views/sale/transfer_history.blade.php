
@extends('layout.master')
@section('title', 'Stock Transfer History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Stock Transfer List</h1>
            <a class="btn" href="{{url('stock/transfer')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
              <li class="breadcrumb-item active">Stock Transfer</li>
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
                <h3 class="card-title">Stock Transfer</h3>
              
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
                    <th>Transfer No</th>
                    <th>Transfer Date</th>
                    <th>Delivery No</th>
                    <th>Delivery Date</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Total Qty</th>
                    <th>Active</th>
                    <th></th>
                  </tr>

                  
            
                    @foreach($transfers as $sale)
                      
                        <tr>
                   
                     
                     <td>{{$sale['id']}}</td>
                     <td>{{$sale['doc_no']}}</td>
                     <td>{{$sale['doc_date']}}</td>
                     <td></td>
                     <td></td>
                    <td>{{$sale['from_customer']['name']}}</td>
                    <td>{{$sale['to_customer']['name']}}</td>
                     <td></td>
                     <?php $active='Active';
                            if($sale['activeness']=='0')
                             $active='Inactive';
                             ?>
                     <td>{{$active}}</td>
                    
                     <td><a href="{{url('edit/stock/transfer/'.$sale['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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
  