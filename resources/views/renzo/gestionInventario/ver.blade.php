@extends('layout.plantilla') 
@section('contenido')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="/select2/bootstrap-select.min.css">


<br>
<div class="container">
    <h1 style="text-align: center">Revisión de Inventario "{{$revision->descripcion}}"</h1>
    <div class="row">
        <input id="codRevision" type="hidden" name="codRevision"  value="{{$revision->codRevision}}" >
        <div class="col-4">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label" style="text-align: right">Sede:</label>
                <div class="col-sm-8">
                    <select class="form-control select2 select2-hidden-accessible selectpicker" data-select2-id="1" 
                        tabindex="-1" aria-hidden="true" id="codSede" name="codSede" data-live-search="true" >
                        <option value="0" selected>-Seleccione Sede-</option>          
                        @foreach($sedes as $itemsede)
                            <option value="{{ $itemsede->codSede }}">{{ $itemsede->nombre}}</option>                                 
                        @endforeach            
                    </select>  
                </div>
            </div>

        </div>

        <div class="col-4">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label" style="text-align: right">Proyecto:</label>
                <div class="col-sm-8">
                    <select class="form-control select2 select2-hidden-accessible selectpicker" 
                        data-select2-id="1" tabindex="-1" aria-hidden="true" 
                        id="codProyecto" name="codProyecto" data-live-search="true" onchange="">
                        <option value="-1" selected>-Seleccione Proyecto-</option>    
                        @foreach($proyectos as $itemproyecto)
                            <option value="{{$itemproyecto->codProyecto}}">{{$itemproyecto->nombre}}</option>                                 
                        @endforeach            
                    </select> 
                </div>
            </div>
            <!--
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label" style="text-align: right">Nombre Activo:</label>
                <div class="col-sm-8">
                    <input
                        type="nombre"
                        class="form-control"
                        id="nombre"
                        placeholder="Nombre activo"
                    />
                </div>
            </div>
            -->
            
        </div>

        <div class="col-4">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label" style="text-align: right">Categoria:</label>
                <div class="col-sm-8">
                    <select class="form-control select2 select2-hidden-accessible selectpicker" data-select2-id="1" tabindex="-1" aria-hidden="true" id="codCategoria" name="codCategoria" data-live-search="true" onchange="">
                        <option value="0" selected>-Seleccione Categoria-</option>          
                        @foreach($categorias as $itemcategoria)
                            <option value="{{ $itemcategoria->codCategoriaActivo }}">{{ $itemcategoria->nombre}}</option>                                 
                        @endforeach            
                    </select> 
                </div>
            </div>
        </div>

    </div>

    <br>

    <div>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Sede</th>
                    <th scope="col">Proyecto</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Características</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody id="tabla">
                @foreach($detalles as $itemdetalle)
                <?php $itemactivo=$itemdetalle->getActivo(); ?>
                <tr>
                    <th>{{$itemactivo->codActivo}}</th>
                    <td>{{$itemactivo->getSede()->nombre}}</td>
                    <td>{{$itemactivo->getProyecto()->nombre}}</td>
                    <td>{{$itemactivo->nombreDelBien}}</td>
                    <td>{{$itemactivo->caracteristicas}}</td>
                    <td>{{$itemactivo->getCategoria()->nombre}}</td>
                    <td>{{$itemactivo->placa}}</td>
                    <td>{{$itemdetalle->getEstado()->nombre}}</td>
                    <td>
                        @if(is_null($revision->fechaHoraCierre))
                        <a href="/gestionInventario/cambiarEstado/{{$itemdetalle->codRevisionDetalle}}*1" class="btn btn-primary btn-xs"><i class="fas fa-check"></i></a>
                        <a href="/gestionInventario/cambiarEstado/{{$itemdetalle->codRevisionDetalle}}*2" class="btn btn-danger btn-xs"><i class="fas fa-window-close"></i></a>
                        <a href="/gestionInventario/cambiarEstado/{{$itemdetalle->codRevisionDetalle}}*3" class="btn btn-warning btn-xs"><i class="fas fa-exclamation-triangle"></i></a>
                        <a href="/gestionInventario/cambiarEstado/{{$itemdetalle->codRevisionDetalle}}*4" class="btn btn-success btn-xs"><i class="fas fa-hand-holding-medical"></i></a>    
                        @endif
                    </td>
                </tr>      
                @endforeach
            </tbody>
        </table>

        <div>
            <a href="{{route('gestionInventario.index')}}" class="btn btn-info"><i class="fas fa-ban"></i>Regresar</button></a>
            <a href="#" class="btn btn-danger" title="Eliminar registro" onclick="swal({//sweetalert
                title:'¿Está seguro de cerrar la revision?',
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
                window.location.href='{{route('gestionInventario.delete',$revision->codRevision)}}';
            });">CERRAR</a>
        </div>
    </div>

</div>



<script type="text/javascript"> 
    $(document).ready(function(){    
        $('#codSede').change(function(){
            cambio();
        });
        $('#codProyecto').change(function(){
            cambio();
        });
        $('#codCategoria').change(function(){
            cambio();
        });
    }); 


    function cambio(){
        //alert('saleee mrrd');
        var codSede=$('#codSede').val();
        var codProyecto=$('#codProyecto').val();
        var codCategoria=$('#codCategoria').val();
        var codRevision=$('#codRevision').val();
        $.ajax({
            url: '/gestionInventario/filtro/' + codSede + '*' + codProyecto + '*' + codCategoria + '*' + codRevision,
            type: 'get',
            data: {},
            dataType: 'JSON',
            success: function(respuesta) {
                var contenido='';
                for (var i in respuesta.activos) {
                    //alert('Proyecto: '+respuesta.activos[i].codProyectoDestino);  

                    contenido += '<tr>';
                        contenido += '<th>'+respuesta.activos[i].codActivo+'</th>';
                        contenido += '<td>'+respuesta.activos[i].codSede+'</td>';
                        contenido += '<td>'+respuesta.activos[i].codProyectoDestino+'</td>';
                        contenido += '<td>'+respuesta.activos[i].nombreDelBien+'</td>';
                        contenido += '<td>'+respuesta.activos[i].caracteristicas+'</td>';
                        contenido += '<td>'+respuesta.activos[i].codCategoriaActivo+'</td>';
                        contenido += '<td>'+respuesta.activos[i].placa+'</td>';
                        contenido += '<td>'+respuesta.activos[i].codEstado+'</td>';
                        contenido += '<td>';
                            if (respuesta.activos[i].isCerrado=='') {
                            contenido += '<a href="/gestionInventario/cambiarEstado/'+respuesta.activos[i].codRevisionDetalle+'*1" class="btn btn-primary btn-xs"><i class="fas fa-check"></i></a>';
                            contenido += '<a href="/gestionInventario/cambiarEstado/'+respuesta.activos[i].codRevisionDetalle+'*2" class="btn btn-danger btn-xs"><i class="fas fa-window-close"></i></a>';
                            contenido += '<a href="/gestionInventario/cambiarEstado/'+respuesta.activos[i].codRevisionDetalle+'*3" class="btn btn-warning btn-xs"><i class="fas fa-exclamation-triangle"></i></a>';
                            contenido += '<a href="/gestionInventario/cambiarEstado/'+respuesta.activos[i].codRevisionDetalle+'*4" class="btn btn-success btn-xs"><i class="fas fa-hand-holding-medical"></i></a>';
                            }
                        contenido += '</td>';
                    contenido += '</tr>';
                }
                $('#tabla').html(contenido);
            }
        });
    }
</script>

<script src="/select2/bootstrap-select.min.js"></script> 
@endsection