@extends('layout.plantilla')
@section('contenido')

    <div class="container">
        <h1>¿Desea eliminar el registro? Código : {{ $unidad->codunidad }} - Descripción:  {{ $unidad->descripcion }}  </h1>
                                    {{-- nombre de la ruta,         atributo --}}
        <form method="POST" action="{{route('unidad.destroy',$unidad->codunidad)}}">
            @method('delete')
            @csrf
        

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check-square"></i>
                    Sí
             </button>
            <a href="{{route('unidad.index')}}" class="btn btn-primary"><i class="fas fa-times-circle"></i>No</a>

          </form>

    </div>

@endsection