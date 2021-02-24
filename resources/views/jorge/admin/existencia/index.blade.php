@extends('layouts.app')

@section('title')
    Existencia
@endsection

@section('page-header')
    Lista de Existencias
@endsection

@section('content')

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Lista de Existencias</h3>

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
                    <a  class="btn btn-primary " href="{{ route('existencia.create') }}"><i class="fa fa-plus"></i> Agregar</a>
                </div>

                <hr>

                <div class="col-12 mt-3">
                    <table id="general-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>Categoria</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($models))

                            @foreach($models as $data)
                                <tr >
                               
                                    <td>{{ $data->codigoInterno }}</td>
                                    <td>{{ $data->nombre }}</td>
                                    <td>{{ $data->stock }}</td>
                                    <td>{{ $data->categoria->nombre }}</td>

                                    <td class="center">
                                        <a href="{{ route('existencia.edit',$data->codExistencia) }}" class="btn btn-info"
                                            title="Editar">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="#" class="btn btn-danger btn-delete"
                                            title="Eliminar"
                                            data-url="{{ route('existencia.delete') }}"
                                            data-id="{{ $data->codExistencia }}">
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
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>Categoria</th>
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