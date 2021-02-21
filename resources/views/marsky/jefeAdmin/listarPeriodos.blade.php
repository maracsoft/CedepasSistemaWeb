@extends('layout.plantilla') 
@section('contenido')
<div class="container">

<h1>MANEJO DE CAJA CHICA</h1>
    <div class="row mt-2">
       
    <div class="col-6">
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Sede</label>
            <div class="col-sm-8">
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>Trujillo</option>
                            <option>Cajamarca</option>
                          </select>

            </div>
        </div>
        <div class="col-sm-4">
            <a href=" " class="btn btn-primary"><i class="fas fa-plus"></i>Buscar</button></a>
        </div>

    </div>
   
 
    <div>
        <h2>LISTADO DE PERIODOS</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Sede</th>
                <th scope="col">Fecha Inicio</th>
                <th scope="col">Fecha Final</th>
                <th scope="col">Monto Max.</th>
                <th scope="col">Monto Gast.</th>
                <th scope="col">Responsable</th>

                <th scope="col">Monto Sol.</th>
                <th scope="col">Estado</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listaPeriodos as $itemPeriodo)
            <tr>

                <th scope="row">
                    {{$itemPeriodo->getSede()->nombre}}
                </th>
                <td>
                    {{$itemPeriodo->fechaInicio}}
                </td>
                <td>
                    {{$itemPeriodo->fechaFinal}}
                </td>
                <td>
                    {{$itemPeriodo->montoApertura}}    
                </td>
                <td>
                    {{$itemPeriodo->montoFinal}}    
                </td>
                <td>
                    {{$itemPeriodo->getCajero()->nombres}}    
                    
                </td>
                <td>
                    {{$itemPeriodo->getMontoSolicitado()}}    
                    
                </td>
                <td>
                    {{$itemPeriodo->getNombreEstado()}}    
                    
                </td>
                    

                <td>
                <a href="" class="btn btn-primary"><i class="fas fa-eye"></i> Ver</button></a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    <div>
    </div>
@endsection