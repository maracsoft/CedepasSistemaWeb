@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h1" style="text-align: center">Registrar Reposicion de Gastos</p>


</div>


<form method = "POST" action = "{{route('reposicionGastos.store')}}" onsubmit="return validarTextos()"  enctype="multipart/form-data">
    
    {{-- CODIGO DEL EMPLEADO --}}
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codEmpleado" id="codEmpleado" value="{{$reposicion->codEmpleadoSolicitante}}">
    
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
                                        value="{{$reposicion->fechaEmision}}" >     
                                </div>
                           
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                              <label for="ComboBoxProyecto">Proyecto</label>

                      </div>
                      <div class="col"> {{-- input de proyecto --}}
                        <input type="text" class="form-control" name="codProyecto" id="codProyecto" value="{{$reposicion->getProyecto()->nombre}}" disabled>
                      </div>
                      <!--
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Evaluador</label>

                      </div>
                      <div class="col">
                        <select class="form-control"  id="codEmpleadoEvaluador" name="codEmpleadoEvaluador" >
                            <option value="-1">Seleccionar</option>

                        </select> 
                      </div>
                        -->
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Moneda</label>

                      </div>

                      <div class="col">
                        <input type="text" class="form-control" name="codMoneda" id="codMoneda" value="{{$reposicion->getMoneda()->nombre}}" disabled>
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">CuentaBancaria</label>

                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="numeroCuentaBanco" id="numeroCuentaBanco" value="{{$reposicion->numeroCuentaBanco}}" disabled>  
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Orden de </label>

                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="girarAOrdenDe" id="girarAOrdenDe" value="{{$reposicion->girarAOrdenDe}}" disabled>  
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Banco</label>

                      </div>

                      <div class="col">
                        <input type="text" class="form-control" name="codBanco" id="codBanco" value="{{$reposicion->getBanco()->nombreBanco}}" disabled>  
                      </div>
                      
                      
                      



                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <label for="fecha">Resumen de la actividad</label>
                            <textarea class="form-control" name="resumen" id="resumen" aria-label="With textarea" style="resize:none; height:100px;" disabled>{{$reposicion->resumen}}</textarea>
            
                        </div>
                    </div>

                    <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}
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
                        <th width="11%" class="text-center">Fecha Cbte</th>                                        
                        <th width="14%">Tipo</th>                                 
                        <th width="11%"> N° Cbte</th>
                        <th width="26%" class="text-center">Concepto </th>
                        <th width="11%">
                            Archivo
                        </th>
                        <th width="11%" class="text-center">Importe </th>
                        <th width="11%" class="text-center">Cod Presup </th>                                         
                        
                    </thead>
                    <tfoot>

                                                                                        
                    </tfoot>
                    <tbody>
                        <?php $total=0;?>
                        @foreach($detalles as $itemdetalle)
                            <tr>
                                <td>{{$itemdetalle->fechaComprobante}}</td>
                                <td>{{$itemdetalle->getNombreTipoCDP()}}</td>
                                <td>{{$itemdetalle->nroComprobante}}</td>
                                <td>{{$itemdetalle->concepto}}</td>
                                <td></td>
                                <td>{{$itemdetalle->importe}}</td>
                                <?php $total+=$itemdetalle->importe;?>
                                <td>{{$itemdetalle->codigoPresupuestal}}</td>
                            </tr>
                        @endforeach
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

                        <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly" value="{{number_format($total,2)}}">   

                    </div>   

                    <div class="w-100">

                    </div>
                    <div class="col-md-8"></div>

                </div>
                    

                
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    <a href="{{route('reposicionGastos.listar',$empleadoLogeado->codEmpleado)}}" class='btn btn-danger'>Regresar</a>              
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

    function cambio(index){

        if(index=='imagenEnvio'){//si es pal comprobante de envio
            
            //DEPRECADO PORQUE AHORA EL ARCHIVO DE CBTE DE DEVOLUCION DE FONDOS SE ADJUNTA COMO UN CBTE MÁS
            /* var idname= 'imagenEnvio'; 
            var filename = $('#imagenEnvio').val().split('\\').pop();
            console.log('filename= '+filename+'    el id es='+idname+'  el index es '+index)
            jQuery('span.'+idname).next().find('span').html(filename);
            document.getElementById("divFileImagenEnvio").innerHTML= filename;
            $('#nombreImgImagenEnvio').val(filename);
             */
        }
        else{ //para los CDP de la tabla
            var idname= 'imagen'+index; 
            var filename = $('#imagen'+index).val().split('\\').pop();
            console.log('filename= '+filename+'    el id es='+idname+'  el index es '+index)
            //jQuery('span.'+idname).next().find('span').html(filename);
            document.getElementById("divFile"+index).innerHTML= filename;
            $('#nombreImg'+index).val(filename);
            
        
        }
    
    }


</script>

     <script>
        var cont=0;
        
        //var IGV=0;
        var total=0;
        var detalleRend=[];
        //var importes=[];
        //var controlproducto=[];
        //var totalSinIGV=0;
        //var saldoFavEmpl=0;

                //GENERACION DE codigoCedepas
                var d = new Date();
                codEmp = $('#codigoCedepasEmpleado').val();
                mes = (d.getMonth()+1.0).toString();
                if(mes.length > 0) mes = '0' + mes;

                year =  d.getFullYear().toString().substr(2,2)  ;
                $('#codigoCedepas').val( codEmp +'-'+ d.getDate() +mes + year + cadAleatoria(2));
                //alert($('#codigoCedepas').val());
    
        

        function alertaArchivo(){
            alert('Asegúrese de haber añadido todos los ítems antes de subir los archivos.');

        }

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