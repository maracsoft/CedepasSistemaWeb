<div class="row">

    <div class="col-md-6 offset-md-3">  

        <div class="form-group ">
            <label class="control-label {{ $errors->has('codEmpleadoResponsable')?'has-error':'' }}">Seleccione Responsable
                <star>*</star>
            </label>

            @if($errors->has('codEmpleadoResponsable'))
            {!! Form::select('codEmpleadoResponsable',$empleado->pluck('apellidos','codEmpleado'),null,['class' => 'form-control is-invalid','placeholder' => 'Porfavor Seleccione un responsable']) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('codEmpleadoResponsable') }}</strong>
                </span>
            @else
            {!! Form::select('codEmpleadoResponsable',$empleado->pluck('apellidos','codEmpleado'),null,['class' => 'form-control','placeholder' => 'Porfavor Seleccione un responsable']) !!}
            @endif
        </div>

    </div>

    <div class="col-md-6 offset-md-3">  

        <div class="form-group ">
            <label class="control-label {{ $errors->has('codEmpleadoEncargadoAlmacen')?'has-error':'' }}">Seleccione Encargado de Almacen
                <star>*</star>
            </label>

            @if($errors->has('codEmpleadoEncargadoAlmacen'))
            {!! Form::select('codEmpleadoEncargadoAlmacen',$empleado->pluck('apellidos','codEmpleado'),@$idEncargado,['class' => 'form-control is-invalid','placeholder' => 'Porfavor Seleccione un encargado','disabled' => true]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('codEmpleadoEncargadoAlmacen') }}</strong>
                </span>
            @else
            {!! Form::select('codEmpleadoEncargadoAlmacen',$empleado->pluck('apellidos','codEmpleado'),@$idEncargado,['class' => 'form-control','placeholder' => 'Porfavor Seleccione un encargado','disabled' => true]) !!}
            @endif
        </div>

    </div>

    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('fecha')?'has-error':'' }}">Ingrese Fecha 
                <star>*</star>
            </label>

            @if($errors->has('fecha'))
                {!! Form::date('fecha',@$fecha,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Fecha','disabled' => true ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('fecha') }}</strong>
                </span>
            @else
                {!! Form::date('fecha',@$fecha,['class' => 'form-control','placeholder' => 'Ingrese Fecha','disabled' => true]) !!}
            @endif
        </div>

    </div>

    <div class="col-md-6 offset-md-3">

        <div class="form-group ">
            <label class="control-label {{ $errors->has('observaciones')?'has-error':'' }}">Ingrese Observaciones 
                <star>*</star>
            </label>

            @if($errors->has('observaciones'))
                {!! Form::textarea('observaciones',null,['class' => 'form-control is-invalid','placeholder' => 'Ingrese Observaciones','rows' => 4, 'cols' => 54 ]) !!}
                <span class="help-block">
                    <strong>{{ $errors->first('observaciones') }}</strong>
                </span>
            @else
                {!! Form::textarea('observaciones',null,['class' => 'form-control','placeholder' => 'Ingrese Observaciones','rows' => 4, 'cols' => 54]) !!}
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
                    {!! Form::number('step',null,['class' => 'form-control','placeholder' => 'Cantidad','id' => 'step', 'onkeypress'=>"return validateNumberLetter(event,this);" ]) !!}
                </div>

                <div class="col-md-3">
                    <button type="button" class="btn btn-rounded btn-success" id="btnAgregarMov" data-url="{{ route('ingreso.validar') }}">
                            <span class="btn-label">
                                <i class="fa fa-plus-circle"></i>
                            </span>                        
                    </button>
                    <button type="button" class="btn btn-rounded btn-primary" data-toggle="modal" data-target="#modal-existencia">
                            <span class="btn-label">
                                <i class="fa fa-search"></i>
                            </span>                        
                    </button>
                </div>

            </div>

            
            
        </div>

    </div>

    <div class="col-md-6 offset-md-3">

        <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <!-- <th style="width: 10px">#</th> -->
                      <th style="width: 20px">Cod.</th>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th style="width: 10px"></th>
                    </tr>
                  </thead>
                  <tbody id="tbody_codExistente">

                   
                    <!-- <tr>
                      <td>1.</td>
                      <td>Update software</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-danger">55%</span></td>
                    </tr>
                  </tbody> -->
                </table>

    </div>

    {!! Form::hidden('codArray',null,['id' => 'codArray' ]) !!}
   
    {!! Form::hidden('tipoMov',1,['id' => 'tipoMov' ]) !!}

</div>