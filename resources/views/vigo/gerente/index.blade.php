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
  <h3> Solicitudes de Fondos para Aprobar </h3>
  <div class="container">
    <div class="row">
      <div class="colLabel">
        <label for="">Nombre gerente:</label>
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

      <div class="colLabel">
        <label for="">Proyecto:</label>
      </div>
      <div class="col"> 
        <input type="text" class="form-control" value="" readonly>
      </div>
      

      
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
      @ENDIF

    <table class="table" style="font-size: 10pt; margin-top:10px; ">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Codigo Sol</th>
                <th scope="col">Fecha emision</th>
                
                <th scope="col">Empleado </th>
                <th scope="col">Proyecto</th>
                <th scope="col">Total Solicitado // Rendido</th>
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
              
                <td> {{$itemSolicitud->getNombreSolicitante()}} </td>
                <td>{{$itemSolicitud->getnombreProyecto()  }}</td>
                <td> 
                  <h3 style="font-size: 14pt;">
                      S/. {{$itemSolicitud->totalSolicitado  }}
                    @if($itemSolicitud->estaRendida())
                      // S/. {{$itemSolicitud->getRendicion()->totalImporteRendido}}
                    @endif
                  </h3>
                </td>
                <td style="text-align: center">
                  
                  <input type="text" value="{{$itemSolicitud->getNombreEstado()}}" class="form-control" readonly 
                  style="background-color: {{$itemSolicitud->getColorEstado()}};
                          width:95%;
                          text-align:center;
                          color: {{$itemSolicitud->getColorLetrasEstado()}} ;
                  ">
              </td>
              <td>  
                @if($itemSolicitud->estaRendida())
                  
                  {{$itemSolicitud->getRendicion()->codigoCedepas}}

                @endif
              </td>

              <td style="text-align: center">{{$itemSolicitud->getFechaRevision()}}</td>
                <td>
                      {{-- Si la tenemos que evaluar --}}  
                      @if($itemSolicitud->verificarEstado('Creada') || $itemSolicitud->verificarEstado('Subsanada') )
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
                          
                          @if($itemSolicitud->estaRendida())   
                            <a href="{{route('rendicionGastos.verGerente',$itemSolicitud->getRendicion()->codRendicionGastos)}}">
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
