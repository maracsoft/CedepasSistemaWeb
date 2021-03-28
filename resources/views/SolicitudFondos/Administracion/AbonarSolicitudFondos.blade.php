@extends('Layout.Plantilla')

@section('titulo')
@if($solicitud->verificarEstado('Aprobada'))
    Abonar Solicitud
@else 
    Ver Solicitud
@endif
@endsection

@section('contenido')

<div>
    <p class="h1" style="text-align: center">
        @if($solicitud->verificarEstado('Aprobada'))
            Abonar a Solicitud de Fondos Aprobada
        @else 
            Ver Solicitud de Fondos
        @endif
    
        
    
    </p>
</div>

<form method = "POST" action = "{{route('SolicitudFondos.Administracion.Abonar')}}" id="frmsoli"  
enctype="multipart/form-data">
    {{-- Para saber en el post cual solicitud es  --}}    
    <input type="hidden" value="{{$solicitud->codSolicitud}}" name="codSolicitud" id="codSolicitud">
   
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
                <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly">                              
            </div>   
        </div>
                    

                
      
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    
                    
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <a href="{{route('SolicitudFondos.Administracion.Listar',$solicitud->codSolicitud)}}" 
                                    class='btn btn-primary' style="float:left;">
                                    <i class="fas fa-undo"></i>
                                    Regresar al menú
                                </a>

                            </div>
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col"></div>
                            
                            

                            @if($solicitud->verificarEstado('Aprobada'))
                                

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


                            <div class="col">
                                <a href="{{route('solicitudFondos.rechazar',$solicitud->codSolicitud)}}" 
                                    class='btn btn-danger'  style="float:right;">
                                    <i class='fas fa-ban'></i>
                                    Rechazar
                                </a>    
                            </div>

                            
                            <div class="col">
                                <button type="button" class='btn btn-success' onclick="marcarComoAbonada()" style="float:right;">
                                    <i class="fas fa-check"></i>
                                    Marcar como Abonado
                                </button>
                            </div>
                          
                            @endif






                            
                        </div>
                    </div>
                   
                        
                          
                    
                               
                    
                    
                
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

    </style>

@include('Layout.EstilosPegados')
@section('script')

    

     <script src="/public/select2/bootstrap-select.min.js"></script>     
     <script>
        var cont=0;
        
      
        var total=0;
  
        var importes=[];
        var controlproducto=[];
        var totalSinIGV=0;
    
        $(document).ready(function(){

            //cuando apenas carga la pagina, se debe copiar el contenido de la tabla a detalleSol
            
        });




        function marcarComoAbonada(){
            

            confirmar('¿Está seguro de marcar como abonada la solicitud?','info','frmsoli');//[success,error,warning,info]
        }


        function observar(){

            textoObs = $('#observacion').val();
            codigoSolicitud = {{$solicitud->codSolicitud}};
            console.log('Se presionó el botón observar, el textoobservacion es ' + textoObs + ' y el cod de la solicitud es ' +  codigoSolicitud);
            location.href = '/SolicitudFondos/Observar/'+ codigoSolicitud +'*' +textoObs;

        }

        /* function validar(){
            if($('#nombreImgImagenEnvio').val() == '')
                {
                    alerta('Debe subir el comprobante del deposito.')
                    return false;
                }

        } */

        


    
    
    

    
    
    
    </script>
     










@endsection
