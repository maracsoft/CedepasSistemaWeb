<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Blank Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">

<!-- DataTables -->
  <link rel="stylesheet" href="/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- PARA SOLUCIONAR EL PROBLEMA DE 'funcion(){' EN js--->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

  <!-- LIBRERIAS PARA NOTIFICACION DE ELIMINACION--->
  <script src="/adminlte/dist/js/sweetalert.min.js"></script>
  <link rel="stylesheet" href="/adminlte/dist/css/sweetalert.css">
  @yield('estilos')

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <div class="text-white">{{ Auth::user()->empleado->nombres}} {{ Auth::user()->empleado->apellidos }}</div>

          <a href="/salir" class="btn  bg-gradient-secondary btn-xs">Salir</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          @if(Auth::user()->isAdmin == 0)
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">

                <p>
                  Mantenedores
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav">
                <li class="nav-item">
                  <a href="/listarEmpleados" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Empleados</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/listarAsistencia" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Asistencias</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/listarSolicitudesJefe" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Solicitudes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/listarJustificacionesJefe" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Justificaciones</p>
                  </a>
                </li>
                
              </ul>
            </li>
          @endif

          <!-----------------------------------------------UNIDAD 2----------------------------------------------------------------->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">

              <p>
                Control Asistencia
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav">
              <?php 
              $cont=0;
              $contratos=Auth::user()->empleado->periodoEmpleado;
              foreach ($contratos as $itemcontrato) {
                if($itemcontrato->activo==1 && $itemcontrato->asistencia==1){
                  $cont+=1;
                }
              }
              ?>
              @if($cont>0)
                <li class="nav-item">
                  <a href="/marcarAsistencia/{{Auth::user()->empleado->codEmpleado}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Asistencia</p>
                    </a>
                </li>
                <li class="nav-item">
                  <a href="/listarSolicitudes/{{Auth::user()->empleado->codEmpleado}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Solicitudes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/listarJustificaciones/{{Auth::user()->empleado->codEmpleado}}o" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Justificaciones</p>
                  </a>
                </li>
              @else
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>NO NECESITA</p>
                </a>
              </li>
              @endif
              
              
            </ul>
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">

      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <br />
  <!--
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.

  </footer>
  -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>

<!-- DataTables -->
<script src="/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/adminlte/dist/js/demo.js"></script>}

<script>// para validar que esté logeado





</script>


@yield('script')
</body>
</html>
