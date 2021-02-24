<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .container{
            text-align: center;
        }

        .contenido{
            /*display: ;margin-left: 10em;
            margin-right: 10em;*/
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            background-color: transparent;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
            text-align: -webkit-match-parent;
        }

        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table-bordered thead td, .table-bordered thead th {
            border-bottom-width: 2px;
        }

        

        

    </style>

</head>
<body>
    
    <div class="container">

        <h1>Listada de ingresos y salidas</h1>

        <div class="contenido">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Tipo Movimiento</th>
                    <!-- <th>Codigo Existente</th> -->
                    <th>Existente</th>
                    <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                @if(count($models))
                    @foreach($models as $data)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{$data->movimiento->fecha}}</td>
                            @if($data->movimiento->tipoMovimiento == 1)
                            <td>Entrada</td>
                            @else
                            <td>Salida</td>
                            @endif
                            <!-- <td>{{$data->codExistencia}}</td> -->
                            <td>{{$data->existencia->nombre}}</td>
                            <td>{{$data->cantidadMovida}}</td>
                        </tr>
                    @endforeach
                @else

                @endif
                </tbody>
            </table>
        </div>

        

    </div>

</body>
</html>