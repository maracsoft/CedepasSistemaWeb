<!-- <a href="{{ route('print') }}">Exportar</a> -->
@extends('layout.plantilla')

@section('title')
    Reporte
@endsection

@section('page-header')
Registro de Reportes
@endsection

@section('contenido')

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Reporte</h3>

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
            <div class="col-md-12 -col-md-12">
                <div class="form-group text-center">
                    <!-- <button type="submit" class="btn btn-rounded btn-success">
                            <span class="btn-label">
                                <i class="fa fa-check"></i>
                            </span>
                        Guardar
                    </button> -->

                    <a href="{{ route('print2') }}" class="btn btn-rounded btn-danger"
                   >
                            <span class="btn-label">
                                <i class="fa fa-file-pdf"></i>
                            </span>
                        Generar Reporte
                    </a>
                </div>
            </div>
            

        <div class="col-md-6 offset-md-3">

            <table class="table table-bordered">
                    <thead>                  
                        <tr>
                            <!-- <th style="width: 10px">#</th> -->
                            <th style="width: 20px">#</th>
                            <th>Producto</th>
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_codExistente">
                        @if(count($models))
                            @foreach($models as $data)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{$data->nombre}}</td>
                                    
                                    <td>{{$data->ingreso}}</td>
                                    <td>{{$data->salida}}</td>
                                    <td>{{$data->stock}}</td>
                                </tr>
                            @endforeach
                        @else

                        @endif
                    
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

            

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->
@include('admin.modals.product')
@endsection

@section('script')
    
    
    <script>
        validacion.init();
        movimiento.modal();
        reporte.init();
    </script>
        

@endsection