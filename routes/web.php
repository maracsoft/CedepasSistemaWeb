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



Route::get('/SolicitudFondos/Empleado/listar/','SolicitudFondosController@listarSolicitudesDeEmpleado')
    ->name('solicitudFondos.listarEmp');

Route::get('/SolicitudFondos/Gerente/listar','SolicitudFondosController@listarSolicitudesParaGerente')
    ->name('solicitudFondos.listarGerente');

Route::get('/SolicitudFondos/Administración/listar','SolicitudFondosController@listarSolicitudesParaJefe')
    ->name('solicitudFondos.listarJefeAdmin');

Route::get('/SolicitudFondos/Contador/listar','SolicitudFondosController@listarSolicitudesParaContador')
    ->name('solicitudFondos.listarContador');

//ruta para regresar al index de solicitudes del actor que esté logeado
Route::get('/irAIndex','SolicitudFondosController@listarSolicitudes')
    ->name('solicitudFondos.listarSolicitudes');



Route::get('/SolicitudFondos/{id}/Gerente/Revisar/','SolicitudFondosController@revisar')
    ->name('solicitudFondos.revisar');


//vista para ver namas (empleado)
Route::get('/SolicitudFondos/{id}/Empleado/ver/','SolicitudFondosController@ver')
    ->name('solicitudFondos.ver');
    

Route::get('/SolicitudFondos/{id}/Administracion/vistaAbonar/','SolicitudFondosController@vistaAbonar')
    ->name('solicitudFondos.vistaAbonar');


Route::get('/SolicitudFondos/{id}/Contador/verContabilizar/','SolicitudFondosController@verContabilizar')
    ->name('solicitudFondos.verContabilizar');

Route::post('/SolicitudFondos/Administracion/Abonar/','SolicitudFondosController@abonar')
    ->name('solicitudFondos.abonar');


Route::get('/SolicitudFondos/descargarComprobanteAbono/{id}','SolicitudFondosController@descargarComprobanteAbono')
    ->name('solicitudFondos.descargarComprobanteAbono');
    


Route::get('/SolicitudFondos/Gerente/Aprobar/{id}','SolicitudFondosController@aprobar')
    ->name('solicitudFondos.aprobar');
    
Route::get('/SolicitudFondos/Contador/Contabilizar/{id}','SolicitudFondosController@contabilizar')
    ->name('solicitudFondos.contabilizar');


Route::get('/SolicitudFondos/Empleado/Rendir/{id}','SolicitudFondosController@rendir')
->name('solicitudFondos.rendir');


Route::get('/SolicitudFondos/Observar/{value}','SolicitudFondosController@observar')
->name('solicitudFondos.observar');

Route::get('/SolicitudFondos/Rechazar/{id}','SolicitudFondosController@rechazar')
->name('solicitudFondos.rechazar');


Route::get('/SolicitudFondos/Empleado/Crear','SolicitudFondosController@create')
->name('solicitudFondos.create');

Route::get('/SolicitudFondos/Empleado/editar/{id}','SolicitudFondosController@edit')
->name('solicitudFondos.edit');


Route::get('/SolicitudFondos/Empleado/delete/{id}','SolicitudFondosController@delete')
->name('solicitudFondos.delete');

Route::get('/SolicitudFondos/Administracion/reportes/','SolicitudFondosController@reportes')
->name('solicitudFondos.reportes');


Route::post('/SolicitudFondos/Empleado/{id}','SolicitudFondosController@update')
    ->name('solicitudFondos.update');

Route::get('/SolicitudFondos/descargar/{id}','SolicitudFondosController@descargarPDF')
    ->name('solicitudFondos.descargarPDF');

Route::get('/SolicitudFondos/verPDF/{id}','SolicitudFondosController@verPDF')
    ->name('solicitudFondos.verPDF');



Route::post('/SolicitudFondos/Empleado/guardar', 'SolicitudFondosController@store')
->name('solicitudFondos.store');

/* ----------------------------------------------        MODULO RENDICIONES           ------------------------------------------ */

Route::post('/RendicionGastos/Empleado/guardar', 'RendicionGastosController@store')->name('rendicionGastos.store');

Route::get('/RendicionGastos/{id}/Empleado/ver/', 'RendicionGastosController@ver')->name('rendicionGastos.ver');

Route::get('/RendicionGastos/{id}/Adminsitracion/ver', 'RendicionGastosController@verAdmin')->name('rendicionGastos.verAdmin');

Route::get('/RendicionGastos/{id}/Gerente/ver', 'RendicionGastosController@verGerente')->name('rendicionGastos.verGerente');

Route::get('RendicionGastos/{id}/Empleado/editar','RendicionGastosController@editar')->name('rendicionGastos.editar');

Route::Post('/RendicionGastos/Empleado/update/','RendicionGastosController@update')->name('rendicionGastos.update');


