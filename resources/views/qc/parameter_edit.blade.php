
@extends('layout.master')
@section('title', 'Edit Item Parameters')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" action="{{url('update/configuration/inventory/parameter')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Edit Item Parameters</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('/configuration/inventory/parameters')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
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
                <h3 class="card-title">Edit Item Parameter</h3>
              
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
                  <label>Item:<span class="text-danger">*</span>&nbsp</label>
                  </div>
                  <div>
                   <select class="form-control select2" name="item_id" id="item_id" required style="width: 100%;">
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
                  <input type="number" min="1" value="{{$parameter['sort_order']}}" name="sort_order" class="form-control select2" required style="width: 100%;">
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
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>Id</th>
                    <th>Parameter</th>
                    <th>Items</th>
                    <th>Process</th>
                   <th>Sort Order</th>
                    <th>Description</th>
                    <th>Active</th>
                    <th>Action</th>
                  </tr>

            
                    @foreach($parameters as $pr)
                      
                        <tr>
                   
                     
                     <td>{{$pr['id']}}</td>
                     <td>{{$pr['name']}}</td>
                     

                      <td>
                     @if($pr['process'])
                     {{$pr['item']['item_name']}}
                     @else
                     {{$pr['parameterable']['item_name']}}
                     @endif
                   </td>
                     <td>@if($pr['process']){{$pr['process']['process_name']}}@endif</td>

                    <td>{{$pr['sort_order']}}</td>
                    <td>{{$pr['description']}}</td>
                
                    <td>{{$pr['activeness']}}</td>
                      <td><a href="{{url('configuration/inventory/parameter/edit/'.$pr['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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

<script type="text/javascript">
  
  $(document).ready(function(){
  
   process_id=<?php echo json_encode($parameter['process_id']); ?> ;
   $('#process_id').val(process_id);
            //alert(process_id);
var item_id = '';
    if(process_id!='')
    {      item_id=<?php echo json_encode($parameter['item_id']); ?> ;
     }
 value=<?php echo json_encode($parameter['parameterable']); ?> ;
     if(value)
     {  item_id=value['id'] ; 
         }

   $('#item_id').val(item_id);

   

   
    value=<?php echo json_encode($parameter['activeness']); ?> ;
    if(value=="active")
   {
    
  $('#activeness').prop("checked", true);
   
   }
    else{
      $('#activeness').prop("checked", false);
  
    } 

   
});

</script>





@endsection  
  