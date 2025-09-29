
@extends('layout.master')
@section('title', 'Employee Profile')
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
    

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Employee Profile</h1>
            <button style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="{{url('employee-Enrollment')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employee</a></li>
              <li class="breadcrumb-item active">Profile</li>
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
                                <!--start form-->
     <form role="form" method="POST" action="">
      <input type="hidden" value="{{csrf_token()}}" id="token" name="_token"/>
<fieldset class="col-md-8 border p-4">
  <legend class="w-auto">Search</legend>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Month</label>
                  <input type="month" name="month" id="month" class="form-control select2"  style="width: 100%;">
                 
                </div>
               
                <!-- /.form-group -->
                
                
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>Employee</label>
                  <select class="form-control select2" name="employee" id="employee" style="width: 100%;">
                    <option value="">Select any employee</option>
                    @foreach($employees as $emp)
                    <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                    @endforeach
                  </select>
                </div>
             
                <!-- /.form-group -->

              </div>
              <!-- /.col -->


            

              <div class="col-md-2">
                <div class="form-group">
                  <label style="visibility: hidden;">A</label>
                  <input type="button" name="sort_order" class="form-control select2" value="Display" style="" onclick="getProfile()">
                 
                </div>
               
                <!-- /.form-group -->
                 </div>

                


            </div>
            <!-- /.row -->
</fieldset>
</form>
<!--end form-->

<!--start employee detail-->
<div class="bg-info">
  <h3>Employee Detail</h3>
</div>

  <div class="row">
      <div class="col-md-3"><!--start 1st col-->
          
          <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Name : 
            </div>
              <div class="col-md-8" id="name">
              </div>
           </div>

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">S/o : 
            </div>
              <div class="col-md-8" id="father">
              </div>
           </div> 

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Department : 
            </div>
              <div class="col-md-8" id="department">
              </div>
           </div>

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Designation : 
            </div>
              <div class="col-md-8" id="designation">
              </div>
           </div> 

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Gender : 
            </div>
              <div class="col-md-8" id="gender">
              </div>
           </div>

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">DOB : 
            </div>
              <div class="col-md-8" id="birth">
              </div>
           </div>  

      </div><!--end 1st col-->
      <div class="col-md-3"><!--start 2nd col-->

        <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Code : 
            </div>
              <div class="col-md-8" id="employeeCode">
              </div>
           </div>

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Qualification: 
            </div>
              <div class="col-md-8" id="qualification">
              </div>
           </div>
 
          
          <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Joining Date : 
            </div>
              <div class="col-md-8" id="joiningDate">
              </div>
           </div>

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">CNIC : 
            </div>
              <div class="col-md-8" id="cnic">
              </div>
           </div> 

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Mobile : 
            </div>
              <div class="col-md-8" id="mobile">
              </div>
           </div>

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Email : 
            </div>
              <div class="col-md-8" id="email">
              </div>
           </div> 

            

      </div><!--end 2nd col-->

      <div class="col-md-3"></div><!--end 3rd col-->
  </div>
  <!--end employee detail-->

  <!--start employee attendance detail-->
<div class="bg-info">
  <h3>Attendance & Other Detail</h3>
