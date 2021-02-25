@extends('layout.plantilla')


@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')

<!--
<script type="text/javascript"> 
    $(document).ready(function(){
        $('#codArea').change(function(){

            var codigo=$('#codArea').val();
            
            if(codigo!=0){

                $.ajax({
                    url: '/listarPuestos/' + codigo,
                    type: 'post',
                    data: {
                        codigo     : codigo,
                        _token	 	: "{{ csrf_token() }}"
                    },
                    dataType: 'JSON',
                    success: function(respuesta) {
                        var comboPuestos = '<label class="col-sm-1 col-form-label" style="margin-left:350px;">Puesto:</label>';
                         comboPuestos += '<div class="col-sm-4">';
                             comboPuestos += '<select class="form-control" name="codPuesto" id="codPuesto">';
                                 comboPuestos += '<option value="0">--Seleccionar--</option>';
                                for (var i in respuesta.puestos) {
                                     comboPuestos += '<option value="'+respuesta.puestos[i].codPuesto+'">'+respuesta.puestos[i].nombre+'</option>';
                                }
                             comboPuestos += '</select>';
                         comboPuestos += '</div>';

                        $('#comboPuestos').html(comboPuestos);
                    }
                });
                
            }else{
                var comboPuestos = '<label class="col-sm-1 col-form-label" style="margin-left:350px;">Puesto:</label>';
                         comboPuestos += '<div class="col-sm-4">';
                             comboPuestos += '<select class="form-control" name="codPuesto" id="codPuesto">';
                                 comboPuestos += '<option value="0">--Seleccionar--</option>';
                                
                             comboPuestos += '</select>';
                         comboPuestos += '</div>';

                $('#comboPuestos').html(comboPuestos);
            }

        })
    });
</script>
-->

<script type="text/javascript"> 
          
    function validarregistro() 
        {
            var expreg = new RegExp("^[A-Za-zÑñ À-ÿ]+$");//para apellidos y nombres ^[a-zA-Z ]+$ ^[A-Za-zÑñ À-ÿ]$
            /*
            if(expreg2.test(document.getElementById("usuario").value))
                alert("La matrícula es correcta");
            else
                alert("La matrícula NO es correcta");
            */
            if (document.getElementById("usuario").value == ""){
                alert("Ingrese el usuario");
                $("#nombre").focus();
            }
            else if (document.getElementById("contraseña").value == ""){
                alert("Ingrese contraseña del usuario");
                $("#contraseña").focus();
            }
            else if (document.getElementById("contraseña").value != document.getElementById("contraseña2").value){
                alert("Las contraseñas no coinciden");
                $("#contraseña").focus();
            }
            else if (document.getElementById("nombres").value == ""){
                alert("Ingrese nombres del usuario");
                $("#nombres").focus();
            }
            else if (!expreg.test(document.getElementById("nombres").value)){
                alert("Ingrese nombres correctos");
                $("#nombres").focus();
            }
            else if (document.getElementById("apellidos").value == ""){
                alert("Ingrese apellidos del usuario");
                $("#apellidos").focus();
            }
            else if (!expreg.test(document.getElementById("apellidos").value)){
                alert("Ingrese apellidos correctos");
                $("#apellidos").focus();
            }
            else if (document.getElementById("direccion").value == ""){
                alert("Ingrese direccion del usuario");
                $("#direccion").focus();
            }
            else if (document.getElementById("fechaNacimiento").value == ""){
                alert("Ingrese fecha de nacimiento del usuario");
                $("#fechaNacimiento").focus();
            }
            else if (document.getElementById("DNI").value == ""){
                alert("Ingrese DNI de la usuario");
                $("#DNI").focus();
            }
            else if (document.getElementById("DNI").value.length != 8){
                alert("Ingrese DNI de 8 caracteres");
                $("#DNI").focus();
            }
            else if (document.getElementById("codSexo").value == "0"){
                alert("Seleccione el sexo de usuario");
            }
            else{
                document.frmempresa.submit(); // enviamos el formulario	
            }
        }
    
</script>

    
    <div class="well"><H3 style="text-align: center;">EDITAR EMPLEADO</H3></div>
    <br>
    <form id="frmempresa" name="frmempresa" role="form" action="/editarEmpleado/save" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 
            <input type="text" class="form-control" id="codEmpleado" name="codEmpleado" placeholder="Codigo" value="{{ $empleado->codEmpleado}}" hidden>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Usuario:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario..." value="{{$empleado->usuario()->usuario}}">
                </div>
            </div>

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
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Direccion:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion..." value="{{$empleado->direccion}}">
                </div>
            </div>

            <div class="form-group row">                   
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Fecha de nacimiento:</label>
                <div class="col-md-4">                        
                    <div class="form-group">                            
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fechaNacimiento" id="fechaNacimiento"
                                   value="{{date("d/m/Y",strtotime($empleado->fechaNacimiento))}}" style="text-align:center;">
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
<!--
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Area:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codArea" id="codArea">
                    <option value="0">--Seleccionar--</option>

                    </select>
                </div>
            </div>
            <div class="form-group row" id="comboPuestos">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Puesto:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codPuesto" id="codPuesto">
                    <option value="0">--Seleccionar--</option>

                    </select>
                </div>
            </div>
        -->
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">DNI:</label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="DNI" name="DNI" placeholder="DNI..." value="{{$empleado->dni}}">
                </div>
            </div>


                <div class="form-group row">
                    <label class="col-sm-1 col-form-label" style="margin-left:350px;">Sexo:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="codSexo" id="codSexo">
                        <option value="0" >--Seleccionar--</option>
                        <option value="M" {{ 'M'==$empleado->sexo ? 'selected':'' }}>Hombre</option>
                        <option value="F" {{ 'F'==$empleado->sexo ? 'selected':'' }}>Mujer</option>
                        </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-1 col-form-label" style="margin-left:350px;">¿Tiene Hijos?:</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="tieneHijos" id="tieneHijos">
                        <option value="1" {{ 1==$empleado->tieneHijos ? 'selected':'' }}>SI</option>
                        <option value="0" {{ 0==$empleado->tieneHijos ? 'selected':'' }}>NO</option>
                        
                        </select>
                    </div>
                  </div>


            <br />
            
            <input type="button" class="btn btn-primary" style="margin-left:600px;" value="Guardar" onclick="validarregistro()" />
            <a href="/listarEmpleados" class="btn btn-info">Regresar</a>
    </form>
@endsection


@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection
