@extends('layout.plantilla')  
@section('contenido')
    <div class="container">
        <h1>Editar Registro</h1>    
    <form method="POST" action="{{route('cliente.update',$cliente->codcliente)}}">
            @method('put')
            @csrf


            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="id">Codigo</label>
                <input type="text" class="form-control" id="CodEstudiante" name="CodEstudiante" placeholder="Codigo" value="{{ $cliente->codcliente}}" disabled>                
                </div>
            </div>  

            <div class="form-group">
                <label for="nombres">Nombres</label>
                <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres" name="nombres" placeHolder="Ingrese Nombres" value="{{$cliente->nombres}}">
                
                @error('nombres')
                    <span class = "invalid-feedback" role ="alert">
                        <strong>{{ $message }} </strong>
                    </span>
                @enderror  
            </div>

            
            <div class="form-group">
                <label for="direccion">Direccion</label>
                <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" placeHolder="Ingrese Direccion"  value="{{$cliente->direccion}}">
                
                @error('direccion')
                    <span class = "invalid-feedback" role ="alert">
                        <strong>{{ $message }} </strong>
                    </span>
                @enderror  
            </div>
        
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeHolder="Ingrese email" value="{{$cliente->email}}">
                
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
                        <input type="number" class="form-control @error('ruc_dni') is-invalid @enderror" id="ruc_dni" name="ruc_dni" value="{{$cliente->ruc_dni}}" >
                                @error('ruc_dni')
                                    <span class = "invalid-feedback" role ="alert">
                                        <strong>{{ $message }} </strong>
                                    </span>
                                @enderror  
                        </div>

                    </div>
                
            </div>


             
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Grabar</button>
        <a href="{{route('cliente.index')}}" class="btn btn-danger"><i class="fas fa-ban"></i> Cancelar</a>
        </form>
    </div>
@endsection
