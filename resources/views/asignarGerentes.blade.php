@extends('layout.plantilla') 
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
<title> PROYECTOS Y GERENTES </title>

@endsection
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
      <h3 class="card-title">PROYECTOS Y GERENTES</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-sm">
        <thead>

          <tr>
            <th scope="col">ID</th>
            <th scope="col">NOMBRE PROYECTO</th>
            <th scope="col">GERENTE</th>

          </tr>

        </thead>
        <tbody>

          @foreach($listaProyectos as $itemProyecto)
            
          
          <tr>
            <td>{{$itemProyecto->codProyecto}}</td>
            <td>{{$itemProyecto->nombre}}</td>
            </td>
            <td>  {{-- BUSCADOR DINAMICO POR NOMBRES --}}
              <select class="form-control select2 select2-hidden-accessible selectpicker" onchange="agregarDetalle2()" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="codProducto" name="codProducto" data-live-search="true" onchange="">
                <option value="0" selected>- Seleccione Gerente -</option>          
              
                @foreach($listaGerentes as $gerente)
                  <option value="{{$gerente->codEmpleado}}" >{{$gerente->getNombreCompleto()}}</option>                                 
                @endforeach
                
              
              </select> 
            </td>
          </tr>

          @endforeach

        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
<br>

@endsection

@section('script')  
    <script src="/select2/bootstrap-select.min.js"></script>     
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/archivos/js/createdoc.js"></script>
@endsection

<script>
$(function(){
    $(".dropdown-menu").on('click', 'a', function(){
        $(this).parents('.dropdown').find('button').text($(this).text());
    });
 });
 </script>
