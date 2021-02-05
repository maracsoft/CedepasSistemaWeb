@extends('layout.plantilla')  
@section('contenido')
    <div class="container">
        <h1>Editar Registro</h1>    
    <form method="POST" action="{{ route('producto.update',$producto->codProducto)}}">
            @method('put')
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="id">Codigo</label>
                <input type="text" class="form-control" id="codproducto" name="codproducto" placeholder="Codigo" value="{{ $producto->codProducto}}" disabled>                
                </div>
                <div class="form-group col-md-12">
                    <label for="nombre">Nombre</label>
                    <input type="text" autocomplete="off" class="form-control @error('nombre') is-invalid @enderror" maxlength="100" id="nombre" name="nombre" value="{{ $producto->nombre }}">
                    @error('nombre')    
                        <span class="invalid-feedback" role="alert"> 
                        <strong>{{ $message }}</strong>
                        </span>   
                    @enderror     
                </div>              
            </div>              
            <div class="form-row">                
                <div class="form-group col-md-6">
                    <label for="">Categorias</label>                
                        <select class="form-control"  id="codCategoria" name="codCategoria">
                            @foreach($categoria as $itemcategoria)
                            <option value="{{$itemcategoria->codCategoria}}" {{ $itemcategoria->codCategoria==$producto->codCategoria ? 'selected':'' }}>{{$itemcategoria->nombre}}</option>                            
                        @endforeach            
                    </select>
                </div>
            </div>
            <div class="form-row">                
                <div class="form-group col-md-4">
                    <label for="precio">Precio</label>
                <input type="number" step = "any" class="form-control @error('precio') is-invalid @enderror" id="precio" name="precio"   style="text-align:right" value="{{$producto->precioActual}}" autocomplete="off"/>                        
                    @error('precio')    
                        <span class="invalid-feedback" role="alert"> 
                        <strong>{{ $message }}</strong>
                        </span>   
                    @enderror     
                </div>              
            </div>     
    
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Grabar</button>
        <a href="{{ route('producto.index') }}" class="btn btn-danger"><i class="fas fa-ban"></i> Cancelar</a>
        </form>
    </div>
@endsection
