@extends('layout.plantilla')

@section('contenido')


    <script type="text/javascript"> 
          
        function validarregistro() 
            {
                //var expreg = new RegExp("^[,;A-Z a-zÑñ0-9À-ÿ\"\-]{3,290}[.]?$");
                var expreg = new RegExp("^(?=^.{3,300}$)^[A-ZÁÉÍÓÚñáéíóúÑ][a-zA-ZÁÉÍÓÚñáéíóúÑ0-9 \\%\\,\\(\\)]*[_]?[a-zA-ZÁÉÍÓÚñáéíóúÑ0-9 ]+[.\\ ]?$");

                /*
                if(expreg.test(document.getElementById("descripcion").value))
                    alert("La matrícula es correcta");
                else
                    alert("La matrícula NO es correcta");
                
                */
                if (document.getElementById("descripcion").value == ""){
                    alert("Ingrese descripcion del area");
                    $("#descripcion").focus();
                }
                else if(!expreg.test(document.getElementById("descripcion").value)){
                    alert("Ingrese una correcta descripcion (entre 3-300 caracteres)(inicio con mayuscula)");
                    $("#descripcion").focus();
                }
                else{
                    document.frmelemento.submit(); // enviamos el formulario	
                }

                //document.frmelemento.submit(); // enviamos el formulario	
            }
        
    </script>
   <br><br>
   <div class="well"><H3 style="text-align: center;">CREAR AREA</h3>
   <br>
    <form id="frmelemento" name="frmelemento" role="form" action="/crearArea/save" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Nombre:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Nombre..." >
                </div>
            </div>

            <br />
            <!--
             <input type="button" class="btn btn-primary"  value="Guardar" onclick="validarregistro()" /> -->
            <input type="button" class="btn btn-primary"  style="margin-left:600px;" value="Guardar"  onclick="validarregistro()"/>
    </form>
@endsection
