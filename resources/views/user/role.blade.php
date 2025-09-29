
@extends('layout.master')
@section('title', 'User Role')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('/configuration/role/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">User Role</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('inventory/Add')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Role</a></li>
              <li class="breadcrumb-item active">Add</li>
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
                <h3 class="card-title">Add New Role</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                
                
                <div class="col-md-6 form-row">

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Text</label>
                  <input type="text" form="ticket_form" name="name" class="form-control select2 col-sm-8"  required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Sort Order</label>
                  <input type="number" min="1" value="1" form="ticket_form" name="sort_order" class="form-control select2 col-sm-8" required style="width: 100%;">
                  </div>
                 </div>

                

                

                  
                 <div class="col-sm-12">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" form="ticket_form" name="activeness" value="active" id="activeness" class=""  checked>&nbsp&nbspActive</label>
                  </div>
                </div> 

               

               </div>
 

                 

                <table id="example1" class="table table-bordered table-hover" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>Id</th>
                    <th>Text</th>
                    <th>Sort Order</th>
                    <th>Active</th>
                   
                    <th></th>
                  </tr>

                  @if(isset($roles))
                    @foreach($roles as $role)
                      
                        <tr>
                   
                     
                     <td>{{$role['id']}}</td>
                      <td>{{$role['name']}}</td>
                     <td>{{$role['sort_order']}}</td>
                    <td>{{$role['activeness']}}</td>
                  
                    <td></td>
                     
                   
                    
                 
                   
                  </tr>

                    @endforeach
                  @endif
                  
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

            </form>        



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')







@endsection  
  