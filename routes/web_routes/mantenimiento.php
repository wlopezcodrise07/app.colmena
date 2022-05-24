<?php
Route::group(['middleware' => 'auth'], function(){
	Route::prefix('mantenimiento')
  //->middleware('permission:Usuario')//
  ->namespace('Mantenimiento')
  ->name('mantenimiento.usuario.')
  ->group(function () {
    Route::get('usuario','UsuariosController@index')->name('index');
		Route::post('usuario/store','UsuariosController@store')->name('store');
    Route::post('usuario/changePass','UsuariosController@changePass')->name('changePass');
	});

	Route::prefix('mantenimiento')
	//->middleware('permission:Usuario')//
	->namespace('Mantenimiento')
	->name('mantenimiento.clientes.')
	->group(function () {
		Route::get('clientes','ClientesController@index')->name('index');
		Route::post('clientes/store','ClientesController@store')->name('store');
		Route::get('clientes/edit','ClientesController@edit')->name('edit');
		Route::get('clientes/destroy','ClientesController@destroy')->name('destroy');
		Route::get('clientes/getCodigo','ClientesController@getCodigo')->name('getCodigo');
	});

	Route::prefix('mantenimiento')
	//->middleware('permission:Usuario')//
	->namespace('Mantenimiento')
	->name('mantenimiento.producto_cliente.')
	->group(function () {
		Route::get('producto_cliente','ProductoClienteController@index')->name('index');
		Route::get('producto_cliente/get_campana/{producto}','ProductoClienteController@get_campana')->name('get_campana');
		Route::post('producto_cliente/store','ProductoClienteController@store')->name('store');
		Route::post('producto_cliente/storeCampaña','ProductoClienteController@storeCampaña')->name('storeCampaña');
		Route::get('producto_cliente/edit','ProductoClienteController@edit')->name('edit');
		Route::get('producto_cliente/destroy','ProductoClienteController@destroy')->name('destroy');
		Route::get('producto_cliente/destroyCampaña','ProductoClienteController@destroyCampaña')->name('destroyCampaña');
	});

	Route::prefix('mantenimiento')
	//->middleware('permission:Usuario')//
	->namespace('Mantenimiento')
	->name('mantenimiento.forma_pago.')
	->group(function () {
		Route::get('forma_pago','FormaPagoController@index')->name('index');
		Route::post('forma_pago/store','FormaPagoController@store')->name('store');
		Route::get('forma_pago/edit','FormaPagoController@edit')->name('edit');
		Route::get('forma_pago/destroy','FormaPagoController@destroy')->name('destroy');
	});

	Route::prefix('mantenimiento')
	//->middleware('permission:Usuario')//
	->namespace('Mantenimiento')
	->name('mantenimiento.categoria_redsocial.')
	->group(function () {
		Route::get('categoria_redsocial','CategoriaRedSocialController@index')->name('index');
		Route::post('categoria_redsocial/store','CategoriaRedSocialController@store')->name('store');
		Route::get('categoria_redsocial/edit','CategoriaRedSocialController@edit')->name('edit');
		Route::get('categoria_redsocial/destroy','CategoriaRedSocialController@destroy')->name('destroy');
	});

	Route::prefix('mantenimiento')
	//->middleware('permission:Usuario')//
	->namespace('Mantenimiento')
	->name('mantenimiento.influencer.')
	->group(function () {
		Route::get('influencer','influencerController@index')->name('index');
		Route::post('influencer/store','influencerController@store')->name('store');
		Route::post('influencer/storeMetrica','influencerController@storeMetrica')->name('storeMetrica');
		Route::get('influencer/edit','influencerController@edit')->name('edit');
		Route::get('influencer/editMetrica','influencerController@editMetrica')->name('editMetrica');
		Route::get('influencer/getInfoAccion','influencerController@getInfoAccion')->name('getInfoAccion');
	});

	Route::prefix('mantenimiento')
	//->middleware('permission:Usuario')//
	->namespace('Mantenimiento')
	->name('mantenimiento.accion.')
	->group(function () {
		Route::get('accion','AccionController@index')->name('index');
		Route::post('accion/store','AccionController@store')->name('store');
		Route::get('accion/edit','AccionController@edit')->name('edit');
		Route::get('accion/destroy','AccionController@destroy')->name('destroy');
	});
});
