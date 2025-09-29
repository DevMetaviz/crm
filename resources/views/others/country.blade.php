
@extends('layout.master')
@section('title', 'Country Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Country Configuration</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
             
              <li class="breadcrumb-item active">Country</li>
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
                <h3 class="card-title">Countries</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                   
                   

                   <div class="col-md-12">
                        
                        <fieldset class="border p-4">
                   <legend class="w-auto">Add New Country</legend>

                    <form role="form" method="post" action="{{url('/configuration/country/save')}}">

                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                

                <label>Country</label>
                <input type="text" name="name" class="" required="true" />

                <label>Description</label>
                <textarea name="description" class=""></textarea>
               
               <label>Sort Order</label>
                <input type="number" name="sort_order" class="" min="1" value="1" required="true" />

                  <input type="checkbox" name="activeness" value="1" id="activeness" class=""  checked>
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
                    <th>Name</th>
                    <th>Description</th>
                     <th>Sort Order</th>
                    <th>Status</th>
                  </tr>

            
                    @foreach($countries as $country)
                      
                        <tr>
                   
                     
                     <td>{{$country['id']}}</td>
                     <td>{{$country['name']}}</td>
                    <td>{{$country['description']}}</td>
                
                    <td>{{$country['sort_order']}}</td>
                    <td>{{$country['activeness']}}</td>
                     
                   
                    
                 
                   
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
  