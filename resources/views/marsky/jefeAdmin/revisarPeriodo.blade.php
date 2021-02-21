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
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fecha" id="fecha"
                                value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="text-align:center;">
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Fecha Final del Periodo</label>
                <div class="col-sm-4">
                    <div class="form-group">                            
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fecha" id="fecha"
                                value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="text-align:center;">
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Porcentaje de Gasto</label>
                <div class="col-sm-6">
                    <input
                        type="porcentajeGasto"
                        class="form-control"
                        id="porcentajeGasto"
                        placeholder="Porcentaje de Gasto"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Encargado</label>
                <div class="col-sm-6">
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>Maricielo Rodriguez</option>
                        <option>Renzo Franco</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Monto de Apertura</label>
                <div class="col-sm-6">
                    <input
                        type="montoApertura"
                        class="form-control"
                        id="montoApertura"
                        placeholder="Monto de apertura"
                    />
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Monto Actual</label>
                <div class="col-sm-6">
                    <input
                        type="montoActual"
                        class="form-control"
                        id="montoActual"
                        placeholder="Monto Actual"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Justificacion</label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <textarea
                            class="form-control"
                            aria-label="With textarea"
                        ></textarea>
                    </div>
                </div>
            </div>

        
    
            <div class="form-group row">
                <div class="col-sm-6" >
                    <a href="" class="btn btn-primary"><i class="fas fa-check"></i>Aprobar solicitud</button></a>
                </div>
            </div>
        </div>

    </div>
    <div>
            <h2>GASTOS DE ESTE PERIODO</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">N° Comprobante</th>
                    <th scope="col">Concepto</th>
                    <th scope="col">Importe</th>
                    <th scope="col">cod. Pres.</th>
                    <th scope="col">nombre Empleado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">01/01/2021</th>
                    <td>Fact</td>
                    <td>F001-2578</td>
                <td>Combustible camion </td>
                <td>90.00 </td>
                <td>5410403</td>
                <td>Renzo Junior</td>
                </tr>
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