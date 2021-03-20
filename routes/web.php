<?php

use Illuminate\Support\Facades\Route;



Route::get('/login', 'UserController@verLogin')->name('user.verLogin'); //para desplegar la vista del Login
Route::post('/ingresar', 'UserController@logearse')->name('user.logearse');
Route::get('/cerrarSesion','UserController@cerrarSesion')->name('user.cerrarSesion');


Route::get('/', 'UserController@home')->name('user.home');


Route::get('/prueba','RendicionGastosController@prueba');





/* --------------------------------------------      MODULO SOLICITUDES       -------------------------------------------------- */
/* RUTAS SERVICIOS */
Route::get('/listarDetallesDeSolicitud/{id}','SolicitudFondosController@listarDetalles');
Route::get('/listarDetallesDeRendicion/{id}','RendicionGastosController@listarDetalles');
Route::get('/listarDetallesDeReposicion/{id}','ReposicionGastosController@listarDetalles');

Route::get('/solicitudFondos/getNumeracionActual/','SolicitudFondosController@getNumeracionLibre');
Route::get('/rendicionGastos/getNumeracionActual/','RendicionGastosController@getNumeracionLibre');
Route::get('/reposicionGastos/getNumeracionActual/','ReposicionGastosController@getNumeracionLibre');

Route::get('/obtenerCodigoPresupuestalDeProyecto/{id}','ProyectoController@getCodigoPresupuestal');



Route::get('/SolicitudFondos/listarDeEmpleado','SolicitudFondosController@listarSolicitudesDeEmpleado')
    ->name('solicitudFondos.listarEmp');

Route::get('/SolicitudFondos/listarDeGerente','SolicitudFondosController@listarSolicitudesParaGerente')
    ->name('solicitudFondos.listarGerente');

Route::get('/SolicitudFondos/listarDeJefeAdmin','SolicitudFondosController@listarSolicitudesParaJefe')
    ->name('solicitudFondos.listarJefeAdmin');

Route::get('/SolicitudFondos/listarDeContador','SolicitudFondosController@listarSolicitudesParaContador')
    ->name('solicitudFondos.listarContador');

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


Route::get('/SolicitudFondos/verContabilizar/{id}','SolicitudFondosController@verContabilizar')
    ->name('solicitudFondos.verContabilizar');

Route::post('/SolicitudFondos/Abonar/','SolicitudFondosController@abonar')
    ->name('solicitudFondos.abonar');


Route::get('/SolicitudFondos/descargarComprobanteAbono/{id}','SolicitudFondosController@descargarComprobanteAbono')
    ->name('solicitudFondos.descargarComprobanteAbono');
    


Route::get('/SolicitudFondos/Aprobar/{id}','SolicitudFondosController@aprobar')
    ->name('solicitudFondos.aprobar');
    
Route::get('/SolicitudFondos/Contabilizar/{id}','SolicitudFondosController@contabilizar')
    ->name('solicitudFondos.contabilizar');


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

/* ----------------------------------------------        MODULO RENDICIONES           ------------------------------------------ */

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

Route::get('/rendicion/verContabilizar/{id}','RendicionGastosController@verContabilizar')
        ->name('rendicionGastos.verContabilizar');   

Route::get( '/rendicion/contabilizar/{cad}','RendicionGastosController@contabilizar')
->name('rendicionGastos.contabilizar');   

Route::post('/reportes/ver', 'RendicionGastosController@reportes')->name('rendicionGastos.reportes');


Route::get('/reportes/descargar/{str}', 'RendicionGastosController@descargarReportes')
    ->name('rendicionGastos.descargarReportes');


Route::get('/rendicion/descargarCDP/{cadena}','RendicionGastosController@descargarCDP')->name('rendiciones.descargarCDP');





//esta ruta sirve tanto como para el comprobante de envio empleado->cedepas como para la reposicion de cedepas->empleado
Route::get('/rendicion/descargarArchivoRendicion/{id}','RendicionGastosController@descargarArchivoRendicion')->name('rendicion.descargarArchivoRendicion');


Route::get('/rendicion/listarContador/','RendicionGastosController@listarContador')->name('rendicionGastos.listarContador');

Route::get('/rendicion/listarJefeAdmin/','RendicionGastosController@listarJefeAdmin')->name('rendicionGastos.listarJefeAdmin');
Route::get('/rendicion/listarGerente/','RendicionGastosController@listarDelGerente')->name('rendicionGastos.listarGerente');

Route::get('/rendicion/listarEmpleado/','RendicionGastosController@listarEmpleado')->name('rendicionGastos.listarEmpleado');

Route::get('/rendicion/descargarPDF/{id}','RendicionGastosController@descargarPDF')->name('rendicionGastos.descargarPDF');
Route::get('/rendicion/verPDF/{id}','RendicionGastosController@verPDF')->name('rendicionGastos.verPDF');



/* ----------------------------------------------        MODULO EMPLEADOS           ------------------------------------------ */
Route::get('/listarEmpleados','EmpleadoController@listarEmpleados');
Route::post('/listarPuestos/{id}','EmpleadoController@listarPuestos');

Route::get('/crearEmpleado','EmpleadoController@crearEmpleado');
Route::post('/crearEmpleado/save','EmpleadoController@guardarCrearEmpleado');

Route::get('/editarEmpleado/{id}','EmpleadoController@editarEmpleado');
Route::post('/editarEmpleado/save','EmpleadoController@guardarEditarEmpleado');

Route::get('/cesarEmpleado/{id}','EmpleadoController@cesarEmpleado');

