<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('index');
});

Route::get('/bienvenido', function () {
    return view('bienvenido');
});


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
Route::resource('cabeceraventa', 'CabeceraVentaController');  // es resource pq trabajamos con varias rutas 


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