<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();
Route::get('cerrarSecion', 'HomeController@cerrarSecion')->name('cerrarSecion');
Route::get('/dashboard', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['prefix' => 'Bancos','middleware' => ['auth']], function () {
    Route::get('show/{id}','BancoController@show')->name('show_Banco');
    Route::get('/', 'BancoController@index')->name('bancos.index');
    Route::get('/buscar','BancoController@store');
    Route::get('/bancosTable','BancoController@bancosTable')->name('bancos.bancosTable');
    Route::post('/add_new', 'BancoController@create');
    Route::get('/get', 'BancoController@show')->name('bancos.show');
    Route::get('/delete_item', 'BancoController@destroy')->name('bancos.delete');
    Route::put('/edit/{id}', 'BancoController@update')->name('bancos.update');
});
Route::group(['prefix' => 'Acciones','middleware' => ['auth']], function () {
    Route::get('index','AccionesController@index')->name('Acciones.index');
    Route::get('AccionesTable','AccionesController@AccionesTable')->name('Acciones.AccionesTable');
    Route::get('show/{id}','AccionesController@show')->name('show_Accion');
    Route::post('add_new','AccionesController@store')->name('add_Accion');
    Route::put('edit/{id}','AccionesController@update')->name('edit_Accion');
    Route::delete('delete/{id}','AccionesController@destroy')->name('delete_Accion');
});

Route::group(['prefix' => 'Servicios','middleware' => ['auth']], function () {
    Route::get('index','ServiciosController@index')->name('Servicios.index');
    Route::get('ServiciosTable','ServiciosController@ServiciosTable')->name('Servicios.ServiciosTable');
    Route::get('show/{id}','ServiciosController@show')->name('show_servicio');
    Route::post('add_new','ServiciosController@store')->name('add_servicio');
    Route::put('edit/{id}','ServiciosController@update')->name('edit_servicio');
    Route::delete('delete/{id}','ServiciosController@destroy')->name('delete_servicio');
});

Route::group(['prefix' => 'Equipos','middleware' => ['auth']], function () {
    Route::get('busqueda/{busqueda}','EquiposController@busqueda')->name('Equipos_busqueda');
    Route::get('index','EquiposController@index')->name('Equipos.index');
    Route::get('fallas/{id}','EquiposController@fallas')->name('Equipos.fallas');
    Route::get('fallasTable/{id}','EquiposController@fallasTable')->name('Equipos.fallasTable');
    Route::get('equiposTable','EquiposController@equiposTable')->name('Equipos.equiposTable');
    Route::get('show/{id}','EquiposController@show')->name('show_Equipo');
    Route::post('add_new','EquiposController@store')->name('add_Equipo');
    Route::put('edit/{id}','EquiposController@update')->name('update_Equipo');
    Route::delete('delete/{id}','EquiposController@destroy')->name('delete_Equipo');
});