</div>

  <div class="row">
   
          <div class="col-md-3"><!--start 1st col-->
           <fieldset class="border p-4">
      <legend class="w-auto">Attendance detail</legend>
         <table>
          <tr><th class="text-right text-capitalize">{{'Month Days :'}}</th><td id="total_days"></td></tr>
          @foreach($attendance_statuses as $status)
           <tr><th class="text-right text-capitalize">{{$status['text'].' :'}}</th><td id="{{$status['id'].'_att_status'}}"></td></tr>
           @endforeach
           <tr><th class="text-right text-capitalize">{{'Not Marked :'}}</th><td id="none_days"></td></tr>
           <tr><th class="text-right text-capitalize">{{'Working Hours :'}}</th><td id="working_hours"></td></tr>
           <tr><th class="text-right text-capitalize">{{'Late Comings :'}}</th><td id="late_comings"></td></tr>
           <tr><th class="text-right text-capitalize">{{'OverTime :'}}</th><td id="overtime_count"></td></tr>
         </table>

         
 </fieldset>
      </div><!--end 1st col-->

      <div class="col-md-3"><!--start 1st col-->
           <fieldset class="border p-4">
      <legend class="w-auto">Allocated Leaves</legend>
         <table>
          
          @foreach($leave_types as $status)
          
           <tr><th class="text-right text-capitalize">{{$status['text'].' :'}}</th><td id="{{$status['id'].'_allocated_leave'}}"></td></tr>
           
           @endforeach
           
         </table>

         
 </fieldset>
      </div><!--end 1st col-->


      <div class="col-md-3"><!--start 1st col-->
           <fieldset class="border p-4">
      <legend class="w-auto">Availed Leaves</legend>
         <table>
          
          @foreach($leave_types as $status)
          
           <tr><th class="text-right text-capitalize">{{$status['text'].' :'}}</th><td id="{{$status['id'].'_availed_leave'}}"></td></tr>
           
           @endforeach
           
         </table>

         
 </fieldset>
      </div><!--end 1st col-->
     

      
    
      <div class="col-md-3"><!--start 2nd col-->
           <fieldset class="border p-4">
      <legend class="w-auto">Salary Detail</legend>

      <table >
        <tbody id="salary_detail">
          <tr><th class="text-right text-capitalize">Gross Salary : </th><td id="gross_salary"></td></tr>
          <tr><th class="text-right text-capitalize">Leave Deduction: </th><td id="leave_deduction"></td></tr>
          <tr><th class="text-right text-capitalize">Overtime Amount: </th><td id="overtime_amount"></td></tr>
           <tr><th class="text-right text-capitalize">Allwoances Amount: </th><td id="allowance_amount"></td></tr>
           <tr><th class="text-right text-capitalize">Penalities Amount: </th><td id="penality_amount"></td></tr>
           <tr><th class="text-right text-capitalize">LateFine Amount: </th><td id="late_coming_amount"></td></tr>
           <tr><th class="text-right text-capitalize">Total Salary: </th><td id="total_salary"></td></tr>
           </tbody>
         </table>

         

</fieldset>
      </div><!--end 2nd col-->

      
       <div class="col-md-3"><!--start 1st col-->
           <fieldset class="border p-4">
      <legend class="w-auto">Allowances & Deductions</legend>

      <table>
        <tbody id="allowance">
          
        </tbody>
      </table>
          

          
 </fieldset>
      </div><!--end 1st col-->


       <div class="col-md-3"><!--start 1st col-->
           <!-- <fieldset class="border p-4">
      <legend class="w-auto">Leave Balances</legend>
          <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Gross Salary : 
            </div>
              <div class="col-md-8">imran
              </div>
           </div>

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Payable Salary : 
            </div>
              <div class="col-md-8">Ibrar
              </div>
           </div> 

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Department : 
            </div>
              <div class="col-md-8">imran
              </div>
           </div>

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Designation : 
            </div>
              <div class="col-md-8">Ibrar
              </div>
           </div> 

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">Gender : 
            </div>
              <div class="col-md-8">imran
              </div>
           </div>

           <div class="row">
            <div class="col-md-4 text-right font-weight-bold">DOB : 
            </div>
              <div class="col-md-8">Ibrar
              </div>
           </div>  
 </fieldset>
 -->      </div><!--end 1st col-->

      
  </div>
  <!--end employee attendance detail-->


  
      </div>

      
    <!-- /.content -->
   
@endsection

@section('jquery-code')
<script type="text/javascript">

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});

