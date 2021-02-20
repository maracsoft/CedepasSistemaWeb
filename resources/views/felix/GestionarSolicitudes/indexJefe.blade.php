@extends('layout.plantilla')

@section('contenido')
<!--
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
-->


<div class="card-body">
    

    <div class="well"><H3 style="text-align: center;">SOLICITUDES</H3></div>

    <br/>
    <!--
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
    </div>
-->
  

    <table class="table table-bordered table-hover datatable">
        <thead>
        <tr>
            <th>EMPLEADO</th>
            <th>TIPO</th>
            <th>DESCRIPCION</th>
            <th>PERIODO</th>
            <th>FECHA REGISTRO</th>
            <th>ADJUNTOS</th>
            <th>OPCIONES</th>
        </tr>
        </thead>
        <tbody id="registro">
            @foreach($solicitudes as $itemsolicitud)
            <tr>
                <td>{{$itemsolicitud->periodoEmpleado->empleado->apellidos}}, {{$itemsolicitud->periodoEmpleado->empleado->nombres}}</td>
                <td>{{$itemsolicitud->tipoLicencia->descripcion}}</td>
                <td>{{$itemsolicitud->descripcion}}</td>
                <td>{{$itemsolicitud->fechaInicio}} hasta {{$itemsolicitud->fechaFin}}</td>
                <td>{{$itemsolicitud->fechaHoraRegistro}}</td>
                <td><a href="/mostrarSolicitud/{{$itemsolicitud->codRegistroSolicitud}}" class="btn btn-info btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Adjunto</a></td>
                <td>
                    @if($itemsolicitud->estado==1)
                    <a href="/evaluarSolicitud/{{$itemsolicitud->codRegistroSolicitud}}*1" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>ACEPTAR</a>
                    <a href="/evaluarSolicitud/{{$itemsolicitud->codRegistroSolicitud}}*2" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>RECHAZAR</a>    
                    @else
                    <strong style="color:rgb(160, 160, 160)">{{$itemsolicitud->estado==2 ? 'ACEPTADA' : 'RECHAZADA'}}</strong>
                    @endif
                    
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
  </div>


@endsection