
@extends('layout.master')
<?php 

$name='';
    if(isset($config['employee_name']))
      $name=$config['employee_name'];

 ?>
@section('title', $name.' Monthly Attendance')
@section('header-css')
<link rel="stylesheet" href="{{asset('/public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Report Monthly Attendance</h1>
            
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Attendance</a></li>
              <li class="breadcrumb-item active">Employee Monthly Attendance</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">Attendance</h3>
                 <!-- <button form="attendances_form" type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button> -->
                <!-- <a href="{{url('employee/attendance/register-search')}}" class="float-sm-right">Employee Wise Attendance</a> -->
               <div class="card-tools">

                

                  <div class="btn-group">
                    <button type="button" class="btn btn-info btn-tool btn-sm dropdown-toggle" data-toggle="dropdown" >
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="{{url('/mark/leave')}}" class="dropdown-item">Mark Leave</a>
                      <a href="{{url('/leaves')}}" class="dropdown-item">Leaves</a>
                      <div class="dropdown-divider"></div>
                      <a href="{{url('employee/attendance/register-search')}}" class="dropdown-item">Employee Wise Attendance</a>
                    </div>
                  </div>

                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                    <form role="form" method="get" action="{{url('employees/monthly-attendance/report')}}">
                   <fieldset class="border p-4">
                   <legend class="w-auto">Select</legend>
                     <label>Month</label>
                     <input type="month" name="attendance_month" value="@if(isset($config)){{$config['attendance_month']}}@endif" required />

                     <label>Employee</label>
                    <select name="employee_id" id="employee_id" required>
                      <option value="">---Select Any Employee---</option>
                      @foreach($employees as $emp)
                      <option value="{{$emp['id']}}">{{$emp['name']}}</option>
                      @endforeach
                    </select>

                    <input type="submit" name="" value="Load Attendance">

                    

                 </fieldset>
                 </form>

                 
                
                <table id="example1" class="table table-bordered table-hover " style="">
                  
                  <thead>
                  <tr>             
                    
                     <th>Date</th>
                     <th>Day</th>
                     <th>Attendance Status</th>
                     <th>C/In</th>
                     <th>C/Out</th>
                     <th>Working Hours</th>
                   </tr>
                 </thead>
                  <tbody>
                     @if(isset($config))
                                     
                  @foreach($attendances as $emp)
                 
                  
                  <tr>

                  <td style="padding:0px;">{{ $emp['date'] }}</td>

                  <td style="padding:0px;">{{ $emp['day'] }}</td>

                  <td style="padding:0px;">
                     
                     {{ $emp['status'] }}

                                        
                  </td>
                  <td style="padding:0px;">{{ $emp['in_time'] }}</td>
                  <td style="padding:0px;">{{ $emp['out_time'] }}</td>

                   <td style="padding:0px;">{{ $emp['working_hours'] }}</td>
                
               
                   </tr>
                  @endforeach
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td >{{$total_working_hours}}</td>
                  </tr>
                       @else
                       <tr>             
                    
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                   </tr>
                      
                      @endif
                  </tbody>
                  <tfoot>
                  <tr>             
                    
                     <th>Date</th>
                     <th>Day</th>
                     <th>Attendance Status</th>
                     <th>C/In</th>
                     <th>C/Out</th>
                     <th>Working Hours</th>
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

<script type="text/javascript">

$(document).ready(function(){

  @if(isset($config))
 var employee_id=<?php echo $config['employee_id'] ; ?> ;
 $('#employee_id').find('option[value="'+employee_id+'"]').attr("selected", "selected");
  @endif 



@if(isset($attendances))
 var attendances=<?php echo json_encode($attendances); ?> ;



for (var i = 0 ; i < attendances.length ; i++) {
    
    value1=attendances[i]['status']
    id=attendances[i]['date']
   
   if(value1!="")
   {
    
 
    $('#'+id+'_status').find('option[value="'+value1+'"]').attr("selected", "selected");
   
   }

  }

  @endif  


})


</script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, 
      "paging": false,
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
  