@extends ('Layout.Plantilla')

@section('titulo')
  Listar Rendiciones
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
  
<div>
  <h3> Rendiciones de Gastos a Reponer </h3>
  <div class="container">
    <div class="row">
    
      
      

      
    </div>
  </div>
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
              <tr>
                <th width="9%" scope="col">Cod. Rendicion</th> {{-- COD CEDEPAS --}}
                <th width="9%"  scope="col" style="text-align: center">F. Rendicion</th>
              
                <th width="13%"  scope="col">Empleado </th>
                <th width="3%">P.P</th>
                <th scope="col">Proyecto</th>              
                <th width="9%"  scope="col" style="text-align: center">Total Recibido</th>
                <th width="9%"  scope="col" style="text-align: center">Total Gastado</th>
                <th width="9%"  scope="col" style="text-align: center">Saldo</th>
                <th width="11%"  scope="col" style="text-align: center">Estado</th>
                <th width="10%"  scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($listaRendiciones as $itemRendicion)
            <tr>
              <td style = "padding: 0.40rem">{{$itemRendicion->codigoCedepas  }}</td>
              <td style = "padding: 0.40rem; text-align: center">{{$itemRendicion->getFechaHoraRendicion()  }}</td>
             
              <td style = "padding: 0.40rem">{{$itemRendicion->getNombreSolicitante()  }}</td>
              <td style = "padding: 0.40rem">{{$itemRendicion->getProyecto()->codigoPresupuestal  }}</td>
              <td style = "padding: 0.40rem">{{$itemRendicion->getNombreProyecto()  }}</td>
              <td style = "padding: 0.40rem; text-align: right">{{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->totalImporteRecibido,2)  }}</td>
              <td style = "padding: 0.40rem; text-align: right">{{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->totalImporteRendido,2)  }}</td>
              <td style = "padding: 0.40rem; text-align: right;  color: {{$itemRendicion->getColorSaldo()}}">{{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->saldoAFavorDeEmpleado,2)  }}</td>
              
        
              <td style = "padding: 0.40rem; text-align: center">
                <input type="text" value="{{$itemRendicion->getNombreEstado()}}" class="form-control" readonly 
                style="background-color: {{$itemRendicion->getColorEstado()}};
                        height: 26px;
                        text-align:center;
                        color: {{$itemRendicion->getColorLetrasEstado()}} ;
                "  title="{{$itemRendicion->getMensajeEstado()}}">
              </td>
              <td style = "padding: 0.40rem">        
                  
                  <a href="{{route('SolicitudFondos.Empleado.Ver',$itemRendicion->getSolicitud()->codSolicitud)}}" class='btn btn-info btn-sm' title="Ver Solicitud">
                    S
                  </a>

                  @if($itemRendicion->verificarEstado('Aprobada') || $itemRendicion->verificarEstado('Creada'))
                  {{-- Es en estos estados que puede observar --}}  
                    <a href="{{route('RendicionGastos.Administracion.Ver',$itemRendicion->codRendicionGastos)}}" class='btn btn-danger btn-sm' title="Revisar Rendición">
                      <i class="fas fa-eye"></i>
                    </a>
                  @else 
                    <a href="{{route('RendicionGastos.Administracion.Ver',$itemRendicion->codRendicionGastos)}}" class='btn btn-info btn-sm' title="Ver Rendición">
                      R
                    </a>

                  @endif

                  
                



                <a class='btn btn-info btn-sm'  href="{{route('rendicionGastos.descargarPDF',$itemRendicion->codRendicionGastos)}}" title="Descargar PDF">
                  <i class="fas fa-file-download"></i>
                </a>
                <a target="pdf_rendicion_{{$itemRendicion->codRendicionGastos}}" class='btn btn-info btn-sm'  href="{{route('rendicionGastos.verPDF',$itemRendicion->codRendicionGastos)}}" title="Ver PDF">
                  <i class="fas fa-file-pdf"></i>
                </a>
                  
              </td>

            </tr>
        @endforeach
      </tbody>
    </table>



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
