@extends('layout.plantilla') 
@section('contenido')

<script>
    function ruta(){
        var valor=$("#mes").val();
        window.location.href='/crearPagoPlanilla/'+valor;
    }
</script>
<h1>PAGOS DE PLANILLAS</h1>
    <div class="row mt-2">
       
    
    <div class="col-5">
  
    <div class="form-group row">


            <div class="col-sm-6" >

                <select class="form-control" name="mes" id="mes">
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

                <a href="#" class="btn btn-primary" onclick="ruta()">
                    <i class="fas fa-plus"></i>Nueva declaracion
                
                </a>
                
            
            </div>


        </div>
    </div>
    </div>
    <div>
        <h2>LISTADO</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Fecha generación</th>

                <th scope="col">Generada por</th>
                <th scope="col">Año</th>
                <th scope="col">Mes</th>
                
                <th scope="col"># Empleados</th>
                <th scope="col">Monto total</th>
      
            </tr>
        </thead>
        <tbody>
            @foreach($listaGastosPlanilla as $itemGastoPlanilla)
            <tr>
                <th>{{$itemGastoPlanilla->fechaGeneracion}}</th>
                <th>{{$itemGastoPlanilla->getEmpleadoCreador()->getNombreCompleto()}}</th>
                
                <td>{{$itemGastoPlanilla->año}}</td>
                <td>{{$itemGastoPlanilla->getMes()}}</td>
                <td>{{$itemGastoPlanilla->getNroEmpleados()}}</td>
                
               <td>{{$itemGastoPlanilla->montoTotal}}</td>

                
               <td>
                    <a href="{{route('pagoPlanilla.ver',$itemGastoPlanilla->mes)}}" class="btn btn-primary"><i class="fas fa-eye"></i> Ver</button></a>
               </td>
            </tr>
            @endforeach
            

        </tbody>
    </table>
    <div>
@endsection