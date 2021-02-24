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
                @foreach($detalles as $itemdetalle)
                <?php $itemactivo=$itemdetalle->getActivo(); ?>
                <tr>
                    <th>{{$itemactivo->codActivo}}</th>
                    <td>{{$itemactivo->getSede()->nombre}}</td>
                    <td>{{$itemactivo->getProyecto()->nombre}}</td>
                    <td>{{$itemactivo->getResponsable()->apellidos}}, {{$itemactivo->getResponsable()->nombres}}</td>
                    <td>{{$itemactivo->nombreDelBien}}</td>
                    <td>{{$itemactivo->caracteristicas}}</td>
                    <td>{{$itemactivo->getCategoria()->nombre}}</td>
                    <td>{{$itemactivo->placa}}</td>
                    <td>{{$itemdetalle->getEstado()->nombre}}</td>
                    <td>
                        @if($itemdetalle->seReviso==0)
                        <a href="/actualizarActivos/cambiarEstado/{{$itemdetalle->codRevisionDetalle}}*1" class="btn btn-success btn-sm">Mantener</a>
                        <a href="/actualizarActivos/cambiarEstado/{{$itemdetalle->codRevisionDetalle}}*0" class="btn btn-danger btn-sm">Dar Baja</a>    
                        @else
                        <em style="color: red" >{{($itemactivo->activo==1)? 'SE MANTIENE' : 'SE DIO DE BAJA'}}</em>
                        @endif
                    </td>
                </tr>      
                @endforeach
            </tbody>
        </table>
    <div>
</div>

@endsection