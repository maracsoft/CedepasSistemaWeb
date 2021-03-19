@extends('layout.plantilla')


@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')

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

    <script type="text/javascript"> 
          
        function validarregistro() 
            {
                
                    document.frmempresa.submit(); // enviamos el formulario	
                
            }
        
    </script>

    
    <div class="well"><H3 style="text-align: center;">EDITAR CONTRATO DE {{$contrato->empleado->nombres}}, {{$contrato->empleado->apellidos}}</H3></div>
    <br>
    <form id="frmempresa" name="frmempresa" role="form" action="/listarEmpleados/editarContrato/save" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 
            <input type="text" class="form-control" id="codPeriodoEmpleado" name="codPeriodoEmpleado" placeholder="Codigo" value="{{ $contrato->codPeriodoEmpleado}}" hidden>
            <div class="form-group row">                   
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Fecha Inicio:</label>
                <div class="col-md-4">                        
                    <div class="form-group">                            
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fechaInicio" id="fechaInicio"
                                   value="{{date("d/m/Y",strtotime($contrato->fechaInicio))}}" style="text-align:center;">
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
                                   value="{{date("d/m/Y",strtotime($contrato->fechaFin))}}" style="text-align:center;">
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
<!--
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Turno:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codTurno" id="codTurno">
                    <option value="0">--Seleccionar--</option>

                    </select>
                </div>
            </div>
        -->
            @if($contrato->codTipoContrato==2)
             
            @endif
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Sueldo:</label>
                <div class="col-sm-4">
                    <input type="number" step="any" class="form-control" id="sueldo" name="sueldo" placeholder="sueldo..."  value="{{$contrato->sueldoFijo}}">
                </div>
            </div>
            @if($contrato->codTipoContrato==1)
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Financiador:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="nombreFinanciador" name="nombreFinanciador" placeholder="Financiador..." value="{{$contrato->nombreFinanciador}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Proyecto:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Proyecto..." value="{{$contrato->nombre}}">
                </div>
            </div> 
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Area:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codArea" id="codArea">
                    <option value="0">--Seleccionar--</option>
                    @foreach($areas as $itemarea)
                    <option value="{{$itemarea->codArea}}" {{ $itemarea->codArea==$contrato->puesto->area->codArea ? 'selected':'' }}>{{$itemarea->nombre}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row" id="comboPuestos">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Puesto:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codPuesto" id="codPuesto">
                    <option value="0">--Seleccionar--</option>
                    @foreach($puestos as $itempuesto)
                    <option value="{{$itempuesto->codPuesto}}" {{ $itempuesto->codPuesto==$contrato->puesto->codPuesto ? 'selected':'' }}>{{$itempuesto->nombre}}</option>
                    @endforeach
                    </select>
                </div>
            </div>    
            @endif

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">AFP:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codAFP" id="codAFP">
                    <option value="0">--Seleccionar--</option>
                    @foreach($AFPS as $itemAFP)
                    <option value="{{$itemAFP->codAFP}}" {{ $itemAFP->codAFP==$contrato->codAFP ? 'selected':'' }}>{{$itemAFP->nombre}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row" id="comboPuestos">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Asistencia:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="asistencia" id="asistencia">
                    <option value="1" {{ 1==$contrato->asistencia ? 'selected':'' }}>SI</option>
                    <option value="0" {{ 2==$contrato->asistencia ? 'selected':'' }}>NO</option>
                    </select>
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
