@extends('layout.plantilla') 
@section('contenido')
<div class="conteiner">
<h1 class="mt-4 mb-5">LIQUIDACION DE PERIODO</h2>
<div>
    <h4 class="mt-4 mb-5">GASTOS DE ESTE PERIODO</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Item</th>
                    <th scope="col">Fecha CDP</th>
                    <th scope="col">Tipo CDP</th>
                    <th scope="col">N° CDP</th>
                    <th scope="col">Concepto</th>
                    <th scope="col">Monto</th>
                    <th scope="col">codigo Presupuestal</th>
                    <th scope="col">nombre Empleado destino</th>
                    <th scope="col">CDP</th>


            </tr>
        </thead>
        <tbody>
            @foreach($listaGastos as $itemGasto)
            <tr>
                <th>{{$itemGasto->nroEnPeriodo}}</th>
                <td>{{$itemGasto->fechaComprobante}}</td>
                <td>{{$itemGasto->getNombreTipoCDP()}}</td>
                <td>{{$itemGasto->nroCDP}}</td>
            
                <td>{{$itemGasto->concepto}}</td>
                
                <td>{{$itemGasto->monto}} </td>
                <td>{{$itemGasto->codigoPresupuestal}}</td>
                <td>{{$itemGasto->getNombreEmpleadoDestino()}}</td>
                <td style="text-align: center">
                    <a target="_blank"  href="{{route('gasto.descargarCDP',$itemGasto->codGastoPeriodo)}}" 
                        class='btn btn-primary'>
                        <i class="fas fa-download"></i>
                    </a>   
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

   <form method="POST" action="{{route('resp.liquidarPeriodo')}}"> 
       @csrf
       <input type="hidden" name="codPeriodoCaja" value="{{$periodo->codPeriodoCaja}}">
        <div class="col-12 mb-3">
            <label for="basic-url">Ingresar justificaciones</label>
            <div class="input-group">
                <textarea
                    name="justificacion"
                    id="justificacion"
                    class="form-control"
                    aria-label="With textarea"
                ></textarea>
            </div>
        </div>
        
        <div class="form-group row">
            <div class="col-sm-4" >
            </div>
            <div class="col-sm-8" >
                <a href="{{route('resp.verPeriodo',$periodo->codPeriodoCaja)}}" class="btn btn-danger">
                    <i class="fas fa-undo"></i> 
                    Regresar
                
                </a>    

                
                <button type="submit"  class="btn btn-primary">
                    <i class="fas fa-save"></i>  
                    Cerrar Periodo y Solicitar Reposición
                </button>
            
            </div>
            </div>
        </div>
    </form>

</div>
@endsection