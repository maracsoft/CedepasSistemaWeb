<!-- <a href="{{ route('print') }}">Exportar</a> -->
@extends('layouts.app')

@section('title')
    Reporte
@endsection

@section('page-header')
Registro de Reportes
@endsection

@section('content')

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
            
            @include('admin.exportar.fields')

            <div class="col-md-12 -col-md-12">
                <div class="form-group text-center">
                <table class="table table-bordered">
                    <thead>                  
                        <tr>
                            <!-- <th style="width: 10px">#</th> -->
                            <!-- <th style="width: 20px">#</th> -->
                            <th>Fecha</th>
                            <th>Responsable</th>
                            <th>Movimiento</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_movimiento">
                        
                    </tbody>
                    </table>
                </div>
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
        reporte.load();
    </script>
        

@endsection