<?php
Route::group(['middleware' => 'auth'], function(){
	Route::prefix('procesos')
  //->middleware('permission:Usuario')//
  ->namespace('Procesos')
  ->name('procesos.cotizaciones.')
  ->group(function () {
		Route::get('cotizaciones','CotizacionController@index')->name('index');
		Route::post('cotizacion/create','CotizacionController@create')->name('create');
		Route::get('cotizacion/versionar','CotizacionController@versionar')->name('versionar');
		Route::get('cotizacion/mantenimiento','CotizacionController@mantenimiento')->name('mantenimiento');
    Route::get('cotizacion/edit','CotizacionController@edit')->name('edit');
		Route::post('cotizacion/createVersion','CotizacionController@createVersion')->name('createVersion');
		Route::get('cotizacion/getVersiones','CotizacionController@getVersiones')->name('getVersiones');
		Route::get('cotizacion/getMetrica','CotizacionController@getMetrica')->name('getMetrica');
	});

	Route::prefix('procesos')
	//->middleware('permission:Usuario')//
	->namespace('Procesos')
	->name('procesos.programaciones.')
	->group(function () {
		Route::get('programaciones','ProgramacionController@index')->name('index');
	});


});
