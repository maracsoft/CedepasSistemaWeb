@extends('layout.plantilla')


@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

@section('contenido')



<script type="text/javascript"> 
          
    function validarregistro() 
        {
            var expreg = new RegExp("^[A-Za-zÑñ À-ÿ]+$");//para apellidos y nombres ^[a-zA-Z ]+$ ^[A-Za-zÑñ À-ÿ]$
            /*
            if(expreg2.test(document.getElementById("usuario").value))
                alert("La matrícula es correcta");
            else
                alert("La matrícula NO es correcta");
            */
            if (document.getElementById("descripcion").value == ""){
                alert("Ingrese la descripcion");
                $("#descripcion").focus();
            }
            else if (document.getElementById("certificado").value == ""){
                alert("Adjunte el documento");
                $("#certificado").focus();
            }
            else if (document.getElementById("fechaInicio").value == ""){
                alert("Ingrese fecha de inicio");
                $("#fechaInicio").focus();
            }
            else if (document.getElementById("fechaFin").value == ""){
                alert("Ingrese fecha de Fin");
                $("#fechaFin").focus();
            }
            //else if (document.getElementById("fechaFin").value < document.getElementById("fechaInicio").value){
            else if (probar2()==0){
                alert("La fecha final tiene que ser mayor que la inicial");
            }
            else{
                document.frmempresa.submit(); // enviamos el formulario	
            }
        }
    
</script>

    
    <div class="well"><H3 style="text-align: center;">CREAR JUSTIFICACION DE FALTA</H3></div>
    <br>
    <form id="frmempresa" name="frmempresa" role="form" action="/crearJustificacion/save" class="form-horizontal form-groups-bordered" method="post" enctype="multipart/form-data">
        @csrf 
            <input type="text" class="form-control" id="codEmpleado" name="codEmpleado" placeholder="Codigo" value="{{ $empleado->codEmpleado}}" hidden>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Descripcion:</label>
                <div class="col-sm-4">
                    <textarea class="form-control" rows="3" name="descripcion" id="descripcion" placeholder="Descripcion ..." style="margin-top: 0px; margin-bottom: 0px; height: 100px;"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Documento:</label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" name="certificado" id="certificado">
                        </div>
            </div>
            
                    
            <div class="form-group row">                   
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Fecha Inicio:</label>
                <div class="col-md-4">                        
                    <div class="form-group">                            
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fechaInicio" id="fechaInicio"
                                   value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="text-align:center;">
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>

            <div class="form-group row">                   
                <label class="col-sm-1 col-form-label" style="margin-left:350px;">Fecha Fin:</label>
                <div class="col-md-4">                        
                    <div class="form-group">                            
                        <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                            <input type="text"  class="form-control" name="fechaFin" id="fechaFin"
                                   value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="text-align:center;">
                            <div class="input-group-btn">                                        
                                <button class="btn btn-primary date-set" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>


            <br />
            
            <input type="button" class="btn btn-primary" style="margin-left:600px;" value="Guardar" onclick="validarregistro()" />
            <a href="/listarJustificaciones/{{$empleado->codEmpleado}}" class="btn btn-info">Regresar</a>
    </form>


    <script>
        function probar2(){
            var cadena1=$('#fechaInicio').val();
            //alert('dia:'+cadena1.substr(0,2) +' mes:'+cadena1.substr(3,2)+' ano:'+cadena1.substr(6,4));
            var cadena2=$('#fechaFin').val();
            //alert('dia:'+cadena2.substr(0,2) +' mes:'+cadena2.substr(3,2)+' ano:'+cadena2.substr(6,4));
            /*
            if(parseInt(cadena1.substr(0,2), 0)>=parseInt(cadena2.substr(0,2), 0)){
                alert('inicio es mayor');
            }else{
                alert('fin es mayor');
            }
            */
            if(parseInt(cadena1.substr(6,4), 0)==parseInt(cadena2.substr(6,4), 0)){
                if(parseInt(cadena1.substr(3,2), 0)==parseInt(cadena2.substr(3,2), 0)){
                    if(parseInt(cadena1.substr(0,2), 0)<=parseInt(cadena2.substr(0,2), 0)){
                        //alert('se puede');
                        return 1;
                    }else{
                        //alert('no se puede');
                        return 0;
                    }
                }else if(parseInt(cadena1.substr(3,2), 0)<parseInt(cadena2.substr(3,2), 0)){
                    //alert('se puede');
                    return 1;
                }else{
                    //alert('no se puede');
                    return 0;
                }
            }else if(parseInt(cadena1.substr(6,4), 0)<parseInt(cadena2.substr(6,4), 0)){
                //alert('se puede');
                return 1;
            }else{
                //alert('no se puede');
                return 0;
            }
    
            
        }
    </script>
@endsection


@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection
