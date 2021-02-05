@extends('layout.plantilla')
@section('contenido')
<h1> CREAR PRODUCTO</h1>

<form method = "POST" action = "{{route('Estudiante.store')}}"  >
    @csrf   
      <div class="form-group">
        <label for="Nombres">Nombres</label>
        <input type="text" class="form-control @error('Nombres') is-invalid @enderror" id="Nombres" name="Nombres" placeHolder="Ingrese Nombres">
        
        @error('Nombres')
            <span class = "invalid-feedback" role ="alert">
                <strong>{{ $message }} </strong>
            </span>
        @enderror  
      </div>

      <div class="form-group">
        <label for="Apellidos">Apellidos</label>
        <input type="text" class="form-control @error('apellidos') is-invalid @enderror" id="Apellidos" name="Apellidos" placeHolder="Ingrese Apellidos">
        
        @error('Apellidos')
            <span class = "invalid-feedback" role ="alert">
                <strong>{{ $message }} </strong>
            </span>
        @enderror  
      </div>
      <div class="form-group">
        <label for="Direccion">Direccion</label>
        <input type="text" class="form-control @error('Direccion') is-invalid @enderror" id="Direccion" name="Direccion" placeHolder="Ingrese Direccion">
        
        @error('Direccion')
            <span class = "invalid-feedback" role ="alert">
                <strong>{{ $message }} </strong>
            </span>
        @enderror  
      </div>
 
      



      <div class="form-group">
        <label for="CodFacultad">Facultad</label>
        <select class="form-control @error('CodFacultad') is-invalid @enderror" id="CodFacultad" name="CodFacultad" >
          @foreach($facultad as $itemFacultad)
            <option value="{{$itemFacultad['CodFacultad']}}"> 
                {{$itemFacultad['Descripcion']}}
            </option>

          @endforeach
        </select>
      </div>
      
      <div class="form-group">
        <label for="CodEscuela">Escuela</label>
        <select class="form-control @error('CodEscuela') is-invalid @enderror" id="CodEscuela" name="CodEscuela" >
          @foreach($escuela as $itemEscuela)
            <option value="{{$itemEscuela['CodEscuela']}}"> 
                {{$itemEscuela['Descripcion']}}
            </option>

          @endforeach
        </select>
      </div>
      
      <div class="row">
              <div class="col-md-4">
            
                <div class="form-group">
                  <label for="stock">Edad</label>
                  <input type="number" class="form-control @error('Edad') is-invalid @enderror" id="Edad" name="Edad" >
                        @error('Edad')
                            <span class = "invalid-feedback" role ="alert">
                                <strong>{{ $message }} </strong>
                            </span>
                        @enderror  
                </div>

              </div>
        
      </div>
      
  
    <button type="submit" class="btn btn-primary">   <i class="fas fa-save"> </i> Grabar </button>
    <a href = "{{route('producto.index')}}" class = "btn btn-danger">
        <i class="fas fa-ban"> </i> Cancelar </a>




</form>



@endsection