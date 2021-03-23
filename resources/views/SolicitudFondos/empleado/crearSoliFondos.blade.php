@extends('layout.plantilla')

@section('estilos')
  
@endsection

@section('contenido')
<div >
    <p class="h1" style="text-align: center">Registrar Nueva Solicitud de Fondos</p>
</div>

<form method = "POST" action = "{{route('SolicitudFondos.Empleado.Guardar')}}" 
onsubmit="" id="frmsoli" name="frmsoli">
        
    {{-- CODIGO DEL EMPLEADO --}}
    <input type="hidden" name="codigoCedepas" id="codigoCedepas" value="{{ $empleadoLogeado->codigoCedepas }}">
    
    @csrf
    <div class="container" style="">
        <div class="row">           
            <div class="col-md" style=""> {{-- COLUMNA IZQUIERDA 1 --}}
                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                      <div  class="colLabel">
                            <label for="fecha">Fecha Actual:</label>
                      </div>
                      <div class="col">
                                <div  style="width: 300px; " >
                                    <input type="text" style="margin:0px auth;" class="form-control" name="fecha" id="fecha" disabled 
                                        value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" >     
                                </div>
                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Girar a la orden de:</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="girarAOrden" 
                            id="girarAOrden" value="{{App\Empleado::getEmpleadoLogeado()->getNombreCompleto()}}">    

                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Nro Cuenta:</label>

                      </div>
                      <div class="col">
                            <input type="text" class="form-control" name="nroCuenta" id="nroCuenta">    
                      </div>
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="fecha">Banco:</label>

                      </div>
                      <div class="col"> {{-- Combo box de banco --}}
                            <select class="form-control"  id="ComboBoxBanco" name="ComboBoxBanco" >
                                <option value="-1">-- Seleccionar -- </option>
                                @foreach($listaBancos as $itemBanco)
                                    <option value="{{$itemBanco['codBanco']}}" >
                                        {{$itemBanco->nombreBanco}}
                                    </option>                                 
                                @endforeach 
                            </select>      
                      </div>
                      
                      <div class="w-100"></div> {{-- SALTO LINEA --}}
                      <div  class="colLabel">
                            <label for="codSolicitud">Codigo Solicitud:</label>

                      </div>
                      <div class="col"> 
                          {{-- ESTE INPUT REALMENTE NO SE USARÁ PORQUE EL CODIGO cedep SE CALCULA EN EL BACKEND (pq es más actual) --}}
                            <input type="text" class="form-control" 
                                value="{{App\SolicitudFondos::calcularCodigoCedepas($objNumeracion)}}" 
                                readonly>     
                      </div>



                    </div>


                </div>
                
                
                
                
            </div>


            <div class="col-md"> {{-- COLUMNA DERECHA --}}
                <label for="fecha">Justificacion</label>
                <textarea class="form-control" name="justificacion" id="justificacion" aria-label="With textarea" style="resize:none; height:100px;"></textarea>

                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div  class="colLabel2">
                                <label for="ComboBoxProyecto">Proyecto y cod:</label>

                        </div>
                        <div class="col"> {{-- Combo box de proyecto --}}
                                <select class="form-control"  id="ComboBoxProyecto" name="ComboBoxProyecto" onchange="actualizarCodPresupProyecto()" >
                                    <option value="-1">-- Seleccionar -- </option>
                                    @foreach($listaProyectos as $itemProyecto)
                                        <option value="{{$itemProyecto['codProyecto']}}" >
                                            {{$itemProyecto->nombre}} [{{$itemProyecto->codigoPresupuestal}}]
                                        </option>                                 
                                    @endforeach 
                                </select>      

                        </div>



                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                       

                        <div class="colLabel2">
                                <label for="ComboBoxMoneda">Moneda:</label>
                        </div>
                        <div class="col"> {{-- Combo box de itemMoneda --}}
                                <select class="form-control"  id="ComboBoxMoneda" name="ComboBoxMoneda" >
                                    <option value="-1">-- Seleccionar --</option>
                                    @foreach($listaMonedas as $itemMoneda)
                                        <option value="{{$itemMoneda->codMoneda}}" >
                                            {{$itemMoneda->nombre}}
                                        </option>                                 
                                    @endforeach 
                                </select>      
                        </div>

                        









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
                    <thead >
                        <th width="6%" class="text-center">
                            <div> {{-- INPUT PARA ITEM --}}
                                <input type="text" style="text-align: center" class="form-control" readonly name="item" id="item" value="1">     
                            </div>    
                        </th>                                           
                        <th width="40%"> 
                            <div> {{-- INPUT PARA CONCEPTO--}}
                                <input type="text" class="form-control" name="concepto" id="concepto">     
                            </div>
                            
                        </th>                                 
                        <th width="10%">
                            <div > {{-- INPUT PARA importe--}}
                                <input type="text" class="form-control" name="importe" id="importe">     
                            </div>
                        </th>
                        <th width="15%" class="text-center">
                            <div> {{-- INPUT PARA codigo presup--}}
                                <input type="text" class="form-control" name="codigoPresupuestal" id="codigoPresupuestal">     
                            </div>

                        </th>
                        <th width="10%" class="text-center">
                            <div>
                                <button type="button" id="btnadddet" name="btnadddet" 
                                    class="btn btn-success" onclick="agregarDetalle()" >
                                    <i class="fas fa-plus"></i>
                                     Agregar
                                </button>
                            </div>      
                        
                        </th>                                            
                     
                    </thead>
                    
                    
                    <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                        <th  class="text-center">Item</th>                                        
                        <th >Concepto</th>                                 
                        <th > Importe</th>
                        <th  class="text-center">Codigo Presupuestal</th>
                        <th  class="text-center">Opciones</th>                                            
                     
                    </thead>
                    <tfoot>

                                                                                        
                    </tfoot>
                    <tbody>
                        
                        {{-- <tr class="selected" id="fila1">
                            <td style="text-align:center;">
                                Item
                            </td>
                            <td>concepto
                            </td>
                            <td  style="text-align:right;">
                               importe
                            </td>
                            <td style="text-align:center;">
                                codigoPresupuestal
                            </td>
                            
                            <td style="text-align:center;">
                                <button type="button" class="btn btn-danger btn-xs" onclick="eliminardetalle('+cod_producto+','+cont+');">
                                    <i class="fa fa-times" ></i>
                                </button>
                            </td>
                        </tr>   --}}     
            
















                    </tbody>
                </table>
            </div> 
                
                <div class="row" id="divTotal" name="divTotal">                       
                    <div class="col-md-8">
                    </div>   
                    <div class="col-md-2">                        
                        <label for="">Total : </label>    
                    </div>   
                    <div class="col-md-2">
                        {{-- HIDDEN PARA GUARDAR LA CANT DE ELEMENTOS DE LA TABLA --}}
                        <input type="hidden" name="cantElementos" id="cantElementos">                              
                        <input type="hidden" class="form-control text-right" name="total" id="total" readonly="readonly">   
                        <input type="text" class="form-control text-right" name="totalMostrado" id="totalMostrado" readonly="readonly">   
                                                   
                    </div>   
                </div>
                    

                
        </div> 
        
        <div class="col-md-12 text-center">  
            <div id="guardar">
                <div class="form-group">
                    <!--
                    <button class="btn btn-primary" type="submit" 
                        id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                        <i class='fas fa-save'></i> 
                        Registrar
                    </button>
                    -->
                    <button type="button" class="btn btn-primary float-right" id="btnRegistrar" 
                        data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando" 
                            onclick="registrar()">
                    
                    <i class='fas fa-save'></i> 
                    Registrar
                    </button> 
                   
                    <a href="{{route('SolicitudFondos.empleado.listar')}}" class='btn btn-info float-left'><i class="fas fa-arrow-left"></i> Regresar al Menu</a>              
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
    margin-top: 20px;
    
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

</style>

@section('script')
     {{-- <script src="/public/select2/bootstrap-select.min.js"></script>      --}}
     <script>
        var cont=0;
        
        var detalleSol=[];
      
    
        $(document).ready(function(){
           

        });


        function registrar(){
            msj=validarFormCreate();
            if(msj!=''){
                alerta(msj);
                return false;
            }

            confirmar('¿Seguro de crear la reposicion?','info','frmsoli');//[success,error,warning,info]
        }



         //Retorna '' si es que todo esta OK y el STRING mensaje de error si no
        function validarFormCreate(){
            msj='';
            
             if($('#justificacion').val()=='' )
                msj='Debe ingresar la justificacion';
            

            if($('#ComboBoxProyecto').val()=='-1' )
                msj='Debe seleccionar el proyecto';
            
            if( $('#ComboBoxMoneda').val()=='-1' )
                msj="Debe ingresar una moneda";

            if($('#ComboBoxBanco').val()=='-1' )
                msj='Debe seleccionar el banco.';
            
            if($('#girarAOrden').val()=='' )
                msj='Debe ingresar la persona dueña de la cuenta.';
            
            if($('#nroCuenta').val()=='' )
                msj='Debe ingresar el nro de cuenta';
            
            if( $('#cantElementos').val()<=0 )
                msj='Debe ingresar Items';


            if( $('#ComboBoxMoneda').val()==-1 )
                msj='Debe seleccionar la moneda';

            for (let index = 0; index < detalleSol.length; index++) {
                console.log('Comparando  ' +codPresupProyecto+' empiezaCon ' + codPresupProyecto.startsWith( detalleSol[index].codigoPresupuestal) )
                if(! detalleSol[index].codigoPresupuestal.startsWith( codPresupProyecto) )
                    msj = "El codigo presupuestal del item " + (index+1) + " no coincide con el del proyecto. ["+codPresupProyecto+ "]";
            }


            return msj;
        }
    
       

       
    
    </script>
     

     @include('SolicitudFondos.plantillas.createEditSolJS')
    
    








@endsection
