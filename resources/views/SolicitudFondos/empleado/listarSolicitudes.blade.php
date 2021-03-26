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
  <h3> LISTA DE MIS SOLICITUDES DE FONDOS </h3>
  


  <br>
    
    <div class="row">
      <div class="col-md-2">
        <a href="{{route('SolicitudFondos.Empleado.Create')}}" class = "btn btn-primary" style="margin-bottom: 5px;"> 
          <i class="fas fa-plus"> </i> 
            Nueva Solicitud
        </a>
      </div>
      <div class="col-md-10">
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
    

  {{--   <nav class = "navbar float-right"> 
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar por descripcion" aria-label="Search" id="buscarpor" name = "buscarpor" value ="{{($buscarpor)}}" >
            <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </nav> --}}


{{-- AQUI FALTA EL CODIGO SESSION DATOS ENDIF xdd --}}
      @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @ENDIF
      
    <table class="table" style="font-size: 10pt; margin-top:10px;">
            <thead class="thead-dark">
              <tr>
                <th width="9%" scope="col">Codigo Sol</th>
                <th width="9%" scope="col" style="text-align: center">F. Emision</th>
               
                <th scope="col">Proyecto</th>
                <th width="9%" scope="col" style="text-align: center">Total Solicitado // Rendido </th>
                <th width="11%" scope="col" style="text-align: center">Estado</th>
                <th width="5%" scope="col">Rendida</th>
                
                <th width="9%" scope="col" style="text-align: center">F. Revision</th>
                

                <th width="7%" scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>
        


        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($listaSolicitudesFondos as $itemSolicitud)
            <tr>
                <td style = "padding: 0.40rem">{{$itemSolicitud->codigoCedepas  }}</td>
                <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->getfechaHoraEmision()  }}</td>
                
                <td style = "padding: 0.40rem">{{$itemSolicitud->getnombreProyecto()  }}</td>
                <td style = "padding: 0.40rem; text-align: right"> 
                    {{$itemSolicitud->getMoneda()->simbolo}}  {{number_format($itemSolicitud->totalSolicitado,2)  }} <br>
                    @if($itemSolicitud->estaRendida())
                      // {{$itemSolicitud->getMoneda()->simbolo}}  {{number_format( $itemSolicitud->getRendicion()->totalImporteRendido,2 )}}
                    @endif
                </td>
                
                <td style = "padding: 0.40rem; text-align: center">
                  <input type="text" value="{{$itemSolicitud->getNombreEstado()}}" class="form-control" readonly 
                    style="background-color: {{$itemSolicitud->getColorEstado()}};
                            height: 26px;
                            text-align:center;
                            color: {{$itemSolicitud->getColorLetrasEstado()}} ;
                    ">
                </td>

                <td style = "padding: 0.40rem; text-align: center">
                  @if($itemSolicitud->estaRendida())
                    SÍ
                  @else
                    NO
                  @endif

                </td>

                <td style = "padding: 0.40rem; text-align: center">{{$itemSolicitud->getFechaRevision()}}</td>
                <td style = "padding: 0.40rem">
                    @switch($itemSolicitud->codEstadoSolicitud)
                        @case(App\SolicitudFondos::getCodEstado('Creada'))   {{-- Si solamente está creada --}}
                        @case(App\SolicitudFondos::getCodEstado('Observada')) {{-- O si está observada --}}
                        @case(App\SolicitudFondos::getCodEstado('Subsanada')) {{-- Si ya subsano las observaciones --}}
                                {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                            <a href="{{route('SolicitudFondos.Empleado.Edit',$itemSolicitud->codSolicitud)}}" class = "btn btn-sm btn-warning" title="Editar Solicitud"><i class="fas fa-edit"></i></a>
                            


                            <a href="#" class="btn btn-sm btn-danger" title="Cancelar Solicitud" onclick="swal({//sweetalert
                                  title:'¿Está seguro de cancelar la solicitud: {{$itemSolicitud->codigoCedepas}} ?',
                                  //type: 'warning',  
                                  type: 'warning',
                                  showCancelButton: true,//para que se muestre el boton de cancelar
                                  confirmButtonColor: '#3085d6',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText:  'SI',
                                  cancelButtonText:  'NO',
                                  closeOnConfirm:     true,//para mostrar el boton de confirmar
                                  html : true
                              },
                              function(){//se ejecuta cuando damos a aceptar
                                window.location.href='{{route('SolicitudFondos.Empleado.cancelar',$itemSolicitud->codSolicitud)}}';
                              });"><i class="fas fa-trash-alt"> </i></a>
                              
                            @break
                        @case(App\SolicitudFondos::getCodEstado('Aprobada')) {{-- YA FUE APROBADA --}}
                          <a href="{{route('SolicitudFondos.Empleado.Ver',$itemSolicitud->codSolicitud)}}" class = "btn btn-sm btn-info" title="Ver Solicitud">
                              S
                          </a>   
                        @break
                        @case(App\SolicitudFondos::getCodEstado('Abonada') || App\SolicitudFondos::getCodEstado('Contabilizada') ) {{-- ABONADA --}}
                            <a href="{{route('SolicitudFondos.Empleado.Ver',$itemSolicitud->codSolicitud)}}" class = "btn btn-sm btn-info" title="Ver Solicitud">
                              S
                            </a>   
                        @break
                        @case(App\SolicitudFondos::getCodEstado('Rechazada')) {{-- RECHAZADA --}} 
                          <a href="{{route('SolicitudFondos.Empleado.Ver',$itemSolicitud->codSolicitud)}}" class = "btn btn-sm btn-info" title="Ver Solicitud">
                            S
                          </a>
                        @break
                        @default
                            
                    @endswitch


                    @if($itemSolicitud->estaRendida())
                    <a href="{{route('RendicionGastos.Empleado.Ver',$itemSolicitud->getRendicion()->codRendicionGastos)}}" class = "btn btn-sm btn-info" title="Ver Rendición">
                      R
                    </a> 
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
