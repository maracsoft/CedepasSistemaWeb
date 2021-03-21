@extends('layout.plantilla')


@section('contenido')

{{-- ESTA VISTA SE USA PARA VER Y PARA CONTABILIZAR --}}
<div >
    
    <p class="h1" style="text-align: center"> 
        @if($solicitud->verificarEstado('Contabilizada'))
        Ver
        @else
        Contabilizar
        @endif
        Solicitud de Fondos
    </p>
</div>

        
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" 
        value="{{ $empleadoLogeado->codigoCedepas }}">

    @csrf
        @include('SolicitudFondos.plantillaVerSF')
    
      
           
    
         
            
                
                <div class="row" id="divTotal" name="divTotal">                       
                    <div class="col-md-8">
                    </div>   
                    <div class="col-md-2">                        
                        <label for="">Total : </label>    
                    </div>   
                    <div class="col-md-2">
                        {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                        <input type="hidden" name="cantElementos" id="cantElementos">                              
                        <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly">                              
                    </div>   
                </div>
                    

        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    
                    
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <a href="{{route('SolicitudFondos.Gerente.listar')}}" 
                                    class='btn btn-primary' style="float:left;">
                                    <i class="fas fa-undo"></i>
                                    Regresar al menú
                                </a>

                            </div>
                            <div class="col"></div>
                       
                          
                            
                        @if($solicitud->verificarEstado('Abonada') )

                              @csrf     
                                <input type="hidden" value="{{$solicitud->codSolicitud}}" name="codSolicitud" id="codSolicitud">
                                {{-- <div class="row">
                                    <div class="col">
                                        <label for="">Observación:</label>
                                        <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="4"></textarea>
                                    </div>
                                    
                                    <div class="col">
                                        <button type="button" onclick="observar()"
                                            class='btn btn-danger'   style="float:right;">
                                            <i class="fas fa-eye-slash"></i>
                                            Observar
                                        </button> 
                                        <br>
                                    </div>    
                                </div>
                         
                                <div class="col">
                                    <a href="{{route('solicitudFondos.rechazar',$solicitud->codSolicitud)}}" 
                                        class='btn btn-danger'  style="float:right;">
                                        <i class='fas fa-ban'></i>
                                        Rechazar
                                    </a>    
                                </div> --}}
                        
                                <div class="col">
                                    <a href="{{route('SolicitudFondos.Contador.Contabilizar',$solicitud->codSolicitud)}}" 
                                        class='btn btn-success'  style="float:right;">
                                        <i class="fas fa-check"></i>
                                        Marcar como contabilizada
                                    </a>    
                                </div>
                        
                        
                        @endif
                        </div>
                    </div>
                   
                        
                          
                    
                               
                    
                    
                
                </div>    
            </div>
        </div>
    </div>


@endsection

{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}
{{-- ************************************************************************************************************* --}}


<style>
    
    
    </style>


@section('script')
     <script src="/public/select2/bootstrap-select.min.js"></script>     
     <script>
        var cont=0;
        
        var IGV=0;
        var total=0;
        var detalleSol=[];
        var importes=[];
        var controlproducto=[];
        var totalSinIGV=0;
    
        $(document).ready(function(){

            //cuando apenas carga la pagina, se debe copiar el contenido de la tabla a detalleSol
            cargarADetallesSol();
            actualizarTabla();
    
        });

        function observar(){

            textoObs = $('#observacion').val();
            codigoSolicitud = {{$solicitud->codSolicitud}};
            console.log('Se presionó el botón observar, el textoobservacion es ' + textoObs + ' y el cod de la solicitud es ' +  codigoSolicitud);
            location.href = '/SolicitudFondos/Observar/'+ codigoSolicitud +'*' +textoObs;

        }

        function cargarADetallesSol(){

            console.log('llega');
            for (let index = 1; $("#fila"+index).length; index++) {
                console.log('SI'+index);


                detalleSol.push({
                    item: $("#colItem"+index).val() ,
                    concepto:$("#colConcepto"+index).val(),
                    importe:$("#colImporte"+index).val(),            
                    codigoPresupuestal:$("#colCodigoPresupuestal"+index).val()
                });   


            }
            

        }

    
        //retorna cadena aleatoria de tamaño length, con el abecedario que se le da ahi
        function cadAleatoria(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
    
        /* Eliminar productos */
        function eliminardetalle(index){
            //total=total-importes[index]; 
            //tam=detalleSol.length;
    
         
    
            //removemos 1 elemento desde la posicion index
            detalleSol.splice(index,1);
           
            console.log('BORRANDO LA FILA' + index);
            //cont--;
            actualizarTabla();
    
        }
    
    
        function actualizarTabla(){
            //funcion para poner el contenido de detallesVenta en la tabla
            //tambien actualiza el total
            //$('#detalles')
            total=0;
            //vaciamos la tabla
            for (let index = 100; index >=0; index--) {
                $('#fila'+index).remove();
                //console.log('borrando index='+index);
            }
            
            //insertamos en la tabla los nuevos elementos
            for (let item = 0; item < detalleSol.length; item++) {
                element = detalleSol[item];
                cont = item+1;
    
                total=total +parseFloat(element.importe); 
    
                //importes.push(importe);
                //item = getUltimoIndex();
                itemMASUNO = item+1;
                var fila=   '<tr class="selected" id="fila'+item+'" name="fila' +item+'">               ' +
                            '    <td style="text-align:center;">               '+
                            '       <input type="text" class="form-control" name="colItem'+item+'" id="colItem'+item+'" value="'+itemMASUNO+'" readonly="readonly">'   +
                            '    </td>               '+
                            '    <td> '+
                            '       <input type="text" class="form-control" name="colConcepto'+item+'" id="colConcepto'+item+'" value="'+element.concepto+'" readonly="readonly">' +
                            '    </td>               '+
                            '    <td  style="text-align:right;">               '+
                            '       <input type="text" class="form-control" name="colImporte'+item+'" id="colImporte'+item+'" value="'+element.importe+'" readonly="readonly">' +
                            '    </td>               '+
                            '    <td style="text-align:center;">               '+
                            '    <input type="text" class="form-control" name="colCodigoPresupuestal'+item+'" id="colCodigoPresupuestal'+item+'" value="'+element.codigoPresupuestal+'" readonly="readonly">' +
                            '    </td>               '+
                        //    '    <td style="text-align:center;">               '+
                        //    '        <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle('+item+');">'+
                        //    '            <i class="fa fa-times" ></i>               '+
                        //    '        </button>               '+
                        //    '    </td>               '+
                            '</tr>                 ';
    
    
                $('#detalles').append(fila); 
            }
            $('#total').val(number_format(total,2));
            
            
            $('#cantElementos').val(cont);
            
            console.log('Se actualizó la tabla.');
            //alert('se termino de actualizar la tabla con cont='+cont);
        }
    
    

    
        function agregarDetalle()
        {
            
    
            // VALIDAMOS 
            concepto=$("#concepto").val();    
            if (concepto=='') 
            {
                alert("Por favor ingrese el concepto");    
                return false;
            }    
    
    
            importe=$("#importe").val();    
            if (!(importe>0)) 
            {
                alert("Por favor ingrese un importe válido.");    
                return false;
            }    
            
    
            codigoPresupuestal=$("#codigoPresupuestal").val();    
            if (codigoPresupuestal=='') 
            {
                alert("Por favor ingrese el codigo presupuestal");    
                return false;
            }    
    
            if (importe==0)
            {
                alert("Por favor ingrese precio de venta del producto");    
                return false;
            }  
            
            // FIN DE VALIDACIONES
    
                item = cont+1;   
                detalleSol.push({
                    item:item,
                    concepto:concepto,
                    importe:importe,            
                    codigoPresupuestal:codigoPresupuestal
                });        
                cont++;
            actualizarTabla();
            //ACTUALIZAMOS LOS VALORES MOSTRADOS TOTALES    
            //$('#total').val(number_format(total,2)); //TOTAL INCLUIDO IGV
            $('#concepto').val('');
            $('#importe').val('');
            $('#codigoPresupuestal').val('');
            
    }
    
    function limpiar(){
        $("#cantidad").val(0);
        //$("#precio").val(0);
        $("#producto_id").val(0);
    }
    
    /* Mostrar Mensajes de Error */
    function mostrarMensajeError(mensaje){
        $(".alert").css('display', 'block');
        $(".alert").removeClass("hidden");
        $(".alert").addClass("alert-danger");
        $(".alert").html("<button type='button' class='close' data-close='alert'>×</button>"+
                            "<span><b>Error!</b> " + mensaje + ".</span>");
        $('.alert').delay(5000).hide(400);
    }
    
    
    function number_format(amount, decimals) {
        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
        decimals = decimals || 0; // por si la variable no fue fue pasada
        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0) 
            return parseFloat(0).toFixed(decimals);
        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);
        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;
        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
        return amount_parts.join('.');
    }
    
    
    </script>
     










@endsection
