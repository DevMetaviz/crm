
@extends('layout.master')
@section('title', 'Employees')
@section('header-css')
<link rel="stylesheet" href="{{asset('/public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <style type="text/css">
    [data-href] {
    cursor: pointer;
}
td
{
 
}
td{
  
  vertical-align: middle;

}
  </style>
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Employee Enrollment</h1>
            <!-- <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
             <a class="btn" style="border: none;background-color: transparent;" href="{{url('down')}}"><span class="fas fa-edit">&nbsp</span>Down</a>-->
            
            <a class="btn" style="border: none;background-color: transparent;" href="{{url('employee-Enrollment')}}"><span class="fas fa-edit">&nbsp</span>New</a>
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

    
      <div class="container-fluid" style="margin-top: 10px;">

          

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">List Of Employees</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover" style="">
                  
                  <thead>
                  <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Employee Code</th>
                    <th>Name</th>
                    <th>Father/Husband Name</th>
                    <th>CNIC</th>
                    <th>Date Of Birth</th>
                    <th>CNIC Place</th>
                    <th>Gender</th>
                    <th>Marital Status</th>
                    <th>qualification</th>
                    <th>religion</th>
                    <th>refference</th>
                    <th>State</th>
                    <th>city</th>
                    <th>address</th>
                    <th>domicile</th>
                    <th>joining_date</th>
                    <th>leaving_date</th>
                    <th>activeness</th>
                    <th>employee_type</th>
                    <th>department</th>
                    <th>designation</th>
                    <th>shift</th>
                    <th>comment</th>
                    <th>phone</th>
                    <th>mobile</th>
                    <th>email</th>
                    <th>salary</th>
                  </tr>



                  </thead>
                  <tbody>
                  
                  @foreach($employees as $emp)
                  <!--  <tr class='clickable-row'  data-href="./employee/+{{$emp['id']}}" > -->
                    <tr>
                    <td><a href="./employee/edit/{{$emp['id']}}/{{$emp['name']}}"><span class="fa fa-edit"></span></a></td>
                    <td>{{$emp['id']}}</td>
                    <td>{{$emp['employee_code']}}</td>
                    <td>{{$emp['name']}}</td>
                    <td>{{$emp['father_husband_name']}}</td>
                    <td>{{$emp['cnic']}}</td>
                    <td>{{$emp['dateOfBirth']}}</td>
                    <td>{{$emp['cnic_place']}}</td>
                    <td>{{$emp['gender']}}</td>
                    <td>{{$emp['marital_status']}}</td>
                    <td>{{$emp['qualification']}}</td>
                    <td>{{$emp['religion']}}</td>
                    <td>{{$emp['refference']}}</td>
                    <td>{{$emp['State']}}</td>
                    <td>{{$emp['city']}}</td>
                    <td>{{$emp['address']}}</td>
                    <td>{{$emp['domicile']}}</td>
                    <td>{{$emp['joining_date']}}</td>
                    <td>{{$emp['leaving_date']}}</td>
                    <td>{{$emp['activeness']}}</td>
                    <td>{{$emp['employee_type']}}</td>
                    <td>@if($emp['department']!=''){{$emp['department']['name']}}@endif</td>
                    <td>@if($emp['designation']!=''){{$emp['designation']['name']}}@endif</td>
                    <td>@if($emp['shift']!=''){{$emp['shift']['shift_name']}}@endif</td>
                    <td>{{$emp['comment']}}</td>
                    <td>{{$emp['phone']}}</td>
                    <td>{{$emp['mobile']}}</td>
                    <td>{{$emp['email']}}</td>
                    <td>{{$emp['salary']}}</td>
                  </tr>
                  @endforeach
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Employee Code</th>
                    <th>Name</th>
                    <th>Father/Husband Name</th>
                    <th>CNIC</th>
                    <th>Date Of Birth</th>
                    <th>CNIC Place</th>
                    <th>Gender</th>
                    <th>Marital Status</th>
                    <th>qualification</th>
                    <th>religion</th>
                    <th>refference</th>
                    <th>State</th>
                    <th>city</th>
                    <th>address</th>
                    <th>domicile</th>
                    <th>joining_date</th>
                    <th>leaving_date</th>
                    <th>activeness</th>
                    <th>employee_type</th>
                    <th>department</th>
                    <th>designation</th>
                    <th>shift</th>
                    <th>comment</th>
                    <th>phone</th>
                    <th>mobile</th>
                    <th>email</th>
                    <th>salary</th>
                  </tr>
                  </tfoot>
                </table>


              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

                   



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')



<!-- DataTables  & Plugins -->
<script src="{{asset('public/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('public/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('public/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('public/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": false,
       "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});

</script>



@endsection  
  