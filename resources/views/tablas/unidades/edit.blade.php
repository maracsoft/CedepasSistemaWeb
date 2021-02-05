@extends('layout.plantilla')
@section('contenido')

   
    <form method="POST" action="{{route('unidad.update',$unidad->codunidad)}}">
            @method('put')
            @csrf
            <div class="form-group">
                    <label for="categoria_id">Codigo:</label>
                <input type="text" class="form-control" id="categoria_id" name="categoria_id" value='{{$unidad->codunidad}}' disabled>
            </div>

            <div class="form-group">
              <label for="descripcion">Descripcion:</label>
              <input type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"  value='{{$unidad->descripcion}}' name="descripcion">
              @error('descripcion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
              @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Grabar</button>
            <a href="{{route('unidad.index')}}" class="btn btn-danger"><i class="fas fa-ban"></i>Cancelar</a>
          </form>


@endsection