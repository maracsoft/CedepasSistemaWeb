@extends('Layout.Plantilla') 

@section('titulo')
    Listado de Proyectos
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

<div class="card">
    <div class="card-header" style=" ">
      <h3 class="card-title">PROYECTOS</h3>
      <div class="card-tools">
        <ul class="nav nav-pills ml-auto">
          <li class="nav-item">
            <a href="{{route('GestiónProyectos.crear')}}" class="nav-link active"><i class="fas fa-plus"></i> Nuevo Registro</a>
          </li>
        </ul>
      </div>
      
    </div>


    

    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-sm">
        <thead>

          <tr>
            <th scope="col">IdBD</th>
            
            <th scope="col">Cod Proy</th>
            <th scope="col">NOMBRE PROYECTO</th>
            <th scope="col">GERENTE</th>
            <th scope="col">CONTADOR</th>
            <th scope="col">Opciones</th>
            
          </tr>

        </thead>
        <tbody>

          @foreach($listaProyectos as $itemProyecto)
            
          
          <tr>
            <td>{{$itemProyecto->codProyecto}}</td>
            <td>{{$itemProyecto->codigoPresupuestal}}</td>
            
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
              <a href="{{route('GestiónProyectos.ListarContadores',$itemProyecto->codProyecto)}}" class="btn btn-success btn-sm btn-icon icon-left">
                <i class="entypo-pencil"></i>Contadores ({{$itemProyecto->nroContadores()}})
              </a>
            </td>
            <td>
              <a href="{{route('GestiónProyectos.editar',$itemProyecto->codProyecto)}}" class="btn btn-alert">
                <i class="fas fa-pen-square"></i>
                Editar
              </a>

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
      //$.get('/asignarGerentesContadores/actualizar/'+codProyecto+'*'+codGerente+'*1', function(data){
      $.get('/GestiónProyectos/'+codProyecto+'*'+codGerente+'*1'+'/asignarGerente', function(data){
        if(data) alertaMensaje('Enbuenahora','Se actualizó el gerente','success');
        else alerta('No se pudo actualizar el gerente');
      });
    }else{
      alerta('seleccione un Gerente');
    }
    
  }
  /*
  function guardar2(codProyecto){
    var codContador=$('#Proyecto2'+codProyecto).val();
    if(codContador!=0){
      $.get('/asignarGerentesContadores/actualizar/'+codProyecto+'*'+codContador+'*2', function(data){
        if(data) alerta('Se actualizo el contador');
        else alerta('No se pudo actualizar el contador');
      });
    }else{
      alerta('seleccione un Contador');
    }
    
  }*/
</script>
