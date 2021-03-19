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
  <h3> Solicitudes de fondos para Contabilizar </h3>
  
  
  {{-- AQUI FALTA EL CODIGO SESSION DATOS ENDIF xdd --}}
  @if (session('datos'))
  <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
      {{session('datos')}}
    <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true"> &times;</span>
    </button>
    
  </div>
  @endif


  <div class="container">
    <div class="row">
      <div class="colLabel">
        <label for="">Nombre Jefe:</label>
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

      AQUI VAN FILTROS DEL PROYECTO , POR DEFECTO DEBE APARECER EL PROYECTO DEL EMPLEADO LOGEADO (JEFE ADMIN )
        UN JEFE DE ADMINISTRACION PUEDE ATENDER DE TODOS LOS PROYECTOS 
    </div>
  </div>
  
  


    <table class="table" style="font-size: 10pt; margin-top:10px; ">
            <thead class="thead-dark">
              <tr>
                <th width="7%" scope="col">Codigo Sol</th>
                <th width="6%"  scope="col">Fecha emision</th>
              
                <th width="6%"  scope="col">Empleado </th>
                <th width="25%"  scope="col">Proyecto</th>
                <th width="10%"  scope="col">Evaluador</th>
                
                <th width="4%"  scope="col">Total Solicitado</th>
                
                <th width="6%"  scope="col">Fecha Revision</th>
                <th width="10%"  scope="col">Estado</th>
                
                <th width="5%"  scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($listaSolicitudesFondos as $itemSolicitud)

      
            <tr>
              <td>{{$itemSolicitud->codigoCedepas  }}</td>
                <td>{{$itemSolicitud->getFechaHoraEmision() }}</td>
           
                <td> {{$itemSolicitud->getNombreSolicitante()}} </td>
                <td> {{$itemSolicitud->getNombreProyecto()}} </td>
                <td> {{$itemSolicitud->getEvaluador()->getNombreCompleto()}} </td>
                <td>{{$itemSolicitud->totalSolicitado  }}</td>
                
          
                <td style="text-align: center">{{$itemSolicitud->getFechaRevision()}}</td>

                <td style="text-align: center">
                  
                  <input type="text" value="{{$itemSolicitud->getNombreEstado()}}" class="form-control" readonly 
                  style="background-color: {{$itemSolicitud->getColorEstado()}};
                          width:95%;
                          text-align:center;
                          color: {{$itemSolicitud->getColorLetrasEstado()}} ;
                  ">
               
                 
                

                

                </td>
                <td>        {{-- OPCIONES --}}
                  
                        
                        @if($itemSolicitud->verificarEstado('Abonada')) {{-- Si está aprobada (pa abonar) --}}   
                          <a  class='btn btn-success' 
                          href="{{route('solicitudFondos.verContabilizar',$itemSolicitud->codSolicitud)}}">
                            Contabilizar <i class="fas fa-hand-holding-usd"></i>
                          </a>
                        @else{{-- si está rendida (pa verla nomas ) --}}
                          <a href="{{route('solicitudFondos.verContabilizar',$itemSolicitud->codSolicitud)}}">
                            <h1>
                              <span class="red">S</span>
                            </h1>
                          </a>
                        
                          <a href="{{route('rendicionGastos.verAdmin',$itemSolicitud->getRendicion()->codRendicionGastos)}}">
                            <h1>
                              <span class="red">R</span>
                            </h1>
                          </a>
                        
                        @endif

                        <a class='btn btn-alert'  href="{{route('solicitudFondos.descargarPDF',$itemSolicitud->codSolicitud)}}">
                          <i class="fas fa-download">Descargar</i>
                        </a>
                        <a  target="blank"  href="{{route('solicitudFondos.verPDF',$itemSolicitud->codSolicitud)}}">
                          <i class="fas fa-file-pdf">Ver</i>
                        </a>
                        
                    
                </td>

            </tr>
        @endforeach
      </tbody>
    </table>

  {{$listaSolicitudesFondos->links()}}
 

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
