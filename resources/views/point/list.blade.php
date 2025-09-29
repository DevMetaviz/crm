
@extends('layout.master')
@section('title', 'Point List')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Point List</h1>
            <a class="btn" href="{{url('point/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Point</a></li>
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
                    <th>Name</th>
                    <th>Distributor</th>
                    <th>Salesman</th>
                    <th>Doctor</th>
                    <th>Mobile</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                  
                    <th>Active</th>
                    <th></th>
                  </tr>

                  
            
                    @foreach($points as $customer)
                      
                        <tr>
                   
                     
                     <td>{{$customer['id']}}</td>
                     <td>{{$customer['name']}}</td>
                     <td>@if(isset($customer['distributor'])){{$customer['distributor']['name']}}@endif</td>
                     <td>@if(isset($customer['salesman'])){{$customer['salesman']['name']}}@endif</td>
                     <td>@if(isset($customer['doctor'])){{$customer['doctor']['name']}}@endif</td>
                     <td>{{$customer['mobile']}}</td>
                     <td>{{$customer['phone']}}</td>
                     <td>{{$customer['email']}}</td>
                    <td>{{$customer['address']}}</td>
                    
                     <?php $active='Active';
                            if($customer['activeness']=='0')
                             $active='Inactive';
                             ?>
                     <td>{{$active}}</td>
                    
                     <td><a href="{{url('edit/point/'.$customer['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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
  