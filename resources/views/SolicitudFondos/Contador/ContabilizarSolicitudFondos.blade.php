@extends('Layout.Plantilla')
@section('titulo')
@if($solicitud->verificarEstado('Contabilizada'))
Ver
@else
Contabilizar
@endif
Solicitud
@endsection

@section('contenido')

{{-- ESTA VISTA SE USA PARA VER Y PARA CONTABILIZAR --}}
<div >
    
    <p class="h1" style="text-align: center"> 
        @if($solicitud->verificarEstado('Contabilizada'))
        Ver
        @else
        Contabilizar
        @endif
        Solicitud de Fondos
    </p>
</div>

        
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" 
        value="{{ $empleadoLogeado->codigoCedepas }}">

    @csrf
        @include('SolicitudFondos.Plantillas.VerSOF')
    
      
           
    
         
            
                
                <div class="row" id="divTotal" name="divTotal">                       
                    <div class="col-md-8">
                    </div>   
                    <div class="col-md-2">                        
                        <label for="">Total : </label>    
                    </div>   
                    <div class="col-md-2">
                        {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                        <input type="hidden" name="cantElementos" id="cantElementos">                              
                        <input type="text" class="form-control text-right" name="total" 
                            value="{{number_format($solicitud->totalSolicitado,2)}}" id="total" readonly="readonly">                              
                    </div>   
                </div>
                    

        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    
                    
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <a href="{{route('SolicitudFondos.Gerente.Listar')}}" 
                                    class='btn btn-primary' style="float:left;">
                                    <i class="fas fa-undo"></i>
                                    Regresar al menú
                                </a>

                            </div>
                            <div class="col"></div>
                       
                          
                            
                        @if($solicitud->verificarEstado('Abonada') )

                              @csrf     
                                <input type="hidden" value="{{$solicitud->codSolicitud}}" name="codSolicitud" id="codSolicitud">
                                {{-- <div class="row">
                                    <div class="col">
                                        <label for="">Observación:</label>
                                        <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="4"></textarea>
                                    </div>
                                    
                                    <div class="col">
                                        <button type="button" onclick="observar()"
                                            class='btn btn-danger'   style="float:right;">
                                            <i class="fas fa-eye-slash"></i>
                                            Observar
                                        </button> 
                                        <br>
                                    </div>    
                                </div>
                         
                                <div class="col">
                                    <a href="{{route('solicitudFondos.rechazar',$solicitud->codSolicitud)}}" 
                                        class='btn btn-danger'  style="float:right;">
                                        <i class='fas fa-ban'></i>
                                        Rechazar
                                    </a>    
                                </div> --}}
                        
                                <div class="col">
                                    <a href="{{route('SolicitudFondos.Contador.Contabilizar',$solicitud->codSolicitud)}}" 
                                        class='btn btn-success'  style="float:right;">
                                        <i class="fas fa-check"></i>
                                        Marcar como contabilizada
                                    </a>    
                                </div>
                        
                        
                        @endif
                        </div>
                    </div>
                   
                        
                          
                    
                               
                    
                    
                
                </div>    
            </div>
        </div>
    </div>


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


@include('Layout.EstilosPegados')

<style>
    
    
    </style>


@section('script')
     <script src="/public/select2/bootstrap-select.min.js"></script>     
     <script>
        var cont=0;
        
        var IGV=0;
        var total=0;
        var detalleSol=[];
        var importes=[];
        var controlproducto=[];
        var totalSinIGV=0;
    
        $(document).ready(function(){

            //cuando apenas carga la pagina, se debe copiar el contenido de la tabla a detalleSol
          
    
        });

        function observar(){

            textoObs = $('#observacion').val();
            codigoSolicitud = {{$solicitud->codSolicitud}};
            console.log('Se presionó el botón observar, el textoobservacion es ' + textoObs + ' y el cod de la solicitud es ' +  codigoSolicitud);
            location.href = '/SolicitudFondos/Observar/'+ codigoSolicitud +'*' +textoObs;

        }

    
    
       
    
    
    
    </script>
     










@endsection
