<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>
<body class="hold-transition login-page">


    <script type="text/javascript">

        //$(document).ready(function(){
            function validarUsuario() 
                {
                    if (document.getElementById("usuario").value == ""){
                        alert("Ingrese el usuario");
                        $("#usuario").focus();
                    }
                    else if (document.getElementById("password").value == ""){
                        alert("Ingrese contraseña del usuario");
                        $("#password").focus();
                    }
                    else{
                        document.frmusuario.submit(); // enviamos el formulario	
                    }
                }
         //   });
    </script>




<div class="login-box">
  <div class="login-logo">
    <a href="/adminlte/index2.html"><b>PROCESOS vs ORGANIZACION</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <!--
      <p class="login-box-msg">Sign in to start your session</p>
        -->
      <p class="login-box-msg">Sign in</p>  

      @if (Session::has('login_errors'))<!--si existe-->
      <p style='color:rgb(41, 39, 153)'>El nombre de usuario o la contraseña no son correctos.</p>
      @endif


      <form id="frmusuario" name="frmusuario" action="/login" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario">
          <div class="input-group-append">
            <div class="input-group-text">

            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" id="password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">

            </div>
          </div>
        </div>
        <div class="row">

          <!-- /.col -->
          <div class="col-4">
            <input type="button" class="btn btn-primary"  value="Ingresar" onclick="validarUsuario()" />
          </div>
          <!-- /.col -->
        </div>
      </form>


    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.min.js"></script>

</body>
</html>
