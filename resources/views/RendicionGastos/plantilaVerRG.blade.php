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
                        <input readonly  type="text" class="form-control" name="codColaborador" id="codColaborador" value="{{$empleado->codigoCedepas}}">    
                  </div>
                  <div class="w-100"></div> {{-- SALTO LINEA --}}
                  <div class="colLabel">
                        <label for="fecha">Importe Recibido:</label>

                  </div>
                  <div class="col">
                        <input readonly  type="text" class="form-control" name="importeRecibido" id="importeRecibido" value="{{$solicitud->totalSolicitado}}">    
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
                         style="resize:none; height:100px;">{{$rendicion->resumenDeActividad}}</textarea>
        
                    </div>
                </div>

                <div class="container"> {{-- OTRO CONTENEDOR DENTRO DE LA CELDA --}}

                    <div class="row">
                        <div class="colLabel">
                            <label for="fecha">Cod Rendicion:</label>
                        </div>
                        <div class="col">
                             <input type="text" class="form-control" name="codRendicion" id="codRendicion" readonly value="{{$rendicion->codigoCedepas}}">     
                        </div>


                        <div class="w-100"></div> {{-- SALTO LINEA --}}
                        <div class="colLabel">
                                <label for="codSolicitud">Cod Sol. Fondos:</label>

                        </div>
                        <div class="col">
                                <input value="{{$solicitud->codigoCedepas}}" type="text" class="form-control" name="codSolicitud" id="codSolicitud" readonly>     
                        </div>

                        <div class="w-100"></div> {{-- SALTO LINEA --}}

                        <div  class="colLabel">
                                <label for="estado">Estado de <br> la Solicitud
                                    @if($rendicion->verificarEstado('Observada')){{-- Si está observada --}}& Observación @endif:</label>
                        </div>
                        <div class="col"> {{-- Combo box de estado --}}
                            <input readonly type="text" class="form-control" name="estado" id="estado"
                            style="background-color: {{$rendicion->getColorEstado()}} ;
                                color:{{$rendicion->getColorLetrasEstado()}};   
                            "
                            readonly value="{{$rendicion->getNombreEstado()}}@if($rendicion->verificarEstado('Observada')): {{$rendicion->observacion}}@endif"  >           
                        </div>


                    </div>

                    

                </div>

            </div>

            
            
        </div>
    </div>
</div>