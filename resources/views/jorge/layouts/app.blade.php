<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin | @yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css"> -->
  {!! Html::style('plugins/fontawesome-free/css/all.min.css') !!}
  <!-- SWEAT ALERT STYLES-->
  {!! Html::style('plugins/bootstrap-sweetalert/sweetalert.css') !!}
  <!-- DataTables -->
  <!-- <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"> -->
  <!-- <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css"> -->
  {!! Html::style('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}
  {!! Html::style('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!}
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="../../dist/css/adminlte.min.css"> -->
  {!! Html::style('dist/css/adminlte.min.css') !!}

  {!! Html::style('dist/css/admin/app.css') !!}

  @yield('estilos')

</head>
<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
    <!-- Navbar -->
    {{-- START HEADER --}}
        @include('layouts.header')
    {{-- END HEADER --}}
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layouts.menu')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include('flash::message')

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@yield('title') Page</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">@yield('title') Page</li>
                    </ol>
                </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        {{-- START CONTAINER --}}
        @yield('content')
        {{-- END CONTAINER --}}

        

        
    </div>
    <!-- /.content-wrapper -->

    {{-- START Footer --}}
        @include('layouts.footer')
    {{-- END Footer --}}

    <!-- Control Sidebar -->
    <aside class="control-sidebar-menu control-sidebar-dark ">
        <!-- Control sidebar content goes here -->
        
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <!-- <script src="../../plugins/jquery/jquery.min.js"></script> -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <!-- <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('plugins/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <!-- <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->

    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>    

    <!-- AdminLTE App -->
    <!-- <script src="../../dist/js/adminlte.min.js"></script> -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="../../dist/js/demo.js"></script> -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>

    <!-- Page Customer -->
    <!-- <script src="../../dist/js/admin/app.js"></script> -->
    <script src="{{ asset('dist/js/admin/app.js') }}"></script>

    @yield('script')

</body>
</html>
