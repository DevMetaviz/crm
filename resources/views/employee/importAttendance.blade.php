
@extends('layout.master')
@section('title', 'Import Attendance')
@section('header-css')

  
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Import Attendance</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <button type="button" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</button>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employees</a></li>
              <li class="breadcrumb-item active">Import Attendance</li>
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
              
                   <form role="form" method="post" action="{{url('/import-attendance')}}" enctype="multipart/form-data" >
                    <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                      <label>Upload File</label>
                      <input type="file" name="sheet">
                      <input type="submit" name="">
                   </form>

              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                   <h4>Mark Attendance</h4>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              
                   <form role="form" method="post" action="{{url('employees/mark-attendance')}}" enctype="multipart/form-data" >
                    <input type="hidden" value="{{csrf_token()}}" name="_token"/>

<div class="row">
  <div class="col-md-2">
                      <label>Attendance Date</label>
 </div>
  <div class="col-md-4">
                      <input type="date" name="date" required>
</div>
</div>

<div class="row">
  <div class="col-md-2">
                      <label>Employee</label>
  </div>
  <div class="col-md-4">                    
                      
                      <select name="employee_ids[]" id="employee_ids" size="7" multiple required>
                        <!--<option value="">---Select Any Employee---</option>-->
                        <option value="" id="select_all">All Employees</option>
                        @foreach($employees as $emp)
                        <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                        @endforeach
                        
                      </select>
 </div>
</div>

<div class="row">
  <div class="col-md-2">
                      <label>Attendance Status</label>
</div>
  <div class="col-md-4">                       
                    <select name="status" id="status"   required>
                        <option value="">---Select Any Status---</option>
                      
                        @foreach($statuses as $st)
                        <option value="{{$st['id']}}">{{$st['text']}}</option>
                        @endforeach
                        
                      </select>
</div>
</div>

<div class="row">
  <div class="col-md-2">
                      <label>Time</label>
  </div>
  <div class="col-md-4">                     
                      <input type="time" name="time">
  </div>
</div> 

<div class="row">
  <div class="col-md-2">                   
                      <label>Attendance Type</label>
 </div>
  <div class="col-md-4"> 
                      <input type="radio" name="attendance_type" value="C/In">
                      <label>In</label>
                      <input type="radio" name="attendance_type" value="C/Out">
                      <label>Out</label>
</div>
</div>


                      <input type="submit" name="" value="Mark">


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

  $('#select_all').click(function() {
    $('#employee_ids option').prop('selected', true);
});


})


</script>




@endsection  
  