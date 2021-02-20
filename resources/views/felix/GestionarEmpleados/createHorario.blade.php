@extends('layout.plantilla')


@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')


<script type="text/javascript">
    $(document).ready(function(){
        $('#codTipoTurno').change(function(){
            
            var codigo=$('#codTipoTurno').val();
            //alert(codigo);
            var horaInicio1 = '<label class="col-sm-2 col-form-label" style="margin-left:350px;">Hora Inicio (MAÑANA):</label><div class="col-sm-3"><input type="time" class="form-control" id="horaInicioInput" name="horaInicioInput" ></div>';
            var horaFin1 = '<label class="col-sm-2 col-form-label" style="margin-left:350px;">Hora Fin (MAÑANA):</label><div class="col-sm-3"><input type="time" class="form-control" id="horaFinInput" name="horaFinInput" ></div>';
            var horaInicio2 = '<label class="col-sm-2 col-form-label" style="margin-left:350px;">Hora Inicio (TARDE):</label><div class="col-sm-3"><input type="time" class="form-control" id="horaInicio2Input" name="horaInhoraInicio2Inputicio2" ></div>';
            var horaFin2 = '<label class="col-sm-2 col-form-label" style="margin-left:350px;">Hora Fin (TARDE):</label><div class="col-sm-3"><input type="time" class="form-control" id="horaFin2Input" name="horaFin2Input" ></div>';

            switch (codigo) {
                case '1':
                    $('#horaInicio1').html(horaInicio1);
                    $('#horaFin1').html(horaFin1);
                    $('#horaInicio2').html('');
                    $('#horaFin2').html('');
                    $('#guardar').show();
                    break;
                case '2':
                    $('#horaInicio1').html('');
                    $('#horaFin1').html('');
                    $('#horaInicio2').html(horaInicio2);
                    $('#horaFin2').html(horaFin2);
                    $('#guardar').show();
                    break;
                case '3':
                    $('#horaInicio1').html(horaInicio1);
                    $('#horaFin1').html(horaFin1);
                    $('#horaInicio2').html(horaInicio2);
                    $('#horaFin2').html(horaFin2);
                    $('#guardar').show();
                    break;
                case '0':
                    $('#guardar').hide();
                    $('#horaInicio1').html('');
                    $('#horaFin1').html('');
                    $('#horaInicio2').html('');
                    $('#horaFin2').html('');
                    break;
            }

        })
    });
</script>


<script type="text/javascript"> 
          
    function validarregistro(){
        var codigo=$('#codTipoTurno').val();
        switch (codigo) {
            case '1':
                if (document.getElementById("horaInicioInput").value == ""){
                    alert("Ingrese hora inicio (mañana)");
                }
                else if (document.getElementById("horaFinInput").value == ""){
                    alert("Ingrese hora fin (mañana)");
                }
                else if (document.getElementById("horaFinInput").value <= document.getElementById("horaInicioInput").value){
                    alert("La fecha final tiene que ser mayor que la inicial");
                }
                else{
                    document.frmempresa.submit(); // enviamos el formulario	
                }
                break;
            case '2':
                if (document.getElementById("horaInicio2Input").value == ""){
                    alert("Ingrese hora inicio (tarde)");
                }
                else if (document.getElementById("horaFin2Input").value == ""){
                    alert("Ingrese hora fin (tarde)");
                }
                else if (document.getElementById("horaFin2Input").value <= document.getElementById("horaInicio2Input").value){
                    alert("La fecha final tiene que ser mayor que la inicial");
                }
                else{
                    document.frmempresa.submit(); // enviamos el formulario	
                }
                break;
            case '3':
                if (document.getElementById("horaInicioInput").value == ""){
                    alert("Ingrese hora inicio (mañana)");
                }
                else if (document.getElementById("horaFinInput").value == ""){
                    alert("Ingrese hora fin (mañana)");
                }
                else if (document.getElementById("horaFinInput").value <= document.getElementById("horaInicioInput").value){
                    alert("La fecha final tiene que ser mayor que la inicial");
                }
                else if (document.getElementById("horaInicio2Input").value == ""){
                    alert("Ingrese hora inicio (tarde)");
                }
                else if (document.getElementById("horaFin2Input").value == ""){
                    alert("Ingrese hora fin (tarde)");
                }
                else if (document.getElementById("horaFin2Input").value <= document.getElementById("horaInicio2Input").value){
                    alert("La fecha final tiene que ser mayor que la inicial");
                }
                else{
                    document.frmempresa.submit(); // enviamos el formulario	
                }
                break;
            case '0':
                alert("Seleccione un turno");
                break;
        }

    }
    
</script>

    
    <div class="well"><H3 style="text-align: center;">MANTENER HORARIO</H3></div>
    <br>
    <form id="frmempresa" name="frmempresa" role="form" action="/crearHorario/save" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 

            <input type="text" class="form-control" id="codPeriodoEmpleado" name="codPeriodoEmpleado" value="{{ $contrato->codPeriodoEmpleado}}" hidden>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">TipoHorario:</label>
                <div class="col-sm-4">
                    <select class="form-control" name="codTipoTurno" id="codTipoTurno">
                    <option value="0">--Seleccionar--</option>
                    @foreach($tiposTurno as $itemtipo)
                    <option value="{{$itemtipo->codTipoTurno}}">{{$itemtipo->nombre}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row" id="horaInicio1">
            </div>
            <div class="form-group row" id="horaFin1">
            </div>
            <div class="form-group row" id="horaInicio2">
            </div>
            <div class="form-group row" id="horaFin2">
            </div>


            <br />
            
            <input id="guardar" type="button" class="btn btn-primary" style="margin-left:600px;" value="Guardar" onclick="validarregistro()" />
            <script>$('#guardar').hide();</script>
    </form>
@endsection


@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection
