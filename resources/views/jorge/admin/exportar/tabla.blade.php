@if(count($models))

@foreach($models as $data)
    <tr>
        <!-- <td>{{ $loop->index + 1 }}</td> -->
        <td>{{$data->movimiento->fecha}}</td>
        <td>{{$data->movimiento->empleadoResponsable->full_name}}</td>
        @if($data->movimiento->tipoMovimiento == 1)
        <td>Entrada</td>
        @else
        <td>Salida</td>
        @endif
        <!-- <td>{{$data->codExistencia}}</td> -->
        <td>{{$data->cantidadMovida}}</td>
    </tr>
@endforeach
@else

@endif
<tr>
    <td></td>
    <td></td>
    <td class="font-weight-bolder">Existencia</td>
    <td class="font-weight-bolder">{{@$existencia->stock}}</td>
</tr>