@extends('layout.plantilla')  
@section('contenido')
    <div class="container">
        <h1>Editar Registro</h1>    
    <form method="POST" action="{{route('Estudiante.update',$estudiante->CodEstudiante)}}">
            @method('put')
            @csrf


            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="id">Codigo</label>
                <input type="text" class="form-control" id="CodEstudiante" name="CodEstudiante" placeholder="Codigo" value="{{ $estudiante->CodEstudiante}}" disabled>                
                </div>
                <div class="form-group col-md-12">
                    <label for="Nombres">Nombres</label>
                    <input type="text" autocomplete="off" class="form-control @error('Nombres') is-invalid @enderror" maxlength="30" id="Nombres" name="Nombres" value="{{ $estudiante->Nombres }}">
                    @error('Nombres')    
                        <span class="invalid-feedback" role="alert"> 
                        <strong>{{ $message }}</strong>
                        </span>   
                    @enderror     
                </div>  

                <div class="form-group col-md-12">
                    <label for="Apellidos">Apellidos</label>
                    <input type="text" autocomplete="off" class="form-control @error('Apellidos') is-invalid @enderror" maxlength="40" id="Apellidos" name="Apellidos" value="{{ $estudiante->Apellidos }}">
                    @error('Apellidos')    
                        <span class="invalid-feedback" role="alert"> 
                        <strong>{{ $message }}</strong>
                        </span>   
                    @enderror     
                </div>  
                
                <div class="form-group col-md-12">
                    <label for="Direccion">Direccion</label>
                    <input type="text" autocomplete="off" class="form-control @error('Direccion') is-invalid @enderror" maxlength="40" id="Direccion" name="Direccion" value="{{ $estudiante->Direccion }}">
                    @error('Direccion')    
                        <span class="invalid-feedback" role="alert"> 
                        <strong>{{ $message }}</strong>
                        </span>   
                    @enderror     
                </div>  
 
            </div>           



            <div class="form-row">                
                <div class="form-group col-md-6">
                    <label for="Escuela">Escuela</label>                
                        <select class="form-control"  id="CodEscuela" name="CodEscuela">
                            @foreach($escuela as $itemEscuela)
                            <option value="{{$itemEscuela->CodEscuela}}" {{ $itemEscuela->CodEscuela==$estudiante->CodEscuela ? 'selected':'' }}>
                                    {{$itemEscuela->Descripcion}}
                            </option>                            
                        @endforeach            
                    </select>
                </div>
            </div>


            <div class="form-row">                
                <div class="form-group col-md-6">
                    <label for="">Facultad</label>                
                        <select class="form-control"  id="CodFacultad" name="CodFacultad">
                            @foreach($facultad as $itemFacultad)
                            <option value="{{$itemFacultad->CodFacultad}}" {{ $itemFacultad->CodFacultad==$estudiante->CodFacultad ? 'selected':'' }}>
                                    {{$itemFacultad->Descripcion}}
                            </option>                            
                        @endforeach            
                    </select>
                </div>
            </div>



            <div class="form-row">                
                <div class="form-group col-md-4">
                    <label for="Edad">Edad</label>
                <input type="number" class="form-control @error('Edad') is-invalid @enderror" id="Edad" name="Edad"   style="text-align:right" value="{{$estudiante->Edad}}" autocomplete="off"/>                        
                    @error('Edad')    
                        <span class="invalid-feedback" role="alert"> 
                        <strong>{{ $message }}</strong>
                        </span>   
                    @enderror     

                </div>              
            </div>     
             
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Grabar</button>
        <a href="{{route('Estudiante.index')}}" class="btn btn-danger"><i class="fas fa-ban"></i> Cancelar</a>
        </form>
    </div>
@endsection
