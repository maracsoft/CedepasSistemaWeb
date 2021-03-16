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
  <h3>Confirmar Reposiciones</h3>
  <div class="container">
    <div class="row">
      <div class="colLabel">
        <label for="">Nombre Jefe de Administracion:</label>
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
      <!--
      <div class="w-100"></div> {{-- SALTO LINEA --}} 

      <div class="colLabel">
        <label for="">Proyecto:</label>
      </div>
      <div class="col"> 
        <input type="text" class="form-control" value="" readonly>
      </div>
      -->

      
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
                <th scope="col">Codigo</th>
                <th scope="col">Fecha emision</th>
                <th scope="col">Fecha Gerente</th>
                <th scope="col">Banco</th>
                <th scope="col">Empleado Evaluador</th>
                <th scope="col">Proyecto</th>
                <th scope="col">Total Solicitado</th>
                <th scope="col">Estado</th>
                <th scope="col">Fecha Revision</th>
                

                <th scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($reposiciones as $itemreposicion)

      
            <tr>
              <td>{{$itemreposicion->codigoCedepas  }}</td>
                <td>{{$itemreposicion->fechaEmision  }}</td>
                <td style="text-align: center">{{$itemreposicion->fechaHoraRevisionGerente}}</td>
                <td>{{$itemreposicion->getBanco()->nombreBanco  }}</td>
                <td>{{$itemreposicion->evaluador()->apellidos}}, {{$itemreposicion->evaluador()->nombres}}</td>
                <td>{{$itemreposicion->getProyecto()->nombre  }}</td>
                <td>{{$itemreposicion->getMoneda()->simbolo}} {{$itemreposicion->monto()}}</td>
                <td style="text-align: center">
                  <input type="text" value="{{$itemreposicion->getNombreEstado()}}" class="form-control" readonly 
                  style="background-color: {{$itemreposicion->getColorEstado()}};
                          width:95%;
                          text-align:center;
                          color: {{$itemreposicion->getColorLetrasEstado()}} ;
                  ">
                </td>
                <td style="text-align: center">{{$itemreposicion->fechaHoraRevisionAdmin==null ? 'No revisado':$itemreposicion->fechaHoraRevisionAdmin}}</td>
                <td>
                  @if($itemreposicion->codEstadoReposicion==2)
                  <a href="{{route('reposicionGastos.verReposicionOfJefe',$itemreposicion->codReposicionGastos)}}" class="btn btn-warning btn-sm"><i class="entypo-pencil"></i>Evaluar</a>
                  @else
                  <a href="{{route('reposicionGastos.verReposicionOfJefe',$itemreposicion->codReposicionGastos)}}" class="btn btn-info btn-sm"><i class="entypo-pencil"></i>Ver</a>
                  @endif
                  
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
