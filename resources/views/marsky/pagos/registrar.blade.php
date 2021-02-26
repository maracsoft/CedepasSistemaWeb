@extends('layout.plantilla') 
@section('contenido')
<div class="">
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
    </div>


    <div>
        <h2>LISTADO</h2>
        <table class="table table-striped" style="font-size: 10pt;">
            <thead>
            
                <tr>
                    <th    >Empleado</th>
                    <th    >dni</th>
                    <th    >AFP</th>
                    <th    >Sueldo Contrato</th>
                    <th  >Costo Diario</th>
                    <th    >Dias de Vac</th>
                    <th    >Dias de Falta</th>
                    <th    >Sueldo Bruto x Trabajar</th>
                    <th    >Monto x Vac</th>
                    <th    >Base Antes de faltas</th>
                    <th    >Desc Faltas</th>
                    <th    >Base Imponible</th>
                    <th    >SNP</th>
                    <th    >Aporte Obligatorio</th>
                    <th    >Com mixta</th>
                    <th    >Prima Seg</th>
                    
                    <th    >Desc Total</th>
                    <th    >Neto</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($vector as $itemVector)
                <tr>
                    <td>
                        {{$itemVector['nombre']}}
                    </td>
                    <td>
                        {{$itemVector['dni']}}
                    </td>
                    <td>
                        {{$itemVector['afp']}}
                    </td>
                    <td>
                        {{$itemVector['sueldoContrato']}}
                    </td>
                    <td>
                        {{$itemVector['costoDiario']}}
                    </td>
                    <td>
                        {{$itemVector['diasVac']}}
                    </td>
                    <td>
                        {{$itemVector['diasFalta']}}
                    </td>
                    <td>
                        {{$itemVector['sueldoBrutoXTrabajar']}}
                    </td>
                    <td>
                        {{$itemVector['montoPagadoVacaciones']}}
                    </td>
                    <td style="background-color: azure">
                        {{$itemVector['baseImpAntesDeFaltas']}}
                    </td>
                    <td>
                        {{$itemVector['descFaltas']}}
                    </td>
                    <td  style="background-color: rgb(114, 148, 148)">
                        {{$itemVector['baseImponible']}}
                    </td>
                    <td>
                        {{$itemVector['SNP']}}
                    </td>
                    <td>
                        {{$itemVector['aporteObligatorio']}}
                    </td>
                    <td>
                        {{$itemVector['comisionMixta']}}
                    </td>
                    <td>
                        {{$itemVector['primaSeguro']}}
                    </td>
                    <td>
                        {{$itemVector['totalDesctos']}}
                    </td>
                    <td  style="background-color: rgb(163, 180, 180)">
                        {{$itemVector['netoAPagar']}}
                    </td>
                            

                </tr>

                @endforeach

            </tbody>
        </table>
    </div>

    <div>
        <div class="row mt-2">
            <div class="col-6">

                <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">
                                    Gastos Planilla
                                </label>
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
    </div>    




    <div>
        <a href="" class="btn btn-danger"><i class="fas fa-ban"></i>Regresar</button></a>
        <a href="" class="btn btn-primary"><i class="fas fa-plus"></i>Registrar</button></a>
    </div>

</div>
@endsection