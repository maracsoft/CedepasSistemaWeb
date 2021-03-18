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
            
            else if (document.getElementById("codSede").value == "-1"){
                alert("Ingrese la sede principal del proyecto");
                $("#codSede").focus();
            }
            
            else if (document.getElementById("codigoPresupuestal").value == "-1"){
                alert("Ingrese el codigo presupuestal del proyecto");
                $("#codigoPresupuestal").focus();
            }
            
            else if (document.getElementById("nombreLargo").value == "-1"){
                alert("Ingrese el nombreLargo del proyecto");
                $("#nombreLargo").focus();
            }
            


            
            else{
                document.frmempresa.submit(); // enviamos el formulario	
            }
        }
    
</script>

<form id="frmempresa" name="frmempresa" role="form" action="{{route('proyecto.store')}}" 
class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">

@csrf 


<div class="well"><H3 style="text-align: center;">CREAR PROYECTO</H3></div>
<br>
<div class="container">
    <div class="row">
        <div class="col-2" style="">
            
        
        </div>
        

        <div class="col" style="">
            <div class="container">
                <div class="row">

                    <div class="col">

                        
                        <label class="" style="">Nombre del Proyecto:</label>
                        
                        
                        <div class="">
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                value="" placeholder="Nombre..." >
                        </div>
                    </div>

                    <div class="w-100"></div>
                    <div class="col">
                        <label class="" style="">Codigo presupuestal:</label>
                        <div class="">
                            <input type="text" class="form-control" id="codigoPresupuestal" name="codigoPresupuestal"
                            value=""  placeholder="..." >
                        </div>
                    </div>

                    <div class="w-100"></div>
                    <div class="col">
                        <label class="" style="">Nombre Largo:</label>
                        <div class="">
                            <textarea class="form-control" name="nombreLargo" id="nombreLargo" cols="30" rows="2"
                            ></textarea>
                        </div>
                    </div>

                    <div class="w-100"></div>
                    <div class="col">
                        <label class="" style="">Sede Principal:</label>
                        <div class="">
                            <select class="form-control" name="codSede" id="codSede">
                                <option value="-1">-- Seleccionar --</option>
                                @foreach($listaSedes as $itemsede)
                                <option value="{{$itemsede->codSede}}">
                                    {{$itemsede->nombre}}
                                </option>    
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="w-100"></div>
                    <div class="col" style=" text-align:center">
                    
                        <button class="btn btn-primary"  style="" onclick="validarregistro()"> 
                            <i class="far fa-save"></i>
                            Guardar
                        </button>
                    
                        
                        
    
                    </div>

                </div>

            </div>
                <a href="{{route('proyecto.index')}}" class="btn btn-info">
                    Regresar al Menú
                </a>
        </div>
        <div class="col-2" >
         
        
        </div>


    </div>


</div>

</form>
@endsection


@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection
