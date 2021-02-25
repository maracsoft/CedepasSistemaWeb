@extends('layout.plantilla') 
@section('contenido')
<br>
<div class="container">
    <h1>LISTA DE ACTIVOS</h1>
    <div class="row mt-2">
        <div class="col-5">
            <div class="form-group row">
                    <div class="col-sm-6" >
                        <a href="{{route('activos.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>Nuevo Activo</button></a>
                    </div>
            </div>
        </div>
    </div>
    <div>

    @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
    @endif

        <table class="table table-striped">
            <thead>
                <tr>
                   
                    <th scope="col">Código Activo</th>
                    <th scope="col">Sede</th>
                    <th scope="col">Proyecto</th>
                    <th scope="col">Responsable</th>
                    <th scope="col">Nombre Activo</th>
                    <th scope="col">Características</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activos as $itemactivo)
                <tr>
                    
                    <td>{{$itemactivo->codActivo}}</td>
                    <td>{{$itemactivo->getSede()->nombre}}</td>
                    <td>{{$itemactivo->getProyecto()->nombre}}</td>
                    <td>{{$itemactivo->getResponsable()->apellidos}}, {{$itemactivo->getResponsable()->nombres}}</td>
                    <td>{{$itemactivo->nombreDelBien}}</td>
                    <td>{{$itemactivo->caracteristicas}}</td>
                    <td>{{$itemactivo->getCategoria()->nombre}}</td>
                    <td>{{!is_null($itemactivo->placa)? $itemactivo->placa : 'NO TIENE'}}</td> 
                    <td>
                        @if($itemactivo->activo==1)
                        <a href="{{route('activos.edit',$itemactivo->codActivo)}}" class="btn btn-success btn-sm">Editar</button></a>    
                        @else
                        <em style="color: red">DE BAJA</em>
                        <a href="{{route('activos.habilitarActivo',$itemactivo->codActivo)}}" class="btn btn-warning btn-sm">Habilidar</button></a>
                        @endif
                        
                    </td>    
                @endforeach
            </tbody>
        </table>
    <div>
</div>

@endsection