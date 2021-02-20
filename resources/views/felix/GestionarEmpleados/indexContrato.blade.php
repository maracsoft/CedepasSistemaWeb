@extends('layout.plantilla')

@section('contenido')


<div class="card-body">
    

  <div class="well"><H3 style="text-align: center;">CONTRATOS DE {{$empleado->nombres}}, {{$empleado->apellidos}}</H3></div>

    <br/>
    <?php $time = time();

    //echo date("d-m-Y (H:i:s)", $time);?>
    <table class="table table-bordered table-hover datatable">
      <thead>                  
        <tr>
          <th>CODIGO</th>
          <th>TIPO</th>
          <th>PROYECTO/MOTIVO</th>
          <th>PUESTO</th>
          <th>PERIODO</th>
          <th>HORARIO</th>
          <th>SUELDO TOTAL</th>
          <th>OPCIONES</th>
        </tr>
      </thead>
      <tbody>

        @foreach($contratos as $itemcontrato)
            <tr>
                <td>{{$itemcontrato->codPeriodoEmpleado}}</td>
                <td>{{$itemcontrato->tipoContrato->nombre}}</td>
                
                @if($itemcontrato->codTipoContrato==1)
                <td>{{$itemcontrato->nombre}}</td>
                @else
                <td>{{$itemcontrato->motivo}}</td>
                @endif

                @if($itemcontrato->codTipoContrato==1)
                <td>{{$itemcontrato->puesto->nombre}}</td>
                @else
                <td>-</td>
                @endif
                
                <td>{{$itemcontrato->fechaInicio}} hasta {{$itemcontrato->fechaFin}}</td>
                <td>{{ !is_null($itemcontrato->codTurno) ? $itemcontrato->turno->tipoTurno->nombre : '-'}}</td>
                
                
                <td>{{$itemcontrato->sueldoFijo}}</td>
                <td>
                    @if($itemcontrato->activo==1 || $itemcontrato->activo==3)
                        <!--
                        <a href="/listarEmpleados/editarContrato/{{$itemcontrato->codPeriodoEmpleado}}" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Editar</a>
                        -->
                        @if($itemcontrato->codTipoContrato==1)
                          @if($itemcontrato->asistencia==1)
                            @if(is_null($itemcontrato->codTurno))
                            <a href="/crearHorario/{{$itemcontrato->codPeriodoEmpleado}}" class="btn btn-info btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Horario</a>    
                            @else
                            <a href="/editarHorario/{{$itemcontrato->codPeriodoEmpleado}}" class="btn btn-info btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Horario</a>    
                            <a href="/exportarContratoPDF/{{$itemcontrato->codPeriodoEmpleado}}" class="btn btn-info btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Reporte</a>  
                            @endif
                          
                          @endif
                        @endif
                        @if($itemcontrato->codTipoContrato==2)
                        <a href="/exportarContratoPDF/{{$itemcontrato->codPeriodoEmpleado}}" class="btn btn-info btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Reporte</a>  
                        @endif

                        <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Eliminar registro" onclick="swal({//sweetalert
                            title:'<h3>¿Está seguro de eliminar el contrato?',
                            text: '',     //mas texto
                            type: 'warning',
                            showCancelButton: true,//para que se muestre el boton de cancelar
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText:  'SI',
                            cancelButtonText:  'NO',
                            closeOnConfirm:     true,//para mostrar el boton de confirmar
                            html : true
                        },
                        function(){//se ejecuta cuando damos a aceptar
                            window.location.href='/listarEmpleados/eliminarContrato/{{$itemcontrato->codPeriodoEmpleado}}';

                        });"><i class="entypo-cancel"></i>Eliminar</a>
                    @endif
                    
                    @if($itemcontrato->activo==2)
                        <strong style="color:rgb(160, 160, 160)">CONTRATO FINALIZADO</strong>
                    @endif

                </td>
            
            </tr>
        @endforeach
        
      </tbody>
    </table>

    
    <div class="card-body" style="margin-left:390px;">
      <a href="/listarEmpleados/crearContrato/{{$empleado->codEmpleado}}*1" class="btn btn-info btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>AGREGAR CONTRATO DE PLAZO FIJO</a>  
      <a href="/listarEmpleados/crearContrato/{{$empleado->codEmpleado}}*2"  class="btn btn-info btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>AGREGAR CONTRATO POR LOCACION</a>  
    </div>
    
    

  </div>


@endsection