Route::get('/RendicionGastos/{id}/revisar','RendicionGastosController@revisar')->name('rendicionGastos.revisar');
Route::get('/RendicionGastos/{id}/aprobar','RendicionGastosController@aprobar')->name('rendicionGastos.aprobar');
Route::get('/RendicionGastos/{id}/rechazar','RendicionGastosController@rechazar')->name('rendicionGastos.rechazar');
Route::get('/rendiciones/observar/{string}','RendicionGastosController@observar')->name('rendicionGastos.observar');


//RUTA MAESTAR QUE REDIRIJE A LOS LISTADOS DE RENDICIONES DE LOS ACTORES EMP GER Y J.A
Route::get('/RendicionGastos/MAESTRA/listar','RendicionGastosController@listarRendiciones')->name('rendicionGastos.listarRendiciones');


Route::get('/verReponer/{id}', 'RendicionGastosController@verReponer')->name('rendicionGastos.verReponer');
Route::post('/rendicion/reponer/','RendicionGastosController@reponer')
    ->name('rendicionGastos.reponer');

Route::get('/RendicionGastos/Contador/verContabilizar/{id}','RendicionGastosController@verContabilizar')
        ->name('rendicionGastos.verContabilizar');   

Route::get( '/rendicion/contabilizar/{cad}','RendicionGastosController@contabilizar')
->name('rendicionGastos.contabilizar');   

Route::post('/reportes/ver', 'RendicionGastosController@reportes')->name('rendicionGastos.reportes');


Route::get('/reportes/descargar/{str}', 'RendicionGastosController@descargarReportes')
    ->name('rendicionGastos.descargarReportes');


Route::get('/rendicion/descargarCDP/{cadena}','RendicionGastosController@descargarCDP')->name('rendiciones.descargarCDP');





//esta ruta sirve tanto como para el comprobante de envio empleado->cedepas como para la reposicion de cedepas->empleado
Route::get('/RendicionGastos/descargarArchivoRendicion/{id}','RendicionGastosController@descargarArchivoRendicion')->name('rendicion.descargarArchivoRendicion');


Route::get('/RendicionGastos/Contador/listar/','RendicionGastosController@listarContador')->name('rendicionGastos.listarContador');

Route::get('/RendicionGastos/Administracion/listar/','RendicionGastosController@listarJefeAdmin')->name('rendicionGastos.listarJefeAdmin');
Route::get('/RendicionGastos/Gerente/listar/','RendicionGastosController@listarDelGerente')->name('rendicionGastos.listarGerente');

Route::get('/RendicionGastos/Empleado/Listar/','RendicionGastosController@listarEmpleado')->name('rendicionGastos.listarEmpleado');

Route::get('/RendicionGastos//descargarPDF/{id}','RendicionGastosController@descargarPDF')->name('rendicionGastos.descargarPDF');
Route::get('/RendicionGastos/verPDF/{id}','RendicionGastosController@verPDF')->name('rendicionGastos.verPDF');



/* ----------------------------------------------        MODULO GESTIÓN DE USUARIOS ---------------------------- */
Route::get('/GestiónUsuarios/listar','EmpleadoController@listarEmpleados')->name('GestionUsuarios.listarEmpleados');

Route::get('/GestiónUsuarios/crear','EmpleadoController@crearEmpleado')->name('GestionUsuarios.create');
Route::post('/GestiónUsuarios/save','EmpleadoController@guardarCrearEmpleado')->name('GestionUsuarios.store');

Route::get('/GestiónUsuarios/{id}/editar','EmpleadoController@editarEmpleado')->name('GestionUsuarios.edit');
Route::post('/GestiónUsuarios/update','EmpleadoController@guardarEditarEmpleado')->name('GestionUsuarios.update');

Route::get('/GestiónUsuarios/{id}/cesar','EmpleadoController@cesarEmpleado')->name('GestionUsuarios.cesar');

/* ----------------------------------------------        MODULO PUESTOS           ------------------------------------------ */
Route::get('/GestiónPuestos/listar','PuestoController@listarPuestos')->name('GestiónPuestos.listarPuestos');

Route::get('/GestiónPuestos/crear','PuestoController@crearPuesto')->name('GestiónPuestos.create');
Route::post('/GestiónPuestos/save','PuestoController@guardarCrearPuesto')->name('GestiónPuestos.store');

Route::get('/GestiónPuestos/{id}/editar','PuestoController@editarPuesto')->name('GestiónPuestos.edit');
Route::post('/GestiónPuestos/update','PuestoController@guardarEditarPuesto')->name('GestiónPuestos.update');

Route::get('/GestiónPuestos/{id}/eliminar','PuestoController@eliminarPuesto')->name('GestiónPuestos.delete');

/* ---------------------------------------------- MODULO REPOSICIONES -------------------------------------------- */
/**RUTA MAESTRA PARA REPOSICION */
Route::get('/indexReposicion','ReposicionGastosController@listarReposiciones')->name('reposicionGastos.listarReposiciones');
/**RUTA MAESTRA PARA DESCARGAR CDP */
Route::get('/reposicion/descargarCDP/{cadena}','ReposicionGastosController@descargarCDP')->name('reposicionGastos.descargarCDP');



