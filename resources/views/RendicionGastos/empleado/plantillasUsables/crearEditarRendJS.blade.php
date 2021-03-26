{{-- CODIGO QUE SE REUTILIZA EN LAS VISTAS DE CREAR Y EDITAR --}}
<script>

    @if (App\Configuracion::enProduccion)
        document.getElementById('nombresArchivos').type = "hidden"
    @endif

    //se ejecuta cada vez que escogewmos un file
    function cambio(){

        msjError = validarPesoArchivos();
        if(msjError!=""){
            alerta(msjError);
            return;
        }


        listaArchivos="";
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


    function validarPesoArchivos(){
    cantidadArchivos = document.getElementById('filenames').files.length;
    
    msj="";
    for (let index = 0; index < cantidadArchivos; index++) {
        var imgsize = document.getElementById('filenames').files[index].size;
        nombre = document.getElementById('filenames').files[index].name;
        if(imgsize > {{App\Configuracion::pesoMaximoArchivoMB}}*1000*1000 ){
            msj=('El archivo '+nombre+' supera los  {{App\Configuracion::pesoMaximoArchivoMB}}Mb, porfavor ingrese uno más liviano o comprima.');
        }
    }
    

    return msj;

    }

    
    function validarFormEdit(){ //Retorna TRUE si es que todo esta OK y se puede hacer el submit
        msj='';
            
            limpiarEstilos();
            if($('#resumen').val()=='' ){
                cambiarEstilo('resumen','form-control-undefined');
                msj='Debe ingresar la resumen';
            }
            
            if( $('#cantElementos').val()<=0 )
                msj='Debe ingresar Items';

            return msj;
    }
    function getNombreImagen(index){
            string = detalleRend[index].nombreImagen;
            //console.log('el nobmre de la imagen es:'+string);
            if(string==undefined)
                return "Subir Archivo"
            return string;            
    }

      
    function eliminardetalle(index){
        
        detalleRend.splice(index,1);
        
        console.log('BORRANDO LA FILA' + index);
        //cont--;
        actualizarTabla();

    }

    
    function calcularNroEnRendicionMayor(){
        mayor = 0;
        for (let index = 0; index < detalleRend.length; index++) {
            if(mayor < detalleRend[index].nroEnRendicion)
                mayor = detalleRend[index].nroEnRendicion;
        }
        return mayor;
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
                msjError=("Por favor ingrese importe");    
                
            }  


            
            if(msjError!=""){
                alerta(msjError);
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
            var fila=  `
                <tr class="selected" id="fila`+item+`" name="fila` +item+`">            

                            <td style="text-align:center;">              
                                                        
                                <input type="text" class="form-control" name="nroEnRendicion`+item+`" id="nroEnRendicion`+item+`" value="`+element.nroEnRendicion+`" readonly="readonly">
                            </td>               
                            <td style="text-align:center;">              
                                <input type="text" class="form-control" name="colFecha`+item+`" id="colFecha`+item+`" value="`+element.fecha+`" readonly="readonly" style="font-size:10pt;"  >
                            </td>               
                    
                            <td style="text-align:center;">               
                                <input type="text" class="form-control" name="colTipo`+item+`" id="colTipo`+item+`" value="`+element.tipo+`" readonly>
                            </td>             
                    
                            <td style="text-align:center;">              
                                <input type="text" class="form-control" name="colComprobante`+item+`" id="colComprobante`+item+`" value="`+element.ncbte+`" readonly>
                            </td>              
                            <td> 

                                <input type="text" class="form-control" name="colConcepto`+item+`" id="colConcepto`+item+`" value="`+element.concepto+`" readonly>
                            </td>               

                            <td  style="text-align:right;">              
                                <input type="text" class="form-control" name="colImporte`+item+`" id="colImporte`+item+`" value="`+(element.importe)+`" readonly>
                            </td>               
                            <td style="text-align:center;">              
                            <input type="text" class="form-control" name="colCodigoPresupuestal`+item+`" id="colCodigoPresupuestal`+item+`" value="`+element.codigoPresupuestal+`" readonly>
                            </td>              
                            <td style="text-align:center;">               
                                <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle(`+item+`);">
                                    <i class="fa fa-times" ></i>   
                                </button>     
                                <button type="button" class="btn btn-xs" onclick="editarDetalle(`+item+`);">
                                    <i class="fas fa-pen"></i>            
                                </button>  

                            </td>               
                        </tr>                 `;


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

        //alerta('se termino de actualizar la tabla con cont='+cont);
    }
    


    function editarDetalle(index){

        $('#fecha').val( detalleRend[index].fecha );

        $('#ComboBoxCDP').val( detalleRend[index].tipo );
        $('#ncbte').val( detalleRend[index].ncbte );
        $('#concepto').val( detalleRend[index].concepto );
        $('#importe').val( detalleRend[index].importe );
        $('#codigoPresupuestal').val( detalleRend[index].codigoPresupuestal );


        eliminardetalle(index);
    }
</script>
