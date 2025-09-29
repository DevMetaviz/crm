
@extends('layout.master')
@section('title', 'Sub Category Configuration')
@section('header-css')

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" method="post" action="{{url('configuration/inventory/type/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Sub Category Configuration</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('inventory/Add')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Item Sub Category</li>
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
                <h3 class="card-title">Sub Category</h3>
              
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
                   <legend class="w-auto">Add New Sub Category</legend>

                    
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                <div class="row">

                   <div class="col-md-3">
                <div class="form-group">
                  <label>Category:<span class="text-danger">*</span>&nbsp</label>
                  
                  <select  name="category_id" class="form-control " id="category" onchange="setItemCode()"  required >
                    <option value="">select any value</option>
                    @foreach($categories as $cat)
                     <option value="{{$cat['id']}}">{{$cat['name']}}</option>
                     @endforeach
                  </select>
                </div>
                </div>

                  

               <div class="col-md-3">
                <div class="form-group">
                  <label>Size:<span class="text-danger">*</span>&nbsp</label>
                  
                  <select  name="size_id" id="size_id" class="form-control " required >
                    <option  value="">select any value</option>
                    @foreach($sizes as $cat)
                     <option value="{{$cat['id']}}">{{$cat['name']}}</option>
                     @endforeach
                  </select>
                </div>
                </div>



               <div class="col-md-3">
                <div class="form-group">
                  <label>Shape:<span class="text-danger">*</span>&nbsp</label>
                  
                  <select  name="shape_id" id="shape_id" class="form-control " required >
                    <option  value="">select any value</option>
                    @foreach($shapes as $cat)
                     <option value="{{$cat['id']}}">{{$cat['name']}}</option>
                     @endforeach
                  </select>
                </div>
                </div>

             



              <div class="col-md-3">
                <div class="form-group">
                  <label>Code :<span class="text-danger">*</span>&nbsp</label>
                  <input type="text" name="code" id="code" class="form-control " readonly required style="width: 100%;">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Sub Category:<span class="text-danger">*</span>&nbsp</label>
                  <input type="text" name="name" id="name" class="form-control " readonly required style="width: 100%;">
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
                    <th>Code</th>
                     <th>Category</th>
                    <th>Sub Category Name</th>
                  
                   <th>Shape</th>
                    <th>Size</th>
                   
                  </tr>

            
                    @foreach($types as $type)
                      
                        <tr>
                   
                     
                     <td>{{$type['id']}}</td>
                       <td>{{$type['code']}}</td>
                     <td>{{$type['category']['name']}}</td>
                     <td>{{$type['name']}}</td>
                    <td>{{$type['shape']['name']}}</td>
                    <td>{{$type['size']['name']}}</td>
                                  
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
  
  function updateItemName() {
        let size_id = $("#size_id option:selected").text();
        let shape_id = $("#shape_id option:selected").text();

       

        // Only include if selected (skip default "-- Select --")
        let parts = [];
      
        if ($("#size_id").val()) parts.push(size_id);
        if ($("#shape_id").val()) parts.push(shape_id);

        $("#name").val(parts.join(" "));
    }

    // Run whenever dropdowns change
    $("#size_id, #shape_id").on("change", updateItemName);


function setItemCode()
{
    
    var category=$('#category').val();

    $.ajax({
               type:'get',
               url:'{{ url("/get/sub-category/code") }}',
               data:{
                    
                    // "_token": "{{ csrf_token() }}",
                    
                  
                     category: category,
               },
               success:function(data) {

                item_code=data;
                 
                 $('#code').val(item_code);
                 



               }
             });

}

</script>




@endsection  
  