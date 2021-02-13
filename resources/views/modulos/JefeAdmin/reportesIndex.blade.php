@extends ('layout.plantilla')

@section('contenido')
<div>
  <h3> REPORTES </h3>

{{-- 
- Reporte de gastos por empleados con %.
-	Reporte de gastos por sedes con %.
- Reporte de 
-	Reporte de las solicitudes.
-	Reporte de las rendiciones
 --}}

   
        <form method="POST" action="{{route('rendicionFondos.reportes')}}">
          @csrf
            <div class="container">
              <div class="row" style="background-color: red">
           
                <div class="col-sm">
                  
                <label for="">Tipo de Reporte</label>
                </div>
                <div class="col-sm">
                  
                  <div>
                    <select class="custom-select" id="tipoInforme" name="tipoInforme">
                      <option value="0">-- Seleccionar -- </option>
                      <option value="1">Por Sedes </option>
                      <option value="2">Por Empleados </option>
                    </select>
                  </div>
                </div>
                <div class="col-sm">
                  <label for="fechaComprobante">Fecha Inicio</label>
                </div>
                <div class="col-sm">
                 
                  <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                    <input type="text"  class="form-control" name="fechaI" id="fechaI"
                          value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="font-size: 10pt;"> 
                    <div class="input-group-btn">                                        
                        <button class="btn btn-primary date-set" type="button">
                            <i class="fas fa-calendar"></i>
                        </button>
                    </div>
                  </div>

                </div>
                <div class="col-sm">
                  <label for="fechaComprobante">Fecha Fin</label>
                </div>

                <div class="col-sm">
                  
                  <div class="input-group date form_date " data-date-format="dd/mm/yyyy" data-provide="datepicker">
                    <input type="text"  class="form-control" name="fechaF" id="fechaF"
                          value="{{ Carbon\Carbon::now()->format('d/m/Y') }}" style="font-size: 10pt;"> 
                    <div class="input-group-btn">                                        
                        <button class="btn btn-primary date-set" type="button">
                            <i class="fas fa-calendar"></i>
                        </button>
                    </div>
                  </div>
                </div>
                <div class="col-sm">
                  <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
              </div>


                          

                
              
            </div>
          
          




        </form>
   

{{-- AQUI FALTA EL CODIGO SESSION DATOS ENDIF xdd --}}
      @if (session('datos'))
        <div class ="alert alert-warning alert-dismissible fade show mt-3" role ="alert">
            {{session('datos')}}
          <button type = "button" class ="close" data-dismiss="alert" aria-label="close">
              <span aria-hidden="true"> &times;</span>
          </button>
          
        </div>
      @ENDIF

 

</div>
@endsection