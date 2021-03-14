<?php

use Illuminate\Support\Facades\Route;



Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login

Route::post('/ingresar', 'UserController@logearse')->name('user.logearse');

Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');



Route::get('/', 'UserController@home')->name('user.home');











/* --------------------------------------------      MODULO VIGO       -------------------------------------------------- */

/* RUTAS SERVICIOS */
Route::get('/listarDetallesDeSolicitud/{id}','SolicitudFondosController@listarDetalles');
Route::get('/listarDetallesDeRendicion/{id}','RendicionGastosController@listarDetalles');



Route::get('/listarDeEmpleado','SolicitudFondosController@listarSolicitudesDeEmpleado')
    ->name('solicitudFondos.listarEmp');

Route::get('/listarDeDirector','SolicitudFondosController@listarSolicitudesParaGerente')
    ->name('solicitudFondos.listarGerente');
Route::get('/listarDeJefeAdmin','SolicitudFondosController@listarSolicitudesParaJefe')
    ->name('solicitudFondos.listarJefeAdmin');

//ruta para regresar al index de solicitudes del actor que esté logeado
Route::get('/irAIndex','SolicitudFondosController@listarSolicitudes')
    ->name('solicitudFondos.listarSolicitudes');



Route::get('/SolicitudFondos/Revisar/{id}','SolicitudFondosController@revisar')
    ->name('solicitudFondos.revisar');


//vista para ver namas (empleado)
Route::get('/Emp/SolicitudFondos/ver/{id}','SolicitudFondosController@ver')
    ->name('solicitudFondos.ver');
    

Route::get('/SolicitudFondos/vistaAbonar/{id}','SolicitudFondosController@vistaAbonar')
    ->name('solicitudFondos.vistaAbonar');

Route::post('/SolicitudFondos/Abonar/','SolicitudFondosController@abonar')
    ->name('solicitudFondos.abonar');


Route::get('/SolicitudFondos/descargarComprobanteAbono/{id}','SolicitudFondosController@descargarComprobanteAbono')
    ->name('solicitudFondos.descargarComprobanteAbono');
    


Route::get('/SolicitudFondos/Aprobar/{id}','SolicitudFondosController@aprobar')
    ->name('solicitudFondos.aprobar');
    
        

Route::get('/SolicitudFondos/Rendir/{id}','SolicitudFondosController@rendir')
->name('solicitudFondos.rendir');


Route::get('/SolicitudFondos/Observar/{value}','SolicitudFondosController@observar')
->name('solicitudFondos.observar');

Route::get('/SolicitudFondos/rechazar/{id}','SolicitudFondosController@rechazar')
->name('solicitudFondos.rechazar');


Route::get('/crearSolicitudFondos','SolicitudFondosController@create')
->name('solicitudFondos.create');

Route::get('/editarSolicitudFondos/{id}','SolicitudFondosController@edit')
->name('solicitudFondos.edit');


Route::get('/solicitudes/delete/{id}','SolicitudFondosController@delete')
->name('solicitudFondos.delete');

Route::get('/solicitudes/reportes/','SolicitudFondosController@reportes')
->name('solicitudFondos.reportes');


Route::post('/updateSolicitud/{id}','SolicitudFondosController@update')
    ->name('solicitudFondos.update');

Route::get('/SolicitudFondos/descargar/{id}','SolicitudFondosController@descargarPDF')
    ->name('solicitudFondos.descargarPDF');

Route::get('/SolicitudFondos/verPDF/{id}','SolicitudFondosController@verPDF')
    ->name('solicitudFondos.verPDF');



Route::post('/guardarSolicitud', 'SolicitudFondosController@store')->name('solicitudFondos.store');

/* RENDICIONES */

Route::post('/guardarRendicion', 'RendicionGastosController@store')->name('rendicionGastos.store');

Route::get('/verRendicion/emp/{id}', 'RendicionGastosController@ver')->name('rendicionGastos.ver');

Route::get('/verRendicion/admin/{id}', 'RendicionGastosController@verAdmin')->name('rendicionGastos.verAdmin');

Route::get('/verRendicion/gerente/{id}', 'RendicionGastosController@verGerente')->name('rendicionGastos.verGerente');

Route::get('/rendiciones/editar/{idRend}','RendicionGastosController@editar')->name('rendicionGastos.editar');

Route::Post('/rendiciones/update/','RendicionGastosController@update')->name('rendicionGastos.update');


