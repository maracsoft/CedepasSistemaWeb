@extends ('Layout.Plantilla')
@section('titulo')
Listar Solicitudes
@endsection
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection
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
  
<div style="text-align: center">
  <h3> Solicitudes de mis proyectos </h3>
   
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
        <label for="">Fecha: </label>
        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker"  style="width: 140px; margin-left: 10px">
          <input type="text"  class="form-control" name="fechaInicio" id="fechaInicio" style="text-align: center"
                 value="{{$fechaInicio==null ? Carbon\Carbon::now()->format('d/m/Y') : $fechaInicio}}" style="text-align:center;font-size: 10pt;">
          <div class="input-group-btn">                                        
              <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
          </div>
        </div>
         - 
        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker"  style="width: 140px">
          <input type="text"  class="form-control" name="fechaFin" id="fechaFin" style="text-align: center"
                 value="{{$fechaFin==null ? Carbon\Carbon::now()->format('d/m/Y') : $fechaFin}}" style="text-align:center;font-size: 10pt;">
          <div class="input-group-btn">                                        
              <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
          </div>
        </div>

        
        <label for="">Mis Proyectos: </label>
        <select class="form-control mr-sm-2"  id="codProyectoBuscar" name="codProyectoBuscar" style="margin-left: 10px;width: 200px;">
          <option value="0">--Seleccionar Proyecto--</option>
          @foreach($proyectos as $itemproyecto)
              <option value="{{$itemproyecto->codProyecto}}" {{$itemproyecto->codProyecto==$codProyectoBuscar ? 'selected':''}}>
               [{{$itemproyecto->codigoPresupuestal}}] {{$itemproyecto->nombre}}
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
              <tr>
                <th width="9%" scope="col">Código Sol</th>
                <th width="9%" scope="col" style="text-align: center">F. Emisión</th>
                
                <th width="13%" scope="col">Empleado</th>
                <th width="3%">Cod.</th>
                <th scope="col">Proyecto</th>

                <th width="9%" scope="col" style="text-align: center">Total Solicitado // Rendido</th>
                <th width="11%" scope="col" style="text-align: center">Estado</th>
                <th width="9%" scope="col">Cod Rendición</th>
                <th width="9%" scope="col" style="text-align: center">F. Revisión</th>
                

                <th width="7%" scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($listaSolicitudesFondos as $itemSolicitud)

      
            <tr>
                <td style = "padding: 0.40rem">{{$itemSolicitud->codigoCedepas  }}</td>
                <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->formatoFechaHoraEmision()}}</td>
              
                <td style = "padding: 0.40rem"> {{$itemSolicitud->getNombreSolicitante()}} </td>
                <td style = "padding: 0.40rem">{{$itemSolicitud->getProyecto()->codigoPresupuestal  }}</td>
                
                <td style = "padding: 0.40rem">{{$itemSolicitud->getnombreProyecto()  }}</td>
                <td style = "padding: 0.40rem; text-align: right"> 
                    {{$itemSolicitud->getMoneda()->simbolo}}  {{number_format($itemSolicitud->totalSolicitado,2)  }}<br>
                    @if($itemSolicitud->estaRendida())
                      // {{$itemSolicitud->getMoneda()->simbolo}}  {{number_format($itemSolicitud->getRendicion()->totalImporteRendido,2)}}
                    @endif
                </td>
                <td style = "padding: 0.40rem; text-align: center">
                  <input type="text" value="{{$itemSolicitud->getNombreEstado()}}" class="form-control" readonly 
                    style="background-color: {{$itemSolicitud->getColorEstado()}};
                            height: 26px;
                            text-align:center;
                            color: {{$itemSolicitud->getColorLetrasEstado()}} ;
                    "  title="{{$itemSolicitud->getMensajeEstado()}}">
                </td>
                <td style = "padding: 0.40rem">  
                  @if($itemSolicitud->estaRendida())
                    
                    {{$itemSolicitud->getRendicion()->codigoCedepas}}

                  @endif
                </td>
                
                <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->formatoFechaHoraRevisado()}}</td>
                <td style = "padding: 0.40rem">
                      {{-- Si la tenemos que evaluar --}}  
                      @if($itemSolicitud->verificarEstado('Creada') || $itemSolicitud->verificarEstado('Subsanada') )
                          <a href="{{route('SolicitudFondos.Gerente.Revisar',$itemSolicitud->codSolicitud)}}" 
                            class='btn btn-warning btn-sm' title="Evaluar Solicitud"><i class="fas fa-thumbs-up"></i></a>    


                      @else {{-- Si ya la evaluamos y solo la vamos a  ver --}}
                            <a href="{{route('SolicitudFondos.Gerente.Revisar',$itemSolicitud->codSolicitud)}}" class='btn btn-info btn-sm' title="Ver Solicitud">S</a>
                          
                          @if($itemSolicitud->estaRendida())   
                            <a href="{{route('RendicionGastos.Gerente.Ver',$itemSolicitud->getRendicion()->codRendicionGastos)}}" class='btn btn-info btn-sm' title="Ver Rendición">R</a>

                          @endif

                        
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
@section('script')  
<script src="/select2/bootstrap-select.min.js"></script>     
 <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
 <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
@endsection