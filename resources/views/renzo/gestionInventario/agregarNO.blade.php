@extends('layout.plantilla') 
@section('contenido')
<div class="container">
<h1>REGISTRAR NUEVO ACTIVO</h1>
<div>
       
    <div class="col-6">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Sede</label>
            <div class="col-sm-6">
                <select class="form-control" id="exampleFormControlSelect1">
                    <option>Trujillo</option>
                    <option>Chiclayo</option>
                  </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-6">
                <input
                    type="nombre"
                    class="form-control"
                    id="nombre"
                    placeholder="Ingresar nombre activo"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Proyecto</label>
            <div class="col-sm-6">
                <select class="form-control" id="pryectos">
                    <option>Proyecto 1</option>
                    <option>Proyecto 2</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Categoria</label>
            <div class="col-sm-6">
                <select class="form-control" id="pryectos">
                    <option>Maquinaria</option>
                    <option>Vehiculos</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Características</label>
            <div class="col-sm-6">
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Placa</label>
            <div class="col-sm-6">
                <input
                    type="placa"
                    class="form-control"
                    id="placa"
                    placeholder="Código de placa"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Responsable</label>
            <div class="col-sm-6">
                <select class="form-control" id="pryectos">
                    <option>Franco Valladolid Renzo</option>
                </select>
            </div>
        </div>
    </div>

        <a href="" class="btn btn-danger"><i class="fas fa-ban"></i>Regresar</button></a>
        <a href="" class="btn btn-primary"><i class="fas fa-save"></i>Registrar</button></a>
    </div>
</div>
@endsection