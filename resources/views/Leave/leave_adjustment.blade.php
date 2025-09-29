
@extends('layout.master')
@section('title', 'Leave Adjustment')
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
    <form role="form" method="POST" action="{{url('/leave/adjustment')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Leave Adjustment</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="#" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{url('/leaves')}}">Leaves</a></li>
              <li class="breadcrumb-item active">Leave Adjustment</li>
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
              <label>Adjustment No</label>
                  <input type="text" name="adjustment_no" class="form-control select2" value="" style="width: 100%;" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
              <label>Adjustment Date</label>
                  <input type="date" name="adjustment_date" class="form-control select2" value="{{date('Y-m-d')}}" style="width: 100%;" required>
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
                <div class="form-group">
                  <label>Adjust Days</label>
                  <input type="number" min="1" name="adjust_days" class="form-control select2" style="width: 100%;" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Leave Type<span class="text-danger">*</span></label>
                  <select class="form-control select2 text-capitalize" name="leave_type" id="leave_type" style="width: 100%;">
                    <option value="" >------Select any value-----</option>
                    @foreach($leaves as $sh)
                    <option class="text-capitalize" value="{{$sh['id']}}">{{$sh['text']}}</option>
                    @endforeach
                  </select>
                  </div>
                   <div class="form-group">
                    <label>Adjustment Month</label>
                  <input type="month" name="adjustment_month" class="form-control select2" style="width: 100%;" >
                </div>
              </div>
            </div>


           
            <!-- /.row -->


            <div class="row">
              <div class="col-md-6">
              
                   <div class="form-group">
                  <label>Comment</label>
                  <textarea name="comment" class="form-control select2"></textarea>
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



</script>

@endsection  
  