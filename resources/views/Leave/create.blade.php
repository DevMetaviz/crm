
@extends('layout.master')
@section('title', 'Configure Leaves')
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
    <form role="form" method="POST" action="{{url('/configuration/leave/save')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Configure Leaves</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('employee-Enrollment')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employees</a></li>
              <li class="breadcrumb-item active">Configure Leaves</li>
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
  <legend class="w-auto">Leaves</legend>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Leave Text<span class="text-danger">*</span></label>
                  <input type="text" name="leave_text" class="form-control select2" value="{{old('leave_text')}}" required style="width: 100%;">
                 
                </div>
               
                <!-- /.form-group -->
                
                
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>Type</label>
                  <select class="form-control select2" name="type" id="type" style="width: 100%;">
                    <option value="">Select any value</option>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                  </select>
                </div>
               
                <!-- /.form-group -->

              </div>
              <!-- /.col -->

              <div class="col-md-3">
                <div class="form-group">
                  <label>Unit</label>
                  <select class="form-control select2" name="unit" id="unit" required="true" style="width: 100%;">
                    <option value="">Select any value</option>
                    <option value="Day">Day</option>
                    <option value="Hour">Hour</option>
                  </select>
                </div>
               
                <!-- /.form-group -->

              </div>
              <!-- /.col -->

              <div class="col-md-3">
                <div class="form-group">
                  <label>Deduction Amount<a href="#" data-toggle="tooltip" data-placement="bottom" title="Enter (%) value, you want to deduct from a day salary! (% of / Day Salary)"><span class="fa fa-info-circle"></span></a></label>
                  <input type="number" name="deduction_amount" class="form-control select2" value="{{old('deduction_amount')}}" required style="width: 100%;">
                </div>
               
                <!-- /.form-group -->

              </div>
              <!-- /.col -->

              <div class="col-md-3">
                <div class="form-group">
                  <label>Sort Order<span class="text-danger">*</span></label>
                  <input type="number" name="sort_order" class="form-control select2" value="{{old('sort_order')}}" required style="width: 100%;">
                 
                </div>
               
                <!-- /.form-group -->
                 </div>

                 <div class="col-md-3">
                <div class="form-group">
                  <input type="checkbox" name="activeness" value="active" class="" checked>
                  <label>Active</label>
                  
                </div>
               
                <!-- /.form-group -->

              </div>


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
                    <th>Leave Text</th>
                    <th>Type</th>
                    <th>Unit</th>
                    <th>Deduction Amount</th>
                    <th>Sort Order</th>
                    <th>Active</th>
                  </tr>

                  @if(isset($leaves))
                    @foreach($leaves as $leave)
                      
                    <tr>
                
                     
                     <td>{{$leave['id']}}</td>
                     <td>{{$leave['text']}}</td>
                    <td>{{$leave['type']}}</td>
                    <td>{{$leave['unit']}}</td>
                    <td>{{$leave['deduction_amount']}}</td>
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
  