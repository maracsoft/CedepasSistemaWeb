@extends('Layout.Plantilla')


@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')


<script type="text/javascript"> 
          
    function validarregistro(nroFrm) 
        {
            var expreg = new RegExp("^[A-Za-zÑñ À-ÿ]+$");//para apellidos y nombres ^[a-zA-Z ]+$ ^[A-Za-zÑñ À-ÿ]$
            if(nroFrm==1){
                if (document.getElementById("contraseña").value == ""){
                    alerta("Ingrese contraseña del usuario");
                    $("#contraseña").focus();
                }
                else if (document.getElementById("contraseña").value != document.getElementById("contraseña2").value){
                    alerta("Las contraseñas no coinciden");
                    $("#contraseña").focus();
                }
                else{
                    confirmar('¿Seguro de guardar la contraseña?','warning','frmUsuario');
                }
            }
            if(nroFrm==2){
                if (document.getElementById("nombres").value == ""){
                    alerta("Ingrese nombres del usuario");
                    $("#nombres").focus();
                }
                else if (!expreg.test(document.getElementById("nombres").value)){
                    alerta("Ingrese nombres correctos");
                    $("#nombres").focus();
                }
                else if (document.getElementById("apellidos").value == ""){
                    alerta("Ingrese apellidos del usuario");
                    $("#apellidos").focus();
                }
                else if (!expreg.test(document.getElementById("apellidos").value)){
                    alerta("Ingrese apellidos correctos");
                    $("#apellidos").focus();
                }
                else if (document.getElementById("DNI").value == ""){
                    alerta("Ingrese DNI de la usuario");
                    $("#DNI").focus();
                }
                else if (document.getElementById("DNI").value.length != 8){
                    alerta("Ingrese DNI de 8 caracteres");
                    $("#DNI").focus();
                }
                else{
                    confirmar('¿Seguro de guardar los cambios de los datos personales?','warning','frmEmpleado');
                }
            }       
        }
    
</script>

    <br>
    <div class="well"><H3 style="text-align: center;">CONTRASEÑA</H3></div>
    <br>
    <form id="frmUsuario" name="frmUsuario" role="form" action="{{route('GestionUsuarios.updateContrasena')}}" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 
            <input type="text" class="form-control" id="codEmpleado" name="codEmpleado" placeholder="Codigo" value="{{ $empleado->codEmpleado}}" hidden>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Contraseña:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Contraseña...">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Repetir Contraseña:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" id="contraseña2" name="contraseña2" placeholder="Contraseña...">
                </div>
            </div>

            <button type="button" class="btn btn-primary float-right" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                onclick="validarregistro('1')"><i class='fas fa-save'></i> Registrar</button> 

            
    </form>
<br> <hr>
<div class="well"><H3 style="text-align: center;">DATOS PERSONALES</H3></div>
<br>
    <form id="frmEmpleado" name="frmEmpleado" role="form" action="{{route('GestionUsuarios.updateDPersonales')}}" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 
            <input type="text" class="form-control" id="codEmpleado" name="codEmpleado" placeholder="Codigo" value="{{ $empleado->codEmpleado}}" hidden>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Nombres:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres..." value="{{$empleado->nombres}}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Apellidos:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos..." value="{{$empleado->apellidos}}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">DNI:</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="DNI" name="DNI" placeholder="DNI..." value="{{$empleado->dni}}">
                </div>
            </div>
              
            <button type="button" class="btn btn-primary float-right" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                onclick="validarregistro('2')"><i class='fas fa-save'></i> Registrar</button> 
            <!--<a href="" class="btn btn-info float-left"><i class="fas fa-arrow-left"></i> Regresar al Menu</a>-->
    </form>
@endsection


@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection
