@extends('layout.plantilla')


@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')

    
<script type="text/javascript"> 
          
    function validarregistro() 
        {


            if (document.getElementById("nombre").value == ""){
                alert("Ingrese el nombre del proyecto");
                $("#nombre").focus();
            }
            else if (document.getElementById("abreviatura").value == ""){
                alert("Ingrese la abreviatura del proyecto");
                $("#abreviatura").focus();
            }
            else if (document.getElementById("codSede").value == "-1"){
                alert("Ingrese la sede principal del proyecto");
                $("#codSede").focus();
            }
            
            else{
                document.frmempresa.submit(); // enviamos el formulario	
            }
        }
    
</script>

    
    <div class="well"><H3 style="text-align: center;">CREAR PROYECTO</H3></div>
    <br>
    <form id="frmempresa" name="frmempresa" role="form" action="{{route('proyecto.store')}}" class="form-horizontal form-groups-bordered" 
        method="post" enctype="multipart/form-data">
        @csrf 

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Nombre del Proyecto:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre..." >
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Abreviatura del proyecto:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="abreviatura" name="abreviatura" placeholder="..." >
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Sede Principal:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codSede" id="codSede">
                        <option value="-1">-- Seleccionar --</option>
                        @foreach($listaSedes as $itemsede)
                        <option value="{{$itemsede->codSede}}">{{$itemsede->nombre}}</option>    
                        @endforeach
                    </select>
                </div>
            </div>


                
            
            <input type="button" class="btn btn-primary" style="margin-left:600px;" value="Guardar" onclick="validarregistro()" />
            <a href="{{route('proyecto.asignarGerentes')}}" class="btn btn-info">Regresar</a>
    </form>
@endsection


@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection
