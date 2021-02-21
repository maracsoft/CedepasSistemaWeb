@extends('layout.plantilla') 
@section('contenido')
<div class="conteiner">
<h1 class="mt-4 mb-5">LIQUIDACION DE PERIODO</h2>
<div>
    <h4 class="mt-4 mb-5">GASTOS DE ESTE PERIODO</h4>
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

    <div class="col-12 mb-3">
        <label for="basic-url">Ingresar justificaciones</label>
        <div class="input-group">
            <textarea
                class="form-control"
                aria-label="With textarea"
            ></textarea>
        </div>
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
@endsection