<?php
//TGeneral
Route::get('/', 'GeneralController@actionIndex');
Route::get('general/index', 'GeneralController@actionIndex');

//TUsuario
Route::match(['get', 'post'], 'usuario/insertar', 'UsuarioController@actionInsertar');
Route::match(['get', 'post'], 'usuario/login', 'UsuarioController@actionLogIn');
Route::get('usuario/logout', 'UsuarioController@actionLogOut');
Route::get('usuario/ver', 'UsuarioController@actionVer');
Route::post('usuario/editar', 'UsuarioController@actionEditar');
Route::post('usuario/cambiarcontrasenia', 'UsuarioController@actionCambiarContrasenia');

//TOficina
Route::match(['get', 'post'], 'oficina/insertar', 'OficinaController@actionInsertar');
Route::get('oficina/ver', 'OficinaController@actionVer');
Route::post('oficina/editar', 'OficinaController@actionEditar');

//TOTDEvtAsignacion
Route::match(['get', 'post'], 'otdevtasignacion/insertar', 'OTDEvtAsignacionController@actionInsertar');
Route::match(['get', 'post'], 'otdevtasignacion/fechas', 'OTDEvtAsignacionController@actionFechas');
Route::get('otdevtasignacion/ver', 'OTDEvtAsignacionController@actionVer');
Route::get('otdevtasignacion/cambiarestado/{codigoOTDEvtAsignacion}/{estado}', 'OTDEvtAsignacionController@actionCambiarEstado');
Route::post('otdevtasignacion/derivar', 'OTDEvtAsignacionController@actionDerivar');
Route::post('otdevtasignacion/atender', 'OTDEvtAsignacionController@actionAtender');
Route::post('otdevtasignacion/rastrear', 'OTDEvtAsignacionController@actionRastrear');
Route::get('otdevtasignacion/descargararchivos/{codigoOTDEvtAsignacion}', 'OTDEvtAsignacionController@actionDescargarArchivos');

//********************************************************************** */
//Registro

//	Route::resource('registro', 'RegistroController', ['except' => ['show']]);
	Route::get('/registro/listar', 'RegistroController@index');
	Route::match(['get', 'post'], 'registro/insertar', 'RegistroController@actionInsertar');
	Route::get('registro/cambiarestado/{registros}/{estado}', 'RegistroController@actionCambiarEstado');
	Route::get('registro/reportegeneral', 'RegistroController@reporteIndividualdocumento');
	Route::post('registro/edit', 'RegistroController@actionEditar');
	Route::get('registros/descargararchivos/{registros}', 'RegistroController@actionDescargarArchivos');

	

	//Route::match(['get', 'post'], 'registro/editar', 'RegistroController@actionEditar');

	

//Treportes
Route::post('/reporte/reporteGral', 'GeneralController@reporteGral');
Route::match(['get', 'post'], 'reporte/reporteFecha', 'GeneralController@reporteGralFecha');
//Treportes
Route::post('/reporte/reporteindividual', 'GeneralController@reporteIndividualdocumento');

