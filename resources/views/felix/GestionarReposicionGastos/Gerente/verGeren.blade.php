@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div >
    <p class="h1" style="text-align: center">Evaluar Reposicion de Gastos</p>


</div>


<form method = "POST" action = "{{route('reposicionGastos.store')}}" onsubmit="return validarTextos()"  enctype="multipart/form-data">
    
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
                        <input type="text" class="form-control" name="codProyecto" 
                            id="codProyecto" value="{{$reposicion->getProyecto()->nombre}}" disabled>
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
                            <label for="fecha">Banco</label>

                      </div>

                      <div class="col">
                        <input type="text" class="form-control" name="codBanco" id="codBanco" value="{{$reposicion->getBanco()->nombreBanco}}" disabled>  
                      </div>
                      
                    </div>


                </div>{{-- Fin container --}}

            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <label for="fecha">Resumen de la actividad</label>
                            <textarea class="form-control" name="resumen" id="resumen" aria-label="With textarea" style="resize:none; height:100px;" disabled>{{$reposicion->resumen}}</textarea>
            
                        </div>
                    </div>

                    <div class="container row"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}
                      <div  class="col">
                            <label for="fecha">CuentaBancaria</label>

                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="numeroCuentaBanco" id="numeroCuentaBanco" value="{{$reposicion->numeroCuentaBanco}}" disabled>  
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="col">
                            <label for="fecha">Girar a Orden de </label>

                      </div>
                      <div class="col">
                        <input type="text" class="form-control" name="girarAOrdenDe" id="girarAOrdenDe" value="{{$reposicion->girarAOrdenDe}}" disabled>  
                      </div>
                    </div>

                </div>

                
                
            </div>
        </div>
    </div>
    
      
      
         


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
                <div class="col"> 


                    {{-- <nav id="colorNav">
                        <ul>
                            <li class="green">
                                <a href="#" class="icon-home">Descargar Archivos Comprobantes</a>
                                <ul>

                                    @for($i = 1; $i <= $reposicion->cantArchivos; $i++)
                                        <li>
                                            <a href="{{route('reposicionGastos.descargarCDP',$reposicion->codReposicionGastos.'*'.$i)}}" class="nav-link">
                                                <i class="far fa-address-card nav-icon"></i>
                                                <p>   {{App\ReposicionGastos::getFormatoNombreCDP($reposicion->codReposicionGastos,$i,$reposicion->getTerminacionNro($i)) }}</p>
                                            </a>
                                        </li>    
                                    @endfor
                                    <li> <a href="">hola</a></li>
                                    
                                    <!-- More dropdown options -->
                                </ul>
                            </li>
                        </ul>
                    </nav> --}}

 
                        <ul class="nav nav-pills nav-sidebar flex-column" 
                            data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                    Descargar Archivos Comprobantes
                                    <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @for($i = 1; $i <= $reposicion->cantArchivos; $i++)
                                        <li class="nav-item">
                                            <a href="{{route('reposicionGastos.descargarCDP',$reposicion->codReposicionGastos.'*'.$i)}}" class="nav-link">
                                                <i class="far fa-address-card nav-icon"></i>
                                                <p>   {{App\ReposicionGastos::getFormatoNombreCDP($reposicion->codReposicionGastos,$i,$reposicion->getTerminacionNro($i)) }}</p>
                                            </a>
                                        </li>    
                                    @endfor
                                </ul>
                            </li> 
                        </ul>
                      





                </div>
                
                <div class="col"></div>

                <div class="col-md-2">                        
                    <label for="">Total Gastado: </label>    
                </div>   
                <div class="col-md-2">
                    {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                    <input type="hidden" name="cantElementos" id="cantElementos">
                    <input type="hidden" name="codigoCedepas" id="codigoCedepas">                          
                    <input type="hidden" name="totalRendido" id="totalRendido">

                    <input type="text" class="form-control text-right" name="total"
                            id="total" readonly="readonly" value="{{number_format($total,2)}}">   

                </div>   

            </div>


            <br>
            <div class="row">
                @if($reposicion->verificarEstado('Creada') || $reposicion->verificarEstado('Subsanada') )
                <div class="col-md-9">
                    <label for="fecha">Observaciones</label>
                    <textarea class="form-control" name="observacion" id="observacion" aria-label="With textarea" style="resize:none; height:100px;"></textarea>
                    <a href="#" class="btn btn-warning" onclick="observar()">Observar</a>
                </div>
                <div class="col-md-3">
                    <a href="{{route('reposicionGastos.aprobar',$reposicion->codReposicionGastos)}}" class="btn btn-success float-right"><i class="entypo-pencil"></i>Aceptar</a>
                    <a href="{{route('reposicionGastos.rechazar',$reposicion->codReposicionGastos)}}" class="btn btn-danger float-right"><i class="entypo-pencil"></i>Rechazar</a>  
                </div>    
                @endif
                
            </div>
                
           
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    <a href="{{route('reposicionGastos.listarRepoOfGerente',$empleadoLogeado->codEmpleado)}}" class='btn btn-info'>Regresar</a>              
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

/* PARA MI MENU DESPLEGABLE NUEVO */
#colorNav > ul{
 width: 450px;
 margin:0 auto;
}
#colorNav > ul > li{ /* will style only the top level li */
 list-style: none;
 box-shadow: 0 0 10px rgba(100, 100, 100, 0.2) inset,1px 1px 1px #CCC;
 display: inline-block;
 line-height: 1;
 margin: 1px;
 border-radius: 3px;
 position:relative;
}

