
@extends('layout.master')
@section('title', 'Edit Process Parameters')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" action="{{url('update/configuration/production/process/parameter')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Edit Process Parameters</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="submit" form="delete_form" style="border: none;background-color: transparent;"><span class="fas fa-trash">&nbsp</span>Delete</button>
            <a class="btn" href="{{url('configuration/production/process/parameters')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Process Parameters</li>
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
                <h3 class="card-title">Edit Process Parameter</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             @if ($errors->has('error'))
                                    
                      <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('error') }}
                                          </div>  
                                @endif

                <div class="row">
                   
                   

                   <div class="col-md-12">
                        
                        <fieldset class="border p-4">
                   <legend class="w-auto">Edit Parameter</legend>

                    
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                  <input type="hidden" value="{{$parameter['id']}}" name="parameter_id"/>

                <div class="row">
                    <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Parameter :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                  <input type="text" name="name" value="{{$parameter['name']}}" class="form-control select2" required style="width: 100%;">
                  </div>
                </div>
                </div>

              </div>
              
              <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Identity :<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                  <input type="text" name="identity" value="{{$parameter['identity']}}" class="form-control select2" required style="width: 100%;">
                  </div>
                </div>
                </div>

              </div> 


              <div class="col-md-4">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Process:<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                   <select class="form-control select2" name="process_id" id="process_id" required style="width: 100%;">
                    <option value="">------Select any process-----</option>
                    @foreach($processes as $pr)
                    <option value="{{$pr['id']}}">{{$pr['identity']}}</option>
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
                  <label>Type:<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                   <select class="form-control select2" name="type" id="type" style="width: 100%;" required>
                    <option value="">------Select any value-----</option>
                    <option value="text">Text</option>
                    <option value="long_text">Long Text</option>
                    
                    <option value="number">Number</option>
                    <option value="date">Date</option>
                    <option value="time">Time</option>
                    <option value="datetime-local">Date & Time</option>
                    <option value="checkbox">Choice</option>
                    <option value="radio">Choice(Multiple)</option>
                    <option value="formula_text">Formula(Value)</option>
                    <option value="formula_show">Formula(Show)</option>
                  </select>
                  </div>
                </div>
                </div>
              </div>

              <div class="col-md-3">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Formula:<span class="text-danger"></span>&nbsp</label>
                  </div>
                  <div>
                  <input type="text"  name="formula" class="form-control select2" value="{{$parameter['formula']}}" style="width: 100%;">
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
                  <input type="number" min="1" value="{{$parameter['sort_order']}}" name="sort_order" class="form-control select2" required style="width: 100%;">
                  </div>
                </div>
                </div>

              </div>

              <div class="col-md-4">

                <div class="form-group">
                  <div class="row">
                    <div>
                  <label>Remarks :</label>
                  </div>
                  <div>
                    <textarea name="description" class="form-control select2">{{$parameter['description']}}</textarea>
                     <input type="checkbox" name="activeness" value="active" id="activeness" class="">
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
                  
                 <tr>
                    <th>Id</th>
                    <th>Parameter</th>
                    <th>Identity</th>
                    <th>Process</th>
                    <th>Process Identity</th>
                    <th>Type</th>
                    <th>Formula</th>
                   <th>Sort Order</th>
                    <th>Description</th>
                    <th>Active</th>
                    <th>Action</th>
                  </tr>


                  </thead>
                  <tbody id="parameters_body">
                  
                 

            
                    @foreach($parameters as $pr)
                      
                        <tr>
                   
                     
                     <td>{{$pr['id']}}</td>
                     <td>{{$pr['name']}}</td>
                     <td>{{$pr['identity']}}</td>
                     <td>{{$pr['parameterable']['process_name']}}</td>
                     <td>{{$parameter['parameterable']['identity']}}</td>
                     <td>{{$pr['type']}}</td>
                     <td>{{$pr['formula']}}</td>
                    <td>{{$pr['sort_order']}}</td>
                    <td>{{$pr['description']}}</td>
                
                    <td>{{$pr['activeness']}}</td>
                      <td><a href="{{url('configuration/production/process/parameter/edit/'.$pr['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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


<form role="form" id="delete_form" method="POST" action="{{url('configuration/production/process/parameter/delete/'.$parameter['id'])}}">
               
               @csrf    
    </form>
                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script type="text/javascript">
  
  $(document).ready(function(){
  
   
    process_id=<?php echo json_encode($parameter['parameterable']['id']); ?> ;

   $('#process_id').val(process_id);
   
    value=<?php echo json_encode($parameter['activeness']); ?> ;
    if(value=="active")
   {
    
  $('#activeness').prop("checked", true);
   
   }
    else{
      $('#activeness').prop("checked", false);
  
    } 


    type=<?php echo json_encode($parameter['type']); ?> ;

   $('#type').val(type);

   
});

</script>





@endsection  
  