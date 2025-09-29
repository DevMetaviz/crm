
@extends('layout.master')
@section('title', 'Edit Shift')
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
    <form role="form" method="POST" action="{{url('/update/shift/'.$shift['id'])}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" value="{{$shift['id']}}" name="shift_id"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Edit Shift</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('shifts')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>List</a>
            <a class="btn" href="{{url('define/shift')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Edit Shift</li>
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
                                    
                      <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                       {{ $errors->first('msg') }}
                                          </div>

                                          
  
                                @endif
     
            
            <div class="row">
              <div class="col-md-3">
            <div class="form-group">
                  <label>Shift Name<span class="text-danger">*</span></label>
                  <input type="text" name="shift_name" class="form-control select2" value="{{$shift['shift_name']}}" required style="width: 100%;">
                 
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-3">
                
                <div class="form-group">
                  <label>Start Time</label>
                  <input type="time" name="start_time" class="form-control select2" value="{{$shift['start_time']}}" style="width: 100%;" required>
                  </div>

                   <div class="form-group">
                  <label>Relaxation</label>
                  <input type="number" name="relaxation" min="0" max="120" value="{{$shift['relaxation']}}" class="form-control select2" style="width: 100%;" required>
                  </div>
                <!-- /.form-group -->
                
                
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>End Time</label>
                  <input type="time" name="end_time" class="form-control select2" value="{{$shift['end_time']}}" style="width: 100%;" required>
                </div>

                <div class="form-group">
                  <label>Over-Time Start</label>
                  <input type="time" name="overtime_start" value="{{$shift['overtime_start']}}" class="form-control select2" style="width: 100%;" required>
                </div>
                <!-- /.form-group -->

              </div>
              <!-- /.col -->

              <div class="col-md-3">

                   <div class="form-group">
                  <input type="checkbox" name="attendance" value="1" id="attendance" class=""  >
                  <label>Attendance</label>
                  </div>

                  <div class="form-group">
                  <input type="checkbox" name="late_deduction" value="1" id="late_deduction" class=""  >
                  <label>Late Deduction</label>
                  </div>

              </div>


            </div>
            <!-- /.row -->


            <div class="row">
              <div class="col-md-8">

                <!-- <div class="">
                  <label>Select Off-Day</label>
                </div>

                  <input type="checkbox" name="offdays[]" value="monday" id="monday" class="" >
                  <label for="monday">Monday</label>
                  
                  <input type="checkbox" name="offdays[]" value="tuesday" id="tuesday" class="" >
                  <label for="tuesday">Tuesday</label>

                  <input type="checkbox" name="offdays[]" value="wednessday" id="wednessday" class="" >
                  <label for="wednessday">Wednessday</label>

                  <input type="checkbox" name="offdays[]" value="thursday" id="thursday" class="" >
                  <label for="thursday">Thursday</label>

                  <input type="checkbox" name="offdays[]" value="friday" id="friday" class="" >
                  <label for="friday">Friday</label>

                  <input type="checkbox" name="offdays[]" value="saturday" id="saturday" class="" >
                  <label for="saturday">Saturday</label>

                  <input type="checkbox" name="offdays[]" value="sunday" id="sunday" class="" >
                  <label for="sunday">Sunday</label> -->
                  

              </div>
              </div>

              <div class="row">
              <div class="col-md-8">

               <!--  <div class="">
                  <label>Select Alternate Off-Day (if any)</label>
                </div>

                  <input type="checkbox" name="alter_offdays[]" value="monday" id="alter_monday" class="" >
                  <label for="alter_monday">Monday</label>
                  
                  <input type="checkbox" name="alter_offdays[]" value="tuesday" id="alter_tuesday" class="" >
                  <label for="alter_tuesday">Tuesday</label>

                  <input type="checkbox" name="alter_offdays[]" value="wednessday" id="alter_wednessday" class="" >
                  <label for="alter_wednessday">Wednessday</label>

                  <input type="checkbox" name="alter_offdays[]" value="thursday" id="alter_thursday" class="" >
                  <label for="alter_thursday">Thursday</label>

                  <input type="checkbox" name="alter_offdays[]" value="friday" id="alter_friday" class="" >
                  <label for="alter_friday">Friday</label>

                  <input type="checkbox" name="alter_offdays[]" value="saturday" id="alter_saturday" class="" >
                  <label for="alter_saturday">Saturday</label>

                  <input type="checkbox" name="alter_offdays[]" value="sunday" id="alter_sunday" class="" >
                  <label for="alter_sunday">Sunday</label> -->
                  

              </div>
              </div>


<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Allowed Leaves</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;">
    <div class="tab-pane fade show active" id="tabA">


@foreach($leaves as $leave)

      <div class="row">

         <div class="col-md-2">
                <div class="form-group">
                  <label class="text-capitalize">{{$leave['text']}}</label>
                  
                </div>
                <!-- /.form-group -->
                
              </div>

<?php 

if(isset($allowed_leave[$leave['id'].'_']))
$label=$allowed_leave[$leave['id'].'_']; 
else
  $label=0;

?> 

              <div class="col-md-3">
                <div class="form-group">
                
                  <input type="number" value="{{$label}}" min="0" max="31" step="any" name="{{$leave['id']}}"  class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                
              </div>
             
        </div>
    @endforeach    
        
    </div> 
   

    
</div>
<!-- End Tabs -->
                   



        
      </div>

      </form>
    <!-- /.content -->
   
@endsection

@section('jquery-code')
<script type="text/javascript">

$(document).ready(function(){

   value1="{{$shift['attendance'] }}";
   
   
   if(value1=="1")
   {
    
  $('#attendance').prop("checked", true);
   
   }
    else{
      $('#attendance').prop("checked", false);
  
    } 


    value1="{{$shift['late_deduction'] }}";
   
   
   if(value1=="1")
   {
    
  $('#late_deduction').prop("checked", true);
   
   }
    else{
      $('#late_deduction').prop("checked", false);
  
    } 


  // offdays="{{$shift['offdays'] }}".split(',');
  // alter_offdays="{{$shift['alter_offdays'] }}".split(',');
  //   for (i = 0; i < offdays.length; i++) {
     
  //    $("#"+offdays[i]).attr('checked', true);

  //   }

  //   for (i = 0; i < alter_offdays.length; i++) {
  //     $("#alter_"+alter_offdays[i]).attr('checked', true);
  //   }


  })

</script>

@endsection  
  