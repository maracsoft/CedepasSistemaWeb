@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h1" style="text-align: center">Registrar Reposicion de Gastos</p>


</div>


<form method = "POST" action = "{{route('reposicionGastos.store')}}" onsubmit="return validarTextos()" id="frmrepo" name="frmrepo"  enctype="multipart/form-data">
    
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepasEmpleado" id="codigoCedepasEmpleado" value="{{ $empleadoLogeado->codigoCedepas }}">
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codEmpleado" id="codEmpleado" value="{{$empleadoLogeado->codEmpleado}}">
    
    @csrf
    <div class="container" >
        <div class="row">           
            <div class="col-md"> {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div  class="col">
                            <label for="fecha">Fecha</label>
                      </div>
                      <div class="col">
                                               
                                <div class="input-group date form_date" style="width: 100px;" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                    <input type="text"  class="form-control" name="fechaHoy" id="fechaHoy" disabled
                                        value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" >     
                                </div>
                           
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                              <label for="ComboBoxProyecto">Proyecto</label>

                      </div>
                      <div class="col"> {{-- input de proyecto --}}
                        <select class="form-control"  id="codProyecto" name="codProyecto" 
                                onchange="actualizarCodPresupProyecto()" >
                            <option value="-1">Seleccionar</option>
                            @foreach($proyectos as $itemproyecto)
                                <option value="{{$itemproyecto->codProyecto}}" >
                                    {{$itemproyecto->nombre}}
                                </option>                                 
                            @endforeach 
                        </select>   
                      </div>
                      <!--
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Evaluador</label>

                      </div>
                      <div class="col">
                        <select class="form-control"  id="codEmpleadoEvaluador" name="codEmpleadoEvaluador" >
                            <option value="-1">Seleccionar</option>
                            @foreach($empleadosEvaluadores as $itemevaluador)
                                <option value="{{$itemevaluador->codEmpleado}}" >
                                    {{$itemevaluador->apellidos}}, {{$itemevaluador->nombres}}
                                </option>                                 
                            @endforeach 
                        </select> 
                      </div>
                        -->
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Moneda</label>

                      </div>

                      <div class="col">
                        <select class="form-control"  id="codMoneda" name="codMoneda" >
                            <option value="-1">Seleccionar</option>
                            @foreach($monedas as $itemmoneda)
                                <option value="{{$itemmoneda->codMoneda}}" >
                                    {{$itemmoneda->nombre}}
                                </option>                                 
                            @endforeach 
                        </select>
                      </div>
                      

                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Banco</label>

                      </div>

                      <div class="col">
                        <select class="form-control"  id="codBanco" name="codBanco" >
                            <option value="-1">Seleccionar</option>
                            @foreach($bancos as $itembanco)
                                <option value="{{$itembanco->codBanco}}" >
                                    {{$itembanco->nombreBanco}}
                                </option>                                 
                            @endforeach 
                        </select>
                      </div>


                      <div class="w-100"></div>
                      <div  class="col">
                        <label for="fecha">Codigo Cedepas</label>

                      </div>
                      <div class="col">
                            <input type="text" readonly class="form-control" value="{{App\ReposicionGastos::calcularCodigoCedepas($objNumeracion)}}
                            ">    
                      </div>
                      
                      


                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <label for="fecha">Resumen de la actividad</label>
                            <textarea class="form-control" name="resumen" id="resumen" aria-label="With textarea" style="resize:none; height:100px;"></textarea>
            
                        </div>
                    </div>

                    <div class="container row"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                      <div  class="col">
                            <label for="fecha">CuentaBancaria</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="numeroCuentaBanco" id="numeroCuentaBanco" value="">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Girar a Orden de </label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="girarAOrdenDe" id="girarAOrdenDe" value="">    
                      </div>

                        <!--
                        <div class="row">
                          <div  class="col">
                                <label for="fecha">Cod Rendicion</label>
                          </div>
                          <div class="col">
                            <input type="text" class="form-control" name="codRendicion" id="codRendicion" readonly>     
                          </div>


                          <div class="w-100"></div> {{-- SALTO LINEA --}}
                          <div  class="col">
                                <label for="codSolicitud">Codigo Solicitud de Fondos</label>
                          </div>
                          <div class="col">
                                <input value="" type="text" class="form-control" name="codSolicitud" id="codSolicitud" readonly>     
                          </div>


                        </div>
                        -->
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
                        <th class="text-center">
                                                     
                                <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                    {{-- INPUT PARA EL CBTE DE LA FECHA --}}
                                    <input type="text" style="text-align: center" class="form-control" name="fechaComprobante" id="fechaComprobante"
                                          value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="font-size: 10pt;"> 
                                    
                                    <div class="input-group-btn">                                        
                                        <button class="btn btn-primary date-set btn-sm" type="button" style="display: none">
                                            <i class="fas fa-calendar fa-xs"></i>
                                        </button>
                                    </div>
                                </div>
                        </th>                                        
                        <th> 
                            <div> {{-- INPUT PARA tipo--}}
                                
                                <select class="form-control"  id="ComboBoxCDP" name="ComboBoxCDP" >
                                    <option value="-1">Seleccionar</option>
                                    @foreach($listaCDP as $itemCDP)
                                        <option value="{{$itemCDP->nombreCDP}}" >
                                            {{$itemCDP->nombreCDP}}
                                        </option>                                 
                                    @endforeach 
                                </select>        
                            </div>
                            
                        </th>                                 
                        <th>
                            <div  > {{-- INPUT PARA ncbte--}}
                                <input type="text" class="form-control" name="ncbte" id="ncbte">     
                            </div>
                        </th>
                        <th  class="text-center">
                            <div > {{-- INPUT PARA  concepto--}}
                                <input type="text" class="form-control" name="concepto" id="concepto">     
                            </div>

                        </th>
                   
                        <th class="text-center">
                            <div > {{-- INPUT PARA importe--}}
                                <input type="text" class="form-control" name="importe" id="importe">     
                            </div>

                        </th>
                        <th  class="text-center">
                            <div > {{-- INPUT PARA codigo presup--}}
                                <input type="text" class="form-control" name="codigoPresupuestal" id="codigoPresupuestal">     
                            </div>

                        </th>
                        <th  class="text-center">
                            <div >
                                <button type="button" id="btnadddet" name="btnadddet" 
                                    class="btn btn-success btn-sm" onclick="agregarDetalle()" >
                                    <i class="fas fa-plus"></i>Agregar
                                </button>
                            </div>      
                        
                        </th>                                            
                     
                    </thead>
                    
                    
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th width="10%" class="text-center">Fecha Cbte</th>                                        
                        <th width="13%">Tipo</th>                                 
                        <th width="10%"> N° Cbte</th>
                        <th width="25%" class="text-center">Concepto </th>
                        
                        <th width="10%" class="text-center">Importe </th>
                        <th width="10%" class="text-center">Cod Presup </th>
                        
                        <th width="7%" class="text-center">Opciones</th>                                            
                        
                    </thead>
                    <tfoot>

                                                                                        
                    </tfoot>
                    <tbody>
                  {{--       <tr>
                            <td>
                                a
                            </td>
                            <td>
                                a
                            </td>
                            <td>
                                a
                            </td>
                            <td>a

                            </td>
                            <td>
                              
            
                                <input type="file" class="btn btn-primary" name="imagen1" id="imagen1" 
                                        style="display: none" accept="" onchange="cambioInputFile()">
                                <label class="label" for="imagen1" style="font-size: 10pt;">
                                    <div id='divFile1'>
                                        Subir Archivo
                                     <i class="fas fa-upload"></i> 
                                    </div>
                                </label>
                               
                            </td>
                            <td>
         
                            </td>
                            <td>
                                a
                            </td>
                            <td>
                                a
                            </td>
                        </tr> --}}
                      

                    </tbody>
                </table>
            </div> 


         
              

                <div class="row" id="divTotal" name="divTotal">                       
                    <div class="col-md-8">
                    </div>   
                    <div class="col-md-2">                        
                        <label for="">Total Gastado: </label>    
                    </div>   
                    <div class="col-md-2">
                        {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                        <input type="hidden" name="cantElementos" id="cantElementos">
                        <input type="hidden" name="codigoCedepas" id="codigoCedepas">                          
                        <input type="hidden" name="totalRendido" id="totalRendido">                              
                        <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly">   

                    </div>   
                    <!--
                    <div class="col-md-8">
                    </div>   
                    <div class="col">                        
                        <label for="">Total Recibido: </label>    
                    </div>   

                    <div class="col">
                                                    
                        <input type="text" class="form-control text-right" name="totalRecibido" id="totalRecibido" readonly="readonly" value="">                              
                    </div>   
                    <div class="col-md-8">
                    </div>   
                    <div class="col">                        
                        <label id="labelAFavorDe" for="">Saldo a favor del Empl: </label>    
                    </div>   
                    <div class="col">                     
                        <input type="text" class="form-control text-right"  
                            name="saldoAFavor" id="saldoAFavor" readonly="readonly"  value="0.00">                              
                    </div>   
                    -->
                    <div class="w-100">

                    </div>
                    <div class="col-md-8"></div>



                    {{-- Este es para subir todos los archivos x.x  --}}
                    <div class="col" id="divEnteroArchivo">            
                        <input type="text" name="nombresArchivos" id="nombresArchivos" value="">
                        <input type="file" multiple class="btn btn-primary" name="filenames[]" id="filenames"        
                                style="display: none" onchange="cambio()">  
                                        <input type="hidden" name="nombreImgImagenEnvio" id="nombreImgImagenEnvio">                 
                        <label class="label" for="filenames" style="font-size: 12pt;">       
                             <div id="divFileImagenEnvio" class="hovered">       
                                Subir archivos comprobantes  
                             <i class="fas fa-upload"></i>        
                            </div>       
                        </label>       
                    </div>    






                </div>
                    

                
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    <!--
                    <button class="btn btn-primary" type="submit"
                        id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                        <i class='fas fa-save'></i> 
                        Registrar
                    </button>   -->
                    <button type="button" class="btn btn-primary float-right" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" onclick="swal({//sweetalert
                        title:'¿Seguro de crear la reposicion?',
                        text: '',     //mas texto
                        type: 'info',//e=[success,error,warning,info]
                        showCancelButton: true,//para que se muestre el boton de cancelar
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText:  'SI',
                        cancelButtonText:  'NO',
                        closeOnConfirm:     true,//para mostrar el boton de confirmar
                        html : true
                    },
                    function(){//se ejecuta cuando damos a aceptar
                        if(validarTextos()==true){
                            document.frmrepo.submit();
                        }
                        
                    });"><i class='fas fa-save'></i> Registrar</button> 
                   
                    <a href="{{route('reposicionGastos.listar')}}" class='btn btn-info float-left'><i class="fas fa-arrow-left"></i> Regresar al Menu</a>              
                </div>    
            </div>
        </div>
    </div>

</form>

<script> 
    
</script>

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

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

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



       {{-- PARA EL FILE  --}}
<script type="application/javascript">
    //se ejecuta cada vez que escogewmos un file

        var cont=0;
        var total=0;
        var detalleRepo=[];
        
        $(document).ready(function(){
          

        });
        var listaArchivos = '';
            
        //se ejecuta cada vez que escogewmos un file
        function cambio(){

                
                cantidadArchivos = document.getElementById('filenames').files.length;
                console.log('----- Cant archivos seleccionados:' + cantidadArchivos);
                for (let index = 0; index < cantidadArchivos; index++) {
                    nombreAr = document.getElementById('filenames').files[index].name;
                    console.log('Archivo ' + index + ': '+ nombreAr);
                    listaArchivos = listaArchivos +', '+  nombreAr; 
                }
                listaArchivos = listaArchivos.slice(1, listaArchivos.length);
                document.getElementById("divFileImagenEnvio").innerHTML= listaArchivos;
                $('#nombresArchivos').val(listaArchivos);
        }

        function alertaArchivo(){
            alert('Asegúrese de haber añadido todos los ítems antes de subir los archivos.');

        }

        function validarTextos(){ //Retorna TRUE si es que todo esta OK y se puede hacer el submit
            msj='';
            
            if($('#codProyecto').val()==-1 ) msj='Debe seleccionar un proyecto';
            if($('#codEmpleadoEvaluador').val()==-1 ) msj='Debe seleccionar un evaluador';
            if($('#codMoneda').val()==-1 ) msj='Debe seleccionar un tipo de moneda';
            if($('#numeroCuentaBanco').val()=='' ) msj='Ingrese una cuenta bancaria';
            if($('#girarAOrdenDe').val()=='' ) msj='Debe ingresar el propietario';
            if($('#codBanco').val()==-1 ) msj='Debe seleccionar un banco';

            if($('#resumen').val()=='' ) msj='Debe ingresar el resumen';
            if($('#cantElementos').val()<=0) msj='Debe ingresar Items';

            if($('#nombresArchivos').val()=="" ) msj='Debe subir los archivos comprobantes de pago.';

            //validamos que todos los items tengan el cod presupuestal correspondiente a su proyecto
            for (let index = 0; index < detalleRepo.length; index++) {
                console.log('Comparando ' + index + " starst:" +detalleRepo[index].codigoPresupuestal.startsWith(codPresupProyecto) )
                if(!detalleRepo[index].codigoPresupuestal.startsWith(codPresupProyecto) )
                {
                    msj="Error: el Código presupuestal del Item N°" 
                    + (index+1) + 
                    ": "+detalleRepo[index].codigoPresupuestal+" debe coincidir con el codigo del proyecto ("
                    +codPresupProyecto+
                    ") ";
                }
            }

            
            if(msj!=''){
                alert(msj);
                return false;
            }
            return true;
        }

        
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
        
    
            detalleRepo.splice(index,1);
           
            console.log('BORRANDO LA FILA' + index);
           
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
            for (let item = 0; item < detalleRepo.length; item++) {
                element = detalleRepo[item];
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
                            '       <input type="text" class="form-control" name="colImporte'+item+'" id="colImporte'+item+'" value="'+(element.importe)+'" readonly="readonly">' +
                            '    </td>               '+
                            '    <td style="text-align:center;">               '+
                            '    <input type="text" class="form-control" name="colCodigoPresupuestal'+item+'" id="colCodigoPresupuestal'+item+'" value="'+element.codigoPresupuestal+'" readonly>' +
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
           
        }
    
    
        var codPresupProyecto = -1;
        function actualizarCodPresupProyecto(){
            codProyecto = $('#codProyecto').val();
            $.get('/obtenerCodigoPresupuestalDeProyecto/'+codProyecto, 
                function(data)
                {   
                    codPresupProyecto = data.substring(0,2); //Pa agarrarle solo los 2 digitos
                    console.log('Se ha actualizado el codPresupuestal del proyecto:[' +codPresupProyecto+"]" );


                }
                );

        }
    
        function agregarDetalle(){


            // VALIDAMOS
            msjError = "";
            fecha = $("#fechaComprobante").val();    
            if (fecha=='') 
                msjError="Por favor ingrese la fecha del comprobante del gasto.";    
                
               
            tipo = $("#ComboBoxCDP").val();    
            if (tipo==-1) 
                msjError="Por favor ingrese el tipo de comprobante del gasto.";    
                
            
            ncbte= $("#ncbte").val();   
            if (ncbte=='') 
                msjError="Por favor ingrese el numero del comprobante del gasto.";    
                
            
                
            concepto=$("#concepto").val();    
            if (concepto=='') 
                msjError="Por favor ingrese el concepto";    
                
            
            codProyecto = $('#codProyecto').val().innerHTML;
            

            importe=$("#importe").val();    
            if (!(importe>0)) 
                msjError="Por favor ingrese un importe válido.";    
                

            codigoPresupuestal=$("#codigoPresupuestal").val();     //el que agregó el user
            if (codigoPresupuestal=='') 
                msjError="Por favor ingrese el codigo presupuestal";    
                
               
            if (importe==0)
                msjError="Por favor ingrese importe";    
            
            console.log('codigoPresupuestal=/'+ codigoPresupuestal +'/ codPresupProyecto=/'+codPresupProyecto + "/");
            console.log('startsWith : ' + codigoPresupuestal.startsWith(codPresupProyecto))
            
            if(!codigoPresupuestal.startsWith(codPresupProyecto) )
                msjError="El código presupuestal debe coincidir con el código del proyecto [" +  codPresupProyecto + "]";


            
            if( codPresupProyecto == -1  )
                msjError="Por favor seleccione un proyecto antes de añadir Items.";    
               

            if(msjError!=""){
                alert(msjError);
                return false;
            }
       
            // FIN DE VALIDACIONES

            detalleRepo.push({
                fecha:fecha,
                tipo:tipo,
                ncbte,ncbte,
                concepto:concepto,
                importe:importe,            
                codigoPresupuestal:codigoPresupuestal
            });        
            cont++;
            actualizarTabla();
    
            $('#ComboBoxCDP').val(0);
            $('#ncbte').val('');
            
            $('#concepto').val('');
            $('#importe').val('');
            $('#codigoPresupuestal').val('');
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
