@extends('layout.plantilla')

@section('contenido')

<script>
  $(function () {
    $("#table-3").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });

  var mismoDNI = '<?php echo Session::get('mismoDNI'); ?>';

  if(mismoDNI!=''){
    if (mismoDNI) alert('No se puede registrar mas de un usuario con el mismo DNI');
  }

</script>

<div class="card-body">
    
  <div class="well"><H3 style="text-align: center;"><strong>EMPLEADOS</strong></H3></div>

    <br/> 

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
          <th>DNI</th>
          <th>USUARIO</th>
          <th>NOMBRES Y APELLIDOS</th>
          <th>OPCIONES</th>
        </tr>
      </thead>
      <tbody>

        @foreach($empleados as $itemempleado)
            <tr>
                <td>{{$itemempleado->dni}}</td>
                <td>{{$itemempleado->usuario->usuario}}</td>
                <td>{{$itemempleado->nombres}}, {{$itemempleado->apellidos}}</td>
                <td>
                    <a href="/editarEmpleado/{{$itemempleado->codEmpleado}}" class="btn btn-success btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Editar</a>
                    <a href="/listarEmpleados/listarContratos/{{$itemempleado->codEmpleado}}" class="btn btn-primary btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Contrato</a>

                    <!--Boton eliminar -->
                    <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Eliminar registro" onclick="swal({//sweetalert
                            title:'<h3>¿Está seguro de cesar el usuario?',
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
                            window.location.href='/cesarEmpleado/{{$itemempleado->codEmpleado}}';

                        });"><i class="entypo-cancel"></i>Cesar</a>

                </td>
            </tr>
        @endforeach
        
      </tbody>
    </table>
    
    <a href="/crearEmpleado" class="btn btn-primary btn-sm btn-icon icon-left" style="margin-left:610px;"><i class="entypo-pencil"></i>CREAR</a>  
    
    

  </div>


@endsection