<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cedepas Norte | Inicio </title>
  <link rel="shortcut icon" href="http://www.cedepas.org.pe/sites/default/files/logo-cedepas_0.png" type="image/png">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
 <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">

 <link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
 <link rel="stylesheet" href="/select2/bootstrap-select.min.css">
 
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
 


  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  @yield('estilos')

</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>


    </ul>
    
    <!-- SEARCH FORM -->

    
    <!-- Right navbar links -->
    
  </nav>
  <!-- /.navbar -->
 {{--  {{route('bienvenido')}} --}}
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('user.home') }}" class="brand-link">
      <img src="/adminlte/dist/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      
      
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>

      
            <div class="info">
              <a href="#" class="d-block"> {{ (new App\Empleado())->getNombrePorUser( Auth::id() ) }} </a>
            </div>
    
        
       
        

      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-header">VIGO</li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="far fa-building nav-icon"></i>
              <p>
                Provision de Fondos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Empleado
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('solicitudFondos.listarEmp')}}" class="nav-link">
                      <i class="far fa-address-card nav-icon"></i>
                      <p>Mis Solicitudes</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('rendicionGastos.listarEmpleado')}}" class="nav-link">
                      <i class="far fa-address-card nav-icon"></i>
                      <p>Mis Rendiciones</p>
                    </a>
                  </li>



                  
                </ul>
              </li>
    
    
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Director
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('solicitudFondos.listarDirector')}}" class="nav-link">
                      <i class="far fa-address-card nav-icon"></i>
                      <p>Listar Fondos</p>
                    </a>
                  </li>
    
                  
                </ul>
              </li>
    
              
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Jefe Admin
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('solicitudFondos.listarJefeAdmin')}}" class="nav-link">
                      <i class="far fa-address-card nav-icon"></i>
                      <p>Solicitudes para abonar</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{route('rendicionGastos.listarJefeAdmin')}}" class="nav-link">
                      <i class="far fa-address-card nav-icon"></i>
                      <p>Rendiciones para Reponer</p>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="{{route('solicitudFondos.reportes')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Reportes</p>
                    </a>
                  </li>
                  
    
                </ul>
    
              </li>
            </ul>



          </li>




          
         
          

          


          



          

          <li class="nav-header">RENZO</li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="far fa-building nav-icon"></i>
              <p>
                Gestión de Inventario
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('gestionInventario.mostrarRevisiones')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Actualizar Activos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{URL::to('/gestionInventario')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestión de Revisiones</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{URL::to('/activos')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gestión de Activos</p>
                </a>
              </li>
            </ul>
          </li>






          <li class="nav-header">MARSKY</li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="far fa-building nav-icon"></i>
              <p>
                Asistencia Contable
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              
              
              <li class="nav-item">
                <a href="{{route('admin.listaPeriodos')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin periodos</p>
                </a>
              </li>
              <li class="nav-item">
                
                <a href="{{route('resp.verPeriodo',App\Empleado::getEmpleadoLogeado()->getPeriodoCaja())}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mi periodo actual</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('resp.listarMisPeriodos')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mis periodos</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('caja.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mant Cajas</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{route('declaracion.listar')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pagos</p>
                </a>
              </li>
              
              

              


            </ul>



          </li>

          <li class="nav-header">FELIX</li>
          @if(Auth::user()->isAdmin == 1)
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">

                <p>
                  Mantenedores
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/listarEmpleados" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Empleados</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/listarAreas" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Areas/Puestos</p>
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
            <ul class="nav nav-treeview">
              <?php 
              $cont=0;
              $contratos=App\Empleado::getEmpleadoLogeado()->periodoEmpleado;
              foreach ($contratos as $itemcontrato) {
                if($itemcontrato->activo==1 && $itemcontrato->asistencia==1){
                  $cont+=1;
                }
              }
              ?>
              @if($cont>0)
                <li class="nav-item">
                  <a href="/marcarAsistencia/{{App\Empleado::getEmpleadoLogeado()->codEmpleado}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Asistencia</p>
                    </a>
                </li>
                <li class="nav-item">
                  <a href="/listarSolicitudes/{{App\Empleado::getEmpleadoLogeado()->codEmpleado}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Solicitudes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/listarJustificaciones/{{App\Empleado::getEmpleadoLogeado()->codEmpleado}}o" class="nav-link">
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
{{--   --------------------------------------------     JORGE        ----------------------------------------------------------------- --}}
          <li class="nav-header">JORGE</li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="far fa-building nav-icon"></i>
              <p>
                Inventarios Jorge
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
                   
              <li class="nav-item">
                <a href="{{ route('categoria.index') }}" class="nav-link">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                        Categoria
                    </p>
                </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('existencia.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-database"></i>
                      <p>
                          Existencia
                      </p>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('ingreso.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-arrow-circle-right"></i>
                      <p>
                          Ingreso
                      </p>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('salida.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-arrow-circle-left"></i>
                      <p>
                          Salida
                      </p>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('existenciaPerdida.index') }}" class="nav-link">
                      <i class="nav-icon fas fa-exclamation-circle"></i>
                      <p>
                          Existentes Perdidos
                      </p>
                  </a>
              </li>
              
              <li class="nav-item">
                  <a href="{{ route('exportar') }}" class="nav-link">
                      <i class="nav-icon fas fa-file-alt"></i>
                      <p>
                          Reporte
                      </p>
                  </a>
              </li>

              <li class="nav-item">
                  <a href="{{ route('reporte') }}" class="nav-link">
                      <i class="nav-icon fas fa-file-alt"></i>
                      <p>
                          Movimiento de existentes
                      </p>
                  </a>
              </li>


            </ul>



          </li>


        {{-- fin jorge --}}


          <li class="nav-item">
            <a href="{{route('user.cerrarSesion')}}" class="nav-link">
              <i class="fas fa-sign-out-alt"></i>
              <p>
                Cerrar Sesión
              </p>
            </a>
          </li>

        </ul>
      </nav>






      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        @yield('contenido')
     
    </section>
    <!-- /.content -->
  </div>
 

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
 @yield('script')
<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/adminlte/dist/js/demo.js"></script>

<script src="/select2/bootstrap-select.min.js"></script>   

<!-- PARA SOLUCIONAR EL PROBLEMA DE 'funcion(){' EN js--->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<!-- LIBRERIAS PARA NOTIFICACION DE ELIMINACION--->
<script src="/adminlte/dist/js/sweetalert.min.js"></script>

<script src="/calendario/js/bootstrap-datepicker.min.js"></script>
<script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
<script>

window.onload=verificadoDeSesion();
  function verificadoDeSesion(){
    console.log('El auth id es {{Auth::id()}}');
   // location.href ="{{route('user.verLogin')}}";
  
  
  }




</script>
<link rel="stylesheet" href="/adminlte/dist/css/sweetalert.css">
</body>
</html>