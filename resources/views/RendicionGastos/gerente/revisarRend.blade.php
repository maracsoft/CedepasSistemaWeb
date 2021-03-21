@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')
<div >
    {{-- ESTE ARCHIVO SIRVE TANTO COMO VER Y COMO REVISAR(aprobar/observar) --}}
    <p class="h1" style="text-align: center">
        @if($rendicion->verificarEstado('Creada') || $rendicion->verificarEstado('Subsanada') )

        Revisar Rendición de  Gastos
        @else 
        Ver Rendicion de Gastos
        @endif
    </p>
</div>

<form method = "POST" action = "{{route('rendicionGastos.reponer')}}"  enctype="multipart/form-data" >
    
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $empleado->codigoCedepas }}">
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codigoSolicitud" id="codigoSolicitud" value="{{ $solicitud->codSolicitud }}">
    <input type="hidden" name="codRendicionGastos" id="codRendicionGastos" value="{{ $rendicion->codRendicionGastos }}">
    

    @csrf
    @include('RendicionGastos.plantillaVerRG')
      
    
        {{-- LISTADO DE DETALLES  --}}
        <div class="col-md-12 pt-3">     
            <div class="table-responsive">                           
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    
                    
                    
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th width="13%" class="text-center">Fecha</th>                                        
                        <th width="13%">Tipo CDP</th>
                                                   
                        <th width="10%"> N° Cbte</th>
                        <th width="20%" class="text-center">Concepto </th>
                        <th width="10%" class="text-center">Importe </th>
                        <th width="10%" class="text-center">Cod Presup </th>
                        
                        
                    </thead>
                    <tfoot>

                                                                                        
                    </tfoot>
                    <tbody>
                        @foreach($detallesRend as $itemDetalle)
                            <tr class="selected" id="filaItem" name="filaItem">                
                                <td style="text-align:center;">     
                                    {{$itemDetalle->fecha  }}
                                    
                                </td>               
                            
                                <td style="text-align:center;">               
                                    {{$itemDetalle->getNombreTipoCDP()  }}
                                </td>               
                               
                            
                                <td style="text-align:center;">               
                                    {{$itemDetalle->nroComprobante  }}
                                </td>               
                                <td> 
                                    {{$itemDetalle->concepto  }}
                                
                                </td>               
                                <td  style="text-align:right;">               
                                    {{$rendicion->getMoneda()->simbolo}}   {{  number_format($itemDetalle->importe,2)  }}
                                </td>               
                                <td style="text-align:center;">               
                                    {{$itemDetalle->codigoPresupuestal  }}
                                </td>               
                                            
                            </tr> 
                        @endforeach
                                       







                    </tbody>
                </table>
            </div> 
                
                      
          

                <div class="row" id="divTotal" name="divTotal">                       
                    <div class="col">
                        @include('RendicionGastos.desplegableDescargarArchivosRend')
                        




                    </div>   

                    <div class="col" >
                        <div class="row">
                            
                            <div class="col">                        
                                <label for="">Total Rendido/Gastado: </label>    
                            </div>   
                            <div class="col">
                                {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                                <input type="hidden" name="cantElementos" id="cantElementos">                              
                                <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly" value="{{number_format(($rendicion->totalImporteRendido),2)}}">                              
                            </div>   



                            <div class="w-100"></div>
                            <div class="col">                        
                                <label for="">Total Recibido: </label>    
                            </div>   

                            <div class="col">
                            
                                <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly" value="{{number_format($rendicion->totalImporteRecibido,2)}}">                              
                            </div>   
                            <div class="w-100"></div>
                            <div class="col">                        
                                <label for="">

                                    @if($rendicion->saldoAFavorDeEmpleado>0) {{-- pal empl --}}
                                        Saldo a favor del Empl: 
                                    @else
                                        Saldo a favor de Cedepas: 
                                    @endif
                                    
                                </label>    
                            </div>   
                            <div class="col">
                                <input type="text" class="form-control text-right" name="total" id="total" 
                                readonly value="{{number_format(abs($rendicion->saldoAFavorDeEmpleado),2)}}">                              
                            </div>   
                            
                            
                            <div class="w-100"></div>
                    
                            
                            
                            @if($rendicion->verificarEstado('Creada') || $rendicion->verificarEstado('Subsanada') )

                            @csrf     
                            <input type="hidden" value="{{$solicitud->codSolicitud}}" name="codSolicitud" id="codSolicitud">
                            
                                <div class="col">
                                    <label for="">Observación:</label>
                                    <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="4"></textarea>
                                
                                    
                                    
                                </div>    
                                <div class="col">
                                    <br><!--
                                    <button type="button" onclick="observarRendicion()"
                                        class='btn btn-danger' >
                                        <i class="fas fa-eye-slash"></i>
                                        Observar
                                    </button>--> 
                                    <a href="#" class="btn btn-warning" onclick="swal({//sweetalert
                                        title:'¿Seguro de observar la rendicion?',
                                        text: '',
                                        type: 'info',  
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText:  'SI',
                                        cancelButtonText:  'NO',
                                        closeOnConfirm:     true,//para mostrar el boton de confirmar
                                        html : true
                                    },
                                    function(){
                                        observarRendicion();
                                    });"><i class="entypo-pencil"></i>Observar</a>
                                </div>
                    
                    
                            @endif
                        </div>
                    </div>



                </div>
                    

                
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group"><!--
                    <a href="{{route('rendicionGastos.listarRendiciones')}}" 
                        class='btn btn-primary' style="float:left;">
                        <i class="fas fa-undo"></i>
                        Regresar al menú
                    </a> -->
                    <a href="{{route('rendicionGastos.listarRendiciones')}}" class='btn btn-info float-left'><i class="fas fa-arrow-left"></i> Regresar al Menu</a>
                    <!--  
                    <a href="{{route('RendicionGastos.Gerente.Aprobar',$rendicion->codRendicionGastos)}}" 
                        class='btn btn-success'  style="float:right;">
                        <i class="fas fa-check"></i>
                        Aprobar
                    </a>-->
                    <a href="#" class="btn btn-success float-right" onclick="swal({//sweetalert
                        title:'¿Seguro de aceptar la rendicion?',
                        text: '',
                        type: 'info',  
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText:  'SI',
                        cancelButtonText:  'NO',
                        closeOnConfirm:     true,//para mostrar el boton de confirmar
                        html : true
                    },
                    function(){
                        window.location.href='{{route('RendicionGastos.Gerente.Aprobar',$rendicion->codRendicionGastos)}}';
                    });"><i class="fas fa-check"></i> Aceptar</a>        
                </div>    
            </div>
        </div>
    </div>

