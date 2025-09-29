
@extends('layout.master')
@section('title', 'Departments Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" action="{{url('save/configuration/departments')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Departments Configuration</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('inventory/Add')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Departments</li>
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
                <h3 class="card-title">Departments</h3>
              
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
                   <legend class="w-auto">Add New Department</legend>

                    
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                <div class="row">
                    <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Department :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                  <input type="text" name="department" class="form-control select2" required style="width: 100%;">
                  </div>
                </div>
                </div>

              </div>
              <!-- <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Code :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                  <input type="text" name="code" class="form-control select2" required style="width: 100%;">
                  </div>
                </div>
                </div>

              </div> -->

              <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Sort Order :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                  <input type="number" min="1" value="1" name="sort_order" class="form-control select2" required style="width: 100%;">
                  </div>
                </div>
                </div>

              </div>

              <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Remarks :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                    <textarea name="description" class="form-control select2"></textarea>
                     <input type="checkbox" name="activeness" value="active" id="activeness" class=""  checked>
                  <label>Active</label>
                  </div>
                </div>
                </div>

              </div>

            </div>

                

                
                
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
                    
                   <th>Sort Order</th>
                    <th>Description</th>
                    <th>Active</th>
                  </tr>

            
                    @foreach($departments as $depart)
                      
                        <tr>
                   
                     
                     <td>{{$depart['id']}}</td>
                     <td>{{$depart['name']}}</td>
                  
                    <td>{{$depart['sort_order']}}</td>
                    <td>{{$depart['description']}}</td>
                
                    <td>{{$depart['activeness']}}</td>
                     
                   
                    
                 
                   
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
  