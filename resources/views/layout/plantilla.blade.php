<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> @yield('titulo') </title>
  <link rel="shortcut icon" href="http://www.cedepas.org.pe/sites/default/files/logo-cedepas_0.png" type="image/png">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Font Awesome -->
 <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">

 <link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
 <link rel="stylesheet" href="/select2/bootstrap-select.min.css">
 <link rel="stylesheet" href="/css/siderbarstyle.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
 
  {!! Html::style('plugins/bootstrap-sweetalert/sweetalert.css') !!}
  <!-- DataTables -->
  <!-- <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"> -->
  <!-- <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css"> -->
  {!! Html::style('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}
  {!! Html::style('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!}


  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


  <style>
    .notificacionXRendir{
      background-color: rgb(87, 180, 44);
      
    }

    .notificacionObservada{
      background-color: rgb(209, 101, 101);
          
    }
    .form-control-undefined {
        display: block;
        width: 100%;
        height: calc(2.25rem + 2px);
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        box-shadow: 0 0 5px 3px #dc354599;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url('/img/espera.gif') 50% 50% no-repeat rgb(249,249,249);
      background-size: 10%;
      opacity: .8;
    }
  </style>
  @yield('estilos')

</head>
<body class="hold-transition sidebar-mini">
  <!--<div class="loader"></div>-->
  @yield('tiempoEspera')
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">

      <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"
           role="button"><i class="fas fa-bars"></i>
          </a>
      </li>


    </ul>
    
    
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu --> {{-- VER CARRITO RAPIDAMENTE --}}
      
      @include('layout.notificaciones.Solicitudes')
      
      @include('layout.notificaciones.Reposiciones')
      @include('layout.notificaciones.Rendiciones')
    </ul>
    








    
  </nav>
  <!-- /.navbar -->
 {{--  {{route('bienvenido')}} --}}
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('user.home') }}" class="brand-link">
      <img src="/img/logo cuadrado.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CEDEPAS Norte</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      
      
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>

      
            <div class="info">
              <a href="{{route('GestionUsuarios.verPerfil')}}" class="d-block"> {{ (new App\Empleado())->getNombrePorUser( Auth::id() ) }} </a>
             
                <label for="" style="color: rgb(255, 255, 255))">
                  {{  (App\Empleado::getEmpleadoLogeado()->getPuestoActual()->nombre ) }}
                </label>
      
            </div>
   
      </div>

      
<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" 
          role="menu" data-accordion="false">
         
        
            @include('layout.menuLateralCDS')  
          
            
        
           
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
  <!--<aside class="control-sidebar control-sidebar-dark">-->
    <!-- Control sidebar content goes here -->
  <!--</aside>-->
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/adminlte/dist/js/demo.js"></script>

<script src="/select2/bootstrap-select.min.js"></script>   

<!-- PARA SOLUCIONAR EL PROBLEMA DE 'funcion(){' EN js--->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- LIBRERIAS PARA NOTIFICACION DE ELIMINACION--->
<script src="/adminlte/dist/js/sweetalert.min.js"></script>

<script src="/calendario/js/bootstrap-datepicker.js"></script>

<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>    
<script src="{{ asset('plugins/bootstrap-sweetalert/sweetalert.min.js') }}"></script>


<script src="{{ asset('dist/js/admin/app.js') }}"></script>



<script type="application/javascript">
  function number_format(amount, decimals) {
          amount += ''; // por si pasan un numero en vez de un string
          amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
          decimals = decimals || 0; // por si la variable no fue fue pasada
          // si no es un numero o es igual a cero retorno el mismo cero
          if (isNaN(amount) || amount === 0) 
              return parseFloat(0).toFixed(decimals);
          // si es mayor o menor que cero retorno el valor formateado como numero
          amount = '' + amount.toFixed(decimals);
          var amount_parts = amount.split('.'),
              regexp = /(\d+)(\d{3})/;
          while (regexp.test(amount_parts[0]))
              amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
          return amount_parts.join('.');
  }


  
  function confirmar(msj,type,formName){
        swal(
            {//sweetalert
                title: msj,
                text: '',     //mas texto
                type: type,//e=[success,error,warning,info]
                showCancelButton: true,//para que se muestre el boton de cancelar
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText:  'SI',
                cancelButtonText:  'NO',
                closeOnConfirm:     true,//para mostrar el boton de confirmar
                html : true
            },
            function(value){//se ejecuta cuando damos a aceptar
                if(value) document.getElementById(formName).submit();
            }
        );
        
    }
    function alerta(msj){
        swal(//sweetalert
            {
                title: 'Error',
                text: msj,     //mas texto
                type: 'warning',//e=[success,error,warning,info]
                showCancelButton: false,//para que se muestre el boton de cancelar
                confirmButtonColor: '#3085d6',
                //cancelButtonColor: '#d33',
                confirmButtonText:  'OK',
                //cancelButtonText:  'NO',
                closeOnConfirm:     true,//para mostrar el boton de confirmar
                html : true
            },
            function(){//se ejecuta cuando damos a aceptar
                
            }
        );
    }
</script>
@yield('script')
<link rel="stylesheet" href="/adminlte/dist/css/sweetalert.css">

</body>
</html>