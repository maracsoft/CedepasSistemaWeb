@extends('layout.plantilla') 
@section('contenido')

<style>
.col{
    margin-top: 15px;

}

.colLabel{
    width: 13%;
    margin-top: 20px;

}

</style>

<h1>MANEJO DE CAJA CHICA</h1>
        @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
        <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true"> &times;</span>
        </button>
        
        </div>
        @ENDIF   
      
        <div class="container">
            <div class="row">           
                <div class="colLabel" > {{-- --}}
                    <label for="">Empleado:</label>
                </div>
                <div class="col">
                    <input type="text" readonly class="form-control" name="" id="" value="{{$caja->getEmpleadoActual()->getNombreCompleto()}}">

                </div>
                
                <div class="colLabel" > {{-- --}}
                    <label for="">Sede:</label>
                </div>
                <div class="col">
                    <input type="text" readonly class="form-control" name="" id="" value="{{$caja->getSede()->nombre}}">

                </div>

                <div class="colLabel" > {{-- --}}
                    <label for="">Estado de la Caja:</label>
                </div>
                <div class="col">
                    <input type="text" readonly class="form-control" 
                        name="" id="" value="{{$caja->getEstado()}}">

                </div>

                
                
                <div class="w-100"></div>
                <div class="colLabel" > {{-- --}}
                    <label for="">Monto Máximo:</label>
                </div>
                <div class="col">
                    <input type="text" readonly class="form-control" name="" id="" value="{{$caja->montoMaximo}}">

                </div>
                
                <div class="colLabel" > {{-- --}}
                    <label for="">Monto actual:</label>
                </div>
                <div class="col">
                    <input type="text" readonly class="form-control" name="" id="" value="{{$caja->montoActual}}">

                </div>

                <div class="colLabel"></div>
                <div class="col">
                    @if($caja->getEstado()=='Lista para iniciar periodo')
                    <div class="col">
                        <a href="#" class="btn btn-primary btn-icon icon-left" title="Iniciar Periodo" 
                            onclick="swal(
                                        {//sweetalert
                                            title:'¿Está seguro de iniciar un nuevo periodo?',
                                            text: '',     //mas texto
                                            //type: 'warning',  
                                            type: '',
                                            showCancelButton: true,//para que se muestre el boton de cancelar
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText:  'SI',
                                            cancelButtonText:  'NO',
                                            closeOnConfirm:     true,//para mostrar el boton de confirmar
                                            html : true
                                        },
                                        function()
                                        {//se ejecuta cuando damos a aceptar
                                            window.location.href='{{route('resp.aperturarPeriodo')}}';
                                        
                                        }
                                        );">
                            <i class="fas fa-plus"></i>
                        
                            Nuevo Periodo
                        </a>
                        
                        
                    </div>
                    @endif
                </div>
                <div class="w-100"></div>
                
            </div>


            

        </div>

            

 
     


   
 
    <div>
        <h2>LISTADO DE PERIODOS</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Sede</th>
                <th scope="col">Fecha Inicio</th>
                <th scope="col">Fecha Final</th>
                <th scope="col">Monto Max.</th>
                <th scope="col">Monto Gast.</th>
                <th scope="col">Responsable</th>

                <th scope="col">Monto Sol.</th>
                <th scope="col">Estado</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listaPeriodos as $itemPeriodo)
            <tr 
            @if($itemPeriodo->codEstado=='1')
                style="background-color: aqua;"
            @endif
            >

                <th scope="row">
                    {{$itemPeriodo->getSede()->nombre}}
                </th>
                <td>
                    {{$itemPeriodo->fechaInicio}}
                </td>
                <td>
                    {{$itemPeriodo->fechaFinal}}
                </td>
                <td>
                    {{$itemPeriodo->montoApertura}}    
                </td>
                <td>
                    {{$itemPeriodo->montoFinal}}    
                </td>
                <td>
                    {{$itemPeriodo->getCajero()->nombres}}    
                    
                </td>
                <td>
                    {{$itemPeriodo->getMontoSolicitado()}}    
                    
                </td>
                <td>
                    {{$itemPeriodo->getNombreEstado()}}    
                    
                </td>
                    

                <td>
                <a href="{{route('resp.verPeriodo',$itemPeriodo->codPeriodoCaja)}}" class="btn btn-primary"><i class="fas fa-eye"></i> Ver</button></a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
 
@endsection