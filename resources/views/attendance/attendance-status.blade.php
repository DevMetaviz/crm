
@extends('layout.master')
@section('title', 'Configure Attendance Status')
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
    <form role="form" method="POST" action="{{url('/configuration/attendance/status/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Configure Attendance Status</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('employee-Enrollment')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employees</a></li>
              <li class="breadcrumb-item active">Configure Attendance Status</li>
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
     
<fieldset class="col-md-8 border p-4">
  <legend class="w-auto">Attendance Status</legend>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Attendance Status<span class="text-danger">*</span></label>
                  <input type="text" name="text" class="form-control select2" value="{{old('leave_text')}}" required style="width: 100%;">
                 
                </div>
               
                <!-- /.form-group -->
                
                
              </div>
              <!-- /.col -->

              <div class="col-md-3">
                <div class="form-group">
                  <label>Code</label>
                  <input type="text" name="code" class="form-control select2" value="{{old('code')}}" required style="width: 100%;">
                </div>
               
                <!-- /.form-group -->

              </div>


              <div class="col-md-4">
                <div class="form-group">
                  <label>Corresponding Leave Type</label>
                  <select class="form-control select2" name="leave_type" id="leave_type" style="width: 100%;">
                    <option value="">Select any value</option>
                    @foreach($leave_types as $type)
                    <option value="{{$type['id']}}">{{$type['text']}}</option>
                    @endforeach
                  </select>
                </div>
               
                <!-- /.form-group -->

              </div>
              <!-- /.col -->

              <div class="col-md-3">
                <div class="form-group">
                  <label>Sort Order</label>
                  <input type="number" name="sort_order" min="1" value="1" class="form-control select2" value="{{old('sort_order')}}" required style="width: 100%;">
                </div>
               
                <!-- /.form-group -->

              </div>
              <!-- /.col -->

              <div class="col-md-3">
                <div class="form-group">
                  <input type="checkbox" name="activeness" value="active" class="" checked>
                  <label>Active</label>
                  
                </div>
               
                <!-- /.form-group -->

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
</fieldset>
</form>

<table id="example1" class="table table-bordered table-hover" style="">
                  
                  <thead>
                  



                  </thead>
                  <tbody>
                  
                 <tr>
                    <th>Id</th>
                    <th>Attendance Status</th>
                    <th>Code</th>
                    <th>Leave Type</th>
                    <th>Sort Order</th>
                    <th>Active</th>
                  </tr>

                  @if(isset($statuses))
                    @foreach($statuses as $leave)
                      
                    <tr>
                
                     
                     <td>{{$leave['id']}}</td>
                     <td>{{$leave['text']}}</td>
                     <td>{{$leave['code']}}</td>
                    <td>@if(isset($leave['leavetype'])){{$leave['leavetype']['text']}}@endif</td>
                    <td>{{$leave['sort_order']}}</td>
                    <td>{{$leave['activeness']}}</td>
                  </tr>

                    @endforeach
                  @endif
                  
                  </tbody>
                  <tfoot>
                  <tr>
                  
                  </tr>
                  </tfoot>
                </table>
  
      </div>

      
    <!-- /.content -->
   
@endsection

@section('jquery-code')
<script type="text/javascript">

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});

</script>

@endsection  
  