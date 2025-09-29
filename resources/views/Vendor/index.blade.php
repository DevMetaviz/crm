
@extends('layout.master')
@section('title', 'Vendors List')
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
            <h1 style="display: inline;">Vendors List</h1>
            <a class="btn" href="{{url('/configuration/vendor/create')}}" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item"><a href="#">Vendors</a></li>
              <li class="breadcrumb-item active">Vendors List</li>
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
                <h3 class="card-title">Vendors</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                   
                   

                   <div class="col-md-12">
                                            
                   </div>

                </div>

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

              
                <table id="example1" class="table table-bordered table-hover mt-4" style="">
                  
                  <thead>
                  

                 <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Mobile</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>NTN No</th>
                    <th>CNIC</th>
                     <th>Sort Order</th>
                    <th>Status</th>
                    <th></th>
                  </tr>

                  </thead>
                  <tbody>
                  
                 

            
                    @foreach($vendors as $type)
                      
                        <tr>
                   
                     
                     <td>{{$type['id']}}</td>
                     <td>{{$type['name']}}</td>
                    <td>{{ isset($type['vendor_type']) ? $type['vendor_type']['text'] : '' }}</td>
                    <td>{{$type['mobile']}}</td>
                    <td>{{$type['phone']}}</td>
                    <td>{{$type['email']}}</td>
                    <td>{{$type['ntn_number']}}</td>
                    <td>{{$type['cnic']}}</td>
                    <td>{{$type['sort_order']}}</td>
                    <?php $active='Inactive';
                            if($type['status']=='1')
                             $active='Active';
                             ?>
                     <td>{{$active}}</td>
                     <td><a href="{{url('configuration/edit/vendor/'.$type['id'])}}"><span class="fa fa-edit"></span></a></td>
                   
                    
                 
                   
                  </tr>

                    @endforeach
                
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Mobile</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>NTN No</th>
                    <th>CNIC</th>
                     <th>Sort Order</th>
                    <th>Status</th>
                    <th></th>
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
  