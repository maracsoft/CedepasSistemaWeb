@extends('layout.plantilla')

@section('contenido')


<div class="card-body">
    

    <div class="well"><H3 style="text-align: center;">ASISTENCIAS</H3></div>

    <br/>
    <!--
    <div class="form-group row">
        <label class="col-sm-1 col-form-label">Periodo:</label>
                <div class="col-sm-2">
                    <select class="form-control" name="codPeriodo" id="codPeriodo">
                    <option value="1">HOY</option>
                    <option value="2">ULTIMO MES</option>
                    </select>
                </div>
    </div>
  -->

    <table class="table table-bordered table-hover datatable">
      <thead>                  
        <tr>
          <th>FECHA</th>
          <th>MAÑANA</th>
          <th>TARDE</th>
        </tr>
      </thead>
      <tbody>
        <?php date_default_timezone_set('America/Lima'); $hoy=time(); $fechaHoy=date('Y-m-d');?>
        @foreach($asistencias as $itemasistencia)
            <tr>
                <td>{{$itemasistencia->fecha}} {{$itemasistencia->estado==1 ? '(Hoy)' :''}}</td>
                
                @switch($itemasistencia->periodoEmpleado->turno->tipoTurno->codTipoTurno)
                    @case(1)
                      <td>
                          @if($hoy>=strtotime($itemasistencia->periodoEmpleado->turno->horaInicio) && $hoy<=strtotime($itemasistencia->periodoEmpleado->turno->horaFin) && $fechaHoy==$itemasistencia->fecha)

                            @if(is_null($itemasistencia->fechaHoraEntrada))
                              <a href="/marcarAsistencia/marcar/{{$itemasistencia->codRegistroAsistencia}}*1" class="btn btn-info btn-sm btn-icon icon-left">ENTRADA</a>    
                            @else
                              <strong style="color:rgb(160, 160, 160)">{{date('H:i:s',strtotime($itemasistencia->fechaHoraEntrada))}} - </strong>
                            @endif

                            @if(is_null($itemasistencia->fechaHoraSalida) && !is_null($itemasistencia->fechaHoraEntrada))
                              <a href="/marcarAsistencia/marcar/{{$itemasistencia->codRegistroAsistencia}}*2" class="btn btn-info btn-sm btn-icon icon-left">SALIDA</a>
                            @elseif(!is_null($itemasistencia->fechaHoraSalida))
                              <strong style="color:rgb(160, 160, 160)">{{date('H:i:s',strtotime($itemasistencia->fechaHoraSalida))}}</strong>
                            @endif
                          
                          @else
                            <strong style="color:rgb(160, 160, 160)">
                              {{!is_null($itemasistencia->fechaHoraEntrada) ? date('H:i:s',strtotime($itemasistencia->fechaHoraEntrada)) : '?'}}
                               - 
                              {{!is_null($itemasistencia->fechaHoraSalida) ? date('H:i:s',strtotime($itemasistencia->fechaHoraSalida)) : '?'}}
                            </strong>
                          @endif
                      </td>
                      <td style="background-color: rgba(190, 188, 188, 0.432);"></td>
                      @break
                    @case(2)
                    <td style="background-color: rgba(190, 188, 188, 0.432);"></td>
                      <td>
                        @if($hoy>=strtotime($itemasistencia->periodoEmpleado->turno->horaInicio2) && $hoy<=strtotime($itemasistencia->periodoEmpleado->turno->horaFin2) && $fechaHoy==$itemasistencia->fecha)

                          @if(is_null($itemasistencia->fechaHoraEntrada2))
                            <a href="/marcarAsistencia/marcar/{{$itemasistencia->codRegistroAsistencia}}*3" class="btn btn-info btn-sm btn-icon icon-left">ENTRADA</a>    
                          @else
                            <strong style="color:rgb(160, 160, 160)">{{date('H:i:s',strtotime($itemasistencia->fechaHoraEntrada2))}} - </strong>
                          @endif

                          @if(is_null($itemasistencia->fechaHoraSalida2) && !is_null($itemasistencia->fechaHoraEntrada2))
                            <a href="/marcarAsistencia/marcar/{{$itemasistencia->codRegistroAsistencia}}*4" class="btn btn-info btn-sm btn-icon icon-left">SALIDA</a>
                          @elseif(!is_null($itemasistencia->fechaHoraSalida2))
                            <strong style="color:rgb(160, 160, 160)">{{date('H:i:s',strtotime($itemasistencia->fechaHoraSalida2))}}</strong>
                          @endif
                        
                        @else
                          <strong style="color:rgb(160, 160, 160)">
                            {{!is_null($itemasistencia->fechaHoraEntrada2) ? date('H:i:s',strtotime($itemasistencia->fechaHoraEntrada2)) : '?'}}
                            - 
                            {{!is_null($itemasistencia->fechaHoraSalida2) ? date('H:i:s',strtotime($itemasistencia->fechaHoraSalida2)) : '?'}}
                          </strong>
                        @endif
                      </td>
                      @break
                    @case(3)
                      <td>
                          @if($hoy>=strtotime($itemasistencia->periodoEmpleado->turno->horaInicio) && $hoy<=strtotime($itemasistencia->periodoEmpleado->turno->horaFin) && $fechaHoy==$itemasistencia->fecha)

                            @if(is_null($itemasistencia->fechaHoraEntrada))
                              <a href="/marcarAsistencia/marcar/{{$itemasistencia->codRegistroAsistencia}}*1" class="btn btn-info btn-sm btn-icon icon-left">ENTRADA</a>    
                            @else
                              <strong style="color:rgb(160, 160, 160)">{{date('H:i:s',strtotime($itemasistencia->fechaHoraEntrada))}} - </strong>
                            @endif

                            @if(is_null($itemasistencia->fechaHoraSalida) && !is_null($itemasistencia->fechaHoraEntrada))
                              <a href="/marcarAsistencia/marcar/{{$itemasistencia->codRegistroAsistencia}}*2" class="btn btn-info btn-sm btn-icon icon-left">SALIDA</a>
                            @elseif(!is_null($itemasistencia->fechaHoraSalida))
                              <strong style="color:rgb(160, 160, 160)">{{date('H:i:s',strtotime($itemasistencia->fechaHoraSalida))}}</strong>
                            @endif
                          
                          @else
                            <strong style="color:rgb(160, 160, 160)">
                              {{!is_null($itemasistencia->fechaHoraEntrada) ? date('H:i:s',strtotime($itemasistencia->fechaHoraEntrada)) : '?'}}
                               - 
                              {{!is_null($itemasistencia->fechaHoraSalida) ? date('H:i:s',strtotime($itemasistencia->fechaHoraSalida)) : '?'}}
                            </strong>
                          @endif
                      </td>
                      <td>
                        @if($hoy>=strtotime($itemasistencia->periodoEmpleado->turno->horaInicio2) && $hoy<=strtotime($itemasistencia->periodoEmpleado->turno->horaFin2) && $fechaHoy==$itemasistencia->fecha)
                        
                          @if(is_null($itemasistencia->fechaHoraEntrada2))
                            <a href="/marcarAsistencia/marcar/{{$itemasistencia->codRegistroAsistencia}}*3" class="btn btn-info btn-sm btn-icon icon-left">ENTRADA</a>    
                          @else
                            <strong style="color:rgb(160, 160, 160)">{{date('H:i:s',strtotime($itemasistencia->fechaHoraEntrada2))}} - </strong>
                          @endif

                          @if(is_null($itemasistencia->fechaHoraSalida2) && !is_null($itemasistencia->fechaHoraEntrada2))
                            <a href="/marcarAsistencia/marcar/{{$itemasistencia->codRegistroAsistencia}}*4" class="btn btn-info btn-sm btn-icon icon-left">SALIDA</a>
                          @elseif(!is_null($itemasistencia->fechaHoraSalida2))
                            <strong style="color:rgb(160, 160, 160)">{{date('H:i:s',strtotime($itemasistencia->fechaHoraSalida2))}}</strong>
                          @endif
                        
                        @else
                          <strong style="color:rgb(160, 160, 160)">
                            {{!is_null($itemasistencia->fechaHoraEntrada2) ? date('H:i:s',strtotime($itemasistencia->fechaHoraEntrada2)) : '?'}}
                            - 
                            {{!is_null($itemasistencia->fechaHoraSalida2) ? date('H:i:s',strtotime($itemasistencia->fechaHoraSalida2)) : '?'}}
                          </strong>
                        @endif
                      </td>
                      @break
                        
                @endswitch
                
                
            
            </tr>
        @endforeach
        
      </tbody>
    </table>
    
  </div>


@endsection