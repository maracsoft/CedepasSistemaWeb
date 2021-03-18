@extends('layout.plantilla')


@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')
<style>
    
    .col{
        /* background-color: orange; */
        margin-top: 15px;
        
    }
    .colLabel{
        width: 30%;
        /* background-color: aqua; */
        margin-top: 20px;    
        text-align: left;
    }
    
    .colLabel2{
        width: 20%;
        /* background-color: #3c8dbc; */
        margin-top: 20px;
        text-align: left;
    }

</style>
    
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
<form id="frmempresa" name="frmempresa" role="form" action="{{route('proyecto.update')}}" 
    class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
    <input type="hidden" name="codProyecto" id="codProyecto" value="{{$proyecto->codProyecto}}">

    @csrf 

    
    <div class="well"><H3 style="text-align: center;">EDITAR PROYECTO</H3></div>
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
                                    value="{{$proyecto->nombre}}" placeholder="Nombre..." >
                            </div>
                        </div>

                        <div class="w-100"></div>
                        <div class="col">
                            <label class="" style="">Codigo presupuestal:</label>
                            <div class="">
                                <input type="text" class="form-control" id="codigoPresupuestal" name="codigoPresupuestal"
                                value="{{$proyecto->codigoPresupuestal}}"  placeholder="..." >
                            </div>
                        </div>

                        <div class="w-100"></div>
                        <div class="col">
                            <label class="" style="">Nombre Largo:</label>
                            <div class="">
                                <textarea class="form-control" name="nombreLargo" id="nombreLargo" cols="30" rows="2"
                                >{{$proyecto->nombreLargo}}</textarea>
                            </div>
                        </div>

                        <div class="w-100"></div>
                        <div class="col">
                            <label class="" style="">Sede Principal:</label>
                            <div class="">
                                <select class="form-control" name="codSede" id="codSede">
                                    <option value="-1">-- Seleccionar --</option>
                                    @foreach($listaSedes as $itemsede)
                                    <option value="{{$itemsede->codSede}}"
                                        @if($itemsede->codSede == $proyecto->codSedePrincipal)
                                            selected
                                        @endif
                                        >{{$itemsede->nombre}}</option>    
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
                        
                            
                            
        
                            <a href="#" class="btn btn-danger btn-icon icon-left" title="Eliminar registro" 
                                onclick="confirmarEliminacion()">
                                <i class="fas fa-trash-alt"></i>
                            Dar de Baja
                            </a>
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

     <script>

        function confirmarEliminacion(){
            swal(
            {//sweetalert
                title:'Dar de baja',
                text: '¿Está seguro de dar de baja el proyecto? Este no aparecerá más en las listas de proyectos activos.',     //mas texto
                //type: 'warning',  
                type: '',
                showCancelButton: true,//para que se muestre el boton de cancelar
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText:  'SI',
                cancelButtonText:  'NO',
                closeOnConfirm:     true,//para mostrar el boton de confirmar
                html : true
            },
            function(){//se ejecuta cuando damos a aceptar
                window.location.href="{{route('proyecto.darDeBaja',$proyecto->codProyecto)}}";
            });
        }

    </script>
@endsection
