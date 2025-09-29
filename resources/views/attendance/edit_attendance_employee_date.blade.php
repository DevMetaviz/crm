
@extends('layout.master')
@section('title', 'Edit Attendance')
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
    <form role="form" method="POST" action="{{url('/edit/employee/attendance/'.$employee['id'].'/'.$date)}}">
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
     <input type="hidden" value="" name="id"/>

            <div class="row">
              <div class="col-md-3">
                
                  <div class="form-group">
                  <label>Employee Name</label>
                  <input type="text" name="employee_name" class="form-control select2" readonly="true" value="{{$employee['name']}}" style="width: 100%;">
                  </div>
                <!-- /.form-group -->
               

                <div class="form-group">
                  <label>C/In Time</label>
                  @if(count($employee['in'])==0)
                  <input type="time" name="time_in" value="" required="true"  class="form-control select2" style="width: 100%;">
                  @elseif(count($employee['in'])==1)
                  <input type="time" name="time_in" value="{{$employee['in'][0]}}" required="true"  class="form-control select2" style="width: 100%;">
                  @else
                  <div class="form-group">
                  <div class="row">
                  @foreach($employee['in'] as $in)
                  <div class="col-md-1">
                    <input type="radio" name="time_in" value="{{$in}}" id="time_in" class="form-control select2"  required="true" >
                  </div>
                  <div class="col-md-5">
                    <input type="text" name="" value="{{$in}}"  class="form-control select2"  style="width: 100%;" >
                  </div>
                  @endforeach
                   </div>
                 </div>
                  @endif
                  </div>
               
                  

               
                
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                
                  <div class="form-group">
                  <label>Date</label>
                  <input type="date" name="date" value="{{$date}}" required="true" readonly="true" class="form-control select2" style="width: 100%;">
                  </div>
                            
                <!-- /.form-group -->
                <div class="form-group">
                  <label>C/Out Time</label>
                  @if(count($employee['out'])==0)
                  <input type="time" name="time_out" value="" required="true" class="form-control select2" style="width: 100%;">
                  @elseif(count($employee['out'])==1)
                  <input type="time" name="time_out" value="{{$employee['out'][0]}}"  required="true"  class="form-control select2" style="width: 100%;">
                  @else
                  <div class="form-group">
                  <div class="row">
                  @foreach($employee['out'] as $out)
                  <div class="col-md-1">
                  <input type="radio" name="time_out" value="{{$out}}" id="time_out" class="form-control select2"  required="true" >
                  </div>
                  <div class="col-md-5">
                    <input type="text" name="" value="{{$out}}"  class="form-control select2"  style="width: 100%;" >
                  </div>
                  @endforeach
                   </div>
                 </div>
                  @endif
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




</script>

@endsection  
  