</form>
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
    
    .hovered:hover{
        background-color:rgb(97, 170, 170);
    }


</style>


@section('script')
       
     <script>
        var cont=0;
        
        var IGV=0;
        var total=0;
        var detalleRend=[];
        var importes=[];
        var controlproducto=[];
        var totalSinIGV=0;
    
        $(document).ready(function(){
            var d = new Date();
            codEmp = $('#codigoCedepas').val();
            mes = (d.getMonth()+1.0).toString();
            if(mes.length > 0) mes = '0' + mes;
            
            year =  d.getFullYear().toString().substr(2,2)  ;
            //$('#codRendicion').val( codEmp +'-'+ d.getDate() +mes + year + cadAleatoria(2));
            
    
        });
    
        
        function observarRendicion(){
            textoObs = $('#observacion').val();
            codigoSolicitud = {{$rendicion->codRendicionGastos}};
            console.log('Se presionó el botón observar, el textoobservacion es ' + textoObs + ' y el cod de la rendicion es ' +  codigoSolicitud);
            location.href = '/rendiciones/observar/'+ codigoSolicitud +'*' +textoObs;
        }



        function cambio(index){
                var idname= 'imagenEnvio'; 
                var filename = $('#imagenEnvio').val().split('\\').pop();
                console.log('filename= '+filename+'    el id es='+idname+'  el index es '+index)
                jQuery('span.'+idname).next().find('span').html(filename);
                document.getElementById("divFileImagenEnvio").innerHTML= filename;
                $('#nombreImgImagenEnvio').val(filename);

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
            //tam=detalleRend.length;
    
         
    
            //removemos 1 elemento desde la posicion index
            detalleRend.splice(index,1);
           
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
            for (let item = 0; item < detalleRend.length; item++) {
                element = detalleRend[item];
                cont = item+1;
    
                total=total +parseFloat(element.importe); 
    
                //importes.push(importe);
                //item = getUltimoIndex();
                var fila=   '<tr class="selected" id="fila'+item+'" name="fila' +item+'">               ' +
                            '    <td style="text-align:center;">               '+
                            '       <input type="text" class="form-control" name="colFecha'+item+'" id="colFecha'+item+'" value="'+element.fecha+'" readonly="readonly">'   +
                            '    </td>               '+
                            
                            '    <td style="text-align:center;">               '+
                            '       <input type="text" class="form-control" name="colTipo'+item+'" id="colTipo'+item+'" value="'+element.tipo+'" readonly="readonly">'   +
                            '    </td>               '+
                            
                            '    <td style="text-align:center;">               '+
                            '       <input type="text" class="form-control" name="colComprobante'+item+'" id="colComprobante'+item+'" value="'+element.ncbte+'" readonly="readonly">'   +
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
                            '    <td style="text-align:center;">               '+
                            '        <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle('+item+');">'+
                            '            <i class="fa fa-times" ></i>               '+
                            '        </button>               '+
                            '    </td>               '+
                            '</tr>                 ';
    
    
                $('#detalles').append(fila); 
            }
            $('#total').val(number_format(total,2));
            
            
            $('#cantElementos').val(cont);
            
          
            //alerta('se termino de actualizar la tabla con cont='+cont);
        }
    
    
    
    
        function agregarDetalle()
        {


            // VALIDAMOS

            fecha = $("#fechaComprobante").val();    
            if (fecha=='') 
            {
                alerta("Por favor ingrese la fecha del comprobante del gasto.");    
                return false;
            }   
            tipo = $("#ComboBoxCDP").val();    
            if (tipo==-1) 
            {
                alerta("Por favor ingrese el tipo de comprobante del gasto.");    
                return false;
            }
            ncbte= $("#ncbte").val();   
             
            if (ncbte=='') 
            {
                alerta("Por favor ingrese el numero del comprobante del gasto.");    
                return false;
            }
             
            concepto=$("#concepto").val();    
            if (concepto=='') 
            {
                alerta("Por favor ingrese el concepto");    
                return false;
            }    
              
            
    
            importe=$("#importe").val();    
            if (!(importe>0)) 
            {
                alerta("Por favor ingrese un importe válido.");    
                return false;
            }    
            
    
            codigoPresupuestal=$("#codigoPresupuestal").val();    
            if (codigoPresupuestal=='') 
            {
                alerta("Por favor ingrese el codigo presupuestal");    
                return false;
            }    
    
            if (importe==0)
            {
                alerta("Por favor ingrese importe");    
                return false;
            }  
            
            // FIN DE VALIDACIONES
    
                item = cont+1;   
                detalleRend.push({
                    fecha:fecha,
                    tipo:tipo,
                    ncbte,ncbte,
                    concepto:concepto,
                    importe:importe,            
                    codigoPresupuestal:codigoPresupuestal
                });        
                cont++;
            actualizarTabla();
            //ACTUALIZAMOS LOS VALORES MOSTRADOS TOTALES    
            //$('#total').val(number_format(total,2)); //TOTAL INCLUIDO IGV
            $('#fechaComprobante').val('');
            $('#ComboBoxCDP').val(0);
            $('#ncbte').val('');
            
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
