<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        html {
            /* Arriba | Derecha | Abajo | Izquierda */
            margin: 30pt 40pt 30pt 40pt;
            font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
        }
        #principal { 
            /*background-color: rgb(161, 51, 51);*/
            word-wrap: break-word;/* para que el texto no salga del div*/
        }
        p {

        }
        table{
            font-size: x-small
        }

        
    </style>
    
</head>
<body>
    <div id="principal" style="width: 700px; height: 850px;">
        <p style="text-align: center;"><u><b>CONVALIDADO DE ASISTENCIAS</b></u></p>
        <table class="table mb-0">
            <thead>
            <tr>
                <th>EMPLEADO</th>
                <th>PUESTO</th>
                <th>AREA</th>
                <th>%ASISTENCIAS</th>
                <th>%FALTAS</th>
                <th>%TARDANZAS</th>
            </tr>
            </thead>
            <tbody>
                @foreach($empleados as $itemempleado)
                <tr>
                    <td>{{$itemempleado->nombres}}</td>
                    <td>{{$itemempleado->codPuesto}}</td>
                    <td>{{$itemempleado->codArea}}</td>
                    <td>100%</td>
                    <td>0%</td>
                    <td>0%</td>
                </tr>
                @endforeach
              </tbody>
        </table>
    </div>
</body>

</html>