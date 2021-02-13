@extends ('layout.plantilla')

@section('contenido')
<div>
  <h3> LISTA DE SOLIC DE FONDOS PARA APROBAR </h3>
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
                <th scope="col">Empleado </th>
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
                <td>{{$itemSolicitud->getFechaEmision() }}</td>
                <td>{{$itemSolicitud->getNombreSede()  }}</td>
                <td> {{$itemSolicitud->getNombreSolicitante()}} </td>
                <td>{{$itemSolicitud->getNombreProyecto()  }}</td>
                <td>{{$itemSolicitud->totalSolicitado  }}</td>
                  
                <td>{{$itemSolicitud->getNombreEstado()  }} 
                  @if($itemSolicitud->codEstadoSolicitud == 4)
                    <br>
                    S/.{{$itemSolicitud->getRendicion()->totalImporteRendido}}

                  @endif
                  

                </td>
                <td style="text-align: center">{{$itemSolicitud->getFechaRevision()}}</td>
                <td>
                  

                        {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                    <a href="{{route('solicitudFondos.revisar',$itemSolicitud->codSolicitud)}}" class = "btn btn-warning">
                      <i class="fas fa-eye"></i>
                    </a>
                   
                    
                </td>

            </tr>
        @endforeach
      </tbody>
    </table>

  {{$listaSolicitudesFondos->links()}}
 

</div>
@endsection