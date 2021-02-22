@extends('layout.plantilla') 
@section('contenido')
<br>
<div class="container">
    <h1 style="text-align: center">REVISIÓN DE INVENTARIO</h1>
    <div class="row">
        
        <div class="col-4">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label" style="text-align: right">Responsable:</label>
                <div class="col-sm-8">
                    <input
                        type="nombre"
                        class="form-control"
                        id="nombre"
                        placeholder="NombreResponsable"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label" style="text-align: right">Sede:</label>
                <div class="col-sm-8">
                    <input
                        type="nombre"
                        class="form-control"
                        id="nombre"
                        placeholder="Nombre SEDE"
                    />
                </div>
            </div>

        </div>

        <div class="col-4">

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label" style="text-align: right">Nombre:</label>
                <div class="col-sm-8">
                    <input
                        type="nombre"
                        class="form-control"
                        id="nombre"
                        placeholder="Nombre activo"
                    />
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label" style="text-align: right">Proyecto:</label>
                <div class="col-sm-8">
                    <input
                        type="proyecto"
                        class="form-control"
                        id="proyecto"
                        placeholder="Nombre proyecto"
                    />
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label" style="text-align: right">Categoria:</label>
                <div class="col-sm-8">
                    <input
                        type="categoria"
                        class="form-control"
                        id="categoria"
                        placeholder="Nombre Categoria"
                    />
                </div>
            </div>
        </div>

    </div>

    <br>

    <div>
        
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
                    <th scope="col">Estado final</th>
                    
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
        <div>
            <a href="" class="btn btn-danger"><i class="fas fa-ban"></i>Regresar</button></a>
            <a href="" class="btn btn-primary"><i class="fas fa-plus"></i>Cerrar revisión</button></a>
        </div>
    </div>

</div>

@endsection