Route::get('/rendiciones/revisar/{id}','RendicionGastosController@revisar')->name('rendicionGastos.revisar');
Route::get('/rendiciones/aprobar/{id}','RendicionGastosController@aprobar')->name('rendicionGastos.aprobar');
Route::get('/rendiciones/rechazar/{id}','RendicionGastosController@rechazar')->name('rendicionGastos.rechazar');
Route::get('/rendiciones/observar/{string}','RendicionGastosController@observar')->name('rendicionGastos.observar');


//RUTA MAESTAR QUE REDIRIJE A LOS LISTADOS DE RENDICIONES DE LOS ACTORES EMP GER Y J.A
Route::get('/rendiciones/listar','RendicionGastosController@listarRendiciones')->name('rendicionGastos.listarRendiciones');


Route::get('/verReponer/{id}', 'RendicionGastosController@verReponer')->name('rendicionGastos.verReponer');
Route::post('/rendicion/reponer/','RendicionGastosController@reponer')
    ->name('rendicionGastos.reponer');


Route::post('/reportes/ver', 'RendicionGastosController@reportes')->name('rendicionGastos.reportes');


Route::get('/reportes/descargar/{str}', 'RendicionGastosController@descargarReportes')
    ->name('rendicionGastos.descargarReportes');


Route::get('/rendicion/descargarCDPDetalle/{id}','RendicionGastosController@descargarCDPDetalle')->name('rendicion.descargarCDPDetalle');


//esta ruta sirve tanto como para el comprobante de envio empleado->cedepas como para la reposicion de cedepas->empleado
Route::get('/rendicion/descargarArchivoRendicion/{id}','RendicionGastosController@descargarArchivoRendicion')->name('rendicion.descargarArchivoRendicion');



Route::get('/rendicion/listarJefeAdmin/','RendicionGastosController@listarJefeAdmin')->name('rendicionGastos.listarJefeAdmin');
Route::get('/rendicion/listarGerente/','RendicionGastosController@listarDelGerente')->name('rendicionGastos.listarGerente');

Route::get('/rendicion/listarEmpleado/','RendicionGastosController@listarEmpleado')->name('rendicionGastos.listarEmpleado');

Route::get('/rendicion/descargarPDF/{id}','RendicionGastosController@descargarPDF')->name('rendicionGastos.descargarPDF');
Route::get('/rendicion/verPDF/{id}','RendicionGastosController@verPDF')->name('rendicionGastos.verPDF');



/* ----------------------------------------------        MODULO FELIX           ------------------------------------------ */


/**GESTIONAR EMPLEADOS */
Route::get('/listarEmpleados','EmpleadoController@listarEmpleados');
Route::post('/listarPuestos/{id}','EmpleadoController@listarPuestos');

Route::get('/crearEmpleado','EmpleadoController@crearEmpleado');
Route::post('/crearEmpleado/save','EmpleadoController@guardarCrearEmpleado');

Route::get('/editarEmpleado/{id}','EmpleadoController@editarEmpleado');
Route::post('/editarEmpleado/save','EmpleadoController@guardarEditarEmpleado');

Route::get('/cesarEmpleado/{id}','EmpleadoController@cesarEmpleado');


/**GESTIONAR CONTRATOS */
Route::get('/listarEmpleados/listarContratos/{id}','PeriodoEmpleadoController@listarContratos');

Route::get('/listarEmpleados/crearContrato/{id}','PeriodoEmpleadoController@crearContrato');
Route::post('/listarEmpleados/crearContrato/save','PeriodoEmpleadoController@guardarCrearContrato');

Route::get('/listarEmpleados/editarContrato/{id}','PeriodoEmpleadoController@editarContrato');
Route::post('/listarEmpleados/editarContrato/save','PeriodoEmpleadoController@guardarEditarContrato');

Route::get('/listarEmpleados/eliminarContrato/{id}','PeriodoEmpleadoController@eliminarContrato');

Route::get('/exportarContratoPDF/{id}','PeriodoEmpleadoController@exportarContrato');
//-----------GESTIONAR HORARIOS
Route::get('/crearHorario/{id}','PeriodoEmpleadoController@crearHorario');
Route::post('/crearHorario/save','PeriodoEmpleadoController@guardarCrearHorario');

Route::get('/editarHorario/{id}','PeriodoEmpleadoController@editarHorario');
Route::post('/editarHorario/save','PeriodoEmpleadoController@guardarEditarHorario');


/**GESTIONAR AREAS */
Route::get('/listarAreas','AreaController@listarAreas');

Route::get('/crearArea','AreaController@crearArea');
Route::post('/crearArea/save','AreaController@guardarCrearArea');

Route::get('/editarArea/{id}','AreaController@editarArea');
Route::post('/editarArea/save','AreaController@guardarEditarArea');

Route::get('/eliminarArea/{id}','AreaController@eliminarArea');

/**GESTIONAR PUESTOS */
Route::get('/listarPuestos/{id}','PuestoController@listarPuestos');

Route::get('/crearPuesto/{id}','PuestoController@crearPuesto');
Route::post('/crearPuesto/save','PuestoController@guardarCrearPuesto');

Route::get('/editarPuesto/{id}','PuestoController@editarPuesto');
Route::post('/editarPuesto/save','PuestoController@guardarEditarPuesto');

Route::get('/eliminarPuesto/{id}','PuestoController@eliminarPuesto');

/**GESTIONAR ASISTENCIAS */
/*********EMPLEADOS */
Route::get('/marcarAsistencia/{id}','AsistenciaController@marcarAsistencia');
Route::get('/marcarAsistencia/marcar/{id}','AsistenciaController@marcar');
/*********JEFE DE RRHH */
Route::get('/listarAsistencia','AsistenciaController@listarAsistencia');
Route::post('/listarAsistencia/{id}','AsistenciaController@filtroAsistencia');
Route::get('/exportarReportePDF/{id}','AsistenciaController@exportarReporte');


/**GESTIONAR SOLICITUDES */
/*********EMPLEADOS */
Route::get('/listarSolicitudes/{id}','SolicitudFaltaController@listarSolicitudes');

Route::get('/crearSolicitud/{id}','SolicitudFaltaController@crearSolicitud');
Route::post('/crearSolicitud/save','SolicitudFaltaController@guardarCrearSolicitud');

Route::get('/editarSolicitud/{id}','SolicitudFaltaController@editarSolicitud');
Route::post('/editarSolicitud/save','SolicitudFaltaController@guardarEditarSolicitud');

Route::get('/eliminarSolicitud/{id}','SolicitudFaltaController@eliminarSolicitud');

Route::get('/mostrarSolicitud/{id}','SolicitudFaltaController@mostrarAdjunto');
/*********JEFE DE RRHH */
Route::get('/listarSolicitudesJefe','SolicitudFaltaController@listarSolicitudesJefe');
Route::get('/evaluarSolicitud/{id}','SolicitudFaltaController@evaluarSolicitud');


/**----------------------------       GESTIONAR JUSTIFICACIONES    -------------------- */
/*********EMPLEADOS */
Route::get('/listarJustificaciones/{id}','JustificacionFaltaController@listarJustificaciones');

Route::get('/crearJustificacion/{id}','JustificacionFaltaController@crearJustificacion');
Route::post('/crearJustificacion/save','JustificacionFaltaController@guardarCrearJustificacion');

Route::get('/editarJustificacion/{id}','JustificacionFaltaController@editarJustificacion');
Route::post('/editarJustificacion/save','JustificacionFaltaController@guardarEditarJustificacion');

Route::get('/eliminarJustificacion/{id}','JustificacionFaltaController@eliminarJustificacion');

Route::get('/mostrarJustificacion/{id}','JustificacionFaltaController@mostrarAdjunto');
/*********JEFE DE RRHH */
Route::get('/listarJustificacionesJefe','JustificacionFaltaController@listarJustificacionesJefe');
Route::get('/evaluarJustificacion/{id}','JustificacionFaltaController@evaluarJustificacion');


/* --------------------------------------- MODULO MARSKY -------------------------------------------------- */


Route::get('/CC/admin/revisar/{id}','PeriodoCajaController@verRevisarPeriodo')->name('admin.periodoCaja.revisar'); 

Route::get('/CC/admin/reponer/{id}','PeriodoCajaController@reponer')->name('admin.periodoCaja.reponer'); 

Route::get('/CC/admin/listarPeriodos/','PeriodoCajaController@listarPeriodosActuales')->name('admin.listaPeriodos');

Route::get('/CC/resp/periodo/{id}','PeriodoCajaController@verPeriodoCajaParaResp')->name('resp.verPeriodo');
Route::get('/CC/resp/registrarGasto','PeriodoCajaController@verRegistrarGasto')
    ->name('resp.registrarGasto');

Route::get('/CC/resp/verLiquidarCaja/{id}','PeriodoCajaController@verLiquidar')
    ->name('resp.verLiquidarPeriodo');

Route::get('/CC/resp/descargarCDP/{id}','GastoCajaController@descargarCDP')
    ->name('gasto.descargarCDP');


Route::post('/CC/resp/liquidarPeriodo/','PeriodoCajaController@liquidar')
    ->name('resp.liquidarPeriodo');


Route::post('/CC/resp/gastoNuevo','GastoCajaController@store')->name('gasto.store');

Route::get('/CC/resp/listarMisPeriodos/','PeriodoCajaController@listarMisPeriodos')
    ->name('resp.listarMisPeriodos');


Route::get('/CC/resp/aperturarPeriodo/','PeriodoCajaController@aperturarPeriodo')
    ->name('resp.aperturarPeriodo');


//mantener cajas 
Route::get('/CC/admin/verCajas/','CajaController@listar')->name('caja.index');
Route::get('/CC/admin/crearCaja/','CajaController@verCrear')->name('caja.verCrear');

Route::post('/CC/admin/storeCaja/','CajaController@store')->name('caja.store');
Route::get('CC/admin/editCaja/{codCaja}','CajaController@edit')->name('caja.edit');
Route::post('CC/admin/updateCaja/{codCaja}','CajaController@update')->name('caja.update');

Route::get('CC/admin/destroyCaja/{codCaja}','CajaController@destroy')->name('caja.destroy');

// DECLARAR IMPUESTOS

Route::get('/listarPagosPlanilla','GastoPlanillaController@listar')->name('pagoPlanilla.listar');

Route::get('/crearPagoPlanilla/','GastoPlanillaController@create')->name('pagoPlanilla.create');
Route::get('/storePagoPlanilla/','GastoPlanillaController@store')->name('pagoPlanilla.store');

Route::get('/verPagoPlanilla/{mes}','GastoPlanillaController@ver')->name('pagoPlanilla.ver');

/* --------------------------------------- MODULO RENZO -------------------------------------------------- */
Route::get('/gestionInventario/cambiarEstado/{id}','GestionInventarioController@cambiarEstadoDetalle');
Route::get('/gestionInventario/filtro/{id}','GestionInventarioController@filtroDetalles');
Route::get('/gestionInventario/{id}/eliminar','GestionInventarioController@delete')->name('gestionInventario.delete');
Route::resource('gestionInventario', GestionInventarioController::class);

Route::resource('activos', ActivoController::class);
Route::get('/actualizarActivos/mostrarRevisiones','GestionInventarioController@mostrarRevisiones')->name('gestionInventario.mostrarRevisiones');
Route::get('/actualizarActivos/mostrarActivos/{id}','ActivoController@mostrarActivos')->name('activos.mostrarActivos');
Route::get('/actualizarActivos/habilidarActivo/{id}','ActivoController@habilitarActivo')->name('activos.habilitarActivo');
Route::get('/actualizarActivos/cambiarEstado/{id}','GestionInventarioController@cambiarEstado');






/* ------------------------------ ---------------- MODULO JORGE -------------- ------------------------------ */


Route::name('exportar')->get('/exportar', 'ExportarController@exportar');
Route::name('print')->get('/imprimir', 'ExportarController@imprimir');
Route::name('print2')->get('/imprimir2', 'ExportarController@imprimir2');

Route::name('reporte')->get('/reporte', 'ExportarController@reporte');

Route::name('searchReporte')->post('/searchReporte', 'ExportarController@searchReporte');

Route::group(['prefix' => 'categoria'], function () {
    Route::get('/', ['as' => 'categoria.index', 'uses' => 'CategoriaController@index']);
    Route::get('/create', ['as' => 'categoria.create', 'uses' => 'CategoriaController@create']);
    Route::post('/create', ['as' => 'categoria.create', 'uses' => 'CategoriaController@store']);
    Route::get('/edit/{id}', ['as' => 'categoria.edit', 'uses' => 'CategoriaController@edit']);
    Route::post('/edit/{id}', ['as' => 'categoria.edit', 'uses' => 'CategoriaController@update']);
    Route::post('/delete', ['as' => 'categoria.delete', 'uses' => 'CategoriaController@destroy']);
});

