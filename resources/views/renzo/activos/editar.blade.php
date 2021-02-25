@extends('layout.plantilla') 
@section('contenido')

<script type="text/javascript">
    function validar() 
            {
                var expreg = new RegExp("^[A-Za-zÑñ À-ÿ]+$");//para apellidos y nombres ^[a-zA-Z ]+$ ^[A-Za-zÑñ À-ÿ]$
                if (document.getElementById("codSede").value == "0"){
                    alert("Seleccione sede");
                }
                else if (document.getElementById("nombre").value == ""){
                    alert("Ingrese nombre del activo");
                    $("#nombre").focus();
                }
                else if (document.getElementById("codProyectoDestino").value == "0"){
                    alert("Seleccione un proyecto");
                }
                else if (document.getElementById("codEmpleadoResponsable").value == "0"){
                    alert("Seleccione responsable");
                }
                else if (document.getElementById("codCategoriaActivo").value == "0"){
                    alert("Seleccione categoria");
                }
                else if (document.getElementById("caracteristicas").value == ""){
                    alert("Ingrese caracteristicas");
                    $("#caracteristicas").focus();
                }
                else{
                    document.frmactivo.submit(); // enviamos el formulario	
                }
            }     
    </script>


<div class="container">
<form method="POST" action="{{ route('activos.update',$activo->codActivo)}}" id="frmactivo" name="frmactivo">
    @method('put')
    @csrf
    <h1>REGISTRAR NUEVO ACTIVO</h1>
    <div>
    <div class="col-6">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Sede</label>
            <div class="col-sm-6">
                <select class="form-control" id="codSede" name="codSede">
                    @foreach($sedes as $itemsede)
                        <option value="{{$itemsede->codSede}}" {{($itemsede->codSede==$activo->codSede)? 'selected' : ''}}>{{$itemsede->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-6">
                <input
                    type="text"
                    class="form-control"
                    id="nombre"
                    name="nombre"
                    placeholder="Ingresar nombre activo"
                    value="{{$activo->nombreDelBien}}"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Proyecto</label>
            <div class="col-sm-6">
                <select class="form-control" id="codProyectoDestino" name="codProyectoDestino">
                    @foreach($proyectos as $itemproyecto)
                        <option value="{{$itemproyecto->codProyecto}}" {{($itemproyecto->codProyecto==$activo->codProyectoDestino)? 'selected' : ''}}>{{$itemproyecto->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Responsable:</label>
            <div class="col-sm-6">
                <select class="form-control" id="codEmpleadoResponsable" name="codEmpleadoResponsable">
                    @foreach($empleados as $itemempleado)
                        <option value="{{$itemempleado->codEmpleado}}" {{($itemempleado->codEmpleado==$activo->codEmpleadoResponsable)? 'selected' : ''}}>{{$itemempleado->apellidos}}, {{$itemempleado->nombres}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Categoria</label>
            <div class="col-sm-6">
                <select class="form-control" id="codCategoriaActivo" name="codCategoriaActivo">
                    @foreach($categoria as $itemcategoria)
                        <option value="{{$itemcategoria->codCategoriaActivo}}" {{($itemcategoria->codCategoriaActivo==$activo->codCategoriaActivo)? 'selected' : ''}}>{{$itemcategoria->nombre}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Características</label>
            <div class="col-sm-6">
                <textarea class="form-control" id="caracteristicas" name="caracteristicas" rows="3">{{$activo->caracteristicas}}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Placa</label>
            <div class="col-sm-6">
                <input
                    type="text"
                    class="form-control"
                    id="placa"
                    name="placa"
                    placeholder="Código de placa"
                    value="{{$activo->placa}}"
                />
            </div>
        </div>

    </div>
        <a href="{{route('activos.index')}}" class="btn btn-danger"><i class="fas fa-ban"></i>Regresar</button></a>
        <input type="button" class="btn btn-primary" value="Registrar" onclick="validar()" />
    </div>
</div>
</form>
@endsection
