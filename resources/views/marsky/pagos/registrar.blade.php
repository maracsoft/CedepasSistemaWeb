@extends('layout.plantilla') 
@section('contenido')
<h1>REGISTRAR PAGO DE IMPUESTOS</h1>
<div class="row mt-2">
       
    <div class="col-6">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Mes</label>
            <div class="col-sm-6">
                <select class="form-control" id="mes" name="mes">
                    <option value="1">ENERO</option>
                    <option value="2">FEBRERO</option>
                    <option value="3">MARZO</option>
                    <option value="4">ABRIL</option>
                    <option value="5">MAYO</option>
                    <option value="6">JUNIO</option>

                    <option value="7">JULIO</option>
                    <option value="8">AGOSTO</option>
                    <option value="9">SEPTIEMBRE</option>
                    <option value="10">OCTUBRE</option>
                    <option value="11">NOVIEMBRE</option>
                    <option value="12">DICIEMBRE</option>
                    
                  </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Ingresos</label>
            <div class="col-sm-6">
                <input
                    name="ingresos"
                    class="form-control"
                    id="ingresos"
                    placeholder="Ingresos"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Dias Lab del Mes</label>
            <div class="col-sm-6">
                <input
                    name="diasLab"
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
                    name="gastos"
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
                <th scope="col">Empleado</th>
                <th scope="col">AFP</th>
                <th scope="col">Horarios</th>
                <th scope="col">Dias laborables del mes</th>
                <th scope="col">Feriados</th>
                <th scope="col">Base Imponible</th>
                <th scope="col">SNP</th>
                <th scope="col">Aporte Obligatorio</th>
                <th scope="col">Comision mixta</th>
                <th scope="col">Prima de seguro</th>
                <th scope="col">Es vida</th>
                <th scope="col">Descuento</th>
                <th scope="col">Neto</th>
                <th scope="col">ESSALUD</th>

            </tr>
        </thead>
        <tbody>
            @foreach($listaEmpleados as $itemEmpleado)
            <tr>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="" id="" readonly>
                </td>
                

            </tr>

            @endforeach

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