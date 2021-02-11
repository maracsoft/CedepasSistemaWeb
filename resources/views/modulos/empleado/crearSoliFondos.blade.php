@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')

<h1> Registrar Nueva Solicitud de Fondos</h1>
<form method = "POST" action = "{{ route('solicitudFondos.store') }}"  >
        
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoEmpleadoCedepas" id="codigoEmpleadoCedepas" value="{{ $empleadoLogeado->codigoEmpleadoCedepas }}">

    @csrf
    <div class="container" style="background-color: green">
        <div class="row">           
            <div class="col-md" style="background-color:blue"> {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div  style="width: 30%">
                            <label for="fecha">Justificacion</label>
                      </div>
                      <div class="col">
                            <div class="form-group" style="text-align:left; background-color:red">                            
                                <div class="input-group date form_date " style="width: 100px;" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                    <input type="text"  class="form-control" name="fecha" id="fecha" disabled
                                        value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" >     
                                </div>
                            </div>
                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  style="width: 30%">
                            <label for="fecha">Girar a la orden de</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="girarAOrden" id="girarAOrden">    

                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  style="width: 30%">
                            <label for="fecha">Nro Cuenta</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="nroCuenta" id="nroCuenta">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  style="width: 30%">
                            <label for="fecha">Banco</label>

                      </div>
                      <div class="col"> {{-- Combo box de banco --}}
                            <select class="form-control"  id="ComboBoxBanco" name="ComboBoxBanco" >
                                <option value="0">-- Seleccionar -- </option>
                                @foreach($listaBancos as $itemBanco)
                                    <option value="{{$itemBanco['codBanco']}}" >
                                        {{$itemBanco->nombreBanco}}
                                    </option>                                 
                                @endforeach 
                            </select>      
                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  style="width: 30%">
                            <label for="codSolicitud">Codigo Solicitud</label>

                      </div>
                      <div class="col"> {{-- Combo box de empleado --}}
                            <input type="text" class="form-control" name="codSolicitud" id="codSolicitud" readonly>     
                      </div>



                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <label for="fecha">Justificacion</label>
                <textarea class="form-control" name="justificacion" id="justificacion" aria-label="With textarea" style="resize:none; height:100px;"></textarea>

                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  style="width: 12%">
                                <label for="ComboBoxProyecto">Proyecto</label>

                        </div>
                        <div class="col"> {{-- Combo box de proyecto --}}
                                <select class="form-control"  id="ComboBoxProyecto" name="ComboBoxProyecto" >
                                    <option value="0">-- Seleccionar -- </option>
                                    @foreach($listaProyectos as $itemProyecto)
                                        <option value="{{$itemProyecto['codProyecto']}}" >
                                            {{$itemProyecto->nombreProyecto}}
                                        </option>                                 
                                    @endforeach 
                                </select>      
                        </div>
                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  style="width: 12%">
                                <label for="ComboBoxSede">Sede</label>
                        </div>
                        <div class="col"> {{-- Combo box de sede --}}
                                <select class="form-control"  id="ComboBoxSede" name="ComboBoxSede" >
                                    <option value="0">-- Seleccionar -- </option>
                                    @foreach($listaSedes as $itemSede)
                                        <option value="{{$itemSede['codSede']}}" >
                                            {{$itemSede->nombre}}
                                        </option>                                 
                                    @endforeach 
                                </select>      
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
                        <th width="10%" class="text-center"></th>                                        
                        <th width="40%"> 
                            <div style=" background-color:blue;"> {{-- INPUT PARA CONCEPTO--}}
                                <input type="text" class="form-control" name="concepto" id="concepto">     
                            </div>
                            
                        </th>                                 
                        <th width="10%">
                            <div style="background-color:blue;" > {{-- INPUT PARA importe--}}
                                <input type="text" class="form-control" name="importe" id="importe">     
                            </div>
                        </th>
                        <th width="15%" class="text-center">
                            <div style="background-color:blue;"> {{-- INPUT PARA codigo presup--}}
                                <input type="text" class="form-control" name="codigoPresupuestal" id="codigoPresupuestal">     
                            </div>

                        </th>
                        <th width="20%" class="text-center">
                            <div style="background-color: blue; ">
                                <button type="button" id="btnadddet" name="btnadddet" 
                                    class="btn btn-success" onclick="agregarDetalle()" >
                                    <i class="fas fa-plus"></i>
                                     Agregar Detalle
                                </button>
                            </div>      
                        
                        </th>                                            
                     
                    </thead>
                    
                    
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th width="10%" class="text-center">Item</th>                                        
                        <th width="40%">Concepto</th>                                 
                        <th width="10%"> Importe</th>
                        <th width="15%" class="text-center">Codigo Presupuestal</th>
                        <th width="20%" class="text-center">Opciones</th>                                            
                     
                    </thead>
                    <tfoot>

                                                                                        
                    </tfoot>
                    <tbody>
                        
                        {{-- <tr class="selected" id="fila1">
                            <td style="text-align:center;">
                                Item
                            </td>
                            <td>concepto
                            </td>
                            <td  style="text-align:right;">
                               importe
                            </td>
                            <td style="text-align:center;">
                                codigoPresupuestal
                            </td>
                            
                            <td style="text-align:center;">
                                <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle('+cod_producto+','+cont+');">
                                    <i class="fa fa-times" ></i>
                                </button>
                            </td>
                        </tr>   --}}     
            
















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
                    <button class="btn btn-primary" type="submit"
                        id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                        <i class='fas fa-save'></i> 
                        Registrar
                    </button>    
                   
                    <a href="" class='btn btn-danger'><i class='fas fa-ban'></i> Cancelar</a>              
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
            var d = new Date();
            codEmp = $('#codigoEmpleadoCedepas').val();
            mes = (d.getMonth()+1.0).toString();
            if(mes.length > 0) mes = '0' + mes;
            
            year =  d.getFullYear().toString().substr(2,2)  ;
            $('#codSolicitud').val( codEmp +'-'+ d.getDate() +mes + year + cadAleatoria(2));
            
    
        });
    
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
                var fila=   '<tr class="selected" id="fila'+item+'" name="fila' +item+'">               ' +
                            '    <td style="text-align:center;">               '+
                            '       <input type="text" class="form-control" name="colItem'+item+'" id="colItem'+item+'" value="'+item+'" readonly="readonly">'   +
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
    
    
        /* function mostrarTipo(){ //ESTE METODO SE EJECUTA CUANDO SE CAMBIA ENTRE BOLETA Y FACTURA
            codigo=$("#seltipo").val();   
                $.get('/EncontrarTipo/'+codigo, function(data){                                 
                    $('input[name=nrodoc]').val(data[0].serie + (data[0].numeracion) );   
                    if(codigo==1){ //factura
                        $('#divTotalSinIGV').show();
                        $('#divIGV').show();
                    }else{ //boleta
                        $('#divTotalSinIGV').hide();
                        $('#divIGV').hide();
                    }
                    
          
                    });
            
        }
     */
        /* function mostrarCliente(){                            
            datosCliente=document.getElementById('cliente_id').value.split('_');        
            $('#ruc').val(datosCliente[1]);  
            $('#direccion').val(datosCliente[2]);    
        } */
    
        /* function mostrarProducto(){      //se ejecuta cuando cambiamos el comboBox del producto
                                   
              producto_id=$("#producto_id").val();  
                   
                  $.get('/EncontrarProducto/'+producto_id, function(data){                         
                      $('input[name=producto_id]').val(data[0].producto_id);   
                      $('input[name=unidad]').val(data[0].unidad);    
                      $('input[name=precio]').val(data[0].precio);    
                      $('input[name=stock]').val(data[0].stock);  
                    });
         }      */   
    
    
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