Route::group(['prefix' => 'Fallas','middleware' => ['auth']], function () {
    Route::get('index','FallasController@index')->name('Fallas_index');
    Route::get('equiposFallas','FallasController@equiposFallas')->name('Fallas_equiposFallas');
    Route::get('show/{id}','FallasController@show')->name('show_Falla');
    Route::post('add_new','FallasController@store')->name('add_Falla');
    Route::get('showFallas/{id}','FallasController@showFallas')->name('show_Fallas');
    Route::get('fallaTable/{id}','FallasController@fallaTable')->name('fallaTable');
    Route::put('edit/{id}','FallasController@update')->name('update_Falla');
    Route::delete('delete/{id}','FallasController@destroy')->name('delete_Falla');
});
Route::group(['prefix' => 'Materiales','middleware' => ['auth']], function () {
    Route::get('busqueda/{busqueda}','MaterialesController@busqueda')->name('Materiales_busqueda');
    Route::get('index','MaterialesController@index')->name('Materiales.index');
    Route::get('materialesTable','MaterialesController@materialesTable')->name('Materiales_materialesTable');
    Route::get('show/{id}','MaterialesController@show')->name('show_Material');
    Route::post('add_new','MaterialesController@store')->name('add_Material');
    Route::put('edit/{id}','MaterialesController@update')->name('update_Material');
    Route::delete('delete/{id}','MaterialesController@destroy')->name('delete_Material');
});
Route::group(['prefix' => 'Usuarios','middleware' => ['auth']], function () {
    Route::get('busqueda/{busqueda}','UsuariosController@busqueda')->name('Usuarios_busqueda');
    Route::get('index','UsuariosController@index')->name('Usuarios.index');
    Route::get('usertable','UsuariosController@usertable')->name('Usuarios.usertable');
    Route::get('show/{id}','UsuariosController@show')->name('show_Usuario');
    Route::post('add_new','UsuariosController@store')->name('add_Usuario');
    Route::put('edit/{id}','UsuariosController@update')->name('update_Usuario');
    Route::delete('delete/{id}','UsuariosController@destroy')->name('delete_Usuario');
});
Route::group(['prefix' => 'Clientes'/*,'middleware' => ['auth']*/], function () {
    Route::get('index','ClientesController@index')->name('Clientes.index');
    Route::get('busqueda/{busqueda}','ClientesController@busqueda')->name('busqueda_Clientes');
    Route::get('clienteTable','ClientesController@clienteTable')->name('Clientes_table');
    Route::get('show/{id}','ClientesController@show')->name('show_Clientes');
    Route::post('add_new','ClientesController@store')->name('add_Clientes');
    Route::put('edit/{id}','ClientesController@update')->name('update_Clientes');
    Route::delete('delete/{id}','ClientesController@destroy')->name('delete_Clientes');
});
Route::group(['prefix' => 'Ordenes'/*,'middleware' => ['auth']*/], function () {
    Route::get('index','OrdenesController@index')->name('Ordenes_index');
    Route::get('evaluacion','OrdenesController@evaluacionTecnicosview')->name('ordenes.tecnicos');
    Route::post('evaluacionTecnicos','OrdenesController@evaluacionTecnicos')->name('orden_evaluacionTecnicos');
    Route::get('show/{id}','OrdenesController@show')->name('show_Orden');
    Route::post('add_new','OrdenesController@store')->name('add_Orden');
    Route::put('edit/{id}','OrdenesController@update')->name('update_Orden');
    Route::delete('delete/{id}','OrdenesController@destroy')->name('delete_Orden');
    Route::put('cerrarOrden/{id}','OrdenesController@cerrarOrden')->name('cerrar_Orden');
    Route::put('cancelar/{id}','OrdenesController@cancelar')->name('cancelar_orden');
    Route::put('cancelarOrden/{id}','OrdenesController@cancelar')->name('cancelar_orden');
    Route::get('calcular/{id}','OrdenesController@calculoMonto')->name('calcularMonto_Orden');
    Route::get('Cotizaciones/{id}','OrdenesController@cotizaciones')->name('cotizaciones_orden');
    Route::get('cotizacionesTable/{id}','OrdenesController@cotizacionesTable')->name('cotizacionesTable_orden');
    Route::get('showCotizacion/{id}','OrdenesController@showCotizacion')->name('showCotizacion_orden');
    Route::get('descargarPdf/{id}','OrdenesController@descargarPdf')->name('descargarPdf_cotizacion');
    Route::get('generarPdf/{id}','OrdenesController@generarPdf')->name('generarPdf_orden');
    
});
Route::group(['prefix' => 'Actividades','middleware' => ['auth']], function () {
    Route::get('Ordenestable','ActividadesController@Ordenestable')->name('Actividades.Ordenestable');
    Route::get('index','ActividadesController@index')->name('Actividades.index');
    Route::get('show/{id}','ActividadesController@show')->name('show_Actividad');
    Route::get('showActividades/{id}','ActividadesController@showActividades')->name('show_Actividades');
    Route::get('ActividadesTable/{id}','ActividadesController@ActividadesTable')->name('ActividadesTable');
    Route::post('add_new','ActividadesController@store')->name('add_Actividad');
    Route::put('edit/{id}','ActividadesController@update')->name('update_Actividad');
    Route::put('completar/{id}','ActividadesController@completar')->name('completar_Actividad');
    Route::delete('delete/{id}','ActividadesController@destroy')->name('delete_Actividad');
});
Route::group(['prefix' => 'Especialidades','middleware' => ['auth']], function () {
    Route::get('index','EspecialidadesController@index')->name('Especialidades_index');
    Route::get('show/{id}','EspecialidadesController@show')->name('show_Especialidad');
    Route::post('add_new','EspecialidadesController@store')->name('add_Especialidad');
    Route::put('edit/{id}','EspecialidadesController@update')->name('update_Especialidad');
    Route::delete('delete/{id}','EspecialidadesController@destroy')->name('delete_Especialidad');
    Route::put('quitarEspecialidad/{id}','EspecialidadesController@quitarEspecialidad')->name('quitar_Especialidad');
    
});
Route::group(['prefix' => 'PagoServicios','middleware' => ['auth']], function () {
    Route::get('index','PagoServiciosController@index')->name('PagoServicios.index');
    Route::put('comprobar/{id}','PagoServiciosController@comprobar')->name('PagoServicios.comprobar');
    Route::put('comprobar50/{id}','PagoServiciosController@comprobar50')->name('PagoServicios.comprobar50');
    Route::get('PagoServiciosTable','PagoServiciosController@PagoTable')->name('PagoServicios_PagoServiciosTable');
    Route::post('montoServicios','PagoServiciosController@montoServicios')->name('PagoServicios.montoServicios');
    Route::get('estadisticas','PagoServiciosController@estadisticas')->name('PagoServicios.estadisticas');
});
Route::group(['prefix' => 'Comprobantes','middleware' => ['auth']], function () {
    Route::post('add_new','ComprobantesController@store')->name('add_Comprobante');
    Route::put('edit/{id}','ComprobantesController@update')->name('update_Comprobantes');
    Route::get('index/{id}','ComprobantesController@index')->name('Comprobantes.index');
    Route::get('ComprobantesTable/{id}','ComprobantesController@ComprobantesTable')->name('Comprobantes_ComprobantesTable');
});
// Rutas de test
// Route::group(['prefix' => 'cargos'], function(){
//     Route::get('/', 'CargoController@index')->name('cargos.index');
//     Route::post('/buscar','CargoController@store');
//     Route::post('/add_new', 'CargoController@create');
//     Route::get('/get_item', 'CargoController@show');
//     Route::get('/delete_item', 'CargoController@destroy');
//     Route::post('/edit', 'CargoController@update');
// });
