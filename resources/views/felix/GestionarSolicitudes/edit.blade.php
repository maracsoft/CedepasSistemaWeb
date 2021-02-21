@extends('layout.plantilla')


@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')



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
            if (document.getElementById("codTipo").value == "0"){
                alert("Seleccione tipo de solicitud");
            }
            else if (document.getElementById("descripcion").value == ""){
                alert("Ingrese la descripcion");
                $("#descripcion").focus();
            }
            else if (document.getElementById("fechaInicio").value == ""){
                alert("Ingrese fecha de inicio");
                $("#fechaInicio").focus();
            }
            else if (document.getElementById("fechaFin").value == ""){
                alert("Ingrese fecha de fin");
                $("#fechaFin").focus();
            }
            else if (document.getElementById("fechaFin").value <= document.getElementById("fechaInicio").value){
                alert("La fecha final tiene que ser mayor que la inicial");
            }
            else{
                document.frmempresa.submit(); // enviamos el formulario	
            }
        }
    
</script>

    
    <div class="well"><H3 style="text-align: center;">EDITAR SOLICITUD DE FALTA</H3></div>
    <br>
    <form id="frmempresa" name="frmempresa" role="form" action="/editarSolicitud/save" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 
            <input type="text" class="form-control" id="codRegistroSolicitud" name="codRegistroSolicitud" placeholder="Codigo" value="{{ $solicitud->codRegistroSolicitud}}" hidden>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Tipo:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codTipo" id="codTipo">
                    <option value="0">--Seleccionar--</option>
                    @foreach($tipos as $itemtipo)
                    <option value="{{$itemtipo->codTipoSolicitud}}" {{$itemtipo->codTipoSolicitud==$solicitud->codTipoSolicitud ? 'selected' : ''}}>{{$itemtipo->descripcion}}</option>
                    @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Descripcion:</label>
                <div class="col-sm-4">
                    <textarea class="form-control" rows="3" name="descripcion" id="descripcion" placeholder="Descripcion ..." style="margin-top: 0px; margin-bottom: 0px; height: 100px;">{{$solicitud->descripcion}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Documento:</label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" name="certificado" id="certificado">
                        </div>
            </div>
            
                    
            <div class="form-group row">                   
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Fecha Inicio:</label>
                <div class="col-md-4">                        
                    <div class="form-group">                            
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fechaInicio" id="fechaInicio"
                                   value="{{$solicitud->fechaInicio}}" style="text-align:center;">
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>

            <div class="form-group row">                   
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Fecha Fin:</label>
                <div class="col-md-4">                        
                    <div class="form-group">                            
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fechaFin" id="fechaFin"
                                   value="{{$solicitud->fechaFin}}" style="text-align:center;">
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>


            <br />
            
            <input type="button" class="btn btn-primary" style="margin-left:600px;" value="Guardar" onclick="validarregistro()" />
    </form>
@endsection


@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection
