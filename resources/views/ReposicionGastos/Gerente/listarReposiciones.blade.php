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
  <h3>Verificaciones de Gerente</h3>

  <br>
  <div class="row">
    <div class="col-md-12">
      <form class="form-inline">
        <label for="">Empleado: </label>
        <select class="form-control select2 select2-hidden-accessible selectpicker" data-select2-id="1" tabindex="-1" aria-hidden="true" id="codEmpleadoBuscar" name="codEmpleadoBuscar" data-live-search="true">
          <option value="0">- Seleccione Empleado -</option>          
          @foreach($empleados as $itemempleado)
            <option value="{{$itemempleado->codEmpleado}}" {{$itemempleado->codEmpleado==$codEmpleadoBuscar ? 'selected':''}}>{{$itemempleado->getNombreCompleto()}}</option>                                 
          @endforeach
        </select> 

      
        <select class="form-control mr-sm-2"  id="codProyectoBuscar" name="codProyectoBuscar">
          <option value="0">--Seleccionar Proyecto--</option>
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
      @ENDIF

    <table class="table" style="font-size: 10pt; margin-top:10px; ">
            <thead class="thead-dark">
              <tr>
                <th width="9%" scope="col">Codigo</th>
                <th width="9%" scope="col" style = "text-align: center">F. Emision</th>
                
                <th width="11%" scope="col">Solicitante</th>
                <th scope="col">Proyecto</th>
                <th width="6%" scope="col">Banco</th>
                <th width="8%" scope="col" style="text-align: center">Total</th>
                <th width="11%" scope="col" style="text-align: center">Estado</th>
                <th width="9%" scope="col" style = "text-align: center">F. Revision</th>
                

                <th width="9%" scope="col">Opciones</th>
                
              </tr>
            </thead>
      <tbody>

        {{--     varQuePasamos  nuevoNombre                        --}}
        @foreach($reposiciones as $itemreposicion)

            
            <tr>
                <td style = "padding: 0.40rem">{{$itemreposicion->codigoCedepas  }}</td>
                <td style = "text-align: center; padding: 0.40rem">{{$itemreposicion->getFechaHoraEmision()  }}</td>
                
                <td style = "padding: 0.40rem">{{$itemreposicion->getEmpleadoSolicitante()->getNombreCompleto()}}</td>
                <td style = "padding: 0.40rem">{{$itemreposicion->getProyecto()->nombre  }}</td>
                <td style = "padding: 0.40rem">{{$itemreposicion->getBanco()->nombreBanco  }}</td>
                <td style = "text-align: right; padding: 0.40rem">{{$itemreposicion->getMoneda()->simbolo}} {{number_format($itemreposicion->monto(),2)}}</td>
                <td style="text-align: center; padding: 0.40rem">
                  <input type="text" value="{{$itemreposicion->getNombreEstado()}}" class="form-control" readonly 
                  style="background-color: {{$itemreposicion->getColorEstado()}};
                          height: 26px;
                          text-align:center;
                          color: {{$itemreposicion->getColorLetrasEstado()}} ;
                  ">
                </td>
                <td style="text-align: center; padding: 0.40rem">{{$itemreposicion->getFechaHoraRevisionGerente()==null ? 'No revisado':$itemreposicion->getFechaHoraRevisionGerente()}}</td>
                <td style = "padding: 0.40rem">
                  @if($itemreposicion->verificarEstado('Creada') || $itemreposicion->verificarEstado('Subsanada')  )
                    <a href="{{route('ReposicionGastos.Gerente.ver',$itemreposicion->codReposicionGastos)}}" 
                      class="btn btn-warning btn-sm" title="Evaluar Reposición">
                      <i class="fas fa-thumbs-up"></i>
                    </a>
                  @else
                    <a href="{{route('ReposicionGastos.Gerente.ver',$itemreposicion->codReposicionGastos)}}"
                      class="btn btn-info btn-sm" title="Ver Reposición">
                      <i class="fas fa-eye"></i>
                    </a>
                  @endif
                  
                  <a  href="{{route('ReposicionGastos.exportarPDF',$itemreposicion->codReposicionGastos)}}" 
                    class="btn btn-primary btn-sm" title="Descargar PDF">
                    <i class="fas fa-file-download"></i>
                  </a>

                  <a target="pdf_reposicion_{{$itemreposicion->codReposicionGastos}}" href="{{route('ReposicionGastos.verPDF',$itemreposicion->codReposicionGastos)}}" 
                    class="btn btn-primary btn-sm" title="Ver PDF">
                    <i class="fas fa-file-pdf"></i>
                  </a>
                  
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
