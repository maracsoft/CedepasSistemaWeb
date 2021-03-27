@extends ('layout.plantilla')

@section('contenido')

<style>

  .col{
    margin-top: 15px;
  
    }
  
  .colLabel{
  width: 13%;
  margin-top: 18px;
  
  
  }
  
  
  </style>
  
<div>
  <h3> Solicitudes de fondos para Abonar </h3>
  
  <br>
  <div class="row">
    <div class="col-md-12">
      <form class="form-inline">
        <label for="">Empleado: </label>
        <select class="form-control select2 select2-hidden-accessible selectpicker" data-select2-id="1" tabindex="-1" aria-hidden="true" id="codEmpleadoBuscar" name="codEmpleadoBuscar" data-live-search="true">
          <option value="0">- Seleccione Empleado -</option>          
          @foreach($empleados as $itemempleado)
            <option value="{{$itemempleado->codEmpleado}}" {{$itemempleado->codEmpleado==$codEmpleadoBuscar ? 'selected':''}}>{{$itemempleado->getNombreCompleto()}}</option>                                 
          @endforeach
        </select> 

      
        <select class="form-control mr-sm-2"  id="codProyectoBuscar" name="codProyectoBuscar">
          <option value="0">--Seleccionar Proyecto--</option>
          @foreach($proyectos as $itemproyecto)
              <option value="{{$itemproyecto->codProyecto}}" {{$itemproyecto->codProyecto==$codProyectoBuscar ? 'selected':''}}>
                  {{$itemproyecto->nombre}}
              </option>                                 
          @endforeach 
        </select>
        <button class="btn btn-success " type="submit">Buscar</button>
       


      </form>
    </div>
  </div>
  
{{-- AQUI FALTA EL CODIGO SESSION DATOS ENDIF xdd --}}
@if (session('datos'))
<div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
    {{session('datos')}}
  <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
      <span aria-hidden="true"> &times;</span>
  </button>
  
</div>
@ENDIF


    <table class="table" style="font-size: 10pt; margin-top:10px; ">
            <thead class="thead-dark">
              <tr >
                <th width="8%" scope="col">Codigo Sol</th>
                <th width="7%"  scope="col" style="text-align: center">F. Emision</th>
              
                <th width="10%"  scope="col">Empleado </th>
                <th>P.P</th>
                <th scope="col">Proyecto</th>
                <th width="10%"  scope="col">Evaluador</th>
                
                <th width="8%"  scope="col" style="text-align: center">Total Solicitado</th>
                
                <th width="7%"  scope="col" style="text-align: center">F. Revision</th>
                <th width="11%"  scope="col" style="text-align: center">Estado</th>
                
                <th width="9%"  scope="col">Opciones Solicitud</th>
                <th width="9%"  scope="col">Opciones Rendicion</th>
                
              </tr>
            </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($listaSolicitudesFondos as $itemSolicitud)

      
            <tr class="filaPr">
                <td style = "padding: 0.40rem">{{$itemSolicitud->codigoCedepas  }}</td>
                <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->getFechaHoraEmision() }}</td>
               
                <td style = "padding: 0.40rem"> {{$itemSolicitud->getNombreSolicitante()}} </td>
                <td style = "padding: 0.40rem">{{$itemSolicitud->getProyecto()->codigoPresupuestal  }}</td>
                
                <td style = "padding: 0.40rem"> {{$itemSolicitud->getNombreProyecto()}} </td>
                <td style = "padding: 0.40rem"> {{$itemSolicitud->getEvaluador()->getNombreCompleto()}} </td>
                <td style = "padding: 0.40rem; text-align: right">{{$itemSolicitud->getMoneda()->simbolo}}  {{number_format($itemSolicitud->totalSolicitado,2)  }}</td>
                
          
                <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->getFechaRevision()}}</td>

                <td style = "padding: 0.40rem; text-align: center">
                  <input type="text" value="{{$itemSolicitud->getNombreEstado()}}" class="form-control" readonly 
                    style="background-color: {{$itemSolicitud->getColorEstado()}};
                            height: 26px;
                            text-align:center;
                            color: {{$itemSolicitud->getColorLetrasEstado()}} ;
                    "  title="{{$itemSolicitud->getMensajeEstado()}}">
                </td>
                <td style = "padding: 0.40rem">        {{-- OPCIONES --}}
                  @if($itemSolicitud->verificarEstado('Aprobada')) {{-- Si está aprobada (pa abonar) --}}   
                    <a  class='btn btn-warning btn-sm' href="{{route('SolicitudFondos.Administracion.verAbonar',$itemSolicitud->codSolicitud)}}" title="Abonar Solicitud"><i class="fas fa-hand-holding-usd"></i></a>
                  @else{{-- si está rendida (pa verla nomas ) --}}
                    @if($itemSolicitud->estaRendida())
                          <a href="{{route('SolicitudFondos.Administracion.verAbonar',$itemSolicitud->codSolicitud)}}" class='btn btn-info btn-sm' title="Ver Solicitud"><i class="fas fa-eye"></i></a>
                          <a href="{{route('solicitudFondos.descargarPDF',$itemSolicitud->codSolicitud)}}" class='btn btn-info btn-sm'  title="Descargar PDF"><i class="fas fa-file-download"></i></a>
                          <a target="pdf_solicitud_{{$itemSolicitud->codSolicitud}}" href="{{route('solicitudFondos.verPDF',$itemSolicitud->codSolicitud)}}" class='btn btn-info btn-sm'  title="Ver PDF"><i class="fas fa-file-pdf"></i></a>
                    @endif
                  @endif
                </td>
                <td style = "padding: 0.40rem">        {{-- OPCIONES --}}
                  @if($itemSolicitud->estaRendida())
                        <a href="{{route('RendicionGastos.Administracion.Ver',$itemSolicitud->getRendicion()->codRendicionGastos)}}" class='btn btn-info btn-sm' title="Ver Rendición"><i class="fas fa-eye"></i></a>
                        <a href="{{route('rendicionGastos.descargarPDF',$itemSolicitud->getRendicion()->codRendicionGastos)}}" class='btn btn-info btn-sm' title="Descargar PDF"><i class="fas fa-file-download"></i></a>
                        <a target="pdf_rendicion_{{$itemSolicitud->getRendicion()->codRendicionGastos}}" href="{{route('rendicionGastos.verPDF',$itemSolicitud->getRendicion()->codRendicionGastos)}}" class='btn btn-info btn-sm'  title="Ver PDF"><i class="fas fa-file-pdf"></i></a>
                  @endif
                </td>

            </tr>
        @endforeach
      </tbody>
    </table>

  {{$listaSolicitudesFondos->links()}}
 

</div>
@endsection


<?php 
  $fontSize = '14pt';
?>
<style>
/* PARA COD ORDEN CON CIRCULITOS  */

  span.grey {
    background: #000000;
    border-radius: 0.8em;
    -moz-border-radius: 0.8em;
    -webkit-border-radius: 0.8em;
    color: #fff;
    display: inline-block;
    font-weight: bold;
    line-height: 1.6em;
    margin-right: 15px;
    text-align: center;
    width: 1.6em; 
    font-size : {{$fontSize}};
  }
  


  span.red {
  background:#932425;
   border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}


span.green {
  background: #5EA226;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}

span.blue {
  background: #5178D0;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}

span.pink {
  background: #EF0BD8;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}





   </style>
