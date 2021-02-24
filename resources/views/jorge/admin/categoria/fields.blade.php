<div class="row">

    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('nombre')?'has-error':'' }}">Ingrese Categoria 
                <star>*</star>
            </label>

            @if($errors->has('nombre'))
                {!! Form::text('nombre',null,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Categoria' ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('nombre') }}</strong>
                </span>
            @else
                {!! Form::text('nombre',null,['class' => 'form-control','placeholder' => 'Ingrese Categoria']) !!}
            @endif
        </div>

    </div>

   
    

</div>