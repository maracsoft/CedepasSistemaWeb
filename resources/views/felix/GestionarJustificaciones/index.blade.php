@extends('layout.plantilla')

@section('contenido')


<div class="card-body">
    

  <div class="well"><H3 style="text-align: center;">JUSTIFICACIONES</H3></div>

    <br/> 

    <table class="table table-bordered table-hover datatable">
      <thead>                  
        <tr>
          <th>DESCRIPCION</th>
          <th>PERIODO</th>
          <th>FECHA REGISTRO</th>
          <th>OPCIONES</th>
          
        </tr>
      </thead>
      <tbody>

        @foreach($justificaciones as $itemjustificacion)
            <tr>
                <td>{{$itemjustificacion->descripcion}}</td>
                <td>{{$itemjustificacion->fechaInicio}} hasta {{$itemjustificacion->fechaFin}}</td>
                <td>{{$itemjustificacion->fechaHoraRegistro}}</td>
                <td>
                    @if($itemjustificacion->estado==1)
                        <a href="/editarJustificacion/{{$itemjustificacion->codRegistroJustificacion}}" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Editar</a>
                        <a href="/mostrarJustificacion/{{$itemjustificacion->codRegistroJustificacion}}" class="btn btn-info btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Adjunto</a>
                        <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Eliminar registro" onclick="swal({//sweetalert
                            title:'<h3>¿Está seguro de eliminar la justificacion?',
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
                            window.location.href='/eliminarJustificacion/{{$itemjustificacion->codRegistroJustificacion}}';

                        });"><i class="entypo-cancel"></i>Eliminar</a>
                    @endif
                    
                    @if($itemjustificacion->estado==2)
                        <strong style="color:rgb(160, 160, 160)">JUSTIFICACION ACEPTADA</strong>
                    @endif
                    @if($itemjustificacion->estado==3)
                        <strong style="color:rgb(160, 160, 160)">JUSTIFICACION RECHAZADA</strong>
                    @endif

                </td>
            
            </tr>
        @endforeach
        
      </tbody>
    </table>
    <br>
  
    <a href="/crearJustificacion/{{$empleado->codEmpleado}}" style="margin-left:570px;" class="btn btn-primary btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>CREAR JUSTIFICACION</a>  
   
    

  </div>


@endsection