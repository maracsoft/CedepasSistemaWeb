<div class="row">

    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label">Ingrese Producto 
                <star>*</star>
            </label>

            <div class="row">
                <div class="col-md-6">
                {!! Form::select('codCategoria',$categoria->pluck('nombre','codCategoria'),null,['class' => 'form-control','placeholder' => 'Seleccione Categoria','id' => 'codCategoria']) !!}
                </div>

                <div class="col-md-6">
                    <select class="form-control" name="codExistencia" id="codExistencia" data-url="{{route('existencia.searchByCategory')}}">
                        <option value="">Seleccione Existente</option>
                    </select>
                </div>


                
            </div>

            
            
        </div>
        <div class="form-group ">
            <label class="control-label">Seleccione fecha de inicio y fin
                <star>*</star>
            </label>
            <div class="row">
                <div class="col-md-6">
                    {!! Form::date('fecha_inicio',@$fecha,['class' => 'form-control','placeholder' => 'Ingrese Fecha Inicio', 'id' => 'fecha_inicio']) !!}
                </div>

                <div class="col-md-6">
                {!! Form::date('fecha_fin',@$fecha,['class' => 'form-control','placeholder' => 'Ingrese Fecha Fin', 'id' => 'fecha_fin']) !!}
                </div>

            </div>
        </div>
        <div class="form-group ">
            <div class="row">

                <div class="col-md-3">
                
                    <button type="button" class="btn btn-rounded btn-primary" id="btn_buscar" data-url="{{route('searchReporte')}}">
                            <span class="btn-label">
                                <i class="fa fa-search"></i>
                            </span>  
                            Buscar
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>