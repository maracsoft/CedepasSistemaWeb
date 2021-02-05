@extends('layout.plantilla')
@section('contenido')


<div class="container">

  <form method = "POST" action = "{{ route('categoria.store') }}"  >
    @csrf   
  <div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" placeHolder="Ingrese nombre">
    
    @error('nombre')
        <span class = "invalid-feedback" role ="alert">
            <strong>{{ $message }} </strong>
        </span>
    @enderror  
 
  </div>
  <div class="form-group">
    <label for="categoria">Categoria</label>
    <select class="form-control @error('codMacroCategoria') is-invalid @enderror" id="codMacroCategoria" name="codMacroCategoria" >
      
        <option value=""> 
         a
        </option>

     
    </select>
  </div>
 
  
    <button type="submit" class="btn btn-primary">   <i class="fas fa-save"> </i> Grabar </button>
    <a href = "{{route('categoria.index')}}" class = "btn btn-danger">
        <i class="fas fa-ban"> </i> Cancelar </a>




</form>

</div>

@endsection