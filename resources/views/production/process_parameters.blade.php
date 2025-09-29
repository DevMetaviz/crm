
@extends('layout.master')
@section('title', 'Process Parameters Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" action="{{url('save/configuration/production/process/parameters')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Process Parameters Configuration</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
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
                <h3 class="card-title">Process Parameters</h3>
              
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
                  <input type="text" name="name" class="form-control select2" required style="width: 100%;">
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
                  <input type="text" name="identity" class="form-control select2" required style="width: 100%;">
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
                   <select class="form-control select2" name="process_id" id="process_id" style="width: 100%;" onchange="setParameters()" required>
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
                  <input type="text"  name="formula" class="form-control select2" style="width: 100%;">
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

              <div class="col-md-4">

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
                  
                 
            
                    @foreach($parameters as $parameter)
                      
                        <tr>
                   
                     
                     <td>{{$parameter['id']}}</td>
                     <td>{{$parameter['name']}}</td>
                     <td>{{$parameter['identity']}}</td>
                     <td>{{$parameter['parameterable']['process_name']}}</td>
                     <td>{{$parameter['parameterable']['identity']}}</td>
                     <td>{{$parameter['type']}}</td>
                     <td>{{$parameter['formula']}}</td>
                    <td>{{$parameter['sort_order']}}</td>
                    <td>{{$parameter['description']}}</td>
                
                    <td>{{$parameter['activeness']}}</td>
                      <td><a href="{{url('configuration/production/process/parameter/edit/'.$parameter['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
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
  
  function setParameters()
  {
    
    var process_id=$("#process_id option:selected").val();

    
    

    $.ajax({
               type:'get',
               url:'{{ url("/get/process/parameters") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                     process_id: process_id ,
                                   },
               success:function(data) {

              
                var parameters=data;

                 
                

                    all = ``;

                    for (var i =0;i < parameters.length ; i ++) {
                      
                      

                      var remarks='';
                      if(parameters[i]['description']!=null)
                      {
                        remarks=parameters[i]['description'];
                      }

                      var proces='';
                      if(parameters[i]['parameterable']!=null)
                      {
                        proces=parameters[i]['parameterable']['process_name'];
                      }

                      var link='{{ url("configuration/production/process/parameter/edit/") }}' +'/'+ parameters[i]['id'] ;
                      
                      txt  = `
                         <tr>
                           <td>${parameters[i]['id']}</td>
                           <td>${parameters[i]['name']}</td>
                           <td>${parameters[i]['identity']}</td>
                           <td>${proces}</td>
                           <td>${parameters[i]['parameterable']['identity']}</td>
                           <td>${parameters[i]['type']}</td>
                           <td>${parameters[i]['formula']}</td>
                           <td>${parameters[i]['sort_order']}</td>
                           <td>${remarks}</td>
                           <td>${parameters[i]['activeness']}</td>
                           <td><a  href="${link}"><span class="fa fa-edit"></span></a></td>
                         </tr>
                      `;

                      all=all.concat(txt);
                    }
                   
                   //alert(sub_accounts);
                 $('#parameters_body').html(all);
                 



               }
             });

  }


</script>





@endsection  
  