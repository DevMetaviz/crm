
@extends('layout.master')
@section('title', 'Quotation History')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Quotation List</h1>
            <a class="btn" href="{{url('quotation/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
              <li class="breadcrumb-item active">Quotation</li>
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
                <h3 class="card-title">Quotations</h3>
              
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
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Total Qty</th>
                    <th>Active</th>
                    <th></th>
                  </tr>


                  </thead>
                  <tbody>
                  
                
                  
                  <?php $i=1; ?>
                    @foreach($quotations as $challan)
                      
                        <tr>
                   
                     
                     <td>{{$i}}</td>
                     <td><a href="{{url('edit/quotation/'.$challan['id'])}}">{{$challan['doc_no']}}</a></td>
                     <td>{{$challan['doc_date']}}</td>
                    
                    <td>{{$challan['customer']['name']}}</td>
                     <td>{{$challan->total_quantity()}}</td>
                     <?php $active='Active';
                            if($challan['activeness']=='0')
                             $active='Inactive';
                             ?>
                     <td>{{$active}}</td>
                    
                     <td><a href="{{url('edit/quotation/'.$challan['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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
  