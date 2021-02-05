@extends('layout.plantilla')
@section('contenido')
<div class="container">
    <br>
<div class="card">
        <div class="card-header">
            <h4><strong>Mantenedor de Estudiante</strong></h4>
        </div>
        <div class="card-body">
            <h5 class="card-title"><u>.::Eliminar Estudiante</u></h5>
            <p class="card-text">
                <p class="card-text">
                    <strong>Código: </strong> {{$estudiante->CodEstudiante}} <br>
                    <strong>Nombre: </strong> {{$estudiante->Apellidos}}
                </p>
                <h5 class="card-title">¿Desea eliminar?</h5><br>
                <form action="{{route('Estudiante.destroy',$estudiante->CodEstudiante)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-check-square"></i>
                            Si
                        </button>
                        <a href="{{route('Estudiante.index')}}" class="btn btn-sm btn-primary">
                            <i class="fas fa-times-circle"></i>
                            NO
                        </a>
                    </div>
                </form>
            </p>
        </div>
    </div>
</div>
@endsection