@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')

<div >
    <p class="h1" style="text-align: center">Editar Rendición de Gastos</p>


</div>


<form method = "POST" action = "{{route('rendicionGastos.update')}}" onsubmit="return validarTextos()"  enctype="multipart/form-data" id="frmrend" name="frmrend">
    
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $solicitud->getEmpleadoSolicitante()->codigoCedepas }}">
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codigoSolicitud" id="codigoSolicitud" value="{{ $solicitud->codSolicitud }}">
    
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
                                        value="{{$rendicion->fechaRendicion}}" >     
                                </div>
                           
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                              <label for="ComboBoxProyecto">Proyecto</label>

                      </div>
                      <div class="col"> {{-- input de proyecto --}}
                          <input readonly type="text" class="form-control" name="proyecto" id="proyecto" value="{{$rendicion->getSolicitud()->getNombreProyecto()}}">    
        
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Colaborador</label>

                      </div>
                      <div class="col">
                            <input  readonly type="text" class="form-control" name="colaboradorNombre" 
                                id="colaboradorNombre" value="{{$rendicion->getSolicitud()->getEmpleadoSolicitante()->getNombreCompleto()}}">    

                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Cod Colaborador</label>

                      </div>

                      <div class="col">
                            <input readonly  type="text" class="form-control" 
                                name="codColaborador" id="codColaborador" value="{{$rendicion->getSolicitud()->getEmpleadoSolicitante()->getNombreCompleto()}}">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Importe Recibido</label>

                      </div>
                      <div class="col">
                            <input readonly  type="text" class="form-control" name="importeRecibido" id="importeRecibido"value="{{number_format($solicitud->totalSolicitado,2)}}">    
                      </div>
                      
                      
                      



                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <label for="fecha">Resumen de la actividad</label>
                            <textarea class="form-control" name="resumen" id="resumen" aria-label="With textarea" style="resize:none; height:100px;">{{$rendicion->resumenDeActividad}}</textarea>
            
                        </div>
                    </div>

                    <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                        <div class="row">
                            <div  class="col">
                                    <label for="fecha">Cod Rendicion</label>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="codRendicion" id="codRendicion" readonly value="{{$rendicion->codRendicionGastos}}">     
                            </div>


                            <div class="w-100"></div> {{-- SALTO LINEA --}}
                            <div  class="col">
                                    <label for="codSolicitud">Codigo Solicitud de Fondos</label>
                            </div>
                            <div class="col">
                                    <input value="{{$solicitud->codigoCedepas}}" type="text" class="form-control" name="codSolicitud" id="codSolicitud" readonly>     
                            </div>
                            <div class="w-100"></div> {{-- SALTO LINEA --}}

                            <div  class="col">
                                    <label for="estado">Estado de <br> la Rendición
                                        @if($rendicion->verificarEstado('Observada')){{-- Si está observada --}}& Observación @endif:</label>
                            </div>
                            <div class="col"> {{-- Combo box de estado --}}
                                <input readonly type="text" class="form-control" name="estado" id="estado"
                                style="background-color: {{$rendicion->getColorEstado()}} ;
                                    color:{{$rendicion->getColorLetrasEstado()}};   
                                "
                                readonly value="{{$rendicion->getNombreEstado()}}@if($rendicion->verificarEstado('Observada')): {{$rendicion->observacion}}@endif"  >           
                            </div>










                        </div>
                    </div>

                </div>

                
                
            </div>
        </div>
      </div>
    
      
      <br>
        @include('SolicitudFondos.listadoDesplegableSolicitud')  


        {{-- LISTADO DE DETALLES  --}}
        <div class="col-md-12 pt-3">     
            <div class="table-responsive">                           
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                    <thead >
                        <th></th>
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
                                    class="btn btn-success" onclick="agregarDetalle()" >
                                    <i class="fas fa-plus"></i>
                                     Agregar
                                </button>
                            </div>      
                        
                        </th>                                            
                     
                    </thead>
                    
                    
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th width="5%" class="text-center">#</th>                                        
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
                    <div class="col">
                        @include('RendicionGastos.desplegableDescargarArchivosRend')
                        
                    </div>


                    <div class="col">
                        <div class="row">
                          
                            <div class="col">                        
                                <label for="">Total Gastado: </label>    
                            </div>   
                            <div class="col">
                                {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                                <input type="hidden" name="cantElementos" id="cantElementos">                              
                                <input type="hidden" name="totalRendido" id="totalRendido">                              
                                <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly">   

                            </div>   
                            
                            <div class="w-100"></div>

                            <div class="col">                        
                                <label for="">Total Recibido: </label>    
                            </div>   
                            <div class="col">                       
                                <input type="text" class="form-control text-right" name="totalRecibido" 
                                    id="totalRecibido" readonly="readonly" value="{{number_format($solicitud->totalSolicitado,2)}}">                              
                            </div>   

                            <div class="w-100"></div>  

                            <div class="col">                        
                                <label id="labelAFavorDe" for="">Saldo a favor del Empl: </label>    
                            </div>   

                            <div class="col">                     
                                <input type="text" class="form-control text-right"  
                                    name="saldoAFavor" id="saldoAFavor" readonly="readonly"  value="0.00">                              
                            </div>   

                            <div class="w-100"></div>
                            
                            {{-- Este es para subir todos los archivos x.x  --}}
                            <div class="col" id="divEnteroArchivo">            
                                <input type="text" name="nombresArchivos" id="nombresArchivos" value="">
                                <input type="file" multiple class="btn btn-primary" name="filenames[]" id="filenames"        
                                        style="display: none" onchange="cambio()">  
                                                <input type="hidden" name="nombreImgImagenEnvio" id="nombreImgImagenEnvio">                 
                                <label class="label" for="filenames" style="font-size: 12pt;">       
                                    <div id="divFileImagenEnvio" class="hovered">       
                                        Subir nuevos archivos comprobantes  
                                    <i class="fas fa-upload"></i>        
                                    </div>       
                                </label>       
                            </div>  

                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    
                    






                </div>
                    

                
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group"><!--
                    <button class="btn btn-primary" type="submit"
                        id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                        <i class='fas fa-save'></i> 
                        Actualizar
                    </button>    -->
                    <button type="button" class="btn btn-primary float-right" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" onclick="swal({//sweetalert
                        title:'¿Seguro de editar la rendicion?',
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
                            document.frmrend.submit();
                        }
                        
                    });"><i class='fas fa-save'></i> Actualizar</button>
                   
                    <a href="{{route('solicitudFondos.listarEmp')}}" class='btn btn-info float-left'><i class='fas fa-arrow-left'></i> Regresar al Menu</a>              
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
        
        var IGV=0;
        var total=0;
        var detalleRend=[];
        var importes=[];
        var controlproducto=[];
        var totalSinIGV=0;
        var saldoFavEmpl=0;
        var codPresupProyecto = "{{$solicitud->getProyecto()->codigoPresupuestal}}";

    
        $(document).ready(function(){
            cargarDetallesRendicion();
    
        });
        
        var listaArchivos = '';  
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

        function cargarDetallesRendicion(){

            //console.log('aaaa ' + '/listarDetallesDeRendicion/'+{{$rendicion->codRendicionGastos}});
            //obtenemos los detalles de una ruta GET 
            $.get('/listarDetallesDeRendicion/'+{{$rendicion->codRendicionGastos}}, function(data)
            {      
                listaDetalles = data;
                    for (let index = 0; index < listaDetalles.length; index++) {     
                        
                        
                        
                        detalleRend.push({
                            codDetalleRendicion:    listaDetalles[index].codDetalleRendicion,
                            nroEnRendicion:         listaDetalles[index].nroEnRendicion,
                            fecha:                  listaDetalles[index].fechaFormateada,
                            tipo:                   listaDetalles[index].nombreTipoCDP,
                            ncbte:                  listaDetalles[index].nroComprobante,
                            concepto:               listaDetalles[index].concepto,
                            nombreImagen:           listaDetalles[index].nombreImagen,
                            importe:                listaDetalles[index].importe,            
                            codigoPresupuestal:     listaDetalles[index].codigoPresupuestal
                        });        
                    }
                    actualizarTabla();                

            });
        }




        function alertaArchivo(){
            alert('Asegúrese de haber añadido todos los ítems antes de subir los archivos.');

        }

        function validarTextos(){ //Retorna TRUE si es que todo esta OK y se puede hacer el submit
            msj='';
            
            if($('#resumen').val()=='' )
                msj='Debe ingresar el resumen';
            
            if( $('#cantElementos').val()<=0 )
                msj='Debe ingresar Items';


           

            if(msj!='')
            {
                alert(msj)
                return false;
            }

            return true;
        }

    
        
    
        /* Eliminar productos */
        function eliminardetalle(index){
            
            detalleRend.splice(index,1);
           
            console.log('BORRANDO LA FILA' + index);
            //cont--;
            actualizarTabla();
    
        }
        
    
        function getNombreImagen(index){
            string = detalleRend[index].nombreImagen;
            //console.log('el nobmre de la imagen es:'+string);
            if(string==undefined)
                return "Subir Archivo"
            return string;            
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
                            '                               '+
                            '       <input type="text" class="form-control" name="nroEnRendicion'+item+'" id="nroEnRendicion'+item+'" value="'+element.nroEnRendicion+'" readonly="readonly">'   +
                            '    </td>               '+

                            '    <td style="text-align:center;">               '+
                            '       <input type="text" class="form-control" name="colFecha'+item+'" id="colFecha'+item+'" value="'+element.fecha+'" readonly="readonly" style="font-size:10pt;"  >'   +
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
            $('#totalRendido').val(total); //el que se va a leer
            

            var totalGastado= parseFloat(total)    ;
            var totalRecibido= parseFloat( {{$solicitud->totalSolicitado}}  ); 
            //console.log(' total= '+total +'       tot2= ' +{{$solicitud->totalSolicitado}});

            saldoFavEmpl = (totalGastado)-(totalRecibido);
            

            
            
            //console.log("{{Carbon\Carbon::now()->format('d/m/Y')}}" );
            $('#fechaComprobante').val( "{{Carbon\Carbon::now()->format('d/m/Y')}}" );
        
            
            $('#cantElementos').val(cont);
            


            if(saldoFavEmpl>0){ //recibido < gastado -> el empleado debe recibir dinero de cedepas para reponer
                $('#saldoAFavor').val(  saldoFavEmpl  ); //puedo hacer esto sin que haya el error pq el input esta disabled
           
              

                document.getElementById("labelAFavorDe").innerHTML= "Saldo a Favor del empleado";
            }else{ //recibido > gastado el empleado debe enviar el dinero que no uso
                $('#saldoAFavor').val(  -saldoFavEmpl  ); //puedo hacer esto sin que haya el error pq el input esta disabled
               
                document.getElementById("labelAFavorDe").innerHTML= "Saldo a Favor de Cedepas";
            }

            //alert('se termino de actualizar la tabla con cont='+cont);
        }
    
    
    
    
        function agregarDetalle()
        {

            msjError="";
            // VALIDAMOS
            codigoPresupuestal=$("#codigoPresupuestal").val();    


            console.log('codigoPresupuestal=/'+ codigoPresupuestal +'/ codPresupProyecto=/'+codPresupProyecto + "/");
            console.log('startsWith : ' + codigoPresupuestal.startsWith(codPresupProyecto))
            
            if(!codigoPresupuestal.startsWith(codPresupProyecto) )
                msjError="El código presupuestal debe coincidir con el código del proyecto [" +  codPresupProyecto + "]";

           
            
            fecha = $("#fechaComprobante").val();    
            if (fecha=='') 
            {
                msjError=("Por favor ingrese la fecha del comprobante del gasto.");    
                
            }   
            tipo = $("#ComboBoxCDP").val();    
            if (tipo==-1) 
            {
                msjError=("Por favor ingrese el tipo de comprobante del gasto.");    
                
            }
            ncbte= $("#ncbte").val();   
             
            if (ncbte=='') 
            {
                msjError=("Por favor ingrese el numero del comprobante del gasto.");    
                
            }
             
            concepto=$("#concepto").val();    
            if (concepto=='') 
            {
                msjError=("Por favor ingrese el concepto");    
                
            }    
              
            
    
            importe=$("#importe").val();    
            if (!(importe>0)) 
            {
                msjError=("Por favor ingrese un importe válido.");    
                
            }    
            
            
            if (codigoPresupuestal=='') 
            {
                msjError=("Por favor ingrese el codigo presupuestal");    
                
            }    
    
            if (importe==0)
            {
                msjError=("Por favor ingrese precio de venta del producto");    
                
            }  


            
            if(msjError!=""){
                alert(msjError);
                return false;
            }
            
            // FIN DE VALIDACIONES
    
                item = cont+1;   
                
                maximo = calcularNroEnRendicionMayor()+1;
                detalleRend.push({
                    nroEnRendicion: maximo,
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
            /* $('#fechaComprobante').val(''); */
            $('#ComboBoxCDP').val(0);
            $('#ncbte').val('');
            
            $('#concepto').val('');
            $('#importe').val('');
            $('#codigoPresupuestal').val('');
            
    }
    
    function calcularNroEnRendicionMayor(){
        mayor = 0;
        for (let index = 0; index < detalleRend.length; index++) {
            if(mayor < detalleRend[index].nroEnRendicion)
                mayor = detalleRend[index].nroEnRendicion;
        }
        return mayor;
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
