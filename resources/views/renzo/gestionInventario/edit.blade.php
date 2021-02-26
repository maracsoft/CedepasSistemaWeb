@extends('layout.plantilla') 
@section('contenido')


<link rel="stylesheet" href="/select2/bootstrap-select.min.css">

<script type="text/javascript">
    function validar() 
            {
                var expreg = new RegExp("^[A-Za-zÑñ À-ÿ]+$");//para apellidos y nombres ^[a-zA-Z ]+$ ^[A-Za-zÑñ À-ÿ]$
                if (document.getElementById("codEmpleadoResponsable").value == "0"){
                    alert("Seleccione Responsable");
                }
                else if (document.getElementById("descripcion").value == ""){
                    alert("Ingrese descripcion");
                    $("#descripcion").focus();
                }
                else{
                    document.frmgestion.submit(); // enviamos el formulario	
                }
            }     
    </script>

<div class="container">
    <form method="POST" action="{{ route('gestionInventario.update',$revision->codRevision)}}" id="frmgestion" name="frmgestion">
        @method('put')
        @csrf
        <h1>EDITAR REVISIÓN DE INVENTARIO</h1>
        <div>
            
        <div class="col-6">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Responsable</label>
                <select class="col-sm-6 form-control select2 select2-hidden-accessible selectpicker" data-select2-id="1" tabindex="-1" aria-hidden="true" id="codEmpleadoResponsable" name="codEmpleadoResponsable" data-live-search="true" onchange="">
                    <option value="0" selected>- Seleccione Empleado -</option>          
                    @foreach($empleados as $itemempleado)
                        <option value="{{ $itemempleado->codEmpleado }}" {{($itemempleado->codEmpleado==$revision->codEmpleadoResponsable)? 'selected' : ''}}>{{ $itemempleado->apellidos}}, {{ $itemempleado->nombres}}</option>                                 
                    @endforeach            
                </select>    
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Descripcion:</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{$revision->descripcion}}</textarea>
                </div>
            </div>

        
        </div>
        <div>
            <a href="{{route('gestionInventario.index')}}" class="btn btn-danger"><i class="fas fa-ban"></i>Regresar</button></a>
            <input type="button" class="btn btn-primary" value="Guardar" onclick="validar()" />
        </div>
        
    </form>

</div>
    

    <script src="/select2/bootstrap-select.min.js"></script> 
@endsection