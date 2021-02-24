<div class="modal fade" id="modal-existencia">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Buscar Producto</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="row">

            <div class="col-md-6 offset-md-3">

                <div class="form-group ">
                    <!-- <label class="control-label">Ingrese Categoria 
                    </label> -->

                    <input type="radio" value="1" name="rbGrupo" checked> Por codigo
                    <input type="radio" value="2" name="rbGrupo"> Por nombre
                    
                </div>

                

            </div>

            <div class="col-md-8 offset-md-2">

                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="txtBuscar">
                        </div>

                        <div class="col-md-3">
                            <button type="button" class="btn btn-rounded btn-primary" id="btnSearchModal" data-url="{{ route('existencia.search') }}">
                                    <span class="btn-label">
                                        <i class="fa fa-search"></i>
                                    </span>                        
                            </button>
                        </div>

                    </div>                    
                </div>

            </div>

            <div class="col-md-8 offset-md-2">

                <table class="table table-bordered">
                        <thead>                  
                            <tr>
                            <!-- <th style="width: 10px">#</th> -->
                            <th style="width: 20px">Cod.</th>
                            <th>Producto</th>
                            <th style="width: 20px">Stock</th>
                            <th style="width: 10px"></th>
                            </tr>
                        </thead>
                        <tbody id="tbody_codExistenteSearch">

                        
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
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>