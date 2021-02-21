@extends('layout.plantilla') 
@section('contenido')
<h1>PAGO Y DECLARACION DE IMPUESTOS</h1>
    <div class="row mt-2">
       
    
    <div class="col-5">
  
    <div class="form-group row">
            <div class="col-sm-6" >
                <a href="" class="btn btn-primary"><i class="fas fa-plus"></i>Nueva declaracion</button></a>
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
            <tr>
                <th>01/01/2021</th>
                <td>Renzo Junior</td>
                <td>0.18</td>
               <td>20000 </td>
               <td>900 </td>
               <td>1000</td>
               <td>
                <a href="" class="btn btn-primary"><i class="fas fa-eye"></i> Ver</button></a>
               </td>
            </tr>
        </tbody>
    </table>
    <div>
@endsection