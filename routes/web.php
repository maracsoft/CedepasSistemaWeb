<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('login');
});






/* RUTAS SERVICIOS */
Route::get('/listarDetallesDeSolicitud/{id}','SolicitudFondosController@listarDetalles');



Route::get('/listarDeEmpleado','SolicitudFondosController@listarSolicitudesDeEmpleado')
    ->name('solicitudFondos.listarEmp');

Route::get('/listarDeJefe','SolicitudFondosController@listarSolicitudesParaJefe')
    ->name('solicitudFondos.listarJefe');

Route::get('/revisar/{id}','SolicitudFondosController@revisar')
    ->name('solicitudFondos.revisar');


    
Route::get('/SolicitudFondos/Aprobar/{id}','SolicitudFondosController@aprobar')
->name('solicitudFondos.aprobar');

Route::get('/SolicitudFondos/Rendir/{id}','SolicitudFondosController@rendir')
->name('solicitudFondos.rendir');


Route::get('/SolicitudFondos/Rechazar/{id}','SolicitudFondosController@rechazar')
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


// usar dd("aaaaaaaaaa"); para debugear GA

/**CATEGORIA */
Route::resource('categoria', 'CategoriaController');  // es resource pq trabajamos con varias rutas 
Route::get('/categoria/delete/{id}','CategoriaController@delete');

/**PRODUCTO */
Route::resource('producto', 'ProductoController');  // es resource pq trabajamos con varias rutas 
Route::get('/producto/delete/{id}','ProductoController@delete');


/**ORDEN */
Route::resource('orden', 'OrdenController');  // es resource pq trabajamos con varias rutas 
Route::resource('caja', 'CajaController');  
Route::get('/caja','OrdenController@listarParaCaja');

Route::get ('orden/{id}/next','OrdenController@siguiente')->name('orden.next');
Route::get ('orden/{id}/ventanaPago','OrdenController@ventanaPago')->name('orden.ventanaPago');



Route::get('/mesasOrden','MesaController@listarMesa');
Route::get('/orden/mesa/{id}','OrdenController@ordenMesa');
//Route::get ('categoria/{id}/confirmar','CategoriaController@confirmar')->name('categoria.confirmar');





Route::get ('producto/{codproducto}/confirmar','ProductoController@confirmar')->name('producto.confirmar');




Route::resource('Escuela', 'EscuelaController');  // es resource pq trabajamos con varias rutas 
Route::resource('Factultad', 'FacultadController');  // es resource pq trabajamos con varias rutas 
Route::resource('Estudiante', 'EstudianteController');  // es resource pq trabajamos con varias rutas 
Route::resource('cliente', 'ClienteController');  // es resource pq trabajamos con varias rutas 
Route::resource('unidad', 'UnidadController');  // es resource pq trabajamos con varias rutas 
/* Route::resource('cabeceraventa', 'CabeceraVentaController');  // es resource pq trabajamos con varias rutas 

 */
Route::get ('unidad/{id}/confirmar','UnidadController@confirmar')->name('unidad.confirmar');
Route::get ('cliente/{id}/confirmar','ClienteController@confirmar')->name('cliente.confirmar');
Route::get ('Estudiante/{id}/confirmar','EstudianteController@confirmar')->name('Estudiante.confirmar');


/* datos productos */
Route::get('EncontrarProducto/{producto_id}', 'CabeceraVentaController@ProductoCodigo');
/* datos tipos */
Route::get('EncontrarTipo/{codigo}', 'CabeceraVentaController@PorTipo');



Route::get('cancelar', function () {
    return redirect()->route('categoria.index')->with('datos','Accion cancelada');
})->name('cancelar');



Route::post('/', 'UserController@login')->name('user.login');