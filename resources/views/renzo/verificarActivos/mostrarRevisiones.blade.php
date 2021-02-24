@extends('layout.plantilla') 
@section('contenido')
<br>
<div class="container">
    <h1>ACTUALIZAR ACTIVOS</h1>
    
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Inicio</th>
                        <th scope="col">Termino</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">% No revisado</th>
                        <th scope="col">% Disponible</th>
                        <th scope="col">% No Habido </th>
                        <th scope="col">% Deteriorado</th>
                        <th scope="col">% Donado</th>
                        <th scope="col">Opciones</th>  
                    </tr>
                </thead>
            <tbody>
                @foreach($revisiones as $itemrevision)
                <tr>
                    <td scope="row">{{$itemrevision->fechaHoraInicio}}</td>
                    <td>{{!is_null($itemrevision->fechaHoraCierre)? $itemrevision->fechaHoraCierre : '-'}}</td>
                    <td>{{$itemrevision->getResponsable()->apellidos}}, {{$itemrevision->getResponsable()->nombres}}</td>
                    <td>{{$itemrevision->descripcion}}</td>
                    <td>{{number_format($itemrevision->parametros()[0],2)}}%</td>
                    <td>{{number_format($itemrevision->parametros()[1],2)}}%</td>
                    <td>{{number_format($itemrevision->parametros()[2],2)}}%</td>
                    <td>{{number_format($itemrevision->parametros()[3],2)}}%</td>
                    <td>{{number_format($itemrevision->parametros()[4],2)}}%</td>
                    <td>
                        <a href="{{route('activos.mostrarActivos',$itemrevision->codRevision)}}" class="btn btn-info btn-sm">{{($itemrevision->seRevisoTodo()==1)? 'VER' : 'VERIFICAR ACTIVOS'}}</a>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
    <div>
</div>


@endsection
