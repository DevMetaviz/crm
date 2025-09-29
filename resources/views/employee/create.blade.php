
@extends('layout.master')
@section('title', 'Enroll New Employee')
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
    <form role="form" method="POST" action="./save-employee">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Employee Enrollment</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('employees')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>List</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employees</a></li>
              <li class="breadcrumb-item active">Enroll Employee</li>
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
     

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Name<span class="text-danger">*</span></label>
                  <input type="text" name="name" class="form-control select2" value="{{old('name')}}" required style="width: 100%;">
                 
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Father/Husband Name</label>
                  <input type="text" name="father_name" class="form-control select2" value="{{old('father_name')}}" style="width: 100%;">
                  </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Gender</label>
                  <select name="gender" id="gender" class="form-control select2" style="width: 100%;">
                    
                    <option value=""  >------Select any value-----</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    
                  </select>
                </div>

                <div class="form-group">
                  <label>Marital Status</label>
                  <select class="form-control select2" name="marital_status" id="marital_status" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Qualification</label>
                  <input type="text" name="qualification" value="{{old('qualification')}}" class="form-control select2" style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <input type="checkbox" name="activeness" value="active" id="activeness" class=""  checked>
                  <label>Active</label>
                  </div>

                  <div class="form-group">
                  <input type="checkbox" name="is_so" value="1" id="is_so" class="" >
                  <label>SO</label>
                  </div>

               
                
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>CNIC</label>
                  <input type="text" name="cnic" value="{{old('cnic')}}" class="form-control select2" style="width: 100%;">
                </div>
                <div class="form-group">
                  <label>CNIC Place</label>
                  <input type="text" name="cnic_place" value="{{old('cnic_place')}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Date Of Birth</label>
                  <input type="date" name="date_of_birth" value="{{old('date_of_birth')}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Religion</label>
                  <input type="text" name="religion" value="{{old('religion')}}" class="form-control select2" style="width: 100%;">
                  </div>

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->



<!-- Start Tabs -->
<div class="nav-tabs-wrapper">
    <ul class="nav nav-tabs dragscroll horizontal">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabA">Offical Information</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabB">Contact Information</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabC">Salary Detail</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabD">Other Info</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabE">Tab E</a></li>
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid #dee2e6;padding: 10px;">
    <div class="tab-pane fade show active" id="tabA">

      <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Employee Code</label>
                  <input type="text" name="code" readonly="false" value="{{$new_employee_code}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Joining Date</label>
                  <input type="date" name="joining_date" value="{{old('joining_date')}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Leaving Date</label>
                  <input type="date" name="leaving_date" value="{{old('leaving_date')}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Employee Type<span class="text-danger">*</span></label>
                  <select class="form-control select2" name="type" id="emp_type" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    <option value="Contract">Contract</option>
                    <option value="Part Time">Part Time</option>
                    <option value="Permanent">Permanent</option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Designation<span class="text-danger">*</span></label>
                  <select class="form-control select2" name="designation" id="designation" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($designations as  $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Department<span class="text-danger">*</span></label>
                  <select class="form-control select2" name="department" id="department" style="width: 100%;" required>
                    <option value="">------Select any value-----</option>
                    @foreach($departments as  $depart)
                    <option value="{{$depart['id']}}">{{$depart['name']}}</option>
                    @endforeach
                  </select>
                </div>
                <!-- /.form-group -->
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Reporting Manager</label>
                  <select class="form-control select2" name="super_employee" id="super_employee" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    @foreach($employees as  $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                    @endforeach
                    
                  </select>
                </div>
                 <div class="form-group">
                  <label>Shift</label>
                  <select class="form-control select2 text-capitalize" name="shift" id="shift" style="width: 100%;">
                    <option value="" >------Select any value-----</option>
                    @foreach($shifts as $sh)
                    <option class="text-capitalize" value="{{$sh['id']}}">{{$sh['shift_name']}}</option>
                    @endforeach
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Comment</label>
                  <textarea name="comment" class="form-control select2" style="width: 100%;">{{old('comment')}}</textarea>
                </div>
                <!-- /.form-group -->

                <!-- <div class="form-group">
                  <input type="checkbox" name="attendance" value="1" id="attendance" class=""  checked>
                  <label>Attendance</label>
                  </div> -->
                  


              </div>
        </div>
        
    </div>
    <div class="tab-pane fade" id="tabB">

      <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" name="phone" value="{{old('phone')}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Mobile</label>
                  <input type="text" name="mobile" value="{{old('mobile')}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" value="{{old('email')}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
               
                <div class="form-group">
                  <label>Domicile</label>
                  <input type="text" name="domicile" value="{{old('domicile')}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
              </div>
              <div class="col-md-3">
                 <div class="form-group">
                  <label>State</label>
                  <select class="form-control select2" name="state" id="state" style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    <option value="Punjab">Punjab</option>
                    <option value="Kpk">Kpk</option>
                    <option value="Sindh">Sindh</option>
                  </select>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>City</label>
                  <select class="form-control select2" name="city" id="city"  style="width: 100%;">
                    <option value="">------Select any value-----</option>
                    <option value="Lahore">Lahore</option>
                    <option value="Sharaq pur sharif">Sharaq pur sharif</option>
                  </select>
                </div>
                <!-- /.form-group -->
              
          
                <div class="form-group">
                  <label>Address</label>
                  <textarea name="address" class="form-control select2" style="width: 100%;">{{old('address')}}</textarea>
                </div>
                <!-- /.form-group -->
              </div>
        </div>
      
    </div>

    <div class="tab-pane fade" id="tabC">

       <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Salary</label>
                  <input type="number" name="salary" value="{{old('salary')}}" class="form-control select2" style="width: 100%;">
                </div>
              </div>
        </div>
      
    </div>

    <div class="tab-pane fade" id="tabD">
             
             <div class="row">
              <div class="col-md-3">
                  <div class="form-group">
                  <label>ZK ID</label>
                  <input type="text" name="zk_id" class="form-control select2" value="{{old('zk_id')}}" style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Allowed Leave</label>
                  <input type="text" name="allowed_leave" class="form-control select2" value="{{old('allowed_leave')}}" style="width: 100%;">
                  </div>
              </div>
            </div>
        
    </div>

    <div class="tab-pane fade" id="tabE">
        
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
  value1="{{old('gender') }}"
   
   if(value1!="")
   {
    
  $('#gender').find('option[value="{{old('gender')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('marital_status') }}"
   
   if(value1!="")
   {
    
  $('#marital_status').find('option[value="{{old('marital_status')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('type') }}"
   
   if(value1!="")
   {
    
  $('#emp_type').find('option[value="{{old('type')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('designation') }}"
   
   if(value1!="")
   {
    
  $('#designation').find('option[value="{{old('designation')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('department') }}"
   
   if(value1!="")
   {
    
  $('#department').find('option[value="{{old('department')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('shift') }}"
   
   if(value1!="")
   {
    
  $('#shift').find('option[value="{{old('shift')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('refference') }}"
   
   if(value1!="")
   {
    
  $('#refference').find('option[value="{{old('refference')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('state') }}"
   
   if(value1!="")
   {
    
  $('#state').find('option[value="{{old('state')}}"]').attr("selected", "selected");
   
   }

   value1="{{old('city') }}"
   
   if(value1!="")
   {
    
  $('#city').find('option[value="{{old('city')}}"]').attr("selected", "selected");
   
   }

    

 



})

</script>

@endsection  
  