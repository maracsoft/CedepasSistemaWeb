@extends('layout.plantilla')

@section('contenido')


<script type="text/javascript"> 
          
    function validarregistro() 
    {
        var expreg = new RegExp("^(?=^.{3,300}$)^[A-ZÁÉÍÓÚñáéíóúÑ][a-zA-ZÁÉÍÓÚñáéíóúÑ0-9 \\%\\,\\(\\)]*[_]?[a-zA-ZÁÉÍÓÚñáéíóúÑ0-9 ]+[.\\ ]?$");
                if (document.getElementById("descripcion").value == ""){
                    alert("Ingrese descripcion del puesto");
                    $("#descripcion").focus();
                }
                else if(!expreg.test(document.getElementById("descripcion").value)){
                    alert("Ingrese una correcta descripcion (entre 3-300 caracteres)(inicio con mayuscula)");
                    $("#descripcion").focus();
                }
                else{
                    document.frmPuesto.submit(); // enviamos el formulario	
                }
                    
        //document.frmPuesto.submit(); // enviamos el formulario	
    }
        
</script>
    <div class="well"><H3 style="text-align: center;">CREAR PUESTO

    </H3></div>
    <br>
    <form id="frmPuesto" name="frmPuesto" role="form" action="/crearPuesto/save" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 
            <input id="codArea" type="hidden" name="codArea" value="{{ $area->codArea }}" >

            <div class="form-group row" style="margin-left:250px;">
                <label class="col-sm-1 col-form-label">Nombre:</label>
                <div class="col-sm-7">
                    <textarea class="form-control" rows="3" name="descripcion" id="descripcion" placeholder="Nombre ..." style="margin-top: 0px; margin-bottom: 0px; height: 61px;"></textarea>
                </div>
            </div>

            <br />
            <!--
             <input type="button" class="btn btn-primary"  value="Guardar" onclick="validarregistro()" /> -->
            <input type="button" class="btn btn-primary" style="margin-left:600px;" value="GUARDAR"  onclick="validarregistro()"/>
    </form>
@endsection
