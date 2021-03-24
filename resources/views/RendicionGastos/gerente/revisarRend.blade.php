@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')
<div >
    {{-- ESTE ARCHIVO SIRVE TANTO COMO VER Y COMO REVISAR(aprobar/observar) --}}
    
    <p class="h1" style="text-align: center">
        @if($rendicion->verificarEstado('Creada') || $rendicion->verificarEstado('Subsanada') )

        Revisar Rendición de  Gastos
        @else 
        Ver Rendicion de Gastos
        @endif
        <div style="text-align: center; align-items:center; font-size:20pt; float:right;">   
            <input type="checkbox"  onclick="desOactivarEdicion()">
            Activar Edición
        </div>
    </p>
    


</div>

<form method = "POST" action = "{{route('RendicionGastos.Gerente.Aprobar')}}"  
enctype="multipart/form-data" id="frmRend" >
    
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $empleado->codigoCedepas }}">
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codigoSolicitud" id="codigoSolicitud" value="{{ $solicitud->codSolicitud }}">
    <input type="hidden" name="codRendicionGastos" id="codRendicionGastos" value="{{ $rendicion->codRendicionGastos }}">
    

    @csrf
    @include('RendicionGastos.plantillaVerRG')
      
    
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
                        <th width="10%" class="text-center">
                            
                            
                            Cod Presup
                        </th>
                        
                        
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
                                    {{$rendicion->getMoneda()->simbolo}}   {{  number_format($itemDetalle->importe,2)  }}
                                </td>               
                                <td style="text-align:center;">             
                                    
                                    <input type="text"  id="CodigoPresupuestal{{$itemDetalle->codDetalleRendicion}}" 
                                                        name="CodigoPresupuestal{{$itemDetalle->codDetalleRendicion}}" 
                                        value="{{$itemDetalle->codigoPresupuestal}}" readonly class="inputEditable">
                                    
                                </td>               
                                            
                            </tr> 
                        @endforeach
                                       







                    </tbody>
                </table>
            </div> 
                
                      
          

                <div class="row" id="divTotal" name="divTotal">                       
                    <div class="col">
                        @include('RendicionGastos.desplegableDescargarArchivosRend')
                        




                    </div>   

                    <div class="col" >
                        <div class="row">
                            
                            <div class="col">                        
                                <label for="">Total Rendido/Gastado: </label>    
                            </div>   
                            <div class="col">
                                {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                                <input type="hidden" name="cantElementos" id="cantElementos">                              
                                <input type="text" class="form-control text-right" name="totalRendido" id="totalRendido" readonly="readonly" 
                                    value="{{number_format(($rendicion->totalImporteRendido),2)}}">                              
                            </div>   



                            <div class="w-100"></div>
                            <div class="col">                        
                                <label for="">Total Recibido: </label>    
                            </div>   

                            <div class="col">
                            
                                <input type="text" class="form-control text-right" name="totalRecibido" id="totalRecibido" readonly="readonly" 
                                    value="{{number_format($rendicion->totalImporteRecibido,2)}}">                              
                            </div>   
                            <div class="w-100"></div>
                            <div class="col">                        
                                <label for="">

                                    @if($rendicion->saldoAFavorDeEmpleado>0) {{-- pal empl --}}
                                        Saldo a favor del Empl: 
                                    @else
                                        Saldo a favor de Cedepas: 
                                    @endif
                                    
                                </label>    
                            </div>   
                            <div class="col">
                                <input type="text" class="form-control text-right" name="totalSaldo" id="totalSaldo" 
                                readonly value="{{number_format(abs($rendicion->saldoAFavorDeEmpleado),2)}}">                              
                            </div>   
                            
                            
                            <div class="w-100"></div>
                    
                            
                            
                            @if($rendicion->verificarEstado('Creada') || $rendicion->verificarEstado('Subsanada') )

                            @csrf     
                            
                                <div class="col">
                                    <label for="">Observación:</label>
                                    <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="4"></textarea>
                                
                                    
                                    
                                </div>    
                                <div class="col">
                                    <br>
                                    <a href="#" class="btn btn-warning" onclick="swal({//sweetalert
                                        title:'¿Seguro de observar la rendicion?',
                                        text: '',
                                        type: 'info',  
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText:  'SI',
                                        cancelButtonText:  'NO',
                                        closeOnConfirm:     true,//para mostrar el boton de confirmar
                                        html : true
                                    },
                                    function(){
                                        observarRendicion();
                                    });"><i class="entypo-pencil"></i>Observar</a>
                                </div>
                    
                    
                            @endif
                        </div>
                    </div>



                </div>
                    

                
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    <a href="#" class="btn btn-success float-right" onclick="aprobar()">
                        <i class="fas fa-check"></i> 
                        Aceptar
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
    
    .hovered:hover{
        background-color:rgb(97, 170, 170);
    }
    input[type='checkbox'] {
        /* -webkit-appearance:none; */
        width:10px;
        height:10px;
        background:white;
        border-radius:15px;
        border:2px solid #555;
      
    }
    input[type='checkbox']:checked {
        background: #abd;
    }
    
    .inputEditable{
        background-color: rgb(196, 196, 196);
    }


</style>


@section('script')
       
     <script>
        var cont=0;
        
        var total=0;
        var detalleRend=[];
        const textResum = document.getElementById('resumen');
        var codPresupProyecto = "{{$solicitud->getProyecto()->codigoPresupuestal}}";

        $(document).ready(function(){
            textResum.classList.add('inputEditable');
    
        });
    
        

        function validarEdicion(){
            msj="";
            
            if(textResum.value=='')
                msj= "Debe ingresar el resumen de la actividad";
            
            
            i=1;
            @foreach ($detallesRend as $itemDetalle)
                
                inputt = document.getElementById('CodigoPresupuestal{{$itemDetalle->codDetalleRendicion}}');
                if(!inputt.value.startsWith(codPresupProyecto) )
                    msj= "El codigo presupuestal del item " + i + " no coincide con el del proyecto ["+ codPresupProyecto +"] .";
                i++;
            @endforeach


            return msj;
        }

        function aprobar(){
            msje = validarEdicion();
            if(msje!="")
                {
                    alerta(msje);
                    return false;
                }
            console.log('TODO OK');
            confirmar('¿Está seguro de Aceptar la Rendición?','info','frmRend');
            

        }





        var edicionActiva = false;
        function desOactivarEdicion(){
            
            console.log('Se activó/desactivó la edición : ' + edicionActiva);
            
            

            @foreach ($detallesRend as $itemDetalle)
                inputt = document.getElementById('CodigoPresupuestal{{$itemDetalle->codDetalleRendicion}}');
                
                if(edicionActiva){
                    inputt.classList.add('inputEditable');
                    inputt.setAttribute("readonly","readonly",false);
                    textResum.setAttribute("readonly","readonly",false);
                }else{
                    inputt.classList.remove('inputEditable');
                    inputt.removeAttribute("readonly"  , false);
                    textResum.removeAttribute("readonly"  , false);
                    
                }
            @endforeach
            edicionActiva = !edicionActiva;
            
            
        }


        function observarRendicion(){
            textoObs = $('#observacion').val();
            codigoSolicitud = {{$rendicion->codRendicionGastos}};
            console.log('Se presionó el botón observar, el textoobservacion es ' + textoObs + ' y el cod de la rendicion es ' +  codigoSolicitud);
            location.href = '/rendiciones/observar/'+ codigoSolicitud +'*' +textoObs;
        }




    
 
    
    </script>
     










@endsection
