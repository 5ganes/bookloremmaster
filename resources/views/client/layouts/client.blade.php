<!DOCTYPE html>
<html lang="en">

<head>
  @include('client/includes/meta')
  @yield('otherstyles')
</head>

<body id="page-top">

  {{-- Top Navigation Bar --}}
  @include('client/includes/topnav')
  {{-- Top Navigation Bar Ends --}}

  <div id="wrapper">  

    @include('client/includes/sidebar')

    <div id="content-wrapper" style="background-image: none">

      <div class="container-fluid">
        @yield('content')
      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      @include('client/includes/footer')

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  @include('client/includes/scrolltotop')

  @include('client/includes/scripts')
  @yield('otherscripts')

</body>

</html>