@extends('layout.plantilla') 
@section('contenido')

<script>
    function ruta(){
        var valor=$("#mes").val();
        window.location.href='/crearPagoPlanilla/';
    }
</script>
<h1>PAGOS DE PLANILLAS</h1>

        @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
        <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true"> &times;</span>
        </button>
        
        </div>
        @endif

    <div class="row mt-2">
       
    
    <div class="col-5">
  
    <div class="form-group row">


            <div class="col-sm-6" >
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