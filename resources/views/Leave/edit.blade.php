
@extends('layout.master')
@section('title', 'Edit/Approve Leave')
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
    <form role="form" method="POST" action="{{url('/update/leave/'.$leave['id'])}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Edit/Approve Leave</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="#" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('/leaves')}}">Leaves</a></li>
              <li class="breadcrumb-item active">Edit/Approve Leave</li>
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
              <label>Application No</label>
                  <input type="text" name="application_no" class="form-control select2" value="{{$leave['application_no']}}" style="width: 100%;" required>
                </div>
              </div>
              <div class="col-md-3">
            <div class="form-group">
              <label>Application Date</label>
                  <input type="date" name="application_date" class="form-control select2" value="{{$leave['application_date']}}" style="width: 100%;" required>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-3">
            <div class="form-group">
                  <label>Employee Name<span class="text-danger">*</span></label>
                  <select class="form-control select2 text-capitalize" name="employee_id" id="employee_id" style="width: 100%;">
                    <option value="" >------Select any value-----</option>
                    @foreach($employees as $sh)
                    <option class="text-capitalize" value="{{$sh['id']}}">{{$sh['name']}}</option>
                    @endforeach
                  </select>
                 
                </div>
              </div>
              <div class="col-md-3">
            <div class="form-group">
                  <label>Leave Type<span class="text-danger">*</span></label>
                  <select class="form-control select2 text-capitalize" name="leave_type" id="leave_type" style="width: 100%;">
                    <option value="" >------Select any value-----</option>
                    @foreach($leaves as $sh)
                    <option class="text-capitalize" value="{{$sh['id']}}">{{$sh['value']}}</option>
                    @endforeach
                  </select>
                  </div>              </div>
            </div>

<?php
if($leave['to_date']=='')
{
  $paid_days=1;
}
else
{
$date1=date_create($leave['from_date']);
$date2=date_create($leave['to_date'].'+1 days');
$diff=date_diff($date1,$date2,'absolute');
$days_diff=$diff->format("%a");

if($leave['paid_days']=='')
{
  $paid_days=$days_diff;
}
else
{
  $paid_days=$leave['paid_days'];
}

}

?>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
              <label>Paid Days</label>
                  <input type="number" name="paid_days" id="paid_days" min="0" max="{{$paid_days}}" id="paid_days" value="{{$paid_days}}" class="form-control select2" style="width: 100%;" >
                </div>
                
                

                  <div class="form-group">
                  <label>From</label>
                  <input type="date" name="from_date" class="form-control select2" value="{{$leave['from_date']}}" id="from_date" style="width: 100%;" onchange="set_paid_days()" required>
                </div>

                  
                <!-- /.form-group -->
                
                
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>Type<span class="text-danger">*</span></label>
                  <select class="form-control select2 text-capitalize" name="type" id="type" style="width: 100%;">
                    <option value="" >------Select any value-----</option>
                    <option class="text-capitalize" value="paid">Paid</option>
                    <option class="text-capitalize" value="unpaid">Unpaid</option>
                  </select>
                </div>

                <div class="form-group">
              <label>To</label>
                  <input type="date" name="to_date" class="form-control select2" value="{{$leave['to_date']}}" id="to_date" style="width: 100%;" onchange="set_paid_days()" required>
                </div>

                <!-- <div class="form-group">
                  <label>Over-Time Start</label>
                  <input type="time" name="overtime_start" value="{{old('overtime_start')}}" class="form-control select2" style="width: 100%;" required>
                </div> -->
                <!-- /.form-group -->

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            
            <div class="row">
              <div class="col-md-6">
              
                   <div class="form-group">
                    <input type="checkbox" name="status" value="approved" id="status" class="" >
                  <label>Approve</label>
                  </div>
                <!-- /.form-group -->
                
              </div>
              </div>

            <div class="row">
              <div class="col-md-6">
              
                   <div class="form-group">
                  <label>Reason</label>
                  <textarea name="reason" class="form-control select2">{{$leave['reason']}}</textarea>
                  </div>
                <!-- /.form-group -->
                
              </div>
              </div>
                   



        
      </div>

      </form>
    <!-- /.content -->
   
@endsection

@section('jquery-code')
<script type="text/javascript">

$(document).ready(function(){
  value1="{{$leave['employee_id'] }}"
   
   if(value1!="")
   {
    
  $('#employee_id').find('option[value="{{$leave['employee_id']}}"]').attr("selected", "selected");
   
   }

   value1="{{ $leave['type'] }}"
   
   if(value1!="")
   {
    
  $('#type').find('option[value="{{$leave['type']}}"]').attr("selected", "selected");
   
   }

   value1="{{$leave['leave_type_id'] }}"
   
   if(value1!="")
   {
    
  $('#leave_type').find('option[value="{{$leave['leave_type_id']}}"]').attr("selected", "selected");
   
   }

   value1="{{$leave['status'] }}"
   
   if(value1=="approved")
   {
    
  $('#status').prop("checked", true);
   
   }
    else{
      $('#status').prop("checked", false);
  
    } 

})

function set_paid_days()
{
  //var name=this.name;
  //alert(name);

    var from_date=$("#from_date").val();
  var to_date=$("#to_date").val();
  var paid_days=0;

  if(to_date=='')
  {
      paid_days=1;
  }
  else
  {
      

           var date1 = new Date(from_date)//converts string to date object
           var date2 = new Date(to_date)
           var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
          var diffDays = Math.abs((date1.getTime() - date2.getTime()) / (oneDay));
                paid_days=diffDays+1;
              
  }
    $("#paid_days").val(paid_days);
  //alert(from_date);
}

</script>

@endsection  
  