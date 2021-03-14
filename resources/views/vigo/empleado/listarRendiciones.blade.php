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
  <h3> Mis Rendiciones de Gastos </h3>
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
                <th width="6%"  scope="col">Fecha Rendicion</th>
                <th width="4%"  scope="col">Sede</th>
                <th width="25%"  scope="col">Proyecto</th>              
                <th width="4%"  scope="col">Total Recibido</th>
                <th width="4%"  scope="col">Total Gastado</th>
                <th width="4%"  scope="col">Saldo</th>
                <th width="15%"  scope="col">Estado</th>
                <th width="5%"  scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($listaRendiciones as $itemRendicion)

      
            <tr>
              <td>{{$itemRendicion->codigoCedepas  }}</td>
              <td>{{$itemRendicion->fechaRendicion  }}</td>
              <td>{{$itemRendicion->getNombreSede()  }}</td>
              <td>{{$itemRendicion->getNombreProyecto()  }}</td>
              <td>{{$itemRendicion->totalImporteRecibido  }}</td>
              <td>{{$itemRendicion->totalImporteRendido  }}</td>
              <td>{{$itemRendicion->saldoAFavorDeEmpleado  }}</td>
              
        
              <td style="text-align: center">
                
                <input type="text" value="{{$itemRendicion->getNombreEstado()}}" class="form-control" readonly 
                style="background-color: {{$itemRendicion->getColorEstado()}};
                        width:95%;
                        text-align:center;
                        color: {{$itemRendicion->getColorLetrasEstado()}} ;
                ">
              </td>
                <td>       
                  

                  @if($itemRendicion->verificarEstado('Creada') || 
                    $itemRendicion->verificarEstado('Subsanada') ||
                     $itemRendicion->verificarEstado('Observada') )
                    <a href="{{route('rendicionGastos.editar',$itemRendicion->codRendicionGastos)}}" class = "btn btn-warning">
                      <i class="fas fa-edit"></i>
                    </a>
                            
                  @endif
                  


                  <a href="{{route('solicitudFondos.ver',$itemRendicion->getSolicitud()->codSolicitud)}}">
                    <h1>
                      <span class="red">S</span>
                    </h1>
                  </a>


                  <a href="{{route('rendicionGastos.ver',$itemRendicion->getSolicitud()->codSolicitud)}}">
                    <h1>
                      <span class="red">R</span>
                    </h1>
                  </a>
                         
                        

                    
                </td>

            </tr>
        @endforeach
      </tbody>
    </table>



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
