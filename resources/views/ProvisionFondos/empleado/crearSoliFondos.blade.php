@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')
<div >
    <p class="h1" style="text-align: center">Registrar Nueva Solicitud de Fondos</p>
</div>

<form method = "POST" action = "{{ route('solicitudFondos.store') }}" onsubmit="return validarTextos()" >
        
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $empleadoLogeado->codigoCedepas }}">
    
    @csrf
    <div class="container" style="">
        <div class="row">           
            <div class="col-md" style=""> {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div  class="colLabel">
                            <label for="fecha">Fecha Actual:</label>
                      </div>
                      <div class="col">
                                <div  style="width: 300px; " >
                                    <input type="text" style="margin:0px auth;" class="form-control" name="fecha" id="fecha" disabled 
                                        value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" >     
                                </div>
                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Girar a la orden de:</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="girarAOrden" 
                            id="girarAOrden" value="{{App\Empleado::getEmpleadoLogeado()->getNombreCompleto()}}">    

                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Nro Cuenta:</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="nroCuenta" id="nroCuenta">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Banco:</label>

                      </div>
                      <div class="col"> {{-- Combo box de banco --}}
                            <select class="form-control"  id="ComboBoxBanco" name="ComboBoxBanco" >
                                <option value="-1">-- Seleccionar -- </option>
                                @foreach($listaBancos as $itemBanco)
                                    <option value="{{$itemBanco['codBanco']}}" >
                                        {{$itemBanco->nombreBanco}}
                                    </option>                                 
                                @endforeach 
                            </select>      
                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="codSolicitud">Codigo Solicitud:</label>

                      </div>
                      <div class="col"> 
                          {{-- ESTE INPUT REALMENTE NO SE USARÁ PORQUE EL CODIGO cedep SE CALCULA EN EL BACKEND (pq es más actual) --}}
                            <input type="text" class="form-control" 
                                value="{{App\SolicitudFondos::calcularCodigoCedepas($objNumeracion)}}" 
                                readonly>     
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
                        <div  class="colLabel2">
                                <label for="ComboBoxProyecto">Proyecto:</label>

                        </div>
                        <div class="col"> {{-- Combo box de proyecto --}}
                                <select class="form-control"  id="ComboBoxProyecto" name="ComboBoxProyecto" >
                                    <option value="-1">-- Seleccionar -- </option>
                                    @foreach($listaProyectos as $itemProyecto)
                                        <option value="{{$itemProyecto['codProyecto']}}" >
                                            {{$itemProyecto->nombre}}
                                        </option>                                 
                                    @endforeach 
                                </select>      

                        </div>



                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                       

                        <div class="colLabel2">
                                <label for="ComboBoxMoneda">Moneda:</label>
                        </div>
                        <div class="col"> {{-- Combo box de itemMoneda --}}
                                <select class="form-control"  id="ComboBoxMoneda" name="ComboBoxMoneda" >
                                    <option value="-1">-- Seleccionar --</option>
                                    @foreach($listaMonedas as $itemMoneda)
                                        <option value="{{$itemMoneda->codMoneda}}" >
                                            {{$itemMoneda->nombre}}
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
                            <div > {{-- INPUT PARA importe--}}
                                <input type="text" class="form-control" name="importe" id="importe">     
                            </div>
                        </th>
                        <th width="15%" class="text-center">
                            <div> {{-- INPUT PARA codigo presup--}}
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
                        <th  class="text-center">Item</th>                                        
                        <th >Concepto</th>                                 
                        <th > Importe</th>
                        <th  class="text-center">Codigo Presupuestal</th>
                        <th  class="text-center">Opciones</th>                                            
                     
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
                        <input type="hidden" class="form-control text-right" name="total" id="total" readonly="readonly">   
                        <input type="text" class="form-control text-right" name="totalMostrado" id="totalMostrado" readonly="readonly">   
                                                   
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
     {{-- <script src="/public/select2/bootstrap-select.min.js"></script>      --}}
     <script>
        var cont=0;
        
        var IGV=0;
        var total=0;
        var detalleSol=[];
        var importes=[];
        var controlproducto=[];
        var totalSinIGV=0;
    
        $(document).ready(function(){
           

            
    
        });
        
        //retorna cadena aleatoria de tamaño length, con el abecedario que se le da ahi. Siempre tiene que empezar por una letra
        function cadAleatoria(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var abecedario = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            var charactersLength = characters.length;
            var abecedarioLength = abecedario.length;
            for ( var i = 0; i < length; i++ ) {
                if(i==0)//primer caracter fijo letra
                    result += abecedario.charAt(Math.floor(Math.random() * abecedarioLength));
                else//los demas da igual que sean numeros
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
        function validarTextos(){ //Retorna TRUE si es que todo esta OK y se puede hacer el submit
            msj='';
            
             if($('#justificacion').val()=='' )
                msj='Debe ingresar la justificacion';
            

            if($('#ComboBoxProyecto').val()=='-1' )
                msj='Debe seleccionar el proyecto';
            
           
           

            if($('#ComboBoxBanco').val()=='-1' )
                msj='Debe seleccionar el banco.';
            
            if($('#girarAOrden').val()=='' )
                msj='Debe ingresar la persona dueña de la cuenta.';
            
            if($('#nroCuenta').val()=='' )
                msj='Debe ingresar el nro de cuenta';
            
            if( $('#cantElementos').val()<=0 )
                msj='Debe ingresar Items';


            if(msj!='')
            {
                alert(msj)
                return false;
            }

            return true;
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
                itemMasUno = item+1;
                //importes.push(importe);
                //item = getUltimoIndex();
                var fila=   '<tr class="selected" id="fila'+item+'" name="fila' +item+'">               ' +
                            '    <td style="text-align:center;">               '+
                            '       <input type="text" class="form-control" name="colItem'+item+'" id="colItem'+item+'" value="'+itemMasUno+'" readonly="readonly">'   +
                            '    </td>               '+
                            '    <td> '+
                            '       <input type="text" class="form-control" name="colConcepto'+item+'" id="colConcepto'+item+'" value="'+element.concepto+'" readonly="readonly">' +
                            '    </td>               '+
                            '    <td  style="text-align:right;">               '+
                            '       <input type="text" style="text-align:right;" class="form-control" name="colImporte'+item+'" id="colImporte'+item+'" value="'+ element.importe+'" readonly="readonly">' +
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
            
            $('#totalMostrado').val(number_format(total,2));
            $('#total').val(total);
            
            
            $('#cantElementos').val(cont);
            $('#item').val(cont+1);
            
          
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

    
    /* Mostrar Mensajes de Error */
    function mostrarMensajeError(mensaje){
        //console.log('a');
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
