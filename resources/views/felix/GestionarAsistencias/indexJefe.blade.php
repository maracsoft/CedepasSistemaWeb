@extends('layout.plantilla')

@section('contenido')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript"> 
    $(document).ready(function(){
        $('#codEmpleado').change(function(){

            var codigo=$('#codEmpleado').val();
            var codigo2=1;
            //alert(codigo);
            
            if(codigo!=0){
                //alert(codigo);
                $.ajax({
                    url: '/listarAsistencia/' + codigo + '*' + codigo2,
                    type: 'post',
                    data: {
                        codigo     : codigo,
                        _token	 	: "{{ csrf_token() }}"
                    },
                    dataType: 'JSON',
                    success: function(respuesta) {

                        var tableValor ='';
                            for (var i in respuesta.asistencias) {
                                tableValor +='<tr>';
                                tableValor +='<td>'+respuesta.asistencias[i].fecha+'</td>';
                                tableValor +='<td>'+respuesta.tipoTurno.nombre+'</td>';

                                switch (respuesta.tipoTurno.codTipoTurno) {
                                    case 1:
                                        tableValor +='<td><strong style="color:rgb(160, 160, 160)">'+ ((respuesta.asistencias[i].fechaHoraEntrada != null) ? respuesta.asistencias[i].fechaHoraEntrada : '?')+'</strong></td>';
                                        tableValor +='<td><strong style="color:rgb(160, 160, 160)">'+ ((respuesta.asistencias[i].fechaHoraSalida != null) ? respuesta.asistencias[i].fechaHoraSalida : '?')+'</strong></td>';
                                        tableValor +='<td style="background-color: rgba(190, 188, 188, 0.432);"></td>';
                                        tableValor +='<td style="background-color: rgba(190, 188, 188, 0.432);"></td>';
                                        break;
                                    case 2:
                                        tableValor +='<td style="background-color: rgba(190, 188, 188, 0.432);"></td>';
                                        tableValor +='<td style="background-color: rgba(190, 188, 188, 0.432);"></td>';
                                        tableValor +='<td><strong style="color:rgb(160, 160, 160)">'+ ((respuesta.asistencias[i].fechaHoraEntrada2 != null) ? respuesta.asistencias[i].fechaHoraEntrada2 : '?')+'</strong></td>';
                                        tableValor +='<td><strong style="color:rgb(160, 160, 160)">'+ ((respuesta.asistencias[i].fechaHoraSalida2 != null) ? respuesta.asistencias[i].fechaHoraSalida2 : '?')+'</strong></td>';
                                        break;
                                    case 3:
                                        tableValor +='<td><strong style="color:rgb(160, 160, 160)">'+ ((respuesta.asistencias[i].fechaHoraEntrada != null) ? respuesta.asistencias[i].fechaHoraEntrada : '?')+'</strong></td>';
                                        tableValor +='<td><strong style="color:rgb(160, 160, 160)">'+ ((respuesta.asistencias[i].fechaHoraSalida != null) ? respuesta.asistencias[i].fechaHoraSalida : '?')+'</strong></td>';
                                        tableValor +='<td><strong style="color:rgb(160, 160, 160)">'+ ((respuesta.asistencias[i].fechaHoraEntrada2 != null) ? respuesta.asistencias[i].fechaHoraEntrada2 : '?')+'</strong></td>';
                                        tableValor +='<td><strong style="color:rgb(160, 160, 160)">'+ ((respuesta.asistencias[i].fechaHoraSalida2 != null) ? respuesta.asistencias[i].fechaHoraSalida2 : '?')+'</strong></td>';
                                        break;
                                }
                                
                                
                                //tableValor += respuesta.asistencias[i].codRegistroAsistencia
                                tableValor +='</tr>';
                            }
                            

                    
                        
                        $('#registro').html(tableValor);

                    }
                });
            }else{
                        $('#registro').html('');

            }

        })
    });
</script>


<div class="card-body">
    

    <div class="well"><H3 style="text-align: center;">ASISTENCIAS</H3></div>

    <br/>
    
    <div class="form-group row">
        <label class="col-sm-1 col-form-label">Empleado:</label>
                <div class="col-sm-2">
                    <select class="form-control" name="codEmpleado" id="codEmpleado">
                    <option value="0">--Seleccionar--</option>
                    @foreach($empleados as $itemempleado)
                    <option value="{{$itemempleado->codEmpleado}}">{{$itemempleado->nombres}}, {{$itemempleado->apellidos}}</option>
                    @endforeach
                    </select>
                </div>
        <!--
        <label class="col-sm-1 col-form-label">Periodo:</label>
                <div class="col-sm-2">
                    <select class="form-control" name="codPeriodo" id="codPeriodo">
                    <option value="1">ULTIMO MES</option>
                    <option value="2">HOY</option>
                    </select>
                </div>
            -->
    </div>
  

    <table class="table table-bordered table-hover datatable">
        <thead>
        <tr>
            <th colspan="2"></th>
            <th colspan="2" style="text-align: center; color:red">MAÑANA</th>
            <th colspan="2" style="text-align: center; color:red">TARDE</th>
        </tr>
        <tr>
            <th>FECHA</th>
            <th>HORARIO</th>
            <th>HORA ENTRADA</th>
            <th>HORA SALIDA</th>
            <th>HORA ENTRADA</th>
            <th>HORA SALIDA</th>
        </tr>
        </thead>
        <tbody id="registro">
        </tbody>
    </table>
    
  </div>


@endsection