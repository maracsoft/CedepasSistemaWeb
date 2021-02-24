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
    
    @if (session('datos'))
    <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
        {{session('datos')}}
      <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
          <span aria-hidden="true"> &times;</span>
      </button>
      
    </div>
    @ENDIF   

  <div class="well"><H3 style="text-align: center;"><strong>Cajas Chicas</strong></H3></div>

    <br/> 

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
          <th>Cod Caja</th>
          
          <th>Proyecto</th>
          <th>Nombre Caja</th>
          <th>Responsable</th>
          <th>OPCIONES</th>
        </tr>
      </thead>
      <tbody>

        @foreach($listaCajas as $itemCaja)
            <tr>
                <td>{{$itemCaja->codCaja}}</td>
                
                <td>{{$itemCaja->getProyecto()->nombre}}</td>
                <td>{{$itemCaja->nombre}}</td>
                  
                <td>{{$itemCaja->getEmpleadoActual()->getNombreCompleto()}}</td>
                
              
                <td>
                    <a href="{{route('caja.edit',$itemCaja->codCaja)}}" class="btn btn-success btn-sm btn-icon icon-left">
                      <i class="entypo-pencil"></i>
                      Editar
                    </a>

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
                           
                        });"><i class="entypo-cancel"></i>Dar de Baja</a>

                </td>
            </tr>
        @endforeach
        
      </tbody>
    </table>
    
    <a href="{{route('caja.verCrear')}}" class="btn btn-primary btn-sm btn-icon icon-left" 
      style="margin-left:610px;">
      <i class="entypo-pencil"></i>
      CREAR
    </a>  
    
    

  </div>


@endsection