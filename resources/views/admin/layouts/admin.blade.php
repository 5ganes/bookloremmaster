<!DOCTYPE html>
<html lang="en">

<head>
  @include('admin/includes/meta')
  @yield('otherstyles')
</head>

<body id="page-top">

  {{-- Top Navigation Bar --}}
  @include('admin/includes/topnav')
  {{-- Top Navigation Bar Ends --}}

  <div id="wrapper">  

    @include('admin/includes/sidebar')

    <div id="content-wrapper">

      <div class="container-fluid">
        <!--all type of alerts starts here-->
        @include('admin/includes/alert')
        <!--all type of alerts ends here-->

        @yield('content')
      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      @include('admin/includes/footer')

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  @include('admin/includes/scrolltotop')

  <!-- Logout Modal-->
  @include('admin/includes/logoutmodal')

  @include('admin/includes/scripts')
  @yield('otherscripts')

</body>

</html>