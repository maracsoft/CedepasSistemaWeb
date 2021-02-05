@extends('layout.plantilla')
@section('contenido')

    <div class="container">
        <h1>¿Desea eliminar el cliente? Código : {{ $cliente->codcliente }} - Descripción:  {{ $cliente->nombres }}  </h1>
                                    {{-- nombre de la ruta,         atributo --}}
        <form method="POST" action="{{route('cliente.destroy',$cliente->codcliente)}}">
            @method('delete')
            @csrf
        

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-check-square"></i>
                    Sí
             </button>
            <a href="{{route('cliente.index')}}" class="btn btn-primary"><i class="fas fa-times-circle"></i>No</a>

          </form>

    </div>

@endsection