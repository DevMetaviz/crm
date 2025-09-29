@include('layout.header')

<body class="hold-transition sidebar-mini  sidebar-collapse1 sidebar-custom-collapse  layout-navbar-fixed layout-fixed">


<!-- Site wrapper -->
<div class="wrapper">
  
 
<?php $id=Auth::user()->roles->first()->id; ?>

@if($id==1)
@include('layout.aside')
@elseif($id==2)
@include('layout.qc_aside')
@elseif($id==3)
@include('layout.store_aside')
@elseif($id==4)
@include('layout.hr_aside')
@elseif($id==5)
@include('layout.acc_aside')
@elseif($id==6)
@include('layout.pro_aside')
@endif

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


@include('layout.top_navbar') 

    <!-- Main content -->

   

    <section class="content-header bjhj" style="padding: 0px;">
      @yield('content-header')
    </section>


        <section class="content" style="">
         @yield('content')
         </section>

       <!-- /.content -->



      @include('layout.footer') 

  </div>
  <!-- /.content-wrapper -->



  
</div>
<!-- ./wrapper -->

<!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

<!-- jQuery -->
<script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('public/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- jquery-validation -->
<script src="{{asset('public/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('public/dist/js/demo.js')}}"></script>

<!-- Custom-->
<script src="{{asset('public/js/custom.js')}}"></script>

<script>
  
$('select[name="company_id"]').on('change', function () {

     let companies = @json($companies);
     
        let companyId = $(this).val();
        let branchSelect = $('select[name="branch_id"]');

        branchSelect.empty(); // clear old options

        if (companyId) {
            // Find company in companies array
            let company = companies.find(c => c.id == companyId);

            branchSelect.append('<option value="">Select any branch</option>');

            if (company && company.branches.length > 0) {
                company.branches.forEach(branch => {
                    branchSelect.append(
                        $('<option>', {
                            value: branch.id,
                            text: branch.name
                        })
                    );
                });
            } else {
               // branchSelect.append('<option value="">No branches available</option>');
            }
        }
    });
 </script>

@yield('jquery-code')
</body>
</html>
