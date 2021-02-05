@extends('layout.plantilla')

@section('estilos')
  <link rel="stylesheet" href="public/calendario/css/bootstrap-datepicker.standalone.css">
  <link rel="stylesheet" href="public/select2/bootstrap-select.min.css">
  
@endsection

@section('contenido')

<h1> Registrar Venta</h1>
<form method = "POST" action = "{{ route('cabeceraventa.store') }}"  >

    @csrf   
    <div class="row">
         <div class="col-md-1">
             <label for="fecha">Fecha</label>
         </div>
         
         <div class="col-md-2" >
               <div class="form-group" style="">                            
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fecha" id="fecha"
                                  value="{{ Carbon\Carbon::now()->format('d/m/Y') }}"> 
                            
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </div>
                        </div>
               </div>
         </div> 



         <div class="col-md-1" style="">
         </div>        
         <div class="col-md-1" style="">
             <label for="">Tipo</label>
         </div>    
         <div class="col-md-2" style="">      
             {{-- combobox de BOLETA Y FACTURA --}}                        
             <select class="form-control"  id="seltipo" name="seltipo"  onchange="mostrarTipo()">
                  @foreach($tipo as $itemtipo)
                     <option value="{{$itemtipo['tipo_id']}}" selected>{{$itemtipo['descripcion']}}</option>                                 
                 @endforeach      
             </select>                                              
         </div>


         <div class="col-md-1" style="">
         </div>  

         <div class="col-md-1" style="">
                       <label for="">No Doc. :</label>
         </div> 

         <div class="col-md-3" style="">
            {{-- input de DNI  --}}
            <input type="text" class="form-control" name="nrodoc" 
                id="nrodoc" value="{{$parametros->serie.($parametros->numeracion) }}">                              
         </div>
         
    </div>
           
        <div class="row">                                              
                <div class="col-md-1">
                    <label for="">Cliente </label>        
                </div>
                <div class="col-md-7">       
                    <select class="form-control select2 select2-hidden-accessible selectpicker" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="cliente_id" name="cliente_id" data-live-search="true" onchange="mostrarCliente()">
                        <option value="0" selected>- Seleccione Cliente -</option>          
                            @foreach($cliente as $itemcliente)
                                <option value="{{ $itemcliente->cliente_id }}_{{ $itemcliente->ruc_dni }}_{{ $itemcliente->direccion }}" >{{ $itemcliente->nombres }}</option>                                 
                            @endforeach            
                    </select>                                                                  
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-1">
                    <label for="">RUC/DNI</label>
                </div>    
                <div class="col-md-2">
                    <div class="input-group">                                  
                        <input type="text" class="form-control" name="ruc" id="ruc">      
                    </div>
                </div>
            </div>
            <div class="row  pt-2">   
                <div class="col-md-1">
                    <label for="">Dirección </label>        
                </div>
                <div class="col-md-11">
                    <input type="text" class="form-control" name="direccion" id="direccion">        
                </div>
            </div>
            <div class="row pt-3">                
                    <div class="col-md-1">
                        <label for="">Producto </label>    
                    </div>    
                    <div class="col-md-6">
                        <select class="form-control select2 select2-hidden-accessible selectpicker" style="width: 100%;" 
                            data-select2-id="1" tabindex="-1" aria-hidden="true" id="producto_id" name="producto_id" 
                            data-live-search="true" onchange="mostrarProducto()">
                            <option value="0" selected>- Seleccione Producto -</option>          
                                @foreach($producto as $itemproducto)
                                    <option value="{{ $itemproducto->codproducto }}">{{ $itemproducto->descripcion }}</option>                                 
                                @endforeach            
                        </select>      
                    </div>                                      
                    <div class="col-md-1" style="text-align:right;">
                        <label for="">Unidad :</label>        
                    </div>         
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="unidad" id="unidad">                              
                    </div>         
            </div>  
            <div class="row pt-3">                                
                <div class="col-md-1">
                </div>             
                <div class="col-md-1">
                    <label for="">Precio </label>        
                </div>                         
                <div class="col-md-2">
                    <input type="text" class="form-control" name="precio" id="precio">                              
                </div>         
                <div class="col-md-1">
                    <label for="">Cantidad </label>    
                </div>    
                <div class="col-md-2">
                    <input type="text" class="form-control" name="cantidad" id="cantidad">                              
                </div>        
                <div class="col-md-3">
                    <button type="button" id="btnadddet" name="btnadddet" 
                        class="btn btn-success" onclick="agregarDetalle()" >
                        <i class="fas fa-shopping-cart"></i>
                         Agregar al carrito
                    </button>
                </div>        
                <div class="col-md-2">
                    <input type="text" class="form-control" name="stock" id="stock" hidden>                              
                </div>         
        </div>  


        {{-- LISTADO DE DETALLES  --}}
        <div class="col-md-12 pt-3">     
            <div class="table-responsive">                           
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th width="10" class="text-center">OPCIONES</th>                                        
                        <th class="text-center">CODIGO</th>                                 
                        <th>DESCRIPCIÓN</th>
                        <th>UNIDAD</th>
                        <th  class="text-center">CANTIDAD</th>                                            
                        <th class="text-center">P.VENTA</th>
                        <th>IMPORTE</th>
                    </thead>
                    <tfoot>
                                                                                                          
                                                                                        
                    </tfoot>
                    <tbody>
                        
                    </tbody>
                </table>
            </div> 
                <div class="row" id="divTotalSinIGV" name="divTotalSinIGV">                       
                    <div class="col-md-8">
                    </div>   
                    <div class="col-md-2">                        
                        <label for="">Total sin igv: </label>    
                    </div>   
                    <div class="col-md-2">
                        <input type="text" class="form-control text-right" name="totalSinIGV" id="totalSinIGV" readonly="readonly">                              
                    </div>   
                </div>
                <br>
                <div class="row" id="divIGV" name="divIGV">                       
                    <div class="col-md-8">
                    </div>   
                    <div class="col-md-2">                        
                        <label for="">IGV : </label>    
                    </div>   
                    <div class="col-md-2">
                        <input type="text" class="form-control text-right" name="IGV" id="IGV" readonly="readonly">                              
                    </div>   
                </div>
                <br>

                <div class="row" id="divTotal" name="divTotal">                       
                    <div class="col-md-8">
                    </div>   
                    <div class="col-md-2">                        
                        <label for="">Total : </label>    
                    </div>   
                    <div class="col-md-2">
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
                   
                    <a href="{{route('cabeceraventa.index')}}" class='btn btn-danger'><i class='fas fa-ban'></i> Cancelar</a>              
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

