
@extends('layout.master')
@section('title', 'Menu')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('/configuration/menu/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Menu</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('inventory/Add')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Menu</a></li>
              <li class="breadcrumb-item active">Menu Items</li>
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
                <h3 class="card-title">Add New Menu Item</h3>
              
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
                  <input type="text" form="ticket_form" name="text" class="form-control select2 col-sm-8"  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Link</label>
                  <input type="text" form="ticket_form" name="link" class="form-control select2 col-sm-8"  required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Super Menu</label>
                  <select form="ticket_form" name="super_menu_id" class="form-control select2 col-sm-8" style="width: 100%;">
                  <option value="0" >Select Super Menu Item</option>
                    @foreach($menu as $me)
                    <option value="{{$me['id']}}" >{{$me['text']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">type</label>
                  <select form="ticket_form" name="type" class="form-control select2 col-sm-8" style="width: 100%;">
                    <option value="" >Select</option>
                  <option value="menu" >Menu Item</option>
                  </select>
                  </div>
                 </div>

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Sort Order</label>
                  <input type="number" min="1" value="1" form="ticket_form" name="sort_order" class="form-control select2 col-sm-8" required style="width: 100%;">
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
                    <th>Type</th>
                    <th>Link</th>
                    <th>Sub Menu</th>
                    <th>Sort Order</th>
                    <th>Active</th>
                   
                    <th></th>
                  </tr>

                  @if(isset($menu))
                    @foreach($menu as $role)
                      
                        <tr>
                   
                     
                     <td>{{$role['id']}}</td>
                      <td>{{$role['text']}}</td>
                      <td>{{$role['type']}}</td>
                         <td>{{$role['link']}}</td>
                         <td></td>
                     <td>{{$role['sort_order']}}</td>
                    
                    <td>{{$role['active']}}</td>
                  
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

 

                 

                <table id="example2" class="table table-bordered table-hover" style="">
                  
                  <thead>
                    <tr>
                      <th colspan="7">Purchase</th>
                    </tr>
                  
                <tr>
                    <th>#</th>
                    <th>Text</th>
                    <th>Create</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Approve</th>
                    <th>Delete</th>
                  
                 
                  </tr>


                  </thead>
                  <tbody>
                  
                 

                                  
                        <tr>
                   
                     <td>1</td>
                      <td>Demand</td>
                      <td><input type="checkbox" name=""></td>
                         <td><input type="checkbox" name=""></td>
                         <td><input type="checkbox" name=""></td>
                     <td><input type="checkbox" name=""></td>
                    
                    <td><input type="checkbox" name=""></td>
                                       
                  </tr>

                  <tr>
                   
                     <td>2</td>
                      <td>Order</td>
                      <td><input type="checkbox" name=""></td>
                         <td><input type="checkbox" name=""></td>
                         <td><input type="checkbox" name=""></td>
                     <td><input type="checkbox" name=""></td>
                    
                    <td><input type="checkbox" name=""></td>
                                       
                  </tr>

                  <td>3</td>
                      <td>GRN</td>
                      <td><input type="checkbox" name=""></td>
                         <td><input type="checkbox" name=""></td>
                         <td><input type="checkbox" name=""></td>
                     <td><input type="checkbox" name=""></td>
                    
                    <td><input type="checkbox" name=""></td>
                                       
                  </tr>

                  <td>4</td>
                      <td>Purchase</td>
                      <td><input type="checkbox" name=""></td>
                         <td><input type="checkbox" name=""></td>
                         <td><input type="checkbox" name=""></td>
                     <td><input type="checkbox" name=""></td>
                    
                    <td><input type="checkbox" name=""></td>
                                       
                  </tr>


                
                  
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
  