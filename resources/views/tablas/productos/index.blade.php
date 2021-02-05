@extends ('layout.plantilla')

@section('contenido')


<div class="container">

  <h3> LISTADO DE PRODUCTO </h3>


  <a href="{{route('producto.create')}}" class = "btn btn-primary"> 
      <i class="fas fa-plus"> </i> 
        Nuevo Registro
  </a>

  <nav class = "navbar float-right" > {{-- PARA MANDARLO A LA DERECHA --}}
      <form class="form-inline my-2 my-lg-0" action="{{route('producto.index')}}">
          <input class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre" aria-label="Search" id="buscarpor" name = "buscarpor" value ="{{($buscarpor)}}" >
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
    @endif

  <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Codigo</th>
              <th scope="col">Nombre</th>
              <th scope="col">Categoria</th>
              <th scope="col">Precio</th>
              <th scope="col">Opciones</th>
              
            </tr>
          </thead>
    <tbody>
      {{--     varQuePasamos  nuevoNombre                        --}}
      @foreach($producto as $itemProducto)
            <tr>
              <td>{{$itemProducto->codProducto  }}</td>
              <td>{{$itemProducto->nombre  }}</td>
              <td>{{$itemProducto->categoria->nombre}}</td>
              <td>S/ {{$itemProducto->precioActual}}</td>
              <td>


                      {{-- MODIFICAR RUTAS DE Delete y Edit --}}
                  <a href="{{route('producto.edit',$itemProducto->codProducto)}}" class = "btn btn-warning">  
                      <i class="fas fa-edit"> </i> 
                        Editar
                  </a>

                  <a href="#" class="btn btn-danger" title="Eliminar registro" onclick="swal({//sweetalert
                      title:'¿Está seguro de eliminar el producto: {{$itemProducto->nombre}} ?',
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
                    window.location.href='/producto/delete/{{$itemProducto->codProducto}}';
                  });"><i class="fas fa-trash-alt"> </i>Eliminar</a>
              </td>

          </tr>
      @endforeach
    </tbody>
  </table>

{{$producto->links()}} 


</div>


@endsection