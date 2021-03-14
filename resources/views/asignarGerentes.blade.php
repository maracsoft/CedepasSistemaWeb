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
              <select class="form-control select2 select2-hidden-accessible selectpicker" onchange="guardar({{$itemProyecto->codProyecto}})" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="Proyecto{{$itemProyecto->codProyecto}}" name="Proyecto{{$itemProyecto->codProyecto}}" data-live-search="true">
                <option value="0" selected>- Seleccione Gerente -</option>          
              
                @foreach($listaGerentes as $gerente)
                  <option value="{{$gerente->codEmpleado}}" {{$itemProyecto->codEmpleadoDirector==$gerente->codEmpleado ? 'selected':''}}>{{$gerente->getNombreCompleto()}}</option>                                 
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
@endsection

<script>
  function guardar(codProyecto){
    var codGerente=$('#Proyecto'+codProyecto).val();
    if(codGerente!=0){
      $.get('/asignarGerentes/actualizar/'+codProyecto+'*'+codGerente, function(data){
        if(data) alert('Se actualizo el gerente');
        else alert('No se pudo actualizar el gerente');
      });
    }else{
      alert('seleccione un Gerente');
    }
    
  }
</script>