#colorNav > ul > li > a{
 color:inherit;
 text-decoration:none !important;
 font-size:24px;
 padding: 25px;
}
#colorNav li ul{
 position:absolute;
 list-style:none;
 text-align:center;
 width:180px;
 left:50%;
 margin-left:-90px;
 top:70px;
 font:bold 12px 'Open Sans Condensed', sans-serif;
 
/* This is important for the show/hide CSS animation */
 max-height:0px;
 overflow:hidden;
 
-webkit-transition:max-height 0.4s linear;
 -moz-transition:max-height 0.4s linear;
 transition:max-height 0.4s linear;
}
#colorNav li:hover ul{
 max-height:200px;
}

#colorNav li ul li{
 background-color:#313131;
}
 
#colorNav li ul li a{
 padding:12px;
 color:#fff !important;
 text-decoration:none !important;
 display:block;
}
 
#colorNav li ul li:nth-child(odd){ /* zebra stripes */
 background-color:#363636;
}
 
#colorNav li ul li:hover{
 background-color:#444;
}
 
#colorNav li ul li:first-child{
 border-radius:3px 3px 0 0;
 margin-top:25px;
 position:relative;
}
 
#colorNav li ul li:first-child:before{ /* the pointer tip */
 content:'';
 position:absolute;
 width:1px;
 height:1px;
 border:5px solid transparent;
 border-bottom-color:#313131;
 left:50%;
 top:-10px;
 margin-left:-5px;
}
 
#colorNav li ul li:last-child{
 border-bottom-left-radius:3px;
 border-bottom-right-radius:3px;
}
#colorNav li.green{
 /* This is the color of the menu item */
 background-color:#00c08b;
 
/* This is the color of the icon */
 color:#127a5d;
}
 
#colorNav li.red{ background-color:#ea5080;color:#aa2a52;}
#colorNav li.blue{ background-color:#53bfe2;color:#2884a2;}
#colorNav li.yellow{ background-color:#f8c54d;color:#ab8426;}
#colorNav li.purple{ background-color:#df6dc2;color:#9f3c85;}


</style>

@section('script')



       {{-- PARA EL FILE  --}}
    <script type="application/javascript">
    //se ejecuta cada vez que escogewmos un file

        function observar(){
            texto=$('#observacion').val();
            if(texto!=''){
                reposicion=$('#codReposicionGastos').val();
                window.location.href='/Reposicion/'+reposicion+'*'+texto+'/observar';  
            }
            else{ 
                alert('Ingrese observacion');
            }
        }

        


        var cont=0;
        
        //var IGV=0;
        var total=0;
        var detalleRend=[];
        //var importes=[];
        //var controlproducto=[];
        //var totalSinIGV=0;
        //var saldoFavEmpl=0;

        

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
