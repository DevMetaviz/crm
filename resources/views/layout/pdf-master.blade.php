<html>
<head>
  <title>@yield('title')</title>
  

  @include('layout.pdf-style')

</head>
<body>
  
<header>

  <table width="100%" style="padding: 10px;" cellspacing="0">
        <tr>
            <td align="" style="width: 34%;">
               
                <!--- <p class="top-heading-name"><strong>{{$order['company']['name']}}</strong></p>
                <p class="top-heading-address"><b>{{$order['branch']['name']}}</p>-->
            </td>
            <td align="center" style="width: 33%">
                <p class="top-heading"><strong>@yield('header-title')</strong></p>
                <!-- <P class="top-heading"><strong>GATE PASS</strong></P> -->
            </td>
            <td align="right"  style="width: 33%;">

               <!---<img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="130">-->
                
            </td>
        </tr>

        <tr><td colspan="3"><hr></td></tr>
         
        

        

    </table>
             
  @yield('header-content')
</header>

  <main>
    @yield('content')
  </main>

  @include('layout.pdf-footer')
</body>
</html>



