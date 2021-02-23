@extends('layout.plantilla') 
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection
@section('contenido')
<br>
<div class="container">
<h1>MANEJO DE CAJA CHICA</h1>
    <div class="row mt-2">
        @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @ENDIF   
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
            <label for="inputEmail3" class="col-sm-4 col-form-label">Porcentaje del Gasto</label>
            <div class="col-sm-6">
                <input class="form-control" value="{{$periodo->getPorcentaje()}} %"
                    placeholder="Porcentaje del Gasto" readonly
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Estado de periodo</label>
            <div class="col-sm-6">
                <input
                    readonly value="{{$periodo->getNombreEstado()}}"
                    class="form-control"
                  
                    placeholder="Estado de periodo"
                />
            </div>
        </div>
    </div>
    <div class="col-5">

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Monto de Apertura</label>
            <div class="col-sm-6">
                <input
                    value="{{$periodo->montoApertura}}"
                    class="form-control"
                    readonly
                    placeholder="Monto de apertura"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Monto Actual</label>
            <div class="col-sm-6">
                <input
                    value="{{$periodo->montoFinal}}"
                    class="form-control" readonly
                
                    placeholder="Monto Actual"
                />
            </div>
        </div>

        @if($periodo->codEstado=='1')
            
        
        <div class="form-group row">
            <div class="col-sm-4" >
            </div>
            <div class="col-sm-8" >
            <a href="{{route('resp.verLiquidarPeriodo',$periodo->codPeriodoCaja)}}" class="btn btn-danger"><i class="fas fa-receipt"></i> Liquidar</button></a>
            <a href="{{route('resp.registrarGasto')}}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Gasto</button></a>

            </div>
        </div>
        @endif


    </div>
    </div>
    <br>
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