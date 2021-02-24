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

        <h1>Listada de Existentes</h1>

        <div class="contenido">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Tipo Entrada</th>
                    <!-- <th>Codigo Existente</th> -->
                    <th>Salida</th>
                    <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                @if(count($models))
                    @foreach($models as $data)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{$data->nombre}}</td>                                    
                            <td>{{$data->ingreso}}</td>
                            <td>{{$data->salida}}</td>
                            <td>{{$data->stock}}</td>
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