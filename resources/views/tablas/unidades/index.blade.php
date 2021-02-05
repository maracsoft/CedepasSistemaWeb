@extends ('layout.plantilla')

@section('contenido')
<h3> LISTADO DE CATEGORIAS </h3>


    <a href="{{route('unidad.create')}}" class = "btn btn-primary"> 
        <i class="fas fa-plus"> </i> 
          Nuevo Registro
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

    <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Codigo</th>
                <th scope="col">Descripción</th>
                <th scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>



        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($unidad as $itemUnidad)

      
            <tr>
                <td>{{$itemUnidad->codunidad  }}</td>
                <td>{{$itemUnidad->descripcion  }}</td>
                <td>


                        {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                    <a href="{{route('unidad.edit',$itemUnidad->codunidad)}}" class = "btn btn-warning">  
                        <i class="fas fa-edit"> </i> 
                          Editar
                    </a>

                    <a href="{{route('unidad.confirmar',$itemUnidad->codunidad)}}" class = "btn btn-danger"> 
                        <i class="fas fa-trash-alt"> </i> 
                          Eliminar
                    </a>
                </td>

            </tr>
        @endforeach
      </tbody>
    </table>

{{-- {{$categoria->links()}} --}}


@endsection