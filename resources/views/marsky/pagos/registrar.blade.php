@extends('layout.plantilla') 
@section('contenido')
<h1>REGISTRAR PAGO</h1>
<div class="row mt-2">
       
    <div class="col-6">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Mes</label>
            <div class="col-sm-6">
                <select class="form-control" id="exampleFormControlSelect1">
                    <option>ENERO</option>
                    <option>FEBRERO</option>
                  </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Ingresos</label>
            <div class="col-sm-6">
                <input
                    type="ingresos"
                    class="form-control"
                    id="ingresos"
                    placeholder="Ingresos"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Dia Lab del Mes</label>
            <div class="col-sm-6">
                <input
                    type="diasLab"
                    class="form-control"
                    id="diasLab"
                    placeholder="Dia Lab del Mes"
                />
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Gastos</label>
            <div class="col-sm-6">
                <input
                    type="gastos"
                    class="form-control"
                    id="gastos"
                    placeholder="Gastos del Mes"
                />
            </div>
        </div>
    </div>

    <div>
        <h2>LISTADO</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Trabajo</th>
                <th scope="col">AFP</th>
                <th scope="col">Horarios</th>
                <th scope="col">#Feriados</th>
                <th scope="col">Sueldo Bruto</th>
                <th scope="col">SNP</th>
                <th scope="col">Aporte Oblig</th>
                <th scope="col">Comision Mixta</th>
                <th scope="col"> Prima Seguro</th>
                <th scope="col">Esvida</th>
                <th scope="col">Total Desc.</th>
                <th scope="col">Desc.</th>
                <th scope="col">Neto</th>
                <th scope="col">ESSALUD</th>

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
               <td>20000 </td>
               <td>900 </td>
               <td>1000</td>
               <td>1000</td>
               <td>20000 </td>
               <td>900 </td>
               <td>1000</td>
               <td>1000</td>

            </tr>
        </tbody>
    </table>
    <div>
        <div class="row mt-2">
            <div class="col-6">

               <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Gastos Planilla</label>
            <div class="col-sm-6">
                <input
                    type="gastosP"
                    class="form-control"
                    id="gastosP"
                />
            </div>
        </div>
        
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Impuesto</label>
            <div class="col-sm-6">
                <input
                    type="ingresos"
                    class="form-control"
                    id="ingresos"
                    placeholder="Impuesto"
                />
            </div>
        </div>
            </div>
    </div>
    <div>
        <a href="" class="btn btn-danger"><i class="fas fa-ban"></i>Regresar</button></a>
        <a href="" class="btn btn-primary"><i class="fas fa-plus"></i>Registrar</button></a>
    </div>
    
@endsection