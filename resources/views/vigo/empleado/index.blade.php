@extends ('layout.plantilla')

@section('contenido')
<div>
  <h3> LISTA DE MIS SOLICITUDES DE FONDOS </h3>


    <a href="{{route('solicitudFondos.create')}}" class = "btn btn-primary"> 
        <i class="fas fa-plus"> </i> 
          Nueva Solicitud
    </a>

    <nav class = "navbar float-right"> {{-- PARA MANDARLO A LA DERECHA --}}
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar por descripcion" aria-label="Search" id="buscarpor" name = "buscarpor" value ="{{($buscarpor)}}" >
            <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </nav>


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
                <th scope="col">Sede</th>
                <th scope="col">Proyecto</th>
                <th scope="col">Total Solicitado</th>
                <th scope="col">Estado</th>
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
                <td>{{$itemSolicitud->getNombreSede()  }}</td>
                <td>{{$itemSolicitud->getNombreProyecto()  }}</td>
                <td> S/. {{$itemSolicitud->totalSolicitado  }}</td>
                  
                <td>{{$itemSolicitud->getNombreEstado()  }} 
                  @if($itemSolicitud->codEstadoSolicitud == 4)
                    <br>
                    S/.{{$itemSolicitud->getRendicion()->totalImporteRendido}}

                  @endif
                  

                </td>
                <td style="text-align: center">{{$itemSolicitud->getFechaRevision()}}</td>
                <td>
                    @switch($itemSolicitud->codEstadoSolicitud)
                        @case(1){{-- Si solamente está creada --}}
                                
                                {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                            <a href="{{route('solicitudFondos.edit',$itemSolicitud->codSolicitud)}}" class = "btn btn-warning"><i class="fas fa-edit"></i></a>
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
                        @case(2) {{-- YA FUE APROBADA --}}
                              
                            @break
                        @case(3) {{-- ABONADA --}}
                            <a href="{{route('solicitudFondos.rendir',$itemSolicitud->codSolicitud)}}" class = "btn btn-warning">
                              Rendir <i class="fas fa-list"></i>
                            </a>


                            @break
                        @case(4) {{-- RENDIDA --}}
                              {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                            {{-- <a href="{{route('solicitudFondos.revisar',$itemSolicitud->codSolicitud)}}" class = "btn btn-warning">
                              <i class="fas fa-eye"> Sol</i>
                            </a> --}}

                            <a href="{{route('solicitudFondos.ver',$itemSolicitud->codSolicitud)}}">
                            <h1>
                              <span class="red">S</span>
                            </h1>
                            </a>
                          
                            <a href="{{route('rendicionFondos.ver',$itemSolicitud->codSolicitud)}}">
                              <h1>
                                <span class="red">R</span>
                              </h1>
                            </a>
                          
                            @break
                            

                        @default
                            
                    @endswitch

             
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
