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
  <div class="container">
    <div class="row">
      <div class="colLabel">
        <label for="">Empleado:</label>
      </div>
      <div class="col"> 
        <input type="text" class="form-control" value="{{$empleado->getNombreCompleto()}}" readonly>
      </div>
      

      <div class="colLabel">
        <label for="">Codigo Empleado:</label>
      </div>
      <div class="col"> 
        <input type="text" class="form-control" value="{{$empleado->codigoCedepas}}" readonly>
      </div>
      <div class="w-100"></div> {{-- SALTO LINEA --}} 

     

      
    </div>
  </div>


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
      
    <table class="table" style="font-size: 10pt;">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Codigo Sol</th>
                <th scope="col">Fecha emision</th>
               
                <th scope="col">Proyecto</th>
                <th scope="col">Total Solicitado & Rendido </th>
                <th scope="col">Estado</th>
                <th scope="col">Rendida</th>
                
                <th scope="col">Fecha Revision</th>
                

                <th scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>
        


        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($listaSolicitudesFondos as $itemSolicitud)

      
            <tr>
              <td>{{$itemSolicitud->codigoCedepas  }}</td>
                <td>{{$itemSolicitud->getfechaHoraEmision()  }}</td>
                
                <td>{{$itemSolicitud->getnombreProyecto()  }}</td>
                <td> 

                  
                  <h3 style="font-size: 14pt;">
                    {{$itemSolicitud->getMoneda()->simbolo}}  {{$itemSolicitud->totalSolicitado  }}
                    @if($itemSolicitud->estaRendida())
                      // {{$itemSolicitud->getMoneda()->simbolo}}  {{$itemSolicitud->getRendicion()->totalImporteRendido}}
                    @endif
                  </h3>
                </td>
                
                <td style="text-align: center">
                  <div class="form-control"  
                    style="background-color: {{$itemSolicitud->getColorEstado()}};
                    width:95%; 
                    text-align:center;
                    color: {{$itemSolicitud->getColorLetrasEstado()}} ;
                    ">
                      {{$itemSolicitud->getNombreEstado()}}
                    
                    {{-- @if($itemSolicitud->verificarEstado('Abonada') or $itemSolicitud->verificarEstado('Rendida'))
                    <a href="{{route('solicitudFondos.descargarComprobanteAbono',$itemSolicitud->codSolicitud)}}">
                      <i class="fas fa-download">Ver Abono</i>
                    </a>
                    @endif --}}
                    

                  </div>
                
                  

                </td>

                <td>
                  @if($itemSolicitud->estaRendida())
                    SÍ
                  @else
                    NO
                  @endif

                </td>

                <td style="text-align: center">{{$itemSolicitud->getFechaRevision()}}</td>
                <td>
                    @switch($itemSolicitud->codEstadoSolicitud)
                        @case(App\SolicitudFondos::getCodEstado('Creada'))   {{-- Si solamente está creada --}}
                        @case(App\SolicitudFondos::getCodEstado('Observada')) {{-- O si está observada --}}
                        @case(App\SolicitudFondos::getCodEstado('Subsanada')) {{-- Si ya subsano las observaciones --}}
                                {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                            <a href="{{route('SolicitudFondos.Empleado.Edit',$itemSolicitud->codSolicitud)}}" class = "btn btn-warning"><i class="fas fa-edit"></i></a>
                            <!--
                            <a href="" class = "btn btn-danger"> 
                                <i class="fas fa-trash-alt"> </i> 
                                  Eliminar
                            </a>
                            -->
                            <a href="#" class="btn btn-danger" title="Eliminar registro" onclick="swal({//sweetalert
                                  title:'¿Está seguro de eliminar la solicitud: {{$itemSolicitud->codigoCedepas}} ?',
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
                                window.location.href='/solicitudes/delete/{{$itemSolicitud->codSolicitud}}';
                              });"><i class="fas fa-trash-alt"> </i></a>
                              
                            @break
                        @case(App\SolicitudFondos::getCodEstado('Aprobada')) {{-- YA FUE APROBADA --}}
                          <a href="{{route('SolicitudFondos.Empleado.Ver',$itemSolicitud->codSolicitud)}}">
                            <h1>
                              <span class="red">S</span>
                            </h1>
                          </a>   

                            @break
                        @case(App\SolicitudFondos::getCodEstado('Abonada') || App\SolicitudFondos::getCodEstado('Contabilizada') ) {{-- ABONADA --}}
                            <a href="{{route('SolicitudFondos.Empleado.Ver',$itemSolicitud->codSolicitud)}}">
                              <h1>
                                <span class="red">S</span>
                              </h1>
                            </a>   

                            


                            @break
                     
                          @case(App\SolicitudFondos::getCodEstado('Rechazada')) {{-- RECHAZADA --}} 
                            <a href="{{route('SolicitudFondos.Empleado.Ver',$itemSolicitud->codSolicitud)}}">
                              <h1>
                                <span class="red">S</span>
                              </h1>
                            </a>
                         
                            
                          @break

                        @default
                            
                    @endswitch


                    @if($itemSolicitud->estaRendida())
                    <a href="{{route('RendicionGastos.Empleado.Ver',$itemSolicitud->getRendicion()->codRendicionGastos)}}">
                      <h1>
                        <span class="red">R</span>
                      </h1>
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
