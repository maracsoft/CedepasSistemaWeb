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


<form method = "POST" action = "{{route('ReposicionGastos.Empleado.store')}}" onsubmit="return validarTextos()"  enctype="multipart/form-data">
    
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
 
                    <a href="#" class="btn btn-success float-right" onclick="actualizarEstado('¿Seguro de aceptar la reposicion?', 'Aceptar')">
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

/* PARA MI MENU DESPLEGABLE NUEVO */





</style>

@section('script')



       {{-- PARA EL FILE  --}}
    <script type="application/javascript">
    //se ejecuta cada vez que escogewmos un file


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
                    case 'Aceptar':
                        window.location.href="{{route('ReposicionGastos.aprobar',$reposicion->codReposicionGastos)}}";
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