Route::group(['prefix' => 'existencia'], function () {
    Route::get('/', ['as' => 'existencia.index', 'uses' => 'ExistenciaController@index']);
    Route::get('/create', ['as' => 'existencia.create', 'uses' => 'ExistenciaController@create']);
    Route::post('/create', ['as' => 'existencia.create', 'uses' => 'ExistenciaController@store']);
    Route::get('/edit/{id}', ['as' => 'existencia.edit', 'uses' => 'ExistenciaController@edit']);
    Route::post('/edit/{id}', ['as' => 'existencia.edit', 'uses' => 'ExistenciaController@update']);
    Route::post('/delete', ['as' => 'existencia.delete', 'uses' => 'ExistenciaController@destroy']);
    
    Route::post('/search', ['as' => 'existencia.search', 'uses' => 'ExistenciaController@search']);
    Route::post('/searchByCategory', ['as' => 'existencia.searchByCategory', 'uses' => 'ExistenciaController@searchByCategory']);
});

Route::group(['prefix' => 'ingreso'], function () {
    Route::get('/', ['as' => 'ingreso.index', 'uses' => 'IngresoController@index']);
    Route::get('/create', ['as' => 'ingreso.create', 'uses' => 'IngresoController@create']);
    Route::post('/create', ['as' => 'ingreso.create', 'uses' => 'IngresoController@store']);
    Route::get('/edit/{id}', ['as' => 'ingreso.edit', 'uses' => 'IngresoController@edit']);
    Route::post('/edit/{id}', ['as' => 'ingreso.edit', 'uses' => 'IngresoController@update']);
    Route::post('/delete', ['as' => 'ingreso.delete', 'uses' => 'IngresoController@destroy']);

    Route::post('/validar', ['as' => 'ingreso.validar', 'uses' => 'IngresoController@validarCodigo']);
});

Route::group(['prefix' => 'salida'], function () {
    Route::get('/', ['as' => 'salida.index', 'uses' => 'SalidaController@index']);
    Route::get('/create', ['as' => 'salida.create', 'uses' => 'SalidaController@create']);
    Route::post('/create', ['as' => 'salida.create', 'uses' => 'SalidaController@store']);
    Route::get('/edit/{id}', ['as' => 'salida.edit', 'uses' => 'SalidaController@edit']);
    Route::post('/edit/{id}', ['as' => 'salida.edit', 'uses' => 'SalidaController@update']);
    Route::post('/delete', ['as' => 'salida.delete', 'uses' => 'SalidaController@destroy']);
});

Route::group(['prefix' => 'existenciaPerdida'], function () {
    Route::get('/', ['as' => 'existenciaPerdida.index', 'uses' => 'ExistenciaPerdidaController@index']);
    Route::get('/create', ['as' => 'existenciaPerdida.create', 'uses' => 'ExistenciaPerdidaController@create']);
    Route::post('/create', ['as' => 'existenciaPerdida.create', 'uses' => 'ExistenciaPerdidaController@store']);
    Route::get('/edit/{id}', ['as' => 'existenciaPerdida.edit', 'uses' => 'ExistenciaPerdidaController@edit']);
    Route::post('/edit/{id}', ['as' => 'existenciaPerdida.edit', 'uses' => 'ExistenciaPerdidaController@update']);
    Route::post('/delete', ['as' => 'existenciaPerdida.delete', 'uses' => 'ExistenciaPerdidaController@destroy']);

});





/**MODULO  "Reposiciones de Fondos a empleados"*/
Route::get('/Emp/Reposiciones/listar/{id}','ReposicionGastosController@listarOfEmpleado')->name('reposicionGastos.listar');

Route::get('/Emp/Reposiciones/crear','ReposicionGastosController@create')->name('reposicionGastos.create');
Route::post('/Emp/Reposiciones/store','ReposicionGastosController@store')->name('reposicionGastos.store');

/*


Route::post('/listarPuestos/{id}','EmpleadoController@listarPuestos');

Route::get('/crearEmpleado','EmpleadoController@crearEmpleado');
Route::post('/crearEmpleado/save','EmpleadoController@guardarCrearEmpleado');

Route::get('/editarEmpleado/{id}','EmpleadoController@editarEmpleado');
Route::post('/editarEmpleado/save','EmpleadoController@guardarEditarEmpleado');

Route::get('/cesarEmpleado/{id}','EmpleadoController@cesarEmpleado');*/




/* MODULO PROYECTOS  */

Route::get('/asignarGerentes','ProyectoController@listarProyectosYGerentes')
    ->name('proyecto.asignarGerentes');