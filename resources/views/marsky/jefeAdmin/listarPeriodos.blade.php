@extends('layout.plantilla') 
@section('contenido')
<div class="container">

<h1>Listado de Periodos de Caja Chica de todos los proyectos.</h1>

    @if (session('datos'))
    <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
        <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true"> &times;</span>
        </button>
        
    </div>
    @endif 


    <div class="row mt-2">
       
    <div class="col-6">
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Sede</label>
            <div class="col-sm-8">
                <select class="form-control"  id="ComboBoxSede" name="ComboBoxSede" >
                    <option value="-1">-- Seleccionar --</option>
                    @foreach($listaSedes as $itemSede)
                        <option value="{{$itemSede['codSede']}}" >
                            {{$itemSede->nombre}}
                        </option>                                 
                    @endforeach 
                </select>   

            </div>
        </div>
        <div class="col-sm-4">
            <a href="" class="btn btn-primary"><i class="fas fa-plus"></i>Buscar</button></a>
        </div>

    </div>
   
 
    <div>
        <h2>LISTADO DE PERIODOS</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Proyecto</th>
                <th scope="col">Nombre C.Chica</th>
                
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
            <tr
            @if($itemPeriodo->codEstado=='1')
                style="background-color: #00a599;"
            @endif
            >

                <td style="font-size: 10pt;">
                    {{$itemPeriodo->getProyecto()->nombre}}
                </td>

                <td style="font-size: 10pt;">
                    {{$itemPeriodo->getCaja()->nombre}}
                </td>

                
                <td>
                    {{$itemPeriodo->getFechaInicio()}}
                </td>
                <td>
                    {{$itemPeriodo->getFechaFinal()}}
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
                <a href="{{route('admin.periodoCaja.revisar',$itemPeriodo->codPeriodoCaja)}}" class="btn btn-primary"><i class="fas fa-eye"></i> Ver</button></a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    <div>
    </div>
@endsection