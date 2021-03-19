@extends('layout.plantilla')

@section('contenido')

<script>
  $(function () {
    $("#table-3").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>

<div class="card-body">
    
  <div class="well"><H3 style="text-align: center;"><strong>AREAS</strong></H3></div>

    <br/> 

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
          <th>CODIGO</th>
          <th>AREA</th>
          <th>OPCIONES</th>
        </tr>
      </thead>
      <tbody>

        @foreach($areas as $itemarea)
            <tr>
                <td>{{$itemarea->codArea}}</td>
                <td>{{$itemarea->nombre}}</td>
                <td>
                    <a href="/listarPuestos/{{$itemarea->codArea}}" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Listar Puestos</a>
                    <a href="/editarArea/{{$itemarea->codArea}}" class="btn btn-primary btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Editar</a>
                    <!--Boton eliminar -->
                    <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Eliminar registro" onclick="swal({//sweetalert
                            title:'¿Eliminar el area?',
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
                            window.location.href='/eliminarArea/{{$itemarea->codArea}}';

                        });"><i class="entypo-cancel"></i>Eliminar</a>

                </td>
            </tr>
        @endforeach
        
      </tbody>
    </table>
    <br>
    <a href="/crearArea" class="btn btn-primary btn-sm btn-icon icon-left" style="margin-left:610px;"><i class="entypo-pencil"></i>CREAR</a>  
    
    

  </div>


@endsection