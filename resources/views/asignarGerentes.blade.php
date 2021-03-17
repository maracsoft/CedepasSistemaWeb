@extends('layout.plantilla') 
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
<title> PROYECTOS Y GERENTES </title>

@endsection
@section('contenido')
<br>



@if (session('datos'))
<div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
    {{session('datos')}}
  <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
      <span aria-hidden="true"> &times;</span>
  </button>
  
</div>
@endif


<div class="col-md-2">
  <a href="{{route('proyecto.crear')}}" class="btn btn-primary">
    <i class="fas fa-plus"></i>
    Nuevo Proyecto
  </a>
</div>


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
            <th scope="col">CONTADOR</th>
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
                <option value="0" {{$itemProyecto->codEmpleadoDirector!=null ? 'hidden':'selected'}}>- Seleccione Gerente -</option>          
              
                @foreach($listaGerentes as $gerente)
                  <option value="{{$gerente->codEmpleado}}" {{$itemProyecto->codEmpleadoDirector==$gerente->codEmpleado ? 'selected':''}}>{{$gerente->getNombreCompleto()}}</option>                                 
                @endforeach
                
              
              </select> 
            </td>
            <td>  {{-- BUSCADOR DINAMICO POR NOMBRES --}}
              <!--
              <select class="form-control select2 select2-hidden-accessible selectpicker" onchange="guardar2({{$itemProyecto->codProyecto}})" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="Proyecto2{{$itemProyecto->codProyecto}}" name="Proyecto2{{$itemProyecto->codProyecto}}" data-live-search="true">
                <option value="0" {{$itemProyecto->codEmpleadoConta!=null ? 'hidden':'selected'}}>- Seleccione Contador -</option>          
              
                @foreach($listaContadores as $contador)
                  <option value="{{$contador->codEmpleado}}" {{$itemProyecto->codEmpleadoConta==$contador->codEmpleado ? 'selected':''}}>{{$gerente->getNombreCompleto()}}</option>                                 
                @endforeach
                
              
              </select> 
              -->
              <a href="{{route('proyecto.listarContadores',$itemProyecto->codProyecto)}}" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Contadores ({{$itemProyecto->nroContadores()}})</a>
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
      $.get('/asignarGerentesContadores/actualizar/'+codProyecto+'*'+codGerente+'*1', function(data){
        if(data) alert('Se actualizo el gerente');
        else alert('No se pudo actualizar el gerente');
      });
    }else{
      alert('seleccione un Gerente');
    }
    
  }
  /*
  function guardar2(codProyecto){
    var codContador=$('#Proyecto2'+codProyecto).val();
    if(codContador!=0){
      $.get('/asignarGerentesContadores/actualizar/'+codProyecto+'*'+codContador+'*2', function(data){
        if(data) alert('Se actualizo el contador');
        else alert('No se pudo actualizar el contador');
      });
    }else{
      alert('seleccione un Contador');
    }
    
  }*/
</script>
