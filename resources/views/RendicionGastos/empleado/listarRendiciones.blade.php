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
  <h3> Mis Rendiciones de Gastos </h3>
  <div class="container">
    <div class="row">
     
      
      
      <label class="colLabel">Sol. Fondos:</label>

      <div class="col" style="">
        <select class="form-control mr-sm-2" onclick="actualizarCodSolicitud()" 
          id="codSolicitudSeleccionada" name="codSolicitudSeleccionada" style="">
          <option value="-1">--Seleccionar--</option>
          @foreach($listaSolicitudesPorRendir as $itemSolicitud)
              <option value="{{$itemSolicitud->codSolicitud}}" 
                {{$itemSolicitud->codSolicitud}}>
                  {{$itemSolicitud->codigoCedepas}} por {{$itemSolicitud->getMoneda()->simbolo}} {{number_format($itemSolicitud->totalSolicitado,2)}}
              </option>                                 
          @endforeach 
        </select>
      </div>

      <div class="col">
        <button class="btn btn-success " onclick="crearRendicion()">Crear Rendicion</button>
      </div>

    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-12">
      <form class="form-inline float-right">
        <select class="form-control mr-sm-2"  id="codProyectoBuscar" name="codProyectoBuscar">
          <option value="0">--Seleccionar--</option>
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
      @endif

    <table class="table" style="font-size: 10pt; margin-top:10px; ">
            <thead class="thead-dark">
              <tr>
                <th width="9%" scope="col">Cod. Rendicion</th> {{-- COD CEDEPAS --}}
                <th width="9%" scope="col" style="text-align: center">F. Rendicion</th>
            
                <th scope="col">Proyecto</th>              
                <th width="9%" scope="col" style="text-align: center">Total Recibido</th>
                <th width="9%" scope="col" style="text-align: center">Total Gastado</th>
                <th width="8%" scope="col" style="text-align: center">Saldo fav Emp</th>
                <th width="11%" scope="col" style="text-align: center">Estado</th>
                <th width="8%" scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($listaRendiciones as $itemRendicion)

      
            <tr>
              <td style = "padding: 0.40rem">{{$itemRendicion->codigoCedepas  }}</td>
              <td style = "padding: 0.40rem; text-align: center">{{$itemRendicion->getFechaHoraRendicion()  }}</td>
             
              <td style = "padding: 0.40rem">{{$itemRendicion->getNombreProyecto()  }}</td>
              <td style = "padding: 0.40rem; text-align: right">{{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->totalImporteRecibido,2)  }}</td>
              <td style = "padding: 0.40rem; text-align: right;">{{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->totalImporteRendido,2)  }}</td>
              <td style = "padding: 0.40rem; text-align: right; color: {{$itemRendicion->getColorSaldo()}}">{{$itemRendicion->getMoneda()->simbolo}} {{number_format($itemRendicion->saldoAFavorDeEmpleado,2)  }}</td>
              
        
              <td style = "padding: 0.40rem; text-align: center">
                <input  type="text" value="{{$itemRendicion->getNombreEstado()}}" class="form-control" readonly 
                style="background-color: {{$itemRendicion->getColorEstado()}};
                        height: 26px;
                        text-align:center;
                        color: {{$itemRendicion->getColorLetrasEstado()}} ;
                ">
              </td>
              <td style = "padding: 0.40rem">       
                @if($itemRendicion->verificarEstado('Creada') || 
                  $itemRendicion->verificarEstado('Subsanada') ||
                    $itemRendicion->verificarEstado('Observada') )
                  <a href="{{route('RendicionGastos.Empleado.Editar',$itemRendicion->codRendicionGastos)}}" class = "btn btn-warning btn-sm" title="Editar Rendición">
                    <i class="fas fa-edit"></i>
                  </a>
                          
                @endif
                <a href="{{route('SolicitudFondos.Empleado.Ver',$itemRendicion->getSolicitud()->codSolicitud)}}" class = "btn btn-info btn-sm" title="Ver Solicitud">
                  S
                </a>
                <a href="{{route('RendicionGastos.Empleado.Ver',$itemRendicion->codRendicionGastos)}}" class = "btn btn-info btn-sm" title="Ver Rendición">
                  R
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

<script>
var codigoSolicitudSeleccionada = -1; 

function actualizarCodSolicitud(){

  codigoSolicitudSeleccionada = document.getElementById('codSolicitudSeleccionada').value;

}


function crearRendicion(){
  console.log('hola');

  if(codigoSolicitudSeleccionada == '-1'){ 
    alerta('Debe seleccionar una solicitud para rendirla.');
    return;
  }
  
  window.location.href = "/SolicitudFondos/Empleado/Rendir/"+codigoSolicitudSeleccionada;
  
}



</script>