@extends('layouts.app')

@section('title')
    Ingreso
@endsection

@section('page-header')
    Lista de Ingresos
@endsection

@section('content')

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Lista de Ingresos</h3>

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

            <div class="row">
                <div class="col-12">
                    <a  class="btn btn-primary " href="{{ route('ingreso.create') }}"><i class="fa fa-plus"></i> Agregar</a>
                </div>

                <hr>

                <div class="col-12 mt-3">
                    <table id="general-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Reponsable</th>
                                <th>Enc. Almacen</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($models))

                            @foreach($models as $data)
                                <tr >
                               
                                    <td>{{ $data->empleadoResponsable->full_name }} </td>
                                    <td>{{ $data->empleadoAlmacen->full_name }} </td>
                                    <td>{{ $data->fecha }}</td>
                                    <td>{{ $data->descripcion }}</td>
                                    <td class="center">
                                        <!-- <a href="{{ route('ingreso.edit',$data->codMovimiento) }}" class="btn btn-info"
                                            title="Editar">
                                            <i class="fa fa-edit"></i>
                                        </a> -->

                                        <a href="#" class="btn btn-danger btn-delete"
                                            title="Eliminar"
                                            data-url="{{ route('ingreso.delete') }}"
                                            data-id="{{ $data->codMovimiento }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            
                            @endforeach

                            @else

                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Reponsable</th>
                                <th>Enc. Almacen</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Opciones</th>
                            </tr>
                        </tfoot>
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

@endsection

@section('script')
    
    
    <script>
        datatable.init();
        app.init();
    </script>
        

@endsection