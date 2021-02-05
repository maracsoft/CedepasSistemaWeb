@extends('layout.plantilla')
@section('contenido')
<h1> CREAR PRODUCTO</h1>

<form method = "POST" action = "{{route('cliente.store')}}"  >
    @csrf   
      <div class="form-group">
        <label for="nombres">Nombres</label>
        <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres" name="nombres" placeHolder="Ingrese Nombres">
        
        @error('nombres')
            <span class = "invalid-feedback" role ="alert">
                <strong>{{ $message }} </strong>
            </span>
        @enderror  
      </div>

      
      <div class="form-group">
        <label for="direccion">Direccion</label>
        <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" placeHolder="Ingrese Direccion">
        
        @error('direccion')
            <span class = "invalid-feedback" role ="alert">
                <strong>{{ $message }} </strong>
            </span>
        @enderror  
      </div>
 
      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeHolder="Ingrese email">
        
        @error('email')
            <span class = "invalid-feedback" role ="alert">
                <strong>{{ $message }} </strong>
            </span>
        @enderror  
      </div>
 
      



      
      
      
      
      <div class="row">
              <div class="col-md-4">
            
                <div class="form-group">
                  <label for="ruc_dni">RUC/DNI</label>
                  <input type="number" class="form-control @error('ruc_dni') is-invalid @enderror" id="ruc_dni" name="ruc_dni" >
                        @error('ruc_dni')
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