@extends('layout.plantilla')

@section('contenido')

<div class="card-body">
    
    <div class="well"><H3 style="text-align: center;"><strong>CONTADORES</strong></H3></div>
    <div class="row">
        <div class="col-md-1"><label for="codEmpleadoConta">Contador:</label></div>
        <div class="col-md-3">
            <select class="form-control"  id="codEmpleadoConta" name="codEmpleadoConta" >
                <option value="-1">Seleccionar</option>
            </select>
        </div>
        <div class="col-md-1"><a href="" class="btn btn-success"><i class="entypo-pencil"></i>Agregar</a></div>
    </div>

    <br/> 

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
          <th>CODIGO</th>
          <th>NOMBRES Y APELLIDOS</th>
          <th>OPCIONES</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
    <br>
    
    <a href="" class="btn btn-primary icon-left" style="margin-left:600px;"><i class="entypo-pencil"></i>Regresar</a>  

  </div>


@endsection