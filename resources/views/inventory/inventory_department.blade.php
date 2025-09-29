
@extends('layout.master')
@section('title', 'Inventory Department Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" action="{{url('configuration/inventory/department/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Inventory Department Configuration</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('inventory/Add')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Inventory Department</li>
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
                <h3 class="card-title">Inventory Department</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

                <div class="row">
                   
                   

                   <div class="col-md-12">
                        
                        <fieldset class="border p-4">
                   <legend class="w-auto">Add New Inventory Department</legend>

                    
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                <div class="row">
                 <div class="col-md-6 form-row">

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Department :<span class="text-danger">*</span>&nbsp</label>
                 <input type="text" name="name" class="form-control col-sm-8" required >  
                  </div>
                 </div>

               <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Code :<span class="text-danger">*</span>&nbsp</label>
                 <input type="text" name="code" class="form-control col-sm-8" required >  
                  </div>
                 </div>

             
              <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Sort Order :<span class="text-danger">*</span>&nbsp</label>
                 <input type="number" min="1" value="1" name="sort_order" class="form-control col-sm-8" required >  
                  </div>
                 </div>

                
                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Remarks :</label> 
                 <textarea name="description" class="form-control col-sm-8"></textarea>

                  </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" name="status" value="1" id="status" class="" checked>&nbsp&nbspActive</label>
                  </div>
                </div>


                         
               </div><!--end col-->

               <div class="col-md-6 form-row">

                <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Account:<span class="text-danger">*</span>&nbsp</label>
                  <select name="account_id" id="account_id" class="form-control select2 col-sm-8" required>
                    <option value="">Select any value</option>
                    @foreach($accounts as $ac)
                    <option value="{{$ac['id']}}">{{$ac['name'].'~'.$ac['code']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                  <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">CGS Account:<span class="text-danger">*</span>&nbsp</label>
                  <select name="cgs_account_id" id="cgs_account_id" class="form-control select2 col-sm-8" required>
                    <option value="">Select any value</option>
                    @foreach($accounts as $ac)
                    <option value="{{$ac['id']}}">{{$ac['name'].'~'.$ac['code']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-sm-4">Sale Account:</label>
                  <select name="sale_account_id" id="sale_account_id" class="form-control select2 col-sm-8" >
                    <option value="">Select any value</option>
                    @foreach($accounts as $ac)
                    <option value="{{$ac['id']}}">{{$ac['name'].'~'.$ac['code']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>


                 </div><!--end col-->

            </div><!--end row-->

                

                
                
                       </fieldset>

                  </form>
                     
                   </div>

                </div>

                

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>Id</th>
                    <th>Department</th>
                    <th>Code</th>
                   <th>Sort Order</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th></th>
                  </tr>

            
                    @foreach($departments as $depart)
                      
                        <tr>
                   
                     
                     <td>{{$depart['id']}}</td>
                     <td>{{$depart['name']}}</td>
                    <td>{{$depart['code']}}</td>
                    <td>{{$depart['sort_order']}}</td>
                    <td>{{$depart['description']}}</td>
                
                    <td>
                      @if($depart['status']==1)
                    Active
                    @else
                    Inactive
                    @endif

                    </td>
                     <td><a href="{{url('configuration/inventory/department/edit/'.$depart['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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
  