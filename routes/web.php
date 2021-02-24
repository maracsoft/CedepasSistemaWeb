<?php

use Illuminate\Support\Facades\Route;



Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login

Route::post('/ingresar', 'UserController@logearse')->name('user.logearse');

Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');



Route::get('/', 'UserController@home')->name('user.home');











/* --------------------------------------------      MODULO VIGO       -------------------------------------------------- */

/* RUTAS SERVICIOS */
Route::get('/listarDetallesDeSolicitud/{id}','SolicitudFondosController@listarDetalles');



Route::get('/listarDeEmpleado','SolicitudFondosController@listarSolicitudesDeEmpleado')
    ->name('solicitudFondos.listarEmp');

Route::get('/listarDeDirector','SolicitudFondosController@listarSolicitudesParaDirector')
    ->name('solicitudFondos.listarDirector');
Route::get('/listarDeJefeAdmin','SolicitudFondosController@listarSolicitudesParaJefe')
    ->name('solicitudFondos.listarJefeAdmin');


Route::get('/SolicitudFondos/Revisar/{id}','SolicitudFondosController@revisar')
    ->name('solicitudFondos.revisar');


//vista para ver namas (empleado)
Route::get('/SolicitudFondos/ver/{id}','SolicitudFondosController@ver')
    ->name('solicitudFondos.ver');


    

Route::get('/SolicitudFondos/vistaAbonar/{id}','SolicitudFondosController@vistaAbonar')
    ->name('solicitudFondos.vistaAbonar');

Route::get('/SolicitudFondos/Abonar/{id}','SolicitudFondosController@abonar')
    ->name('solicitudFondos.abonar');

Route::get('/SolicitudFondos/Aprobar/{id}','SolicitudFondosController@aprobar')
    ->name('solicitudFondos.aprobar');
    
        

Route::get('/SolicitudFondos/Rendir/{id}','SolicitudFondosController@rendir')
->name('solicitudFondos.rendir');


Route::post('/SolicitudFondos/Rechazar/','SolicitudFondosController@rechazar')
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


Route::post('/guardarSolicitud', 'SolicitudFondosController@store')->name('solicitudFondos.store');

/* RENDICIONES */

Route::post('/guardarRendicion', 'RendicionFondosController@store')->name('rendicionFondos.store');

Route::get('/verRendicion/{id}', 'RendicionFondosController@ver')->name('rendicionFondos.ver');

Route::post('/reportes/ver', 'RendicionFondosController@reportes')->name('rendicionFondos.reportes');


Route::get('/reportes/descargar/{str}', 'RendicionFondosController@descargarReportes')
    ->name('rendicionFondos.descargarReportes');


Route::get('/rendicion/descargarCDPDetalle/{id}','RendicionFondosController@descargarCDPDetalle')->name('rendicion.descargarCDPDetalle');



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



/* --------------------------------------- MODULO RENZO -------------------------------------------------- */
Route::get('/gestionInventario/cambiarEstado/{id}','gestionInventarioController@cambiarEstadoDetalle');
Route::get('/gestionInventario/filtro/{id}','gestionInventarioController@filtroDetalles');
Route::get('/gestionInventario/{id}/eliminar','gestionInventarioController@delete')->name('gestionInventario.delete');
Route::resource('gestionInventario', GestionInventarioController::class);

Route::resource('activos', ActivoController::class);
Route::get('/actualizarActivos/mostrarRevisiones','gestionInventarioController@mostrarRevisiones')->name('gestionInventario.mostrarRevisiones');
Route::get('/actualizarActivos/mostrarActivos/{id}','ActivoController@mostrarActivos')->name('activos.mostrarActivos');
Route::get('/actualizarActivos/cambiarEstado/{id}','gestionInventarioController@cambiarEstado');