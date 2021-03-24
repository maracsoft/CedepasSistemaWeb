@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div class="row">
    <div class="col-md-10">
        <p class="h1" style="margin-left:430px;">
            @if($reposicion->verificarEstado('Creada') || 
                $reposicion->verificarEstado('Subsanada') )
                {{-- Estados en los que es valido Evaluar --}}
                Evaluar
            @else 
                Ver
            @endif
                Reposicion de Gastos

                <div style="text-align: center; align-items:center; font-size:20pt; float:right;">   
                    <input type="checkbox"  onclick="desOactivarEdicion()">
                    Activar Edición
                </div>
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


<form method = "POST" action = "{{route('ReposicionGastos.Gerente.aprobar')}}" onsubmit="return validarTextos()"   id="frmRepo"
    enctype="multipart/form-data">
    
    {{-- CODIGO DEL EMPLEADO --}}
    {{-- CODIGO DE LA SOLICITUD QUE ESTAMOS RINDIENDO --}}
    <input type="hidden" name="codEmpleado" id="codEmpleado" value="{{$reposicion->codEmpleadoSolicitante}}">
    <input type="hidden" name="codReposicionGastos" id="codReposicionGastos" value="{{$reposicion->codReposicionGastos}}">
    
    @csrf
   
        @include('ReposicionGastos.plantillaVerREP')
      
      
         


        {{-- LISTADO DE DETALLES  --}}
      
        <div class="row" id="divTotal" name="divTotal">      
            <div class="col"> 
                    <br>
                    @include('ReposicionGastos.desplegableDescargarArchivosRepo')


            </div>
            <!--
            <div class="col"></div>
            -->
            <div class="col-md-2">                        
                <label for="">Total Gastado: </label>    
                <br><br><br>
                @if($reposicion->verificarEstado('Creada') || $reposicion->verificarEstado('Subsanada') )
                    <label for="fecha">Observaciones</label>
                    <textarea class="form-control" name="observacion" id="observacion" 
                        aria-label="With textarea" style="resize:none; height:100px;"></textarea>
                    <br>
                @endif
            </div>   
            <div class="col-md-2">
                {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                <input type="hidden" name="cantElementos" id="cantElementos">
                <input type="hidden" name="codigoCedepas" id="codigoCedepas">                          
                <input type="hidden" name="totalRendido" id="totalRendido">

                <input type="text" class="form-control text-right" name="total"
                        id="total" readonly="readonly" value="{{number_format($reposicion->totalImporte,2)}}">   
                        <br><br><br>

                @if($reposicion->verificarEstado('Creada') || $reposicion->verificarEstado('Subsanada') )
                <a href="#" class="btn btn-warning" onclick="actualizarEstado('¿Seguro de observar la reposicion?', 'Observar')">
                    <i class="entypo-pencil"></i>Observar</a>
                @endif
            </div>   

        </div>
       
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    <a href="{{route('ReposicionGastos.Gerente.listar')}}" class='btn btn-info float-left'><i class="fas fa-arrow-left"></i> Regresar al Menu</a>
                    <!--
                    <a href="" 
                        class="btn btn-success float-right">
                        <i class="entypo-pencil"></i>
                        Marcar como Abonada
                    </a>-->

                    @if($reposicion->verificarEstado('Creada') || $reposicion->verificarEstado('Subsanada') )
 
                    <a href="#" class="btn btn-success float-right" onclick="aprobar()">
                        <i class="fas fa-check"></i> Aceptar</a>
                    <!--<a href="" class="btn btn-danger float-right"><i class="entypo-pencil"></i>Rechazar</a>  -->
                    <a href="#" class="btn btn-danger float-right" style="margin-right:5px;"onclick="actualizarEstado('¿Seguro de rechazar la reposicion?', 'Rechazar')">
                        <i class="fas fa-times"></i> Rechazar</a>


                    @endif


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



</style>

@section('script')



       {{-- PARA EL FILE  --}}
    <script type="application/javascript">
    //se ejecuta cada vez que escogewmos un file

        const textResum = document.getElementById('resumen');
        var codPresupProyecto = "{{$reposicion->getProyecto()->codigoPresupuestal}}";

        $(document).ready(function(){
            textResum.classList.add('inputEditable');
            
        });

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
                        observar();
                        break;
                  
                    case 'Rechazar':
                        window.location.href="{{route('ReposicionGastos.rechazar',$reposicion->codReposicionGastos)}}";    
                        break;
                }
                
            });
        }



        function observar(){
            texto=$('#observacion').val();
            if(texto!=''){
                reposicion=$('#codReposicionGastos').val();
                window.location.href='/ReposicionGastos/'+reposicion+'*'+texto+'/Observar'; 
                
            }
            else{ 
                alerta('Ingrese observacion');
            }
        }

        

 
     

    
        

        function validarEdicion(){
            msj="";
            
            if(textResum.value=='')
                msj= "Debe ingresar el resumen de la actividad";
            
            
            i=1;
            @foreach ($detalles as $itemDetalle)
                
                inputt = document.getElementById('CodigoPresupuestal{{$itemDetalle->codDetalleReposicion}}');
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
            confirmar('¿Está seguro de Aceptar la Reposicion?','info','frmRepo');
            

        }





        var edicionActiva = false;
        function desOactivarEdicion(){
            
            console.log('Se activó/desactivó la edición : ' + edicionActiva);
            
            

            @foreach ($detalles as $itemDetalle)
                inputt = document.getElementById('CodigoPresupuestal{{$itemDetalle->codDetalleReposicion}}');
                
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

    
    </script>
     










@endsection
