@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')

<h1> 
    @if($solicitud->verificarEstado('Observada'))
        Subsanar Solicitud de Fondos
        
    @else
        Editar Solicitud de Fondos

    @endif
    

</h1>
<form method = "POST" action = "{{ route('solicitudFondos.update',$solicitud->codSolicitud) }}"  >
        
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $empleadoLogeado->codigoCedepas }}">

    @csrf
    <div class="container" >
        <div class="row">           
            <div class="col-md" > {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div class="colLabel">
                            <label for="fecha">Fecha emision</label>
                      </div>
                      <div class="col">
                                                     
                                <div class="input-group date form_date " style="width: 300px;" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                    <input type="text"  class="form-control" name="fecha" id="fecha" disabled
                                        value="{{$solicitud->fechaHoraEmision}}" >     
                                </div>
                           
                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Girar a la orden de</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="girarAOrden" id="girarAOrden" value="{{$solicitud->girarAOrdenDe}}">    

                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="fecha">Nro Cuenta</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="nroCuenta" id="nroCuenta" value="{{$solicitud->numeroCuentaBanco}}">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="fecha">Banco</label>

                      </div>
                      <div class="col"> {{-- Combo box de banco --}}
                            <select class="form-control"  id="ComboBoxBanco" name="ComboBoxBanco" >
                                {{-- <option value="0">-- Seleccionar -- </option> --}}
                                @foreach($listaBancos as $itemBanco)

                                    <option value="{{$itemBanco['codBanco']}}" 
                                    @if($solicitud->codBanco== $itemBanco->codBanco)
                                        selected
                                    @endif
                                    >
                                        {{$itemBanco->nombreBanco}}
                                    </option>                                 
                                
                                    @endforeach 
                            </select>      
                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="codSolicitud">Codigo Solicitud</label>

                      </div>
                      <div class="col"> {{-- Combo box de empleado --}}
                            <input type="text" class="form-control" name="codSolicitud" id="codSolicitud" readonly value="{{$solicitud->codigoCedepas}}">     
                      </div>



                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <label for="fecha">Justificacion</label>
                <textarea class="form-control" name="justificacion" id="justificacion"
                 aria-label="With textarea" style="resize:none; height:70px;">{{$solicitud->justificacion}}</textarea>

                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel2">
                                <label for="ComboBoxProyecto">Proyecto</label>

                        </div>
                        <div class="col"> {{-- Combo box de proyecto --}}
                                <select class="form-control"  id="ComboBoxProyecto" name="ComboBoxProyecto" >
                                    {{-- <option value="0">-- Seleccionar -- </option> --}}
                                    @foreach($listaProyectos as $itemProyecto)
                                        <option value="{{$itemProyecto['codProyecto']}}" 
                                        @if($solicitud->codProyecto== $itemProyecto->codProyecto)
                                            selected
                                        @endif
                                        >
                                            {{$itemProyecto->nombre}}
                                        </option>                                 
                                    @endforeach 
                                </select>      
                        </div>


                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                       
                     
                        <div class="colLabel2">
                                <label for="ComboBoxMoneda">Moneda:</label>
                        </div>
                        <div class="col"> {{-- Combo box de sede --}}
                                <select class="form-control"  id="ComboBoxMoneda" name="ComboBoxMoneda" >
                                    <option value="-1">-- Seleccionar --</option>
                                    @foreach($listaMonedas as $itemMoneda)
                                        <option value="{{$itemMoneda->codMoneda}}" 
                                            @if($solicitud->codMoneda== $itemMoneda->codMoneda)
                                                selected
                                            @endif
                                            >
                                            {{$itemMoneda->nombre}}
                                        </option>                                 
                                    @endforeach 
                                </select>      
                        </div>






                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel2">
                                <label for="ComboBoxSede">Estado de <br> la Solicitud 
                                    @if($solicitud->verificarEstado('Observada')){{-- Si está observada --}}& Observación @endif:</label>
                        </div>
                        <div class="col"> {{-- Combo box de estado --}}
                            <input readonly type="text" class="form-control" name="sede" id="sede"
                            style="background-color: {{$solicitud->getColorEstado()}} ;
                                color:{{$solicitud->getColorLetrasEstado()}};
                                
                            "
                            readonly value="{{$solicitud->getNombreEstado()}}@if($solicitud->verificarEstado('Observada') ): @endif {{$solicitud->observacion}}">     
                            
                            
                                    
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
                    <thead >
                        <th width="6%" class="text-center">
                            <div> {{-- INPUT PARA ITEM --}}
                                <input type="text" style="text-align: center" class="form-control" readonly name="item" id="item" value="1">     
                            </div>    
                        </th>                                        
                        <th width="40%"> 
                            <div> {{-- INPUT PARA CONCEPTO--}}
                                <input type="text" class="form-control" name="concepto" id="concepto">     
                            </div>
                            
                        </th>                                 
                        <th width="10%">
                            <div  > {{-- INPUT PARA importe--}}
                                <input type="text" class="form-control" name="importe" id="importe">     
                            </div>
                        </th>
                        <th width="15%" class="text-center">
                            <div > {{-- INPUT PARA codigo presup--}}
                                <input type="text" class="form-control" name="codigoPresupuestal" id="codigoPresupuestal">     
                            </div>

                        </th>
                        <th width="10%" class="text-center">
                            <div>
                                <button type="button" id="btnadddet" name="btnadddet" 
                                    class="btn btn-success" onclick="agregarDetalle()" >
                                    <i class="fas fa-plus"></i>
                                     Agregar
                                </button>
                            </div>    
                        
                        </th>                                            
                     
                    </thead>
                    
                    
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th class="text-center">Item</th>                                        
                        <th >Concepto</th>                                 
                        <th > Importe</th>
                        <th  class="text-center">Codigo Presupuestal</th>
                        <th  class="text-center">Opciones</th>                                            
                     
                    </thead>
                    <tfoot>

                                                                                        
                    </tfoot>
                    <tbody>
                       {{--  @foreach($detallesSolicitud as $itemDetalle)
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
                                <td style="text-align:center;">               
                                    <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle({{$itemDetalle->nroItem - 1}});">
                                        <i class="fa fa-times" ></i>               
                                    </button>               
                                </td>               
                            </tr>                
                        
                        @endforeach    
 --}}


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
                        <input type="hidden" class="form-control text-right" name="total" id="total" readonly>   
                        <input type="text" class="form-control text-right" name="totalMostrado" id="totalMostrado" readonly>   

                    </div>   
                </div>
                    

                
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit"
                        id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                        <i class='fas fa-save'></i> 
                        Actualizar
                    </button>    
                   
                    <a href="{{route('solicitudFondos.listarEmp')}}" class='btn btn-danger'><i class='fas fa-ban'></i> Cancelar</a>              
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
            
            
        });
        
        function cargarADetallesSol(){
            
            //obtenemos los detalles de una ruta GET 
            $.get('/listarDetallesDeSolicitud/'+{{$solicitud->codSolicitud}}, function(data)
            {      
                    listaDetalles = data;
                    for (let index = 0; index < listaDetalles.length; index++) {
                        console.log('SI'+index);
                        
                        detalleSol.push({
                            item:               listaDetalles[index].nroItem,
                            concepto:           listaDetalles[index].concepto,
                            importe:            listaDetalles[index].importe,            
                            codigoPresupuestal: listaDetalles[index].codigoPresupuestal
                        });   
                    }
                    actualizarTabla();                

            });



      
            
            

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
                itemMasUno = item+1;
                var fila=   '<tr class="selected" id="fila'+item+'" name="fila' +item+'">               ' +
                            '    <td style="text-align:center;">               '+
                            '       <input type="text" class="form-control" name="colItem'+item+'" id="colItem'+item+'" value="'+itemMasUno+'" readonly="readonly">'   +
                            '    </td>               '+
                            '    <td> '+
                            '       <input type="text" class="form-control" name="colConcepto'+item+'" id="colConcepto'+item+'" value="'+element.concepto+'" readonly="readonly">' +
                            '    </td>               '+
                            '    <td  style="text-align:right;">               '+
                            '       <input type="text" style="text-align:right;" class="form-control" name="colImporte'+item+'" id="colImporte'+item+'" value="'+ (element.importe)+'" readonly="readonly">' +
                            '    </td>               '+
                            '    <td style="text-align:center;">               '+
                            '    <input type="text" class="form-control" style="text-align:center;" name="colCodigoPresupuestal'+item+'" id="colCodigoPresupuestal'+item+'" value="'+element.codigoPresupuestal+'" readonly="readonly">' +
                            '    </td>               '+
                            '    <td style="text-align:center;">               '+
                            '        <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle('+item+');">'+
                            '            <i class="fa fa-times" ></i>               '+
                            '        </button>               '+
                            '    </td>               '+
                            '</tr>                 ';
    
    
                $('#detalles').append(fila); 
            }
            $('#total').val(total);
            $('#totalMostrado').val(number_format(total,2));
            console.log('aaaaaaaaaaa' + total)
            
            
            $('#cantElementos').val(cont);
            $('#item').val(cont+1);
            
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
