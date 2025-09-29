
@extends('layout.master')
@section('title', 'Make Salary')
@section('header-css')


  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="make_salary" method="get" action="{{url('make-month-salary')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Generate Salaries</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Generate</button>
            <a class="btn" href="{{url('salary/history')}}"><span class="fas fa-edit">&nbsp</span>History</a>
            <!-- <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <button type="button" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</button> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Employees</a></li>
              <li class="breadcrumb-item active">Generate Salaries</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">Salary Sheet</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                 @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

                <div class="row">
                   
                   <div class="col-md-5">

                    
                  

                <label>Month</label>
                <input type="month" name="salary_month" id="salary_month" required value=""/>

                

               


                  </form>
                     
                   </div>
                </div>
                

                  <div class="row">

                    <div class="col-md-3">

                      <div class="card card-row card-info">
                         <div class="card-header">
                            <h3 class="card-title">
                                     Departments
                             </h3>
                          </div>
                       <div class="card-body">

                          <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="{{'depart_all'}}" value="0" onchange="setAllEmployees()" >
                          <label for="{{'depart_all'}}" class="custom-control-label">All Departments</label>
                          </div>

                  
                        @foreach($departments as $depart)
                          <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="{{'depart_'.$depart['id']}}" value="{{$depart['id']}}" onchange="setEmployee('{{$depart['id']}}')" >
                          <label for="{{'depart_'.$depart['id']}}" class="custom-control-label">{{$depart['name']}}</label>
                          </div>
                      
                          @endforeach
           
                        </div>
                      </div>


                    </div>

                    <div class="col-md-3">

                      <div class="card card-row card-info">
                         <div class="card-header">
                            <h3 class="card-title">
                                     Employees
                             </h3>
                          </div>
                       <div class="card-body" id="emp_body" style="height: 300px;overflow-y: scroll;">
                        
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="{{'emp_all'}}" value="0" onchange="checkAllEmployees()" checked>
                          <label for="{{'emp_all'}}" class="custom-control-label">All Employees</label>
                          </div>
           
                        </div>
                      </div>


                    </div>
                    

                  </div>


              
              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')

<script type="text/javascript">

 

function checkAllEmployees()
{

  var chk=jQuery(`input[id=emp_all]`).is(':checked');
   
   if(chk==true)
    {
          var departs=JSON.parse('<?php echo json_encode($departments); ?>');  
          for (var i =0; i < departs.length ; i++) {

              
                var emps=departs[i]['active_employees'];

                for (var k =0; k < emps.length ; k++) {

                   if( $(`#emp_l_${emps[k]['id']}`). length > 0 )
                    { 

                         $(`#emp_${emps[k]['id']}`).prop("checked", true);
                     }
  
                          
                }

                   
           }
    }
    else
    {

    }

}

  function setAllEmployees()
{
      var chk=jQuery(`input[id=depart_all]`).is(':checked');
   
   if(chk==true)
    {
          var departs=JSON.parse('<?php echo json_encode($departments); ?>');  
          for (var i =0; i < departs.length ; i++) {

               $(`#depart_${departs[i]['id']}`).prop("checked", true);
                var emps=departs[i]['active_employees'];

                for (var k =0; k < emps.length ; k++) {

                   if( $(`#emp_l_${emps[k]['id']}`). length > 0 )
                    { continue; }
      
                txt=`<div class="custom-control custom-checkbox" id="emp_l_${emps[k]['id']}">
                          <input class="custom-control-input" form="make_salary" type="checkbox" id="emp_${emps[k]['id']}" name="employees[]"  value="${emps[k]['id']}"  checked>
                          <label for="emp_${emps[k]['id']}" class="custom-control-label">${emps[k]['name']}</label>
                          </div>`;
                     $(`#emp_body`).append(txt);
                          
                }

                   
           }
    }
    else
    {

    }
}
  
function setEmployee(depart_id)
{    

    departs=JSON.parse('<?php echo json_encode($departments); ?>');  

   let point = departs.findIndex((item) => item.id == depart_id);

  
    var emps=departs[point]['active_employees'];

    var chk=jQuery(`input[id=depart_${depart_id}]`).is(':checked');
   
   if(chk==true)
    {
    var all='';

    for (var i =0; i < emps.length ; i++) {

      
      
      txt=`<div class="custom-control custom-checkbox" id="emp_l_${emps[i]['id']}">
                          <input class="custom-control-input" form="make_salary" type="checkbox" id="emp_${emps[i]['id']}" name="employees[]"  value="${emps[i]['id']}" onchange="uncheckAllEmp()"  checked>
                          <label for="emp_${emps[i]['id']}" class="custom-control-label">${emps[i]['name']}</label>
                          </div>`;

                          all=all + txt;
    }

     $(`#emp_body`).append(all);
   }
   else
   {
        for (var i =0; i < emps.length ; i++) {

             $(`#emp_l_${emps[i]['id']}`).remove();
        }

        $(`#depart_all`).prop("checked", false);
   }

   //var chk=jQuery(`input[id=emp_40]`).is(':checked'); alert(chk);

}

function uncheckAllEmp()
{
  $(`#emp_all`).prop("checked", false);
}

</script>





@endsection  
  