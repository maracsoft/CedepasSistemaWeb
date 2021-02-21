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
  <h3> LISTA DE SOLIC DE FONDOS APROBADAS PARA DEPOSITAR </h3>
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

      

      
    </div>
  </div>
  
    <nav class = "navbar float-right"> {{-- PARA MANDARLO A LA DERECHA --}}
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar por descripcion" aria-label="Search" id="buscarpor" name = "buscarpor" value ="{{($buscarpor)}}" >
            <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </nav>

{{-- AQUI FALTA EL CODIGO SESSION DATOS ENDIF xdd --}}
      @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @ENDIF

    <table class="table" style="font-size: 10pt;">
            <thead class="thead-dark">
              <tr>
                <th width="7%" scope="col">Codigo Sol</th>
                <th width="6%"  scope="col">Fecha emision</th>
                <th width="4%"  scope="col">Sede</th>
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
                <td>{{$itemSolicitud->getNombreSede()  }}</td>
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
                <td>        
                  
                         
                        @if($itemSolicitud->codEstadoSolicitud == 2) {{-- Si está aprobada (pa abonar) --}}   
                          <a  class='btn btn-success' 
                          href="{{route('solicitudFondos.vistaAbonar',$itemSolicitud->codSolicitud)}}">
                            Abonar <i class="fas fa-hand-holding-usd"></i>
                          </a>
                        @else{{-- si está rendida (pa verla nomas ) --}}
                          <a href="{{route('solicitudFondos.ver',$itemSolicitud->codSolicitud)}}">
                            <h1>
                              <span class="red">S</span>
                            </h1>
                          </a>
                        
                          <a href="{{route('rendicionFondos.ver',$itemSolicitud->codSolicitud)}}">
                            <h1>
                              <span class="red">R</span>
                            </h1>
                          </a>
                        
                        @endif

                    
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