/**EMPLEADO*/
Route::get('/ReposicionGastos/Empleado/listar','ReposicionGastosController@listarOfEmpleado')->name('reposicionGastos.listar');
Route::get('/ReposicionGastos/Empleado/crear','ReposicionGastosController@create')->name('reposicionGastos.create');
Route::post('/ReposicionGastos/Empleado/store','ReposicionGastosController@store')->name('reposicionGastos.store');

Route::post('/ReposicionGastos/Empleado/update','ReposicionGastosController@update')->name('reposicionGastos.update');
Route::get('/ReposicionGastos/{id}/Empleado/editar','ReposicionGastosController@editar')->name('reposicionGastos.editar');

Route::get('/ReposicionGastos/{id}/Empleado/view','ReposicionGastosController@view')->name('reposicionGastos.view');

/**GERENTE*/
Route::get('/ReposicionGastos/Gerente/listar','ReposicionGastosController@listarOfGerente')->name('reposicionGastos.listarRepoOfGerente');
Route::get('/ReposicionGastos/{id}/Gerente/view','ReposicionGastosController@viewGeren')->name('reposicionGastos.verReposicionOfGerente');

/**ADMINISTRACION*/
Route::get('/ReposicionGastos/Administracion/listar','ReposicionGastosController@listarOfJefe')->name('reposicionGastos.listarRepoOfJefe');
Route::get('/ReposicionGastos/{id}/Administracion/view','ReposicionGastosController@viewJefe')->name('reposicionGastos.verReposicionOfJefe');

/**CONTADOR*/
Route::get('/ReposicionGastos/Contador/listar','ReposicionGastosController@listarOfConta')->name('reposicionGastos.listarRepoOfContador');
Route::get('/ReposicionGastos/{id}/Contador/view','ReposicionGastosController@viewConta')->name('reposicionGastos.verReposicionOfContador');



/**RUTA MAESTRA PARA ESTADOS */
Route::get('/ReposicionGastos/{id}/Aprobar','ReposicionGastosController@aprobar')->name('reposicionGastos.aprobar');
Route::get('/ReposicionGastos/{id}/Rechazar','ReposicionGastosController@rechazar')->name('reposicionGastos.rechazar');
Route::get('/ReposicionGastos/{id}/Observar','ReposicionGastosController@observar')->name('reposicionGastos.observar');
Route::get('/ReposicionGastos/{id}/Abonar','ReposicionGastosController@abonar')->name('reposicionGastos.abonar');
Route::get('/ReposicionGastos/{id}/Contabilizar','ReposicionGastosController@contabilizar')->name('reposicionGastos.contabilizar');

/**RUTA MAESTRA PARA DESCARGAR FORMULARIOS PDF */
Route::get('/ReposicionGastos/{id}/PDF','ReposicionGastosController@descargarPDF')->name('reposicionGastos.PDF');
Route::get('/ReposicionGastos/{id}/verPDF','ReposicionGastosController@verPDF')->name('reposicionGastos.verPDF');


/* ---------------------------------------------- MODULO PROYECTOS -------------------------------------------- */
Route::get('/GestiónProyectos/listar','ProyectoController@index')->name('proyecto.index');

Route::get('/GestiónProyectos/crear','ProyectoController@crear')->name('proyecto.crear');
Route::post('/GestiónProyectos/store','ProyectoController@store')->name('proyecto.store');

Route::get('/GestiónProyectos/{id}/editar','ProyectoController@editar')->name('proyecto.editar');
Route::post('/GestiónProyectos/update','ProyectoController@update')->name('proyecto.update');

Route::get('/GestiónProyectos/{id}/darDeBaja','ProyectoController@darDeBaja')->name('proyecto.darDeBaja');


/**GERENTES-CONTADORES */
Route::get('/GestiónProyectos/{id}/asignarGerente','ProyectoController@actualizarProyectosYGerentesContadores');

Route::get('/GestiónProyectos/{id}/asignarContador','ProyectoController@listarContadores')->name('proyecto.listarContadores');
Route::post('/GestiónProyectos/asignarContadores/save','ProyectoController@agregarContador')->name('proyecto.agregarContador');

Route::get('/GestiónProyectos/{id}/eliminarContador','ProyectoController@eliminarContador')->name('proyecto.eliminarContador');























/* ------------------------------ ---------------- MODULO JORGE -------------- ------------------------------ */
Route::group(['prefix' => 'categoria'], function () {
    Route::get('/', ['as' => 'categoria.index', 'uses' => 'CategoriaController@index']);
    Route::get('/create', ['as' => 'categoria.create', 'uses' => 'CategoriaController@create']);
    Route::post('/create', ['as' => 'categoria.create', 'uses' => 'CategoriaController@store']);
    Route::get('/edit/{id}', ['as' => 'categoria.edit', 'uses' => 'CategoriaController@edit']);
    Route::post('/edit/{id}', ['as' => 'categoria.edit', 'uses' => 'CategoriaController@update']);
    Route::post('/delete', ['as' => 'categoria.delete', 'uses' => 'CategoriaController@destroy']);
});

