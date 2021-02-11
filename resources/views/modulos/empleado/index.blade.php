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
                <td>{{$itemSolicitud->fechaEmision  }}</td>
                <td>{{$itemSolicitud->getNombreSede()  }}</td>
                <td>{{$itemSolicitud->getNombreProyecto()  }}</td>
                <td>{{$itemSolicitud->totalSolicitado  }}</td>
                  
                <td>{{$itemSolicitud->getNombreEstado()  }}</td>
                <td style="text-align: center">{{$itemSolicitud->getFechaRevision()}}</td>
                <td>


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
                      
                </td>

            </tr>
        @endforeach
      </tbody>
    </table>

  {{$listaSolicitudesFondos->links()}}
 

</div>
@endsection