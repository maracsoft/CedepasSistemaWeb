@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')

<div>
    <p class="h1" style="text-align: center">Abonar a Solicitud de Fondos Aprobada</p>
</div>

<form method = "POST" action = "{{route('solicitudFondos.abonar')}}" onsubmit="return validar()"  enctype="multipart/form-data">
    {{-- Para saber en el post cual solicitud es  --}}    
    <input type="hidden" value="{{$solicitud->codSolicitud}}" name="codSolicitud" id="codSolicitud">
   
    @csrf
    <div class="container">
        <div class="row">           
            <div class="col-md" > {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div  class="col">
                            <label for="fecha">Fecha emisión</label>
                      </div>
                      <div class="col">
                                                  
                                <div class="input-group date form_date " style="width: 100px;" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                    <input type="text"  class="form-control" name="fecha" id="fecha" disabled
                                        value="{{$solicitud->fechaHoraEmision}}" >     
                                </div>

                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Girar a la orden de</label>

                      </div>
                      <div class="col">
                            <input readonly type="text" class="form-control" name="girarAOrden" id="girarAOrden" value="{{$solicitud->girarAOrdenDe}}">    

                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">N° Cuenta</label>

                      </div>
                      <div class="col">
                            <input readonly  type="text" class="form-control" name="nroCuenta" id="nroCuenta" value="{{$solicitud->numeroCuentaBanco}}">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Banco</label>

                      </div>
                      <div class="col"> {{-- Combo box de banco --}}
                            <input type="text" class="form-control" name="banco" id="banco" readonly value="{{$solicitud->getNombreBanco()}}">     
                                     
                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="codSolicitud">Código Solicitud</label>

                      </div>
                      <div class="col"> {{-- Combo box de empleado --}}
                            <input readonly  type="text" class="form-control" name="" id="" readonly value="{{$solicitud->codigoCedepas}}">     
                      </div>



                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <label for="fecha">Justificación</label>
                <textarea readonly  class="form-control" name="justificacion" id="justificacion"
                 aria-label="With textarea" style="resize:none; height:50px;">{{$solicitud->justificacion}}</textarea>

                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel">
                                <label for="ComboBoxProyecto">Proyecto</label>

                        </div>
                        <div class="col"> {{-- Combo box de proyecto --}}
                                <input readonly  type="text" class="form-control" name="proyecto" id="proyecto" readonly value="{{$solicitud->getNombreProyecto()}}">     
                               
                        </div>
                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel">
                                <label for="ComboBoxSede">Sede</label>
                        </div>
                        <div class="col"> {{-- Combo box de sede --}}
                            <input readonly  type="text" class="form-control" name="sede" id="sede" readonly value="{{$solicitud->getNombreSede()}}">     
                                    
                        </div>


                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel">
                                <label for="ComboBoxSede">Estado de la Solicitud 
                                    @if($solicitud->verificarEstado('Observada')){{-- Si está observada --}}& Observación @endif:</label>
                        </div>
                        <div class="col"> {{-- Combo box de estado --}}
                            <input readonly type="text" class="form-control" name="sede" id="sede"
                            style="background-color: {{$solicitud->getColorEstado()}} ;
                                color:{{$solicitud->getColorLetrasEstado()}};
                                
                            "
                            readonly value="{{$solicitud->getNombreEstado()}} {{$solicitud->observacion}}">     
                        
                                    
                        </div>


                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel">
                                <label for="ComboBoxSede">Aprobado por:</label>
                        </div>
                        <div class="col"> {{-- Combo box de sede --}}
                            <input readonly  type="text" class="form-control" name="evaluador" id="evaluador" readonly value="{{$solicitud->getNombreEvaluador()}}">     
                                    
                        </div>




                    </div>
                </div>
            </div>
        </div>
      </div>
    
      
           
        {{-- <div class="container" style="background-color: brown; margin-top: 50px;" >
            <div class="row">                                

                      
            </div> 
        </div> --}}
           
           
         


        {{-- LISTADO DE DETALLES  --}}
        <div class="col-md-12 pt-3">     
            <div class="table-responsive">                           
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    
                    {{--  --}}
                    
                    
                    
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th width="10%" class="text-center">Ítem</th>                                        
                        <th width="40%">Concepto</th>                                 
                        <th width="10%"> Importe</th>
                        <th width="15%" class="text-center">Código Presupuestal</th>
                        {{-- <th width="20%" class="text-center">Opciones</th>                                            
                      --}}
                    </thead>
                    <tfoot>

                                                                                        
                    </tfoot>
                    <tbody>
                        @foreach($detallesSolicitud as $itemDetalle)
                            <tr class="selected" id="fila{{$itemDetalle->nroItem}}" name="fila{{$itemDetalle->nroItem}}">
                                <td style="text-align:center;">               
                                   <input type="text" class="form-control" name="colItem{{$itemDetalle->nroItem}}" 
                                        id="colItem{{$itemDetalle->nroItem}}" value="{{$itemDetalle->nroItem}}" readonly="readonly">   
                                </td>               
                                <td> 
                                   <input type="text" class="form-control" name="colConcepto{{$itemDetalle->nroItem}}" id="colConcepto{{$itemDetalle->nroItem}}" value="{{$itemDetalle->concepto}}" readonly="readonly"> 
                                </td>               
                                <td  style="text-align:right;">               
                                   <input type="text" class="form-control" name="colImporte{{$itemDetalle->nroItem}}" id="colImporte{{$itemDetalle->nroItem}}" value="{{$itemDetalle->importe}}" readonly="readonly"> 
                                </td>               
                                <td style="text-align:center;">               
                                <input type="text" class="form-control" name="colCodigoPresupuestal{{$itemDetalle->nroItem}}" id="colCodigoPresupuestal{{$itemDetalle->nroItem}}" value="{{$itemDetalle->codigoPresupuestal}}" readonly="readonly">
                                </td>               
                                {{-- <td style="text-align:center;">               
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle({{$itemDetalle->nroItem - 1}});">
                                        <i class="fa fa-times" ></i>               
                                    </button>               
                                </td>   --}}             
                            </tr>                
                        
                        @endforeach    



                    </tbody>
                </table>
            </div> 
                
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
                    

                
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    
                    
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <a href="{{route('solicitudFondos.listarJefeAdmin',$solicitud->codSolicitud)}}" 
                                    class='btn btn-primary' style="float:left;">
                                    <i class="fas fa-undo"></i>
                                    Regresar al menú
                                </a>

                            </div>
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col"></div>
                            
                            

                            @if($solicitud->verificarEstado('Aprobada'))
                                

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


                            <div class="col">
                                <a href="{{route('solicitudFondos.rechazar',$solicitud->codSolicitud)}}" 
                                    class='btn btn-danger'  style="float:right;">
                                    <i class='fas fa-ban'></i>
                                    Rechazar
                                </a>    
                            </div>

                            
                            <div class="col">
                                <button type="submit" class='btn btn-success'  style="float:right;">
                                    <i class="fas fa-check"></i>
                                    Marcar como Abonado
                                </button>
                            </div>
                                  
                            <div class="col">            
                                <input type="file" class="btn btn-primary" name="imagenEnvio" id="imagenEnvio"        
                                        style="display: none" onchange="cambio('imagenEnvio')">  
                                                <input type="hidden" name="nombreImgImagenEnvio" id="nombreImgImagenEnvio">                 
                                <label class="label" for="imagenEnvio" style="font-size: 12pt;">       
                                     <div id="divFileImagenEnvio" class="hovered">       
                                        Subir comprobante deposito.      
                                     <i class="fas fa-upload"></i>        
                                    </div>       
                                </label>       
                            </div> 
                            @endif






                            
                        </div>
                    </div>
                   
                        
                          
                    
                               
                    
                    
                
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
    .col{
        /* background-color: orange; */
        margin-top: 20px;
        
    }
    .colLabel{
        width: 30%;
        /* background-color: aqua; */
        margin-top: 20px;    
        text-align: left;
    }
    
    .colLabel2{
        width: 20%;
        /* background-color: #3c8dbc; */
        margin-top: 20px;
        text-align: left;
    }
    .hovered:hover{
    background-color:rgb(97, 170, 170);
}

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

        function validar(){
            if($('#nombreImgImagenEnvio').val() == '')
                {
                    alert('Debe subir el comprobante del deposito.')
                    return false;
                }

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
