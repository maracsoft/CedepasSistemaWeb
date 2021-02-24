<div class="row">

    <!-- <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('codExistencia')?'has-error':'' }}">Ingrese Codigo 
                <star>*</star>
            </label>

            @if($errors->has('codExistencia'))
                {!! Form::text('codExistencia',@$codigo,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Codigo','onkeypress'=>"return validateNumberNatural(event,this);",'maxlength'=>'4','readonly' => true ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('codExistencia') }}</strong>
                </span>
            @else
                {!! Form::text('codExistencia',@$codigo,['class' => 'form-control','placeholder' => 'Ingrese Codigo', 'onkeypress'=>"return validateNumberNatural(event,this);",'maxlength'=>'4','readonly' => true]) !!}
            @endif
        </div>

    </div> -->

    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('codigoInterno')?'has-error':'' }}">Ingrese Codigo 
                <star>*</star>
            </label>

            @if($errors->has('codigoInterno'))
                {!! Form::text('codigoInterno',null,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Codigo','maxlength'=>'8','onkeypress'=>"return validateNumberLetter(event,this);",'readonly' => @$model->codigoInterno ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('codigoInterno') }}</strong>
                </span>
            @else
                {!! Form::text('codigoInterno',null,['class' => 'form-control','placeholder' => 'Ingrese Codigo','maxlength'=>'8', 'onkeypress'=>"return validateNumberLetter(event,this);",'readonly' => @$model->codigoInterno]) !!}
            @endif
        </div>

    </div>

    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('nombre')?'has-error':'' }}">Ingrese Nombre de la existencia 
                <star>*</star>
            </label>

            @if($errors->has('nombre'))
                {!! Form::text('nombre',null,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Nombre de la existencia' ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('nombre') }}</strong>
                </span>
            @else
                {!! Form::text('nombre',null,['class' => 'form-control','placeholder' => 'Ingrese Nombre de la existencia']) !!}
            @endif
        </div>

    </div>

    <!-- <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('stock')?'has-error':'' }}">Ingrese Stock 
                <star>*</star>
            </label>

            @if($errors->has('stock'))
                {!! Form::number('stock',null,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Stock','onkeypress'=>"return validateNumberNatural(event,this);", 'min'=> '1' ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('stock') }}</strong>
                </span>
            @else
                {!! Form::number('stock',null,['class' => 'form-control','placeholder' => 'Ingrese Stock', 'onkeypress'=>"return validateNumberNatural(event,this);" , 'min'=> '1']) !!}
            @endif
        </div>

    </div> -->

    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('marca')?'has-error':'' }}">Ingrese Marca 
                <star>*</star>
            </label>

            @if($errors->has('marca'))
                {!! Form::text('marca',null,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Marca' ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('marca') }}</strong>
                </span>
            @else
                {!! Form::text('marca',null,['class' => 'form-control','placeholder' => 'Ingrese Marca']) !!}
            @endif
        </div>

    </div>
    
    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('unidad')?'has-error':'' }}">Ingrese Unidad 
                <star>*</star>
            </label>

            @if($errors->has('unidad'))
                {!! Form::text('unidad',null,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Unidad' ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('unidad') }}</strong>
                </span>
            @else
                {!! Form::text('unidad',null,['class' => 'form-control','placeholder' => 'Ingrese Unidad']) !!}
            @endif
        </div>

    </div>

    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('codCategoria')?'has-error':'' }}">Seleccione Categoría
                <star>*</star>
            </label>

            @if($errors->has('codCategoria'))
            {!! Form::select('codCategoria',$categoria->pluck('nombre','codCategoria'),null,['class' => 'form-control is-invalid','placeholder' => 'Porfavor Seleccione una categoria']) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('codCategoria') }}</strong>
                </span>
            @else
            {!! Form::select('codCategoria',$categoria->pluck('nombre','codCategoria'),null,['class' => 'form-control','placeholder' => 'Porfavor Seleccione una categoria']) !!}
            @endif
        </div>

    </div>

    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('modelo')?'has-error':'' }}">Ingrese Modelo 
                <star>*</star>
            </label>

            @if($errors->has('modelo'))
                {!! Form::text('modelo',null,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Modelo' ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('modelo') }}</strong>
                </span>
            @else
                {!! Form::text('modelo',null,['class' => 'form-control','placeholder' => 'Ingrese Modelo']) !!}
            @endif
        </div>

    </div>

</div>