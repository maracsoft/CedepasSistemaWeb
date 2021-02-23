@extends('layout.plantilla') 
@section('contenido')
<br>
<div class="container">
    <h1>LISTA DE ACTIVOS</h1>
    <div>

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
                    <th scope="col">Estado</th>
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
                    <td>{{$itemactivo->getEstado()->nombre}}</td>
                    <td>{{!is_null($itemactivo->placa)? $itemactivo->placa : 'NO TIENE'}}</td> 
                    <td>
                        <a href="" class="btn btn-success btn-sm">Mantener</a>
                        <a href="" class="btn btn-danger btn-sm">Dar Baja</a>
                    </td> <!--se tiene que cambiar el atributo activo de la tabla activo(segunla opcion seleccionada)-->
                @endforeach
            </tbody>
        </table>
    <div>
</div>

@endsection