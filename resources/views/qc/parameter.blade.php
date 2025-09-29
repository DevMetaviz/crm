
@extends('layout.master')
@section('title', 'Parameters Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" action="{{url('save/configuration/inventory/parameters')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Item Parameters Configuration</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('configuration/inventory/parameters')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Item Parameters</li>
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
                <h3 class="card-title">Item Parameters</h3>
              
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
                   <legend class="w-auto">Add New Parameter</legend>

                    
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                <div class="row">
                    <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Parameter :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                  <input type="text" name="name" class="form-control" required style="width: 100%;">
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
                  <input type="text" name="code" class="form-control" required style="width: 100%;">
                  </div>
                </div>
                </div>

              </div> -->

              <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Item:<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                   <select class="form-control select2" name="item_id" id="item_id" style="width: 100%;">
                    <option value="">------Select any item-----</option>
                    @foreach($items as $pr)
                    <option value="{{$pr['id']}}">{{$pr['item_name']}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>
                </div>

              </div>


              <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Process:<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                   <select class="form-control select2" name="process_id" id="process_id" style="width: 100%;">
                    <option value="">------Select any item-----</option>
                    @foreach($processes as $pr)
                    <option value="{{$pr['id']}}">{{$pr['process_name']}}</option>
                    @endforeach
                  </select>
                  </div>
                </div>
                </div>

              </div>

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
                  <label>Remarks :</label>
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
                    <th>Parameter</th>
                    <th>Item</th>
                    <th>Process</th>
                   <th>Sort Order</th>
                    <th>Description</th>
                    <th>Active</th>
                    <th>Action</th>
                  </tr>

            
                    @foreach($parameters as $parameter)
                      
                        <tr>
                   
                     
                     <td>{{$parameter['id']}}</td>
                     <td>{{$parameter['name']}}</td>
                     <td>
                     @if($parameter['process'])
                     {{$parameter['item']['item_name']}}
                     @else
                     {{$parameter['parameterable']['item_name']}}
                     @endif
                   </td>
                     <td>@if($parameter['process']){{$parameter['process']['process_name']}}@endif</td>
                    <td>{{$parameter['sort_order']}}</td>
                    <td>{{$parameter['description']}}</td>
                
                    <td>{{$parameter['activeness']}}</td>
                      <td><a href="{{url('configuration/inventory/parameter/edit/'.$parameter['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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
  