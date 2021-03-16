@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')
<div >
    <p class="h1" style="text-align: center">
        Ver Rendicion de Gastos
    </p>
</div>

<form method = "POST" action = "{{route('rendicionGastos.reponer')}}"  enctype="multipart/form-data" >
    
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $empleado->codigoCedepas }}">
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codigoSolicitud" id="codigoSolicitud" value="{{ $solicitud->codSolicitud }}">
    <input type="hidden" name="codRendicionGastos" id="codRendicionGastos" value="{{ $rend->codRendicionGastos }}">
    

    @csrf
    <div class="container" >
        <div class="row">           
            <div class="col-md" > {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div class="colLabel">
                            <label for="fecha">Fecha:</label>
                      </div>
                      <div class="col">
                                                   
                                <div class="input-group date form_date " style="width: 100px;" >
                                    <input type="text"  class="form-control" name="fechaHoy" id="fechaHoy" disabled
                                        value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" >     
                                </div>
                          
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                              <label for="ComboBoxProyecto">Proyecto:</label>

                      </div>
                      <div class="col"> {{-- input de proyecto --}}
                          <input readonly type="text" class="form-control" name="proyecto" id="proyecto" value="{{$solicitud->getNombreProyecto()}}">    
        
                      </div>

                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="fecha">Colaborador:</label>

                      </div>
                      <div class="col">
                            <input  readonly type="text" class="form-control" name="colaboradorNombre" id="colaboradorNombre" value="{{$empleado->nombres}}">    

                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="fecha">Cod Colaborador:</label>

                      </div>

                      <div class="col">
                            <input readonly  type="text" class="form-control" name="codColaborador" 
                            id="codColaborador" value="{{$empleado->codigoCedepas}}">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div class="colLabel">
                            <label for="fecha">Importe Recibido:</label>

                      </div>
                      <div class="col">
                            <input readonly  type="text" class="form-control" name="importeRecibido" 
                            id="importeRecibido" value="{{$solicitud->totalSolicitado}}">    
                      </div>
                      
                      
                      



                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <label for="fecha">Resumen de la actividad:</label>
                            <textarea class="form-control" name="resumen" id="resumen" readonly aria-label="With textarea"
                             style="resize:none; height:100px;">{{$rend->resumenDeActividad}}</textarea>
            
                        </div>
                    </div>

                    <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                        <div class="row">
                            <div class="colLabel">
                                <label for="fecha">Cod Rendicion:</label>
                            </div>
                            <div class="col">
                                 <input type="text" class="form-control" name="codRendicion" id="codRendicion" readonly value="{{$rend->codigoCedepas}}">     
                            </div>
                            <div  class="colLabel">
                                <label for="ComboBoxSede">Moneda</label>
                            </div>
                            <div class="col"> {{-- Combo box de sede --}}
                                <input readonly  type="text" class="form-control" name="moneda" id="moneda" 
                                    readonly value="{{$solicitud->getMoneda()->nombre}}">     
                                        
                            </div>

                            <div class="w-100"></div> {{-- SALTO LINEA --}}
                            <div class="colLabel">
                                    <label for="codSolicitud">Cod Sol. Fondos:</label>

                            </div>
                            <div class="col">
                                    <input value="{{$solicitud->codigoCedepas}}" type="text" class="form-control" name="codSolicitud" id="codSolicitud" readonly>     
                            </div>


                            <div class="w-100"></div> {{-- SALTO LINEA --}}
                            <div class="col"> 
                        {{--  --}}

                              
                                {{--  --}}

                            </div>

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
                        <th width="13%" class="text-center">Fecha</th>                                        
                        <th width="13%">Tipo CDP</th>
                                                   
                        <th width="10%"> N° Cbte</th>
                        <th width="20%" class="text-center">Concepto </th>
                        <th width="10%" class="text-center">Importe </th>
                        <th width="10%" class="text-center">Cod Presup </th>
                        
                        
                    </thead>
                    <tfoot>

                                                                                        
                    </tfoot>
                    <tbody>
                        @foreach($detallesRend as $itemDetalle)
                            <tr class="selected" id="filaItem" name="filaItem">                
                                <td style="text-align:center;">     
                                    {{$itemDetalle->fecha  }}
                                    
                                </td>               
                            
                                <td style="text-align:center;">               
                                    {{$itemDetalle->getNombreTipoCDP()  }}
                                </td>               
                               
                            
                                <td style="text-align:center;">               
                                    {{$itemDetalle->nroComprobante  }}
                                </td>               
                                <td> 
                                    {{$itemDetalle->concepto  }}
                                
                                </td>               
                                <td  style="text-align:right;">               
                                    S/. {{  number_format($itemDetalle->importe,2)  }}
                                </td>               
                                <td style="text-align:center;">               
                                    {{$itemDetalle->codigoPresupuestal  }}
                                </td>               
                                            
                            </tr> 
                        @endforeach
                                       







                    </tbody>
                </table>
            </div> 
                
                      
          

                <div class="row" id="divTotal" name="divTotal">                       
                    <div class="col">
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                      <i class="nav-icon fas fa-tachometer-alt"></i>
                                      <p>
                                        Descargar Archivos Comprobantes
                                        <i class="right fas fa-angle-left"></i>
                                      </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @for($i = 1; $i <= $rend->cantArchivos; $i++)
                                            <li class="nav-item">
                                                <a href="{{route('rendiciones.descargarCDP',$rend->codRendicionGastos.'*'.$i)}}" class="nav-link">
                                                <i class="far fa-address-card nav-icon"></i>
                                                <p>   {{App\RendicionGastos::getFormatoNombreCDP($rend->codRendicionGastos,$i,$rend->getTerminacionNro($i)) }}</p>
                                                </a>
                                            </li>    
                                        @endfor
                                    </ul>
                                  </li>
                            </ul>
                        </nav>  




                    </div>   

                    <div class="col" >
                        <div class="row">
                            
                            <div class="col">                        
                                <label for="">Total Rendido/Gastado: </label>    
                            </div>   
                            <div class="col">
                                {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                                <input type="hidden" name="cantElementos" id="cantElementos">                              
                                <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly" value="{{number_format(($rend->totalImporteRendido),2)}}">                              
                            </div>   



                            <div class="w-100"></div>
                            <div class="col">                        
                                <label for="">Total Recibido: </label>    
                            </div>   

                            <div class="col">
                            
                                <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly" value="{{number_format($rend->totalImporteRecibido,2)}}">                              
                            </div>   
                            <div class="w-100"></div>
                            <div class="col">                        
                                <label for="">

                                    @if($rend->saldoAFavorDeEmpleado>0) {{-- pal empl --}}
                                        Saldo a favor del Empl: 
                                    @else
                                        Saldo a favor de Cedepas: 
                                    @endif
                                    
                                </label>    
                            </div>   
                            <div class="col">
                                <input type="text" class="form-control text-right" name="total" id="total" 
                                readonly value="{{number_format(abs($rend->saldoAFavorDeEmpleado),2)}}">                              
                            </div>   
                            
                            
                            <div class="w-100"></div>
                    
                        </div>
                    </div>



                </div>
                    

                
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    <a href="{{route('rendicionGastos.listarRendiciones')}}" 
                        class='btn btn-primary' style="float:left;">
                        <i class="fas fa-undo"></i>
                        Regresar al menú
                    </a>    
                               
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
       
     <script>
        var cont=0;
        
        var IGV=0;
        var total=0;
        var detalleRend=[];
        var importes=[];
        var controlproducto=[];
        var totalSinIGV=0;
    
        $(document).ready(function(){
            
        });
    
        
        
        

    
    
    
    
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
