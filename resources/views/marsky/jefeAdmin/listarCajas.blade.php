@extends('layout.plantilla')




@section('contenido')

<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>


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

  <div class="container">
    <div class="row">
      <div class="col">
        <a href="{{route('caja.verCrear')}}" class="btn btn-primary btn-icon icon-left" 
          style="margin-left:610px;">
          <i class="fas fa-plus"></i>
          Crear nueva Caja Chica
        </a>  
      </div>
    
    </div>

  </div>
  

    <br/> 

    <table class="table table-bordered table-hover datatable" id="table-3">
      <thead>                  
        <tr>
          <th>Cod Caja</th>
          <th>Nombre Caja</th>
          <th>Proyecto</th>
          <th>Responsable</th>
          <th>Estado del periodo</th>
          <th>Estado</th>
          <th>OPCIONES</th>
        </tr>
      </thead>
      <tbody>

        @foreach($listaCajas as $itemCaja)
            <tr>
                <td>{{$itemCaja->codCaja}}</td>
                <td>{{$itemCaja->nombre}}</td>
                <td>{{$itemCaja->getProyecto()->nombre}}</td>
                <td>
                  @if($itemCaja->codEmpleadoCajeroActual!='0') {{-- Si no está de baja --}}
                    {{$itemCaja->getEmpleadoActual()->getNombreCompleto()}}
                  @endif
                  
                </td>
                <td>{{$itemCaja->getEstado()}}</td>
                <td>{{$itemCaja->getEstadoActivo()}}</td>
                
              
                <td>
                  @if($itemCaja->codEmpleadoCajeroActual!='0') {{-- Si no está de baja --}}
                    <a href="{{route('caja.edit',$itemCaja->codCaja)}}" class="btn btn-success btn-sm btn-icon icon-left">
                      
                      <i class="fas fa-pencil-alt"></i> Editar
                    </a>
                  
                    <!--Boton eliminar -->
                    <a href="#" class="btn btn-danger btn-sm btn-icon icon-left" title="Dar de baja Caja Chica" onclick="swal({//sweetalert
                            title:'¿Está seguro de dar de baja a la caja chica {{$itemCaja->nombre}}? ',
                            text: 'Esto implica que ya no se podrán crear periodos ni gastos en esta. ',     //mas texto
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
                            window.location.href='{{route('caja.destroy',$itemCaja->codCaja)}}';
                        });">
                        
                        <i class="fas fa-window-close"></i>
                        Dar de Baja
                      
                    </a>
                  @endif
                </td>
            </tr>
        @endforeach
        
      </tbody>
    </table>
    
    
    
    

  </div>


@endsection