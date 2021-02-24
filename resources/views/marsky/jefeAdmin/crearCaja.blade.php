@extends('layout.plantilla') 
@section('contenido')

<script type="text/javascript">     
    function validar() {
        document.frmactivo.submit(); // enviamos el formulario	
    }
</script>



<form method="POST" action="{{route('caja.store')}}" id="frmactivo" name="frmactivo">
    @csrf
    <h1>Registrar nueva Caja</h1>

    <div class="container">
        <div class="row"> 



            <div class="col-6">
            

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre de la Caja</label>
                    <div class="col-sm-6">
                        <input
                            type="text"
                            class="form-control"
                            id="nombre"
                            name="nombre"
                            placeholder="Ingresar nombre de la caja"
                        />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label" >Proyecto:</label>
                    <div class="col-sm-6">
                        <select class="form-control select2 select2-hidden-accessible selectpicker" 
                            data-select2-id="1" tabindex="-1" aria-hidden="true" 
                            id="codProyectoDestino" name="codProyectoDestino" data-live-search="true" onchange="">
                            <option value="-1" selected>-Seleccione Empleado-</option>    
                            @foreach($proyectos as $itemproyecto)
                                <option value="{{$itemproyecto->codProyecto}}">
                                    {{$itemproyecto->nombre}}
                                </option>
                            @endforeach      
                        </select> 
                    </div>
                </div>

        


                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label" >Empleado:</label>
                    <div class="col-sm-6">
                        <select class="form-control select2 select2-hidden-accessible selectpicker" 
                            data-select2-id="1" tabindex="-1" aria-hidden="true" 
                            id="codEmpleadoResponsable" name="codEmpleadoResponsable" data-live-search="true" onchange="">
                            <option value="-1" selected>-Seleccione Empleado-</option>    
                            @foreach($empleados as $itemempleado)
                                <option value="{{$itemempleado->codEmpleado}}">{{$itemempleado->apellidos}}, {{$itemempleado->nombres}}</option>
                            @endforeach          
                        </select> 
                    </div>
                </div>
                

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Monto Inicial</label>
                    <div class="col-sm-6">
                        <input
                            type="number"
                            class="form-control"
                            id="montoMaximo"
                            name="montoMaximo"
                            placeholder="Mónto inicial de los periodos"
                        />
                    </div>
                </div>

            </div>


                
        </div>
        <div class="row">
            <a href="{{route('caja.index')}}" class="btn btn-danger">
                <i class="fas fa-ban"></i>
                Regresar
            </a>
            <input type="button" class="btn btn-primary" value="Registrar" onclick="validar()" />
            
        </div>

    </div>
</form>


@endsection
