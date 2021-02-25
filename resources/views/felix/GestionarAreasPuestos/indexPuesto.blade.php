@extends('layout.plantilla')

@section('contenido')

<div class="card-body">
    

  <div class="well"><H3 style="text-align: center;">PUESTOS DEL AREA DE "{{$area->nombre}}"</H3></div>

    <br/> 

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
          <th>CODIGO</th>
          <th>NOMBRE</th>
          <th>OPCIONES</th>
        </tr>
      </thead>
      <tbody>
        @foreach($puestos as $itempuesto)
            <tr>
                <td>{{$itempuesto->codPuesto}}</td>
                <td>{{$itempuesto->nombre}}</td>
                
                <td>
                    <a href="/editarPuesto/{{$itempuesto->codPuesto}}" class="btn btn-primary btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Editar</a> 
                    <!-- <a href="" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-cancel"></i>Eliminar</a> -->

                    <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Eliminar registro" onclick="swal({//sweetalert
                        title:'¿Eliminar el puesto?',
                        text: '',     //mas texto
                        //type: 'warning',  
                        type: '',
                        showCancelButton: true,//para que se muestre el boton de cancelar
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText:  'SI',
                        cancelButtonText:  'NO',
                        closeOnConfirm:     true,//para mostrar el boton de confirmar
                        html : true
                    },
                    function(){//se ejecuta cuando damos a aceptar
                        window.location.href='/eliminarPuesto/{{$itempuesto->codPuesto}}';

                    });"><i class="entypo-cancel"></i>Eliminar</a>

                </td>
            </tr>
        @endforeach
        
      </tbody>
    </table>
    <br>
    <a href="/crearPuesto/{{$area->codArea}}" style="margin-left:570px;" class="btn btn-primary btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>AGREGAR PUESTO</a>

  </div>


@endsection