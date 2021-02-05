@extends('layout.plantilla')
@section('contenido')

@section('estilos')
<link rel="stylesheet" href="/calendario/css/bootstrap-datepicker.standalone.css">
<link rel="stylesheet" href="/select2/bootstrap-select.min.css">
@endsection

<div class="card">
    <div class="card-header ui-sortable-handle" style="cursor: move;">
      <h3 class="card-title">
        <i class="fas fa-chart-pie mr-1"></i>
        Control de Mesas/Productos
      </h3>
    </div><!-- /.card-header -->

    <div class="card-body">
        <div class="form-group row">
            <select class="form-control col-sm-2" id="codCategoria" name="codCategoria" size="15" style="border: 0px">
                @foreach($categorias1 as $itemcategoria)
                <option value="{{$itemcategoria->codCategoria}}">{{$itemcategoria->nombre}}</option>
                @endforeach
            </select>
            <div class="col sm-10">
                <div class="row" >
                    <!-- small box -->
                    <div class="col-lg-2 col-3">

                        <div class="small-box bg-secondary">
                            <div class="container" style="font-size: medium">
                                <span>Polo Deportivo Silo - S</span>
                                <div style="width: 90%">
                                    <a href="#"><img src="/img/breakfast.png" style="width: 100%; height: auto;"></a>
                                </div>
                                <span>S/. 50.00</span>
                            </div>
                        </div>

                    </div>
                    
                    <div class="col-lg-2 col-3">

                        <div class="small-box bg-secondary">
                            <div class="container" style="font-size: medium">
                                <span>Polo Deportivo Silo - S</span>
                                <div style="width: 90%">
                                    <a href="#"><img src="/img/breakfast.png" style="width: 100%; height: auto;"></a>
                                </div>
                                <span>S/. 50.00</span>
                            </div>
                        </div>

                    </div>
                    

                  </div>
            </div>
        </div>
    </div><!-- /.card-body -->

</div>
<div class="row">

    <section class="col-lg-8 connectedSortable ui-sortable">
      <!-- Custom tabs (Charts with tabs)-->
      <div class="card">

          <div class="card-body">
            <label for="">Busqueda de Productos: </label>        
                  
                <select class="form-control select2 select2-hidden-accessible selectpicker" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="cliente_id" name="cliente_id" data-live-search="true" onchange="">
                    <option value="0" selected>- Seleccione Producto -</option>          
                        @foreach($productos as $itemproducto)
                            <option value="{{ $itemproducto->codProducto }}" >{{ $itemproducto->nombre }}</option>                                 
                        @endforeach            
                </select>                                                                  
            
            <div class="table-responsive">                           
              <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style='background-color:#FFFFFF;'> 
                  <thead class="thead-default" style="background-color:#3c8dbc;color: #fff;">
                      <th width="10" class="text-center">OPCIONES</th>                                        
                      <th class="text-center">CANTIDAD</th>                                 
                      <th class="text-center">DESCRIPCION DE PRODUCTO</th>
                      <th class="text-center">PRECIO</th>
                  </thead>
                  <tfoot>
                                                                                                        
                                                                                      
                  </tfoot>
                  <tbody>
                      
                  </tbody>
              </table>
            </div> 
            <div class="row">                       
                  <div class="col-md-8">
                  </div>   
                  <div class="col-md-2">                        
                      <label for="">Total : </label>    
                  </div>   
                  <div class="col-md-2">
                      <input type="text" class="form-control text-right" name="total" id="total" readonly="readonly">                              
                  </div>   
            </div>
            
            <hr>
            
            <div class="form-group">
              <label>Observaciones:</label>
              <textarea class="form-control" rows="3" placeholder="Enter ..." style="margin-top: 0px; margin-bottom: 0px; height: 79px;"></textarea>
            </div>
            <div class="text-right">  
              <div  id="guardar">
                  <div class="form-group">
                      <button class="btn btn-primary" id="btnRegistrar" data-loading-text="<i class='fa a-spinner fa-spin'></i> Registrando">
                          <i class='fas fa-save'></i> Registrar</button>    
              
                      <a href="{{URL::to('venta')}}" class='btn btn-danger'><i class='fas fa-ban'></i> Cancelar</a>              
                  </div>    
              </div>
            </div>
           
          </div><!-- /.card-body -->

      </div>
    </section>
    
    
    <section class="col-lg-4 connectedSortable ui-sortable">
  

        <!-- Custom tabs (Charts with tabs)-->
      <div class="card">
        <div class="card-body">
            <span>SALA {{$mesa->sala->nombre}}</span><br>
            <span>MESA {{$mesa->nroEnSala}}</span> <br> <br>

            <label for="">Mesero: </label>        
                  
            <select class="form-control select2 select2-hidden-accessible selectpicker" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="cliente_id" name="cliente_id" data-live-search="true" onchange="">
                <option value="0" selected>- Seleccione Mesero -</option>          
                    @foreach($meseros as $itemmesero)
                        <option value="{{ $itemmesero->codEmpleado }}" >{{ $itemmesero->apellidos }}, {{$itemmesero->nombres}}</option>                                 
                    @endforeach            
            </select>

        </div>
      </div>


    </section>

</div>

@section('script')  
     <script src="/calendario/js/bootstrap-datepicker.min.js"></script>
     <script src="/calendario/locales/bootstrap-datepicker.es.min.js"></script>
     <script src="/select2/bootstrap-select.min.js"></script> 
@endsection


  @endsection