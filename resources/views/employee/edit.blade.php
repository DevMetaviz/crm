
@extends('layout.master')
@section('title', $employee['name'])
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
    <form role="form" id="allowance_form" method="post" action="{{url('employee/allowance/save')}}">
      <input type="hidden" form="allowance_form" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" form="allowance_form" value="{{$employee['id']}}" name="employee_id"/>
    </form>

    <form role="form" method="POST" action="{{url('/update-employee')}}">
      <input type="hidden" value="{{csrf_token()}}" name="_token"/>

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Employee Enrollment</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Update</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('employee-Enrollment')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
            <a class="btn" href="{{url('employees')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>List</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employees</a></li>
              <li class="breadcrumb-item active">Edit Employee</li>
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
     <input type="hidden" value="{{$employee['id']}}" name="id"/>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Name<span class="text-danger">*</span></label>
                  <input type="text" name="name" class="form-control select2" value="{{$employee['name']}}" required style="width: 100%;">
                 
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Father/Husband Name</label>
                  <input type="text" name="father_name" class="form-control select2" value="{{$employee['father_husband_name']}}" style="width: 100%;">
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
                  <input type="text" name="qualification" value="{{$employee['qualification']}}" class="form-control select2" style="width: 100%;">
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
                  <input type="text" name="cnic" value="{{$employee['cnic']}}" class="form-control select2" style="width: 100%;">
                </div>
                <div class="form-group">
                  <label>CNIC Place</label>
                  <input type="text" name="cnic_place" value="{{$employee['cnic_place']}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Date Of Birth</label>
                  <input type="date" name="date_of_birth" value="{{$employee['dateOfBirth']}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Religion</label>
                  <input type="text" name="religion" value="{{$employee['religion']}}" class="form-control select2" style="width: 100%;">
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
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabE">Allowances & Deductions</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabD">Other Info</a></li>
        
    </ul>
</div>

<span class="nav-tabs-wrapper-border" role="presentation"></span>

<div class="tab-content" style="background-color: white;border: 1px solid ##dee2e6;padding: 10px;">
    <div class="tab-pane fade show active" id="tabA">

      <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Employee Code</label>
                  <input type="text" name="code" readonly="true" value="{{$employee['employee_code']}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Joining Date</label>
                  <input type="date" name="joining_date" value="{{$employee['joining_date']}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Leaving Date</label>
                  <input type="date" name="leaving_date" value="{{$employee['leaving_date']}}" class="form-control select2" style="width: 100%;">
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
                  <textarea name="comment" class="form-control select2" style="width: 100%;">{{$employee['comment']}}</textarea>
                </div>
                <!-- /.form-group -->
                  <!-- <div class="form-group">
                  <input type="checkbox" name="attendance" value="1" id="attendance" class=""  >
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
                  <input type="text" name="phone" value="{{$employee['phone']}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Mobile</label>
                  <input type="text" name="mobile" value="{{$employee['mobile']}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" value="{{$employee['email']}}" class="form-control select2" style="width: 100%;">
                </div>
                <!-- /.form-group -->
               
                <div class="form-group">
                  <label>Domicile</label>
                  <input type="text" name="domicile" value="{{$employee['domicile']}}" class="form-control select2" style="width: 100%;">
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
                  <textarea name="address" class="form-control select2" style="width: 100%;">{{$employee['address']}}</textarea>
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
                  <input type="number" name="salary" value="{{$employee['salary']}}" class="form-control select2" style="width: 100%;">
                </div>
              </div>
        </div>
      
    </div>

    <div class="tab-pane fade" id="tabD">
             
             <div class="row">
              <div class="col-md-3">
                  <div class="form-group">
                  <label>ZK ID</label>
                  <input type="text" name="zk_id" class="form-control select2" value="{{$employee['zk_id']}}" style="width: 100%;">
                  </div>

                  <div class="form-group">
                  <label>Allowed Leave</label>
                  <input type="text" name="allowed_leave" class="form-control select2" value="{{$employee['allowed_leave']}}" style="width: 100%;">
                  </div>
              </div>
            </div>
        
    </div>

    <div class="tab-pane fade" id="tabE">
        
        <!-- <fieldset class="border p-4">
                   <legend class="w-auto">Add Allownce</legend>

                    <form role="form" method="post" action="{{url('configuration/allowances/save')}}">
                  <input type="hidden" value="{{csrf_token()}}" name="_token"/>

                

                <label>Allowance</label>
                 <select  name="allowance_id" id="allowance_id" required="true" style="">
                    <option value="">------Select any value-----</option>
                    
                    <option value="Additive">Additive</option>
                    <option value="Aeductive">Deductive</option>
                  
                  </select>


                <label>Type</label>
                
                <select  name="type" id="type" required="true" style="">
                    <option value="">------Select any value-----</option>
                    
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage (%)</option>
                  
                  </select>

                

                <input type="submit" name="" value="Add">
                       </fieldset> -->

                       <label>Allowance & Deduction</label><button type="button" class="btn" data-toggle="modal" data-target="#myModal">
    <span class="fa fa-plus-circle text-info"></span>
  </button>

  @foreach($employee['allowances'] as $allowance)

     <form role="form" id="{{'allowance_form_'.$allowance['id']}}" method="post" action="{{url('employee/allowance/delete')}}">
      <input type="hidden" form="{{'allowance_form_'.$allowance['id']}}" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" form="{{'allowance_form_'.$allowance['id']}}" value="{{$employee['id']}}" name="employee_id"/>
       <input type="hidden" form="{{'allowance_form_'.$allowance['id']}}" value="{{$allowance['id']}}" name="allowance_id"/>

  
    <div class="row">
                    <div class="col-md-2">
                <label>{{$allowance['text']}}</label>
                 </div>
                  <div class="col-md-2">
                    <input type="text" value="{{$allowance['pivot']['type']}}" readonly="true" />
                  </div>
                     <div class="col-md-2">
                    <input type="text" value="{{$allowance['pivot']['amount']}}" readonly="true" />
                     </div>
                     <div class="col-md-2">
                      <!-- <a href=""><span class="fa fa-minus-circle text-danger"></span></a> -->
                      <button class="btn" type="submit" form="{{'allowance_form_'.$allowance['id']}}"><span class="fa fa-minus-circle text-danger"></span></button>
                     </div>
                   
       </div>

       </form>

   @endforeach

   @foreach($employee['deductions'] as $allowance)

     <form role="form" id="{{'allowance_form_'.$allowance['id']}}" method="post" action="{{url('employee/allowance/delete')}}">
      <input type="hidden" form="{{'allowance_form_'.$allowance['id']}}" value="{{csrf_token()}}" name="_token"/>
      <input type="hidden" form="{{'allowance_form_'.$allowance['id']}}" value="{{$employee['id']}}" name="employee_id"/>
       <input type="hidden" form="{{'allowance_form_'.$allowance['id']}}" value="{{$allowance['id']}}" name="allowance_id"/>

  
    <div class="row">
                    <div class="col-md-2">
                <label>{{$allowance['text']}}</label>
                 </div>
                  <div class="col-md-2">
                    <input type="text" value="{{$allowance['pivot']['type']}}" readonly="true" />
                  </div>
                     <div class="col-md-2">
                    <input type="text" value="{{$allowance['pivot']['amount']}}" readonly="true" />
                     </div>
                     <div class="col-md-2">
                      <!-- <a href=""><span class="fa fa-minus-circle text-danger"></span></a> -->
                      <button class="btn" type="submit" form="{{'allowance_form_'.$allowance['id']}}"><span class="fa fa-minus-circle text-danger"></span></button>
                     </div>
                   
       </div>

       </form>

   @endforeach

   

   <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Allowance/Deduction</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
             
                  
                
                  <div class="row">
                    <div class="col-md-6">
                <label>Allowance/Deduction</label>
                 <select  name="allowance_id" id="allowance_id" form="allowance_form" required="true" style="">
                    <option value="">------Select any value-----</option>
                    @foreach($allowances as $all)
                    <option value="{{$all['id']}}">{{$all['text']}}</option>
                    
                     @endforeach
                  </select>
                    <label>Amount / Percentage</label>
                    <input type="number" form="allowance_form"  name="amount" required="true" />
                     </div>
                     <div class="col-md-6">

                <label>Type</label>
                
                <select  name="type" id="type" form="allowance_form" required="true" style="">
                    <option value="">------Select any value-----</option>
                    
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage (%)</option>
                  
                  </select>
                </div>
              </div>
                
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          
          <input type="submit" form="allowance_form" class="btn btn-success" value="ADD">

        </div>
      
      </div>
    </div>
  </div>





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
  value1="{{$employee['gender'] }}"
   
   if(value1!="")
   {
    
  $('#gender').find('option[value="{{$employee['gender']}}"]').attr("selected", "selected");
   
   }

   value1="{{$employee['marital_status'] }}"
   
   if(value1!="")
   {
    
  $('#marital_status').find('option[value="{{$employee['marital_status']}}"]').attr("selected", "selected");
   
   }

   value1="{{$employee['employee_type'] }}"
   
   if(value1!="")
   {
    
  $('#emp_type').find('option[value="{{$employee['employee_type']}}"]').attr("selected", "selected");
   
   }

   value1="{{$employee['designation_id'] }}"
   
   if(value1!="")
   {
    
  $('#designation').find('option[value="{{$employee['designation_id']}}"]').attr("selected", "selected");
   
   }

   value1="{{$employee['department_id'] }}"
   
   if(value1!="")
   {
    
  $('#department').find('option[value="{{$employee['department_id']}}"]').attr("selected", "selected");
   
   }

   value1="{{$employee['shift_id'] }}"
   
   if(value1!="")
   {
    
  $('#shift').find('option[value="{{$employee['shift_id']}}"]').attr("selected", "selected");
   
   }

   value1="{{$employee['refference'] }}"
   
   if(value1!="")
   {
    
  $('#refference').find('option[value="{{$employee['refference']}}"]').attr("selected", "selected");
   
   }

   value1="{{$employee['state'] }}"
   
   if(value1!="")
   {
    
  $('#state').find('option[value="{{$employee['state']}}"]').attr("selected", "selected");
   
   }

   value1="{{$employee['city'] }}";
   
   if(value1!="")
   {
    
  $('#city').find('option[value="{{$employee['city']}}"]').attr("selected", "selected");
   
   }

   value1="{{$employee['activeness'] }}";
   
   
   if(value1=="active")
   {
    
  $('#activeness').prop("checked", true);
   
   }
    else{
      $('#activeness').prop("checked", false);
  
    } 

    //value1="{{$employee['attendance_required'] }}"
   
   
  //  if(value1=="1")
  //  {
    
  // $('#attendance').prop("checked", true);
   
  //  }
  //   else{
  //     $('#attendance').prop("checked", false);
  
  //   } 

     so="{{$employee['is_so'] }}";
   
   
   if(so=="1")
   {
    
  $('#is_so').prop("checked", true);
   
   }
    else{
      $('#is_so').prop("checked", false);
  
    }

   var super_id="{{$employee['super_employee'] }}";
 
    $('#super_employee').val(super_id);
 



})

</script>

@endsection  
  