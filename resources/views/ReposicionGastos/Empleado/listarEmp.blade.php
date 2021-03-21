@extends ('layout.plantilla')

@section('contenido')

<style>

  .col{
    margin-top: 15px;
  
    }
  
  .colLabel{
  width: 13%;
  margin-top: 18px;
  
  
  }
  
  
  </style>
  
<div>
  <h3> Mis Reposiciones de Gastos </h3>
  <div class="container">
    <div class="row">
      <div class="colLabel">
        <label for="">Nombre Empleado:</label>
      </div>
      <div class="col"> 
        <input type="text" class="form-control" value="{{$empleado->getNombreCompleto()}}" readonly>
      </div>
      

      <div class="colLabel">
        <label for="">Codigo Empleado:</label>
      </div>
      <div class="col"> 
        <input type="text" class="form-control" value="{{$empleado->codigoCedepas}}" readonly>
      </div>
      <div class="w-100"></div> {{-- SALTO LINEA --}} 

      

      
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-2">
      <a href="{{route('ReposicionGastos.Empleado.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i>Nuevo Registro</a>
    </div>
    <div class="col-md-10">
      <form class="form-inline float-right">
        <select class="form-control mr-sm-2"  id="codProyectoBuscar" name="codProyectoBuscar">
          <option value="0">--Seleccionar--</option>
          @foreach($proyectos as $itemproyecto)
              <option value="{{$itemproyecto->codProyecto}}" {{$itemproyecto->codProyecto==$codProyectoBuscar ? 'selected':''}}>
                  {{$itemproyecto->nombre}}
              </option>                                 
          @endforeach 
        </select>
        <button class="btn btn-success " type="submit">Buscar</button>
      </form>
    </div>
  </div>
  
  
    

{{-- AQUI FALTA EL CODIGO SESSION DATOS ENDIF xdd --}}
      @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @endif

    <table class="table" style="font-size: 10pt; margin-top:10px; ">
            <thead class="thead-dark">
              <tr>
                <th width="7%" scope="col">Codigo Rendicion</th> {{-- COD CEDEPAS --}}
                <th width="6%"  scope="col">Fecha Emision</th>
     
                <th width="25%"  scope="col">Proyecto</th>              
                <th width="4%"  scope="col">Orden de</th>
                <th width="4%"  scope="col">Banco</th>
                <th width="4%"  scope="col">Total</th>
                <th width="15%"  scope="col">Estado</th>
                <th width="5%"  scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($reposiciones as $itemreposicion)

      
            <tr>
              <td>{{$itemreposicion->codigoCedepas  }}</td>
              <td>{{$itemreposicion->fechaEmision  }}</td>
              
              <td>{{$itemreposicion->getProyecto()->nombre  }}</td>
              <td>{{$itemreposicion->girarAOrdenDe  }}</td>
              <td>{{$itemreposicion->getBanco()->nombreBanco  }}</td>
              <td>{{$itemreposicion->getMoneda()->simbolo}} {{$itemreposicion->monto()}}</td>
              
        
              <td style="text-align: center">
                
                <input type="text" value="{{$itemreposicion->getNombreEstado()}}" class="form-control" readonly 
                style="background-color: {{$itemreposicion->getColorEstado()}};
                        width:95%;
                        text-align:center;
                        color: {{$itemreposicion->getColorLetrasEstado()}} ;
                ">
              </td>
                <td>       

                  <a href="{{route('ReposicionGastos.Empleado.ver',$itemreposicion->codReposicionGastos)}}" 
                      class="btn btn-info btn-sm"><i class="entypo-pencil"></i>Ver</a>
                  @if($itemreposicion->codEstadoReposicion==5 || $itemreposicion->codEstadoReposicion==1 || $itemreposicion->codEstadoReposicion==6)
                  <a href="{{route('ReposicionGastos.Empleado.editar',$itemreposicion->codReposicionGastos)}}" class="btn btn-success btn-sm">
                      <i class="entypo-pencil"></i>
                      Editar
                  </a>
                  @endif
                  <!--
                  <a  href="{{route('ReposicionGastos.exportarPDF',$itemreposicion->codReposicionGastos)}}" 
                    class="btn btn-warning btn-sm">
                    <i class="entypo-pencil"></i>
                    PDF
                  </a>

                  <a target="blank" href="{{route('ReposicionGastos.verPDF',$itemreposicion->codReposicionGastos)}}" 
                    class="btn btn-warning btn-sm">
                    <i class="entypo-pencil"></i>
                    verPDF
                  </a>
                -->
                  
                </td>

            </tr>
        @endforeach
      </tbody>
    </table>
    {{$reposiciones->links()}}

      
</div>
@endsection


<?php 
  $fontSize = '14pt';
?>
<style>
/* PARA COD ORDEN CON CIRCULITOS  */

  span.grey {
    background: #000000;
    border-radius: 0.8em;
    -moz-border-radius: 0.8em;
    -webkit-border-radius: 0.8em;
    color: #fff;
    display: inline-block;
    font-weight: bold;
    line-height: 1.6em;
    margin-right: 15px;
    text-align: center;
    width: 1.6em; 
    font-size : {{$fontSize}};
  }
  


  span.red {
  background:#932425;
   border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}


span.green {
  background: #5EA226;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}

span.blue {
  background: #5178D0;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}

span.pink {
  background: #EF0BD8;
  border-radius: 0.8em;
  -moz-border-radius: 0.8em;
  -webkit-border-radius: 0.8em;
  color: #ffffff;
  display: inline-block;
  font-weight: bold;
  line-height: 1.6em;
  margin-right: 15px;
  text-align: center;
  width: 1.6em; 
  font-size : {{$fontSize}};
}
   </style>
