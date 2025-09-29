
@extends('layout.master')
@section('title', 'Import Sale')
@section('header-css')

  
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Import Sale</h1>
           <!--  <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button> -->
           <!--  <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <button type="button" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</button> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Sale</a></li>
              <li class="breadcrumb-item active">Import</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

        @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

          

         <div class="card">
              <div class="card-header">
                   <h4>Upload</h4>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              
                   <form role="form" method="post" action="{{url('/import/sale')}}" enctype="multipart/form-data" >
                    <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                      <label>Upload File</label>
                      <input type="file" name="sheet">
                      <input type="submit" name="">
                   </form>

              
                  
                  
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

  

})


</script>




@endsection  
  