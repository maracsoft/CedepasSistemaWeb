@extends('layout.plantilla') 
@section('contenido')
<div class="">
<h1>Ver pagos de planilla del mes de </h1>


    <div>
       
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
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total:</td>
                    
                    
                    
                    <td>{{$montoTotal}}</td>
                    
                </tr>
            </tbody>
        </table>
    </div>

  



    <div>
        <a href="{{route('pagoPlanilla.listar')}}" class="btn btn-danger"><i class="fas fa-ban"></i>Regresar</button></a>
        
    </div>

</div>
@endsection