
@extends('layout.master')
@section('title','Attendance Update')
@section('header-css')
<style type="text/css">
  .alert-success {
     color: #155724; 
    background-color: #d4edda;
    /*border-color: #c3e6cb;*/
}
</style>
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
    <form role="form" method="POST" action="{{url('/attendance/update/'.$attendance['id'])}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Attendance Update</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="#" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Attendance</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

<style type="text/css">
  .alert-inline{
              display: inline;
              color: #d32535;
              background-color:transparent ;
              border:none;padding: .7rem 4rem 0rem 0rem;
     }
</style>
    
      <div class="container-fluid" style="margin-top: 10px;">

            @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

             
                       @if ($errors->has('msg'))
                                    
                      <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('msg') }}
                                          </div>

                                          <div class="alert alert-danger alert-dismissible alert-inline">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                       {{ $errors->first('msg') }}
                                          </div>
  
                                @endif
     <input type="hidden" value="{{$attendance['id']}}" name="id"/>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>ZK Id<span class="text-danger">*</span></label>
                  <input type="text" name="zk_id" class="form-control select2" readonly="true" value="{{$attendance['name']}}" required style="width: 100%;">
                 
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Employee Name</label>
                  <input type="text" name="employee_name" class="form-control select2" readonly="true" value="{{$attendance['employee']['name']}}" style="width: 100%;">
                  </div>
                <!-- /.form-group -->
               

                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control select2" name="status" id="status" required="true" style="width: 100%;">
                    <option value="C/In">C/In</option>
                    <option value="C/Out">C/Out</option>
                  </select>
                </div>

               
                  

               
                
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                
                  <div class="form-group">
                  <label>Date</label>
                  <input type="date" name="date" value="{{$attendance['date']}}" required="true" class="form-control select2" style="width: 100%;">
                  </div>
                            
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Time</label>
                  <input type="time" name="time" value="{{$attendance['time']}}" required="true" class="form-control select2" style="width: 100%;">
                  </div>

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->




                   



        
      </div>

      </form>
    <!-- /.content -->
   
@endsection

@section('jquery-code')
<script type="text/javascript">

$(document).ready(function(){


value1="{{$attendance['status'] }}"
   
   if(value1!="")
   {
    
  $('#status').find('option[value="{{$attendance['status']}}"]').attr("selected", "selected");
   
   }

})


</script>

@endsection  
  