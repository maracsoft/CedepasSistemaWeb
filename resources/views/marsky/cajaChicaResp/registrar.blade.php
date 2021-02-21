@extends('layout.plantilla') 
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection
@section('contenido')
<br>
<h1>REGISTRAR NUEVO GASTO</h1>

<div class="row mt-2">
       
    <div class="col-6">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Fecha de Comprobante</label>
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
            <label for="inputEmail3" class="col-sm-4 col-form-label">Concepto</label>
            <div class="col-sm-6">
                <input
                    type="concepto"
                    class="form-control"
                    id="concepto"
                    placeholder="Concepto del Gasto"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Monto del Gasto</label>
            <div class="col-sm-6">
                <input
                    type="montoGasto"
                    class="form-control"
                    id="montoGasto"
                    placeholder="Monto del Gasto"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Encargado</label>
            <div class="col-sm-6">
                <select class="form-control" id="exampleFormControlSelect1">
                    <option>Maricielo Rodriguez</option>
                    <option>Diego Vigo</option>
                  </select>
            </div>
        </div>
    </div>
    <div class="col-5">

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Tipo Comprobante</label>
            <div class="col-sm-6">
                <select class="form-control" id="exampleFormControlSelect1">
                    <option>Factura</option>
                    <option>Boleta</option>
                  </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">N° Comprobante</label>
            <div class="col-sm-6">
                <input
                    type="nroComprobante"
                    class="form-control"
                    id="nroComprobante"
                    placeholder="Número de Comprobante"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Cod Presupuestal</label>
            <div class="col-sm-6">
                <input
                    type="codPresupuestal"
                    class="form-control"
                    id="codPresupuestal"
                    placeholder="Código Presupuestal"
                />
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4" >
            </div>
            <div class="col-sm-8" >
            <a href=" " class="btn btn-danger"><i class="fas fa-undo"></i> Regresar</button></a>
            <a href="" class="btn btn-primary"><i class="fas fa-save"></i>  Registrar</button></a>

            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@section('script')  
<script src="/select2/bootstrap-select.min.js"></script>     
<script src="/calendario/js/bootstrap-datepicker.min.js"></script>
<script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
<script src="/archivos/js/createdoc.js"></script>
@endsection