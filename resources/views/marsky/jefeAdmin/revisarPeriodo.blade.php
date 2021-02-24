@extends('layout.plantilla') 
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection
@section('contenido')
<br>
<div class="container">
    <h1>REVISION DE SOLICITUD</h1>
    <div class="row mt-2">
       
        <div class="col-6">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Fecha Inicio del Periodo</label>
                <div class="col-sm-4">
                    <div class="form-group">                            
                        <div class="input-group date form_date ">
                            <input type="text"  class="form-control" name="fecha" id="fecha" readonly
                                value="{{$periodo->fechaInicio}}" style="text-align:center;">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Fecha Final del Periodo</label>
                <div class="col-sm-4">
                    <div class="form-group">                            
                        <div class="input-group date form_date " >
                            <input type="text"  class="form-control" name="fecha" id="fecha" readonly
                                value="{{$periodo->fechaFinal}}" style="text-align:center;">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Porcentaje de Gasto</label>
                <div class="col-sm-6">
                    <input
                        name="porcentajeGasto" readonly
                        class="form-control"
                        id="porcentajeGasto"
                        value="{{$periodo->getPorcentaje()}} %"
                        placeholder="Porcentaje de Gasto"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Encargado</label>
                <div class="col-sm-6">
                    <input type="text" readonly class="form-control" value="{{$periodo->getCajero()->getNombreCompleto()}}">
                </div>
            </div>
        </div>
        <div class="col-6">

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Monto de Apertura</label>
                <div class="col-sm-6">
                    <input
                        name="montoApertura" 
                        class="form-control" readonly
                        id="montoApertura"
                        value="{{$periodo->montoApertura}}"
                        placeholder="Monto de apertura"
                    />
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Monto Actual</label>
                <div class="col-sm-6">
                    <input
                    name="montoActual"
                        class="form-control" 
                        id="montoActual" readonly
                        value="{{$periodo->montoFinal}}"
                        placeholder="Monto Actual"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Estado</label>
                <div class="col-sm-6">
                    <input
                    name="montoActual"
                        class="form-control" readonly
                        id="montoActual"
                        value="{{$periodo->getNombreEstado()}}"
                        placeholder="Monto Actual"
                    />
                </div>
            </div>
            @if($periodo->codEstado!='1')
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Justificacion</label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <textarea
                            class="form-control"
                            aria-label="With textarea" readonly
                        >{{$periodo->justificacion}}</textarea>
                    </div>
                </div>
            </div>
            
        
            @if($periodo->codEstado=='2')
                
            
            <div class="form-group row">
                <div class="col-sm-6" >
                    <a href="{{route('admin.periodoCaja.reponer',$periodo->codPeriodoCaja)}}" 
                            class="btn btn-primary">
                            <i class="fas fa-check"></i>
                            Aprobar solicitud
                    
                </a>
                </div>
            </div>
            @endif

            @endif
        </div>

    </div>
    <div>
            <h2>GASTOS DE ESTE PERIODO</h2>
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
    <div>
</div>


@endsection

@section('script')  
    <script src="/select2/bootstrap-select.min.js"></script>     
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/archivos/js/createdoc.js"></script>
@endsection