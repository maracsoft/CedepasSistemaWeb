@extends('layout.plantilla')

@section('contenido')


<div class="card-body">
    

  <div class="well"><H3 style="text-align: center;">SOLICITUDES</H3></div>

    <br/> 

    <table class="table table-bordered table-hover datatable">
      <thead>                  
        <tr>
          <th>TIPO</th>
          <th>DESCRIPCION</th>
          <th>PERIODO</th>
          <th>FECHA REGISTRO</th>
          <th>OPCIONES</th>
          
        </tr>
      </thead>
      <tbody>

        @foreach($solicitudes as $itemsolicitud)
            <tr>
                <td>{{$itemsolicitud->tipoLicencia->descripcion}}</td>
                <td>{{$itemsolicitud->descripcion}}</td>
                <td>{{$itemsolicitud->fechaInicio}} hasta {{$itemsolicitud->fechaFin}}</td>
                <td>{{$itemsolicitud->fechaHoraRegistro}}</td>
                <td>
                    @if($itemsolicitud->estado==1)
                        <a href="/editarSolicitud/{{$itemsolicitud->codRegistroSolicitud}}" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Editar</a>
                        <a href="/mostrarSolicitud/{{$itemsolicitud->codRegistroSolicitud}}" class="btn btn-info btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Adjunto</a>
                        <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Eliminar registro" onclick="swal({//sweetalert
                            title:'<h3>¿Está seguro de eliminar la solicitud?',
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
                            window.location.href='/eliminarSolicitud/{{$itemsolicitud->codRegistroSolicitud}}';

                        });"><i class="entypo-cancel"></i>Eliminar</a>
                    @endif
                    
                    @if($itemsolicitud->estado==2)
                        <strong style="color:rgb(160, 160, 160)">SOLICITUD ACEPTADA</strong>
                    @endif
                    @if($itemsolicitud->estado==3)
                        <strong style="color:rgb(160, 160, 160)">SOLICITUD RECHAZADA</strong>
                    @endif

                </td>
            
            </tr>
        @endforeach
        
      </tbody>
    </table>
    <br>
  
    <a href="/crearSolicitud/{{$empleado->codEmpleado}}" style="margin-left:570px;" class="btn btn-primary btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>CREAR SOLICITUD</a>  
   
    

  </div>


@endsection