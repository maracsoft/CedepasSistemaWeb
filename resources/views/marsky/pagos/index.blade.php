@extends('layout.plantilla') 
@section('contenido')
<h1>PAGO Y DECLARACION DE IMPUESTOS</h1>
    <div class="row mt-2">
       
    
    <div class="col-5">
  
    <div class="form-group row">
            <div class="col-sm-6" >
                <a href="{{route('declaracion.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>Nueva declaracion</button></a>
            </div>
        </div>
    </div>
    </div>
    <div>
        <h2>LISTADO</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Empleado</th>
                <th scope="col">Impuesto</th>
                <th scope="col">Ingresos</th>
                <th scope="col">Gastos</th>
                <th scope="col">Gastos Plan.</th>
                <th scope="col">Informe</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listaDeclaraciones as $declaracion)
            <tr>
                <th>{{$declaracion->fechaDeclaracion}}</th>
                <td>{{$declaracion->getEmpleado()}}</td>
                <td>{{$declaracion->ingresos}}</td>
               <td>{{$declaracion->gastos}}</td>
               <td>{{$declaracion->gastosPlanilla}}</td>
               <td>{{$declaracion->getMes()}}</td>
               <td>
                <a href="" class="btn btn-primary"><i class="fas fa-eye"></i> Ver</button></a>
               </td>
            </tr>
            @endforeach


        </tbody>
    </table>
    <div>
@endsection