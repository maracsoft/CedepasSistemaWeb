@extends('layout.plantilla') 
@section('contenido')


<link rel="stylesheet" href="/select2/bootstrap-select.min.css">

<script type="text/javascript">     
    function validar() {
        document.frmgestion.submit(); // enviamos el formulario	
    }
</script>

<div class="container">
    <form method="POST" action="{{ route('gestionInventario.store')}}" id="frmgestion" name="frmgestion">
        @csrf
        <h1>REGISTRAR REVISIÓN DE INVENTARIO</h1>
        <div>
            
        <div class="col-6">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Responsable</label>
                <select class="col-sm-6 form-control select2 select2-hidden-accessible selectpicker" data-select2-id="1" tabindex="-1" aria-hidden="true" id="codEmpleadoResponsable" name="codEmpleadoResponsable" data-live-search="true" onchange="">
                    <option value="0" selected>- Seleccione Empleado -</option>          
                    @foreach($empleados as $itemempleado)
                        <option value="{{ $itemempleado->codEmpleado }}" >{{ $itemempleado->apellidos}}, {{ $itemempleado->nombres}}</option>                                 
                    @endforeach            
                </select>    
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Descripcion:</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                </div>
            </div>

        
        </div>
        <div>
            <a href="{{route('gestionInventario.index')}}" class="btn btn-danger"><i class="fas fa-ban"></i>Regresar</button></a>
            <input type="button" class="btn btn-primary" value="Registrar" onclick="validar()" />
        </div>
        
    </form>

</div>
    <!--
    <div class="float-right">
        <a href="" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar activo</a>
    </div>
    <br>

    <div>
        <br>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Sede</th>
                    <th scope="col">Proyecto</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Características</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Actualizar estado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>1</th>
                    <td>Trujillo</td>
                    <td>Proyecto 1</td>
                    <td>Moto </td>
                    <td>Moto Pulsa año 2015</td>
                    <td>Vehículo</td>
                    <td>ACH-839 </td>
                    <td>0 </td>
                    <td>
                        <a href="" class="btn btn-primary"><i class="fas fa-check"></i></button></a>
                        <a href="" class="btn btn-danger"><i class="fas fa-window-close"></i></button></a>
                        <a href="" class="btn btn-warning"><i class="fas fa-exclamation-triangle"></i></button></a>
                    </td>


                </tr>
            </tbody>
        </table>
    
        
    </div>
    -->
    

    <script src="/select2/bootstrap-select.min.js"></script> 
@endsection