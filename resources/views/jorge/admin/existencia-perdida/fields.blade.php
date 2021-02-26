<div class="row">

    <div class="col-md-6 offset-md-3">  

        <div class="form-group ">
            <label class="control-label {{ $errors->has('codEmpleadoEncargadoAlmacen')?'has-error':'' }}">Seleccione Encargado de almacen
                <star>*</star>
            </label>

            @if($errors->has('codEmpleadoEncargadoAlmacen'))
            {!! Form::select('codEmpleadoEncargadoAlmacen',$empleado->pluck('apellidos','codEmpleado'),@$idEncargado,['class' => 'form-control is-invalid','placeholder' => 'Porfavor Seleccione un Encargado de almacen', 'disabled' => true]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('codEmpleadoEncargadoAlmacen') }}</strong>
                </span>
            @else
            {!! Form::select('codEmpleadoEncargadoAlmacen',$empleado->pluck('apellidos','codEmpleado'),@$idEncargado,['class' => 'form-control','placeholder' => 'Porfavor Seleccione un Encargado de almacen', 'disabled' => true]) !!}
            @endif
        </div>

    </div>

    <div class="col-md-6 offset-md-3">
        <div class="form-group ">
            <label class="control-label {{ $errors->has('fecha')?'has-error':'' }}">Ingrese Fecha 
                <star>*</star>
            </label>

            @if($errors->has('fecha'))
                {!! Form::date('fecha',@$fecha,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Fecha', 'disabled' => true ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('fecha') }}</strong>
                </span>
            @else
                {!! Form::date('fecha',@$fecha,['class' => 'form-control','placeholder' => 'Ingrese Fecha', 'disabled' => true]) !!}
            @endif
        </div>
    </div>

    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('descripcion')?'has-error':'' }}">Ingrese descripcion 
                <star>*</star>
            </label>

            @if($errors->has('descripcion'))
                {!! Form::textarea('descripcion',null,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Descripcion','rows' => 4, 'cols' => 54 ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('descripcion') }}</strong>
                </span>
            @else
                {!! Form::textarea('descripcion',null,['class' => 'form-control','placeholder' => 'Ingrese Descripcion','rows' => 4, 'cols' => 54]) !!}
            @endif
        </div>

    </div>
    
    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label">Ingrese Producto 
                <star>*</star>
            </label>

            <div class="row">
                <div class="col-md-6">
                    {!! Form::text('codExistencia',null,['class' => 'form-control','placeholder' => 'Codigo','id' => 'codExistencia', 'onkeypress'=>"return validateNumberLetter(event,this);" ]) !!}
                </div>

                <div class="col-md-3">
                    {!! Form::number('cantidad',null,['class' => 'form-control','placeholder' => 'Cantidad','id' => 'cantidad', 'onkeypress'=>"return validateNumberLetter(event,this);" ]) !!}
                </div>

                <div class="col-md-3">
                    <button type="button" class="btn btn-rounded btn-primary" data-toggle="modal" data-target="#modal-existencia">
                            <span class="btn-label">
                                <i class="fa fa-search"></i>
                            </span>                        
                    </button>
                </div>

            </div>

            
            
        </div>

    </div>
    {!! Form::hidden('tipoMov',3,['id' => 'tipoMov' ]) !!}
</div>