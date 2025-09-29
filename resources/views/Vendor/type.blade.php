
@extends('layout.master')
@section('title', 'Vendors Type Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Vendors Type Configuration</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item"><a href="#">Vendors</a></li>
              <li class="breadcrumb-item active">Type</li>
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
                <h3 class="card-title">Vendors Type</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                   
                   

                   <div class="col-md-12">
                        
                        <fieldset class="border p-4">
                   <legend class="w-auto">Add New Vendor Type</legend>

                    <form role="form" method="post" action="{{url('/configuration/vendor/type/save')}}">

                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                

                <label>Text</label>
                <input type="text" name="text" class="" required="true" />

                <label>Description</label>
                <textarea name="description" class=""></textarea>
               
               <label>Sort Order</label>
                <input type="number" name="sort_order" class="" value="1" required="true" />

                  <input type="checkbox" name="status" value="1" id="status" class=""  checked>
                  <label>Active</label>

                

                <input type="submit" name="" value="Add">
                       </fieldset>

                  </form>
                     
                   </div>

                </div>

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
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
                    <th>Text</th>
                    <th>Description</th>
                     <th>Sort Order</th>
                    <th>Status</th>
                    <th></th>
                  </tr>

            
                    @foreach($vendor_types as $type)
                      
                        <tr>
                   
                     
                     <td>{{$type['id']}}</td>
                     <td>{{$type['text']}}</td>
                    <td>{{$type['description']}}</td>
                
                    <td>{{$type['sort_order']}}</td>
                    <td>{{$type['status']}}</td>
                     
                   <td><a href="{{url('/configuration/vendor/type/edit/'.$type['id'])}}"><span class="fa fa-edit"></span></a></td>
                    
                 
                   
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
  