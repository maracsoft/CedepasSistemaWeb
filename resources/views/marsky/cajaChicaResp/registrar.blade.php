@extends('layout.plantilla') 
@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection
@section('contenido')
<br>
<h1>REGISTRAR NUEVO GASTO</h1>


<form method="POST" action="{{route('gasto.store')}}"  enctype="multipart/form-data" >
    @csrf
    <input type="hidden" name="codPeriodo" id="codPeriodo" value="{{$periodo->codPeriodoCaja}}">

<div class="row mt-2">
       
    <div class="col-6">

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Fecha de Comprobante</label>
            <div class="col-sm-4">
                <div class="form-group">                            
                    <div class="input-group date form_date " data-date-format="yyyy-mm-dd" data-provide="datepicker">
                        <input type="text"  class="form-control" name="fechaComprobante" id="fechaComprobante"
                            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" style="text-align:center;">
                        <div class="input-group-btn">                                        
                            <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Concepto</label>
            <div class="col-sm-6">
                <input
                    type="concepto"
                    class="form-control"
                    id="concepto"
                    name= "concepto"
                    placeholder="Concepto del Gasto"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Monto del Gasto</label>
            <div class="col-sm-6">
                <input
                   
                    class="form-control"
                    name="monto"
                    id="monto"
                    placeholder="Monto del Gasto"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Empleado Destino</label>
            <div class="col-sm-6">
                <select class="form-control"  id="codEmpleadoDestino" name="codEmpleadoDestino">
                    <option value="0" selected>-- Seleccionar -- </option>
                    @foreach($listaEmpleados as $itemEmpleado)
                        <option value="{{$itemEmpleado->codEmpleado}}" >
                            {{$itemEmpleado->apellidos.' '.$itemEmpleado->nombres}}
                        </option>                                 
                    @endforeach 
                </select>   
            </div>
        </div>
    </div>
    <div class="col-5">

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Tipo Comprobante</label>
            <div class="col-sm-6">
                <select class="form-control"  id="codTipoCDP" name="codTipoCDP">
                    <option value="0" selected>-- Seleccionar -- </option>
                    @foreach($listaCDP as $itemCDP)
                        <option value="{{$itemCDP->codTipoCDP}}" >
                            {{$itemCDP->nombreCDP}}
                        </option>                                 
                    @endforeach 
                </select>   
            </div>
        </div>
{{-- 


"codTipoCDP":null} --}}
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">N° Comprobante</label>
            <div class="col-sm-6">
                <input
                 
                    class="form-control"
                    id="nroCDP"
                    name="nroCDP"
                    placeholder="Número de Comprobante"
                />
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Cod Presupuestal</label>
            <div class="col-sm-6">
                <input
                
                    class="form-control"
                    id="codigoPresupuestal"
                    name="codigoPresupuestal"
                    placeholder="Código Presupuestal"
                />
            </div>
        </div>


       

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Foto Comprobante</label>
            <div class="col-sm-6">
                <input type="file" class="btn btn-primary" name="imagen" id="imagen"             
                     style="display: none" onchange="cambioImagen()"> 
                             <input type="hidden" name="nombreImg" id="nombreImg">   

                <label class="label" for="imagen" style="font-size: 10pt;" >    
                    <div id="divFile" class="hovered">     
                        Subir Archivo               
                    <i class="fas fa-upload"></i>  
                    </div>         
                </label> 

            </div>
        </div>



                  
                       
                       












        <div class="form-group row">
            <div class="col-sm-4" >
            </div>
            <div class="col-sm-8" >

            <a href=" " class="btn btn-danger"><i class="fas fa-undo"></i> Regresar</a>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>  Registrar</button>

            </div>
        </div>
    </div>
    </div>
</div>


</form>
<script>
    function cambioImagen(){
        var idname= 'imagen'; 
        var filename = $('#imagen').val().split('\\').pop();
        console.log('filename= '+filename+'    el id es='+idname)
        jQuery('span.'+idname).next().find('span').html(filename);
        document.getElementById("divFile").innerHTML= filename;
        $('#nombreImg').val(filename);
    }


</script>
{{-- PARA EL FILE BONITO --}}
<script type="application/javascript">
    jQuery('input[type=file]').change(function(){
      var filename = jQuery(this).val().split('\\').pop();
      var idname = jQuery(this).attr('id');
      console.log(jQuery(this));
      console.log(filename);
      console.log(idname);
      jQuery('span.'+idname).next().find('span').html(filename);
      document.getElementById("divFile").innerHTML= filename;
    });
</script>

<style>
.hovered:hover{
    background-color:rgb(97, 170, 170);
}




</style>
@endsection

@section('script')  
<script src="/select2/bootstrap-select.min.js"></script>     
<script src="/calendario/js/bootstrap-datepicker.min.js"></script>
<script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
<script src="/archivos/js/createdoc.js"></script>
@endsection