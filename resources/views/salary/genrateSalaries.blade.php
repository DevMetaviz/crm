
@extends('layout.master')
@section('title', 'Genrate Salary')
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
            <h1 style="display: inline;">Generate Salaries</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <button type="button" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</button>
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

                <div class="row">
                   
                   <div class="col-md-5">

                    <form role="form" method="get" action="{{url('generate/salary/')}}">
                  

                <label>Month</label>
                <input type="month" name="salary_month" required value="@yield('salary_month')"/>

                

                <input type="submit" name="" value="Search">


                  </form>
                     
                   </div>
                </div>
                

                  


              
                <table id="salary_tabel" class="table table-bordered table-hover" style="">
                  
                  
                
                  <thead>
                 <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Salary</th>
                  
                    <th>Lates</th>
                    <th>Late Fine</th>
                    <th>Overtime(mins)</th>
                    <th>Overtime Amount</th>
                    <th>Absent Deduction</th>
                    <th>Allowances</th>

                    
                    <th>Penality Charges</th>
                    <th>Total Salary</th>
                   
                    
                  </tr>

                  </thead>
                  <tbody>
                  @if(isset($employees))
                    @foreach($employees as $emp)
                      
                        <tr>
                   
                     <td>{{$emp['employee']['id']}}</td>
                     <td>{{$emp['employee']['name']}}</td>
                     <td>{{$emp['employee']['salary']}}</td>
                     <td>{{$emp['profile']['month_late_comings_count']}}</td>
                    <td>{{$emp['profile']['month_late_comings_amount']}}</td>
                     <td>{{$emp['profile']['month_overtime_count']}}</td>
                     <td>{{$emp['profile']['month_overtime_amount']}}</td>
                     <td>{{$emp['profile']['monthly_leave_deduction']}}</td>
                     <td>{{$emp['profile']['allowance_amount']}}</td>
                      <td>{{$emp['profile']['penality_amount']}}</td>
                       
                    
                     <td>{{$emp['profile']['total_salary']}}</td>
                     
                    
                     
                     
                                       
                   </tr>

                    @endforeach

                    <tr>
                  <th></th>
                    <th></th>
                    <th>{{$total_basic_salary}}</th>
                  
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>

                    
                    <th></th>
                    <th>{{$total_gross_salary}}</th>
                  </tr>

                  @endif

                  </tbody>

                   <tfoot>
                  <tr>
                  <th>Id</th>
                    <th>Name</th>
                    <th>Salary</th>
                  
                    <th>Lates</th>
                    <th>Late Fine</th>
                    <th>Overtime(mins)</th>
                    <th>Overtime Amount</th>
                    <th>Absent Deduction</th>
                    <th>Allowances</th>

                    
                    <th>Penality Charges</th>
                    <th>Total Salary</th>
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
    $("#salary_tabel").DataTable({
      "responsive": true, 
      "lengthChange": false,
      "paging": false,
       "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#salary_tabel_wrapper .col-md-6:eq(0)');


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
  