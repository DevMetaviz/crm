@include('layout.pdf.head')

<body class="">
	<!-- Site wrapper -->
<div class="wrapper">
  
 


    <!-- Main content -->

    <section class="content-header" style="">
      @include('layout.pdf.header')
    </section>


        <section class="content">
       @yield('content')
          </section>

       <!-- /.content -->




@include('layout.pdf.footer') 

  </div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>


@yield('jquery-code')
</body>
</html>
