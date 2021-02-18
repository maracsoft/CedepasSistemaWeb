@extends ('layout.plantilla')

@section('contenido')
<div>
  <h3> LISTA DE SOLIC DE FONDOS PARA APROBAR </h3>
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
                <th scope="col">Codigo Sol</th>
                <th scope="col">Fecha emision</th>
                <th scope="col">Sede</th>
                <th scope="col">Empleado </th>
                <th scope="col">Proyecto</th>
                <th scope="col">Total Solicitado</th>
                <th scope="col">Estado</th>
                <th>Cod Rendicion</th>
                <th scope="col">Fecha Revision</th>
                

                <th scope="col">Opciones</th>
                
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
                <td>{{$itemSolicitud->getNombreProyecto()  }}</td>
                <td>{{$itemSolicitud->totalSolicitado  }}</td>
                  
                <td>{{$itemSolicitud->getNombreEstado()  }} 

                  @if($itemSolicitud->codEstadoSolicitud == 4)
                    <br>
                    S/.{{$itemSolicitud->getRendicion()->totalImporteRendido}}

                  @endif
                  

                </td>
                <td>  
                  @if($itemSolicitud->codEstadoSolicitud == 4)
                    <br>
                    {{$itemSolicitud->getRendicion()->codigoCedepas}}

                  @endif
                </td>

                
                <td style="text-align: center">{{$itemSolicitud->getFechaRevision()}}</td>
                <td>
                  

                       
                       
                      {{-- Si la tenemos que evaluar --}}  
                      @if($itemSolicitud->codEstadoSolicitud==1)
                          <a href="{{route('solicitudFondos.revisar',$itemSolicitud->codSolicitud)}}" 
                            class='btn btn-success'  style="float:right;">
                            
                            Revisar
                          </a>    


                      @else {{-- Si ya la evaluamos y solo la vamos a  ver --}}
                            <a href="{{route('solicitudFondos.revisar',$itemSolicitud->codSolicitud)}}">
                              <h1>
                                <span class="red">S</span> 
                              </h1>
                            </a>
                          
                          @if($itemSolicitud->codEstadoSolicitud == 4)   
                            <a href="{{route('rendicionFondos.ver',$itemSolicitud->codSolicitud)}}">
                              <h1>
                                <span class="red">R</span>
                              </h1>
                            </a>

                          @endif

                        
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
