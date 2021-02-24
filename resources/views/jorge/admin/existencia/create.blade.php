@extends('layout.plantilla')

@section('title')
    Existencia
@endsection

@section('page-header')
Registro de Existencias
@endsection

@section('contenido')

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Registro de Existencias</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
            </button>
        </div>
        </div>
        <div class="card-body">

            {!! Form::model(null,[
                    'method'=>'POST',
                    'role'=>'form',
                    'class' => 'form-horizontal',
                    'id' =>"frmValidate",
                    'files'=> true,
                    'enctype' => "multipart/form-data"]) !!}

            @include('admin.existencia.fields')

            <div class="col-md-12 -col-md-12">
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-rounded btn-success">
                            <span class="btn-label">
                                <i class="fa fa-check"></i>
                            </span>
                        Guardar
                    </button>

                    <a href="{{ route('existencia.index') }}" class="btn btn-rounded btn-danger">
                            <span class="btn-label">
                                <i class="fa fa-times"></i>
                            </span>
                        Cancelar
                    </a>
                </div>
            </div>

            {!! Form::close() !!}

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@section('script')
    
    
    <script>
        validacion.init();
    </script>
        

@endsection