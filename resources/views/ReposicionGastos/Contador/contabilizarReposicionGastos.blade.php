@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div class="row">
    <div class="col-md-10">
        <p class="h1" style="text-align:center">
            @if($reposicion->verificarEstado('Abonada'))
            Contabilizar
            @else 
            Ver
            @endif
            
            
            Reposicion de Gastos</p>
        </p>
    </div>

    <div class="col-md-2">
        <br>
        <a  href="{{route('ReposicionGastos.exportarPDF',$reposicion->codReposicionGastos)}}" 
            class="btn btn-warning btn-sm btn-right" style="margin-left:60px;">
            <i class="entypo-pencil"></i>
            PDF
            </a>
        <a target="blank" href="{{route('ReposicionGastos.verPDF',$reposicion->codReposicionGastos)}}" 
            class="btn btn-warning btn-sm btn-right">
            <i class="entypo-pencil"></i>
            verPDF
        </a>
    </div>
</div>
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
        width: 30%;
        /* background-color: #3c8dbc; */
        margin-top: 20px;
        text-align: left;
    }


</style>


<form method = "POST" action = "{{route('ReposicionGastos.Empleado.store')}}" onsubmit="return validarTextos()"  enctype="multipart/form-data">
    
    {{-- CODIGO DEL EMPLEADO --}}
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codEmpleado" id="codEmpleado" value="{{$reposicion->codEmpleadoSolicitante}}">
    <input type="hidden" name="codReposicionGastos" id="codReposicionGastos" value="{{$reposicion->codReposicionGastos}}">
    
    @csrf
   
    
    <div class="container" >
        <div class="row">           
            <div class="col-md"> {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                        <div  class="colLabel">
                                <label for="fecha">Fecha</label>
                        </div>
                        <div class="col">
                                                
                                    <div class="input-group date form_date" style="width: 100px;" data-date-format="dd/mm/yyyy" data-provide="datepicker">
                                        <input type="text"  class="form-control" name="fechaHoy" id="fechaHoy" disabled
                                            value="{{$reposicion->getFechaHoraEmision()}}" >     
                                    </div>
                            
                        </div>

                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel">
                                <label for="ComboBoxProyecto">Proyecto</label>

                        </div>
                        <div class="col"> {{-- input de proyecto --}}
                            <input type="text" class="form-control" name="codProyecto" id="codProyecto" value="{{$reposicion->getProyecto()->nombre}}" disabled>
                        </div>
                    
                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel">
                                <label for="fecha">Moneda</label>

                        </div>

                        <div class="col">
                            <input type="text" class="form-control" name="codMoneda" id="codMoneda" value="{{$reposicion->getMoneda()->nombre}}" disabled>
                        </div>
                        

                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel">
                                <label for="fecha">Banco</label>

                        </div>

                        <div class="col">
                            <input type="text" class="form-control" name="codBanco" id="codBanco" value="{{$reposicion->getBanco()->nombreBanco}}" disabled>  
                        </div>



                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel">
                                <label for="fecha">Codigo Cedepas</label>

                        </div>

                        <div class="col">
                            <input type="text" class="form-control" name="" id="" value="{{$reposicion->codigoCedepas}}" disabled>  
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <label for="fecha">Resumen de la actividad</label>
                            <textarea class="form-control" name="resumen" id="resumen" 
                                aria-label="With textarea" style="resize:none; height:50px;" disabled
                                >{{$reposicion->resumen}}</textarea>
            
                        </div>
                    </div>

                    <div class="container row"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}
                    <div  class="colLabel2">
                            <label for="fecha">CuentaBancaria</label>

                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="numeroCuentaBanco" id="numeroCuentaBanco" 
                        value="{{$reposicion->numeroCuentaBanco}}" readonly>  
                    </div>

                    <div class="w-100"></div> {{-- SALTO LINEA --}}
                    <div  class="colLabel2">
                            <label for="fecha">Girar a Orden de </label>

                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="girarAOrdenDe" id="girarAOrdenDe" 
                        value="{{$reposicion->girarAOrdenDe}}" readonly>  
                    </div>

                    <div class="w-100"></div>
                    <div class="colLabel2">
                        <label for="">Estado:</label>
                    </div>

                    <div class="col">
                        <input type="text" value="{{$reposicion->getNombreEstado()}}" class="form-control" readonly 
                            style="background-color: {{$reposicion->getColorEstado()}};
                                    width:95%;
                                    color: {{$reposicion->getColorLetrasEstado()}} ;
                            ">
                    </div>





                    </div>

                </div>

                
                
            </div>
        </div>
    </div>
    <br>
         
    <div class="table-responsive">                           
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
            
            <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                <th width="11%" class="text-center">Fecha Cbte</th>                                        
                <th width="14%">Tipo</th>                                 
                <th width="11%"> N° Cbte</th>
                <th width="26%" class="text-center">Concepto </th>
            
                <th width="11%" class="text-center">Importe </th>
                <th width="11%" class="text-center">Cod Presup </th>                                         
                <th>Contabilizar</th>
            </thead>
            <tfoot>

                                                                                
            </tfoot>
            <tbody>
          
                @foreach($detalles as $itemdetalle)
                    <tr>
                        <td>{{$itemdetalle->fechaComprobante}}</td>
                        <td>{{$itemdetalle->getNombreTipoCDP()}}</td>
                        <td>{{$itemdetalle->nroComprobante}}</td>
                        <td>{{$itemdetalle->concepto}}</td>
                
                        <td>{{number_format($itemdetalle->importe,2)}}</td>
                       
                        <td>{{$itemdetalle->codigoPresupuestal}}</td>
                        <td style="text-align:center;">               
                            <input type="checkbox"  readonly
                            @if($reposicion->verificarEstado('Contabilizada')) {{-- Ya está contabilizada --}}
                                @if($itemdetalle->contabilizado=='1')
                                    checked
                                @endif    
                                onclick="return false;"
                            @else {{-- Caso normal cuando se está contabilizando --}}
                                onclick="contabilizarItem({{$itemdetalle->codDetalleReposicion}})"
                            @endif
                            
                            >
                        </td>    
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> 
    
            
              
    <input type="text" id="listaContabilizados" 
    name = "listaContabilizados" value="">

    <div class="row" id="divTotal" name="divTotal">     
        <div class="col">
            @include('ReposicionGastos.desplegableDescargarArchivosRepo')

        </div>
        
        <div class="col">
            <div class="row">
                
                <div class="col">                        
                    <label for="">Total Gastado: </label>    
                </div>   
                <div class="col">
                    {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                    <input type="hidden" name="cantElementos" id="cantElementos">
                    <input type="hidden" name="codigoCedepas" id="codigoCedepas">                          
                    <input type="hidden" name="totalRendido" id="totalRendido">

                    <input type="text" class="form-control text-right" 
                        name="total" id="total" readonly="readonly" value="{{$reposicion->getMoneda()->simbolo}} {{number_format($reposicion->totalImporte,2)}}">   

                </div>   
                <div class="w-100"></div>
                <div class="col"></div>
                <div class="col">
                    @if($reposicion->codEstadoReposicion==3)
                    <button type="button" class='btn btn-success float-right'  style="float:right;" onclick="actualizarEstado('¿Seguro de contabilizar la reposicion?', 'Contabilizar')">
                        <i class="fas fa-check"></i> Guardar como Contabilizado</button>
                    <!--
                    <button type="button" onclick="guardarContabilizar()"
                            class='btn btn-success'  style="float:right;">
                            <i class="fas fa-check"></i>
                            Guardar como Contabilizado
                        </button>    
                    -->
                    @endif
                </div>


            </div>
        </div>

        

    
    </div>

    
    <br>
        
    
    <div class="col-md-12 text-center">  
        <div id="guardar">
            <div class="form-group">
                <a href="{{route('ReposicionGastos.Contador.listar',$empleadoLogeado->codEmpleado)}}" 
                    class='btn btn-info float-left float-left'><i class="fas fa-arrow-left"></i> Regresar al Menu</a>              
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


    .hovered:hover{
    background-color:rgb(97, 170, 170);
    
}

    input[type='checkbox'] {
        /* -webkit-appearance:none; */
        width:25px;
        height:25px;
        background:white;
        border-radius:15px;
        border:2px solid #555;
    }
    input[type='checkbox']:checked {
        background: #abd;
    }

    </style>

@section('script')



       {{-- PARA EL FILE  --}}
<script type="application/javascript">
    @if (App\Configuracion::enProduccion)
        document.getElementById('listaContabilizados').type = "hidden"
    @endif


    function actualizarEstado(msj, action){
        swal({//sweetalert
            title: msj,
            text: '',
            type: 'warning',  
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText:  'SI',
            cancelButtonText:  'NO',
            closeOnConfirm:     true,//para mostrar el boton de confirmar
            html : true
        },
        function(){//se ejecuta cuando damos a aceptar
            switch (action) {
                case 'Observar':

                    break;
                case 'Contabilizar':
                    guardarContabilizar();
                    break;
            }
            
        });
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


        function alertaArchivo(){
            alerta('Asegúrese de haber añadido todos los ítems antes de subir los archivos.');

        }

        var listaItems = [];//para contabilizar
        function contabilizarItem(item){
            
            if( listaItems.indexOf(item)==-1  )
            { //no lo tiene 
                listaItems.push(item);
            }
            else 
            { //ya lo tiene, lo quitamos
                let pos = listaItems.indexOf(item);
                listaItems.splice(pos,1);
                
            }
           
            $('#listaContabilizados').val(listaItems);

        }

        function guardarContabilizar (){
            codReposicion = {{$reposicion->codReposicionGastos}};
            //location.href = '/Conta/Reposiciones/contabilizar/'+ codReposicion +'*' +listaItems;
            location.href = '/ReposicionGastos/'+ codReposicion +'*' +listaItems+'/Contabilizar';
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
