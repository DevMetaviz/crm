
@extends('layout.master')
@section('title', 'Mark Overtime')
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
    <form role="form" method="POST" action="{{url('/overtime/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Mark Overtime</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('/overtime/list')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>History</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employee</a></li>
              <li class="breadcrumb-item active">Mark Overtime</li>
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


             <div class="row col-md-8 form-row">

                <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Doc No.</label>
                  <input type="text"  name="doc_no" class="form-control select2 col-sm-8" value="{{$doc_no}}"  required style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Overtime date</label>
                  <input type="date"  name="overtime_date" class="form-control select2 col-sm-8" value="{{date('Y-m-d')}}" required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Employee Name</label>
                  <select class="form-control select2 text-capitalize col-sm-8" name="employee_id" id="employee_id" required style="width: 100%;">
                    <option value="" >------Select any value-----</option>
                    @foreach($employees as $sh)
                    <option class="text-capitalize" value="{{$sh['id']}}">{{$sh['name']}}</option>
                    @endforeach
                  </select>
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Start Time</label>
                  <input type="time"  name="start_time" id="start_time" onchange="setTotalTime()" class="form-control select2 col-sm-8" value=""  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">End Time</label>
                  <input type="time"  name="end_time" id="end_time" onchange="setTotalTime()" class="form-control select2 col-sm-8" value=""  style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-6">
                <div class="form-group row">
                  <label class="col-sm-4">Total Time</label>
                  <input type="text"  name="total_time" id="total_time" class="form-control select2 col-sm-8" value="" placeholder="e.g. 03:06" pattern="[0-9]{2}:[0-9]{2}" required style="width: 100%;">
                  
                  
                  </div>
                 </div>



                 <div class="col-sm-12">
                  <div class="form-group row">
                  <label class="col-sm-2">Remarks</label>
                  <textarea name="remarks"  class="form-control select2 col-sm-10"></textarea>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group row">
                  
                  <label class="col-sm-8 offset-sm-4"><input type="checkbox" name="activeness" value="1" id="activeness" class="" checked>&nbsp&nbspActive</label>
                  </div>
                </div>

              </div>
                   



        
      </div>

      </form>
    <!-- /.content -->
   
@endsection

@section('jquery-code')
<script type="text/javascript">

function setTotalTime()
{
  var start= $('#start_time').val() ;
  var end= $('#end_time').val() ;

  if(start=='' || end=='')
    { return; }

  var start=start.split(":");
  var end=end.split(":"); 

  var date1 = new Date(2000, 0, 1,  start[0], start[1]); // 9:00 AM
var date2 = new Date(2000, 0, 1, end[0], end[1]); // 5:00 PM

// the following is to handle cases where the times are on the opposite side of
// midnight e.g. when you want to get the difference between 9:00 PM and 5:00 AM

if (date2 < date1) {
    date2.setDate(date2.getDate() + 1);
}

var diff = date2 - date1;
var hh = Math.floor(diff / 1000 / 60 / 60);

diff -= hh * 1000 * 60 * 60;
var mm = Math.floor(diff / 1000 / 60);

  
  //var total=hh +' : '+mm ;

  hh=hh > 9 ? "" + hh: "0" + hh;
  mm=mm > 9 ? "" + mm: "0" + mm;
 
   $('#total_time').val(hh +':'+mm) ;


  
}

</script>

@endsection  
  