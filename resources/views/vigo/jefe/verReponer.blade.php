@extends('layout.plantilla')

@section('estilos')
  
@endsection


{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}
{{-- ********************* ESTA VISTA NO SE USA  **************** --}}

@section('contenido')
<div >
    <p class="h1" style="text-align: center">Reponer Gastos de un Empleado</p>
</div>

<form method = "POST" action = "{{route('rendicionGastos.reponer')}}"  enctype="multipart/form-data" >
    
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $empleado->codigoCedepas }}">
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codigoSolicitud" id="codigoSolicitud" value="{{ $solicitud->codSolicitud }}">
    <input type="hidden" name="codRendicionGastos" id="codRendicionGastos" value="{{ $rend->codRendicionGastos }}">
    

    @csrf
    <div class="container" >
        <div class="row">           
            <div class="col-md" > {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div class="colLabel">
                            <label for="fecha">Fecha:</label>
                      </div>
                      <div class="col">
                                                   
                                <div class="input-group date form_date " style="width: 100px;" >
                                    <input type="text"  class="form-control" name="fechaHoy" id="fechaHoy" disabled
                                        value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" >     
                                </div>
                          
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                              <label for="ComboBoxProyecto">Proyecto:</label>

                      </div>
                      <div class="col"> {{-- input de proyecto --}}
                          <input readonly type="text" class="form-control" name="proyecto" id="proyecto" value="{{$solicitud->getNombreProyecto()}}">    
        
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="fecha">Colaborador:</label>

                      </div>
                      <div class="col">
                            <input  readonly type="text" class="form-control" name="colaboradorNombre" id="colaboradorNombre" value="{{$empleado->nombres}}">    

                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="fecha">Cod Colaborador:</label>

                      </div>

                      <div class="col">
                            <input readonly  type="text" class="form-control" name="codColaborador" 
                            id="codColaborador" value="{{$empleado->codigoCedepas}}">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="fecha">Importe Recibido:</label>

                      </div>
                      <div class="col">
                            <input readonly  type="text" class="form-control" name="importeRecibido" 
                            id="importeRecibido" value="{{$solicitud->totalSolicitado}}">    
                      </div>
                      
                      
                      



                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <label for="fecha">Resumen de la actividad:</label>
                            <textarea class="form-control" name="resumen" id="resumen" readonly aria-label="With textarea"
                             style="resize:none; height:100px;">{{$rend->resumenDeActividad}}</textarea>
            
                        </div>
                    </div>

                    <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                        <div class="row">
                            <div class="colLabel">
                                <label for="fecha">Cod Rendicion:</label>
                            </div>
                            <div class="col">
                                 <input type="text" class="form-control" name="codRendicion" id="codRendicion" readonly value="{{$rend->codigoCedepas}}">     
                            </div>


                            <div class="w-100"></div> {{-- SALTO LINEA --}}
                            <div class="colLabel">
                                    <label for="codSolicitud">Cod Sol. Fondos:</label>

                            </div>
                            <div class="col">
                                    <input value="{{$solicitud->codigoCedepas}}" type="text" class="form-control" name="codSolicitud" id="codSolicitud" readonly>     
                            </div>
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
                    
                    
                    
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th width="13%" class="text-center">Fecha</th>                                        
                        <th width="13%">Tipo CDP</th>
                        <th width="13%">Comprobante</th>                                 
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
                                <td style="text-align: center">
                                    <a href="{{route('rendicion.descargarCDPDetalle',$itemDetalle->codDetalleRendicion)}}" 
                                        class='btn btn-primary'>
                                        <i class="fas fa-download"></i>
                                    </a>   
                                </td>
                            
                                <td style="text-align:center;">               
                                    {{$itemDetalle->nroComprobante  }}
                                </td>               
                                <td> 
                                    {{$itemDetalle->concepto  }}
                                
                                </td>               
                                <td  style="text-align:right;">               
                                    S/. {{  number_format($itemDetalle->importe,2)  }}
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
                    <div class="col-md-8">
                    </div>   
                    <div class="col-md-2">                        
                        <label for="">Total Rendido/Gastado: </label>    
                    </div>   
                    <div class="col-md-2">
                        {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                        <input type="hidden" name="cantElementos" id="cantElementos">                              
                        <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly" value="{{number_format(($rend->totalImporteRendido),2)}}">                              
                    </div>   
                    <div class="col-md-8">
                    </div>   
                    <div class="col">                        
                        <label for="">Total Recibido: </label>    
                    </div>   

                    <div class="col">
                       
                        <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly" value="{{number_format($rend->totalImporteRecibido,2)}}">                              
                    </div>   
                    <div class="col-md-8">
                    </div>   
                    <div class="col">                        
                        <label for="">

                            @if($rend->saldoAFavorDeEmpleado>0) {{-- pal empl --}}
                                Saldo a favor del Empl: 
                            @else
                                Saldo a favor de Cedepas: 
                            @endif
                            
                        </label>    
                    </div>   
                    <div class="col">
                     
                        <input type="text" class="form-control text-right" name="total" id="total" 
                        readonly value="{{number_format(abs($rend->saldoAFavorDeEmpleado),2)}}">                              
                    </div>   
                    

                    <div class="col-md-8">

                    </div>

                    <div class="col" id="divEnteroArchivo">            
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

                    <div class="col-md-8"></div>
                    <div class="col">
                        <button class="btn btn-primary" type="submit" id="btnRegistrar"
                         data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                            <i class="fas fa-save"></i> 
                            Reponer Gasto
                        </button>
                    </div>


                </div>
                    

                
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    <a href="{{route('rendicionGastos.listarJefeAdmin')}}" 
                        class='btn btn-primary' style="float:left;">
                        <i class="fas fa-undo"></i>
                        Regresar al menú
                    </a>    
                               
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
        margin-top: 15px;
        
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
            
          
            //alert('se termino de actualizar la tabla con cont='+cont);
        }
    
    
    
    
        function agregarDetalle()
        {


            // VALIDAMOS

            fecha = $("#fechaComprobante").val();    
            if (fecha=='') 
            {
                alert("Por favor ingrese la fecha del comprobante del gasto.");    
                return false;
            }   
            tipo = $("#ComboBoxCDP").val();    
            if (tipo==-1) 
            {
                alert("Por favor ingrese el tipo de comprobante del gasto.");    
                return false;
            }
            ncbte= $("#ncbte").val();   
             
            if (ncbte=='') 
            {
                alert("Por favor ingrese el numero del comprobante del gasto.");    
                return false;
            }
             
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