function getProfile() {
            $.ajax({
               type:'get',
               url:'{{ url("/employee/profile1/") }}',
               data:{
                    
                    "_token": "{{ csrf_token() }}",
                    
                     month: jQuery('#month').val(),
                      employee: jQuery('#employee').val(),

               },
               success:function(data) {
                  //start employee detail
                  //alert( data['employee']['name']  );

                  var depart='';
                  if(data['employee']['department']!='')
                   depart=data['employee']['department']['name'];

                  var desi='';
                  if(data['employee']['designation']!='')
                   desi=data['employee']['designation']['name'];


                $('#name').text(data['employee']['name']);
                $('#father').text(data['employee']['father_husband_name']);
                $('#birth').text(data['employee']['dateOfBirth']);
                $('#department').text(depart);
                $('#designation').text(desi);
                $('#gender').text(data['employee']['gender']);

                $('#joiningDate').text(data['employee']['joining_date']);
                $('#cnic').text(data['employee']['cnic']);
                $('#mobile').text(data['employee']['mobile']);
                $('#email').text(data['employee']['email']);
                $('#qualification').text(data['employee']['qualification']);
                $('#employeeCode').text(data['employee']['employee_code']);
                  
                   txt=data['employee']['salary'];
                    $('#gross_salary').html(data['employee']['salary']);
                  //end employee detail

     
                var status = <?php echo json_encode($attendance_statuses); ?>;
                var types = <?php echo json_encode($leave_types); ?>;
                   
                   if(data['profile'].length==0)
                   {
                    $('#total_days').html('');
                  for(i=0;i<status.length;i++)
                  {
                    $('#'+status[i]['id']+'_att_status').html('');
                  }
                    $('#none_days').html('');

                    for(i=0;i<types.length;i++)
                  {
                    
                    $('#'+types[i]['id']+'_allocated_leave').html('');

                    
                    $('#'+types[i]['id']+'_availed_leave').html('');

                    $('#leave_deduction').html('');


                  }

                     $('#allowance').html('');
                     $('#allowance_amount').html('');
                     $('#penality_amount').html('');

                     $('#late_comings').html('');
                     $('#working_hours').html('');
                     $('#overtime_amount').html('');
                     $('#overtime_count').html('');
                     $('#late_coming_amount').html('');
                     $('#total_salary').html('');
                   }//end profile if
                   else
                   {
                   txt=data['profile']['monthly_attendance_status_count']['total_days'];
                    $('#total_days').html(txt);
                  for(i=0;i<status.length;i++)
                  {
                    txt=data['profile']['monthly_attendance_status_count'][status[i]['id']+'_att_status'];
                    $('#'+status[i]['id']+'_att_status').html(txt);
                  }
                  txt=data['profile']['monthly_attendance_status_count']['none'];
                    $('#none_days').html(txt);

                    txt=data['profile']['month_late_comings_count'];
                    $('#late_comings').html(txt);

                    txt=data['profile']['month_overtime_count'];
                    $('#overtime_count').html(txt);

                    txt=data['profile']['month_working_hours'];
                    $('#working_hours').html(txt);

                     for(i=0;i<types.length;i++)
                  {
                    txt=data['profile']['allocated_leave_count'][types[i]['id']+'_allocated_leave'];
                    $('#'+types[i]['id']+'_allocated_leave').html(txt);

                    txt=data['profile']['availed_leave_count'][types[i]['id']+'_availed_leave'];
                    $('#'+types[i]['id']+'_availed_leave').html(txt);
                  }

                  $('#leave_deduction').html(data['profile']['monthly_leave_deduction']);

                  //allowance

                  $('#allowance_amount').html(data['profile']['allowance_amount']);
                  $('#late_coming_amount').html(data['profile']['month_late_comings_amount']);

                  $('#overtime_amount').html(data['profile']['month_overtime_amount']);

                   $('#total_salary').html(data['profile']['total_salary']);

                    text=''; //alert(data['profile']['allowances']);
                  for(i=0;i<data['profile']['allowances'].length;i++)
                  {
                        var val=data['profile']['allowances'][i]['text'];
                        var amount=data['profile']['allowances'][i]['amount'];
                 
                        //alert(val);
           text+=`<tr><th class="text-right text-capitalize">${val} : </th><td id=""> ${amount}</td></tr>`;

                  }

                  //$('#allowance').append(text);
                  //end allowance

                  //penality

                  $('#penality_amount').html(data['profile']['penality_amount']);

                    //text=''; //alert(data['profile']['allowances']);
                  for(i=0;i<data['profile']['penalities'].length;i++)
                  {
                        var val=data['profile']['penalities'][i]['text'];
                        var amount=data['profile']['penalities'][i]['amount'];
                 
                        //alert(val);
           text+=`<tr><th class="text-right text-capitalize">${val} : </th><td id=""> ${amount}</td></tr>`;

                  }

                  $('#allowance').html(text);
                  //end penality

                  }// end else

              
                
               }
            });
         }

</script>

@endsection  
  