<script>
    var cont=0;
    
    var IGV=0;
    var total=0;
    var detalleventa=[];
    var subtotal=[];
    var controlproducto=[];
    var totalSinIGV=0;


    $(document).ready(function(){
        $('#seltipo').change(function(){
            mostrarTipo();
        });

        $('#cliente_id').change(function(){
            mostrarCliente();
        });
        
        $('#producto_id').change(function(){
            mostrarProducto();
        });
        
        $('#btnadddet').click(function(){ //ACA NO LLEGA
            alert('hoals');
            agregarDetalle();
        });


        
        
    });


    /* Eliminar productos */
function eliminardetalle(codigo,index){
    total=total-subtotal[index]; 
    IGV = IGV - subtotal[index]*0.18;
    totalSinIGV = total - IGV;
    tam=detalleventa.length;
     var i=0;
     var pos;      
     while (i<tam)
      {
           if (detalleventa[i].codigo==codigo)
           {
               pos=i;      
               break;                   
           }
           i=i+1;
      }
    detalleventa.splice(pos,1);    
    $('#fila'+index).remove();
    controlproducto[index]="";
    $('#total').val(number_format(total,2));

    $('#IGV').val(number_format(IGV,2));
    $('#totalSinIGV').val(number_format(totalSinIGV,2));
        

}

    function mostrarTipo(){ //ESTE METODO SE EJECUTA CUANDO SE CAMBIA ENTRE BOLETA Y FACTURA
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

    function mostrarCliente(){                            
        datosCliente=document.getElementById('cliente_id').value.split('_');        
        $('#ruc').val(datosCliente[1]);  
        $('#direccion').val(datosCliente[2]);    
    }

    function mostrarProducto(){      //se ejecuta cuando cambiamos el comboBox del producto
                               
          producto_id=$("#producto_id").val();  
               
              $.get('/EncontrarProducto/'+producto_id, function(data){                         
                  $('input[name=producto_id]').val(data[0].producto_id);   
                  $('input[name=unidad]').val(data[0].unidad);    
                  $('input[name=precio]').val(data[0].precio);    
                  $('input[name=stock]').val(data[0].stock);  
                });
     }        


    function agregarDetalle()
    {
        

        // VALIDAMOS 
        ruc=$("#ruc").val();    
        if (ruc=='') 
        {
            alert("Por favor seleccione el Cliente");    
            return false;
        }    
        descripcion = $('#producto_id option:selected').text();    
        if (descripcion=='- Seleccione Producto -')
        {
            alert("Por favor seleccione el Producto");    
            return false;   
        }     
        let cantidad=$("#cantidad").val();   
        let stock= $("#stock").val();     
        if (cantidad=='' || Number(cantidad)==0 || cantidad==null)
        {
            alert("Por favor ingrese cantidad del producto");    
            return false;
        }
        if (cantidad<=0)
        {
            alert("Por favor debe escribir cantidad del producto mayor a 0");    
            return false;
        }  
        if (Number(cantidad)>Number(stock))
        {
            alert("No se tiene tal cantidad de producto solo hay " + stock);    
            return false;
        }  
        pventa=$("#precio").val();
        if (pventa=='' || pventa==0)
        {
            alert("Por favor ingrese precio de venta del producto");    
            return false;
        }  
        cod_producto=$("#producto_id").val();
        // FIN DE VALIDACIONES

        /* Buscar que codigo de producto no se repita  */
        var i=0;
        var band=false;   
        while (i<cont)
        {
            if (controlproducto[i]==cod_producto)
            {
                band=true;
            }
            i=i+1;
        }
        if  (band==true) //si sí estaba en la lista de ya añadidos
        {
            alert("No puede volver a vender el mismo producto");    
            return false;
        }
        else
        {   //cont es la cant de productos que hay en la lista
            limpiar();
            unidad=$("#unidad").val();    
            subtotal[cont]=cantidad*pventa;  
            controlproducto[cont]=cod_producto;
            total=total + subtotal[cont]; 
            
             IGV = IGV + subtotal[cont]*0.18;
            // AQUI DEBERIA IR LO DEL IGV 
            totalSinIGV = total-IGV; 



            var fila='<tr class="selected" id="fila'+cont+
                '"><td style="text-align:center;"><button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle('+cod_producto+','+cont+');"><i class="fa fa-times" ></i></button></td><td style="text-align:right;"><input type="text" name="cod_producto[]" value="'+ cod_producto +'" readonly style="width:50px; text-align:right;"></td><td>'+ descripcion +'</td><td><input type="text" readonly name="unidad[]" value="'+ unidad +'" style="width:140px; text-align:left;"></td><td style="text-align:right;"><input type="number" name="cantidad[]" value="'+ cantidad +'" style="width:80px; text-align:right;" readonly></td><td  style="text-align:right;"><input type="number" name="pventa[]" value="'+ pventa +'" style="width:80px; text-align:right;" readonly></td><td style="text-align:right;">'+number_format(subtotal[cont],2)+'</td></tr>';        
            
            $('#detalles').append(fila);      
            detalleventa.push({
                codigo:cod_producto,
                unidad:unidad,
                cantidad:cantidad,            
                pventa:pventa,
                subtotal:subtotal
            });        
            cont++;
        }
        //ACTUALIZAMOS LOS VALORES MOSTRADOS TOTALES    
        $('#total').val(number_format(total,2)); //TOTAL INCLUIDO IGV
        $('#IGV').val(number_format(IGV,2));
        $('#totalSinIGV').val(number_format(totalSinIGV,2));
        
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


@section('script')
     <script src="/public/select2/bootstrap-select.min.js"></script>     
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
    {{--  <script src="/public/archivos/createdoc.js"></script>   --}}   
@endsection