/* ----------------------------------------------        MODULO PUESTOS           ------------------------------------------ */
Route::get('/listarPuestos','PuestoController@listarPuestos');

Route::get('/crearPuesto','PuestoController@crearPuesto');
Route::post('/crearPuesto/save','PuestoController@guardarCrearPuesto');

Route::get('/editarPuesto/{id}','PuestoController@editarPuesto');
Route::post('/editarPuesto/save','PuestoController@guardarEditarPuesto');

Route::get('/eliminarPuesto/{id}','PuestoController@eliminarPuesto');


/* ------------------------------ ---------------- MODULO JORGE -------------- ------------------------------ */
Route::group(['prefix' => 'categoria'], function () {
    Route::get('/', ['as' => 'categoria.index', 'uses' => 'CategoriaController@index']);
    Route::get('/create', ['as' => 'categoria.create', 'uses' => 'CategoriaController@create']);
    Route::post('/create', ['as' => 'categoria.create', 'uses' => 'CategoriaController@store']);
    Route::get('/edit/{id}', ['as' => 'categoria.edit', 'uses' => 'CategoriaController@edit']);
    Route::post('/edit/{id}', ['as' => 'categoria.edit', 'uses' => 'CategoriaController@update']);
    Route::post('/delete', ['as' => 'categoria.delete', 'uses' => 'CategoriaController@destroy']);
});


/* ---------------------------------------------- MODULO REPOSICIONES -------------------------------------------- */
//RUTA MAESTAR PARA REPOSICION
Route::get('/reposiciones/listar','ReposicionGastosController@listarReposiciones')->name('reposicionGastos.listarReposiciones');


/**MODULO  "Reposiciones de Fondos a empleados"*/
Route::get('/Emp/Reposiciones/listar/','ReposicionGastosController@listarOfEmpleado')->name('reposicionGastos.listar');
Route::get('/Emp/Reposiciones/crear','ReposicionGastosController@create')->name('reposicionGastos.create');
Route::post('/Emp/Reposiciones/store','ReposicionGastosController@store')->name('reposicionGastos.store');

Route::post('/Emp/Reposiciones/update','ReposicionGastosController@update')->name('reposicionGastos.update');
Route::get('/Emp/Reposiciones/editar/{id}','ReposicionGastosController@editar')->name('reposicionGastos.editar');

Route::get('/Emp/Reposiciones/view/{id}','ReposicionGastosController@view')->name('reposicionGastos.view');





Route::get('/Geren/Reposiciones/listar','ReposicionGastosController@listarOfGerente')->name('reposicionGastos.listarRepoOfGerente');
Route::get('/Geren/Reposiciones/view/{id}','ReposicionGastosController@viewGeren')->name('reposicionGastos.verReposicionOfGerente');

Route::get('/Jefe/Reposiciones/listar','ReposicionGastosController@listarOfJefe')->name('reposicionGastos.listarRepoOfJefe');
Route::get('/Jefe/Reposiciones/view/{id}','ReposicionGastosController@viewJefe')->name('reposicionGastos.verReposicionOfJefe');

Route::get('/Conta/Reposiciones/listar','ReposicionGastosController@listarOfConta')->name('reposicionGastos.listarRepoOfContador');
Route::get('/Conta/Reposiciones/view/{id}','ReposicionGastosController@viewConta')->name('reposicionGastos.verReposicionOfContador');

Route::get('/reposicion/descargarCDP/{cadena}','ReposicionGastosController@descargarCDP')->name('reposicionGastos.descargarCDP');

//estados
Route::get('/Reposicion/{id}/aprobar','ReposicionGastosController@aprobar')->name('reposicionGastos.aprobar');
Route::get('/Reposicion/{id}/rechazar','ReposicionGastosController@rechazar')->name('reposicionGastos.rechazar');
Route::get('/Reposicion/{id}/observar','ReposicionGastosController@observar')->name('reposicionGastos.observar');
Route::get('/Reposicion/{id}/abonar','ReposicionGastosController@abonar')->name('reposicionGastos.abonar');
Route::get('/Conta/Reposiciones/contabilizar/{id}','ReposicionGastosController@contabilizar')->name('reposicionGastos.contabilizar');

//probando manito
Route::get('/Reposicion/{id}/PDF','ReposicionGastosController@descargarPDF')->name('reposicionGastos.PDF');
Route::get('/Reposicion/{id}/verPDF','ReposicionGastosController@verPDF')->name('reposicionGastos.verPDF');


/* ---------------------------------------------- MODULO PROYECTOS -------------------------------------------- */
Route::get('/asignarGerentesContadores/actualizar/{id}','ProyectoController@actualizarProyectosYGerentesContadores');
Route::get('/contadores/{id}','ProyectoController@listarContadores')->name('proyecto.listarContadores');
Route::post('/contadores/save','ProyectoController@agregarContador')->name('proyecto.agregarContador');
Route::get('/contadores/delete/{id}','ProyectoController@eliminarContador')->name('proyecto.eliminarContador');

Route::get('/proyecto/crear','ProyectoController@crear')->name('proyecto.crear');
Route::post('/proyecto/store','ProyectoController@store')->name('proyecto.store');

Route::get('/proyecto/index','ProyectoController@index')->name('proyecto.index');
Route::get('/proyecto/editar/{id}','ProyectoController@editar')->name('proyecto.editar');
Route::post('/proyecto/update','ProyectoController@update')->name('proyecto.update');


Route::get('proyecto/darDeBaja/{id}','ProyectoController@darDeBaja')->name('proyecto.darDeBaja');
