<!DOCTYPE html>
<html>
<head>
	 <meta charset="utf-8"/>
     <title>CEDEPAS Norte | Login</title>
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta content="width=device-width, initial-scale=1.0" name="viewport"/>      
     <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
     <link rel="stylesheet" href="/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
     <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
     <link rel="stylesheet" href="/stylebonis.css">
     <link rel="stylesheet" href="css/login.css">
     <link rel="stylesheet" href="css/style.css">
     <link  rel="stylesheet" href="public/uicons-regular-rounded/css/uicons-regular-rounded.css">
     <link rel="shortcut icon" href="http://www.cedepas.org.pe/sites/default/files/logo-cedepas_0.png" type="image/png">
      
</head>
<div class="conteiner">
    <br>
<div class="login-wrap">
	

	<form method="POST" action="{{route('user.logearse')}}">
		@csrf  
		<div class="login-html">
			<input id="tab-1" type="radio" name="tab" class="sign-in" checked>
				<label for="tab-1" class="tab">Iniciar Sesión</label>


			<input id="tab-2" type="radio" name="tab" class="sign-up">
				<label for="tab-2" class="tab"> </label>


			<div class="login-form">
				<div class="sign-in-htm">
					<div class="group">
						<label for="user" class="label">Usuario</label>
						<input type="text" class="input" placeholder="Ingrese usuario" 
							id="usuario" name="usuario" value="{{old('usuario')}}">
					</div>
					<div class="group">
						<label for="pass" class="label">Contraseña</label>
						<input placeholder="Ingrese contraseña"  id="password" name="password"
							type="password" class="input" data-type="password">
					</div>
				
					<div class="group">
						<input type="submit" class="button" value="Ingresar">
					</div>
					<div class="hr"></div>
					{{-- <div class="foot-lnk">
						<a href="#forgot">Forgot Password?</a>
						<
					</div> --}}
					

				</div>

				{{-- Los registros son desde adentro, no necesitamos --}}
				{{-- <div class="sign-up-htm">
					<div class="group">
						<label for="user" class="label">Username</label>
						<input id="user" type="text" class="input">
					</div>
					<div class="group">
						<label for="pass" class="label">Password</label>
						<input id="pass" type="password" class="input" data-type="password">
					</div>
					<div class="group">
						<label for="pass" class="label">Repeat Password</label>
						<input id="pass" type="password" class="input" data-type="password">
					</div>
					<div class="group">
						<label for="pass" class="label">Email Address</label>
						<input id="pass" type="text" class="input">
					</div>
					<div class="group">
						<input type="submit" class="button" value="Sign Up">
					</div>
					<div class="hr"></div>
					<div class="foot-lnk">
						<label for="tab-1">Already Member?</a>
					</div>
				</div>
	--}}
	
			</div>
			<div align="center">
				<img src="https://lh3.googleusercontent.com/proxy/JBDJ0EzX1HHyYAfO_a8C5X-5GM1ZKTQbchoDuGcpa_5uWWwsH23B1GK4wL1VUYYeggb_at4MTlyoU3BGncvSYY-A5v3mK3s6y8pIEvlIrZxHYM5rId9uLA"
				width="200" height="140" ></div>
		</div>
		
	</form>


</div>
</div>
</html>