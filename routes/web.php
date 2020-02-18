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

/*Route::get('/', function () {
    return view('welcome');
});
*/
/*assetTest*/

Route::get('QR', function(){
	return view('QR');
});

Route::resource('assetTest', 'cypController');

Route::resource('miscelaneos', 'miscelaneosController');
/*programa*/

Route::get('/', 'mainController@index');

Route::get('registraNR/{pieza}/inspector/{inspector}/revision/{revision}/etapa/{etapa}/comentario/{comentario}', 'cypController@registraNR');

Route::get('login','mainController@login');

Route::get('updateAPK', 'updateController@update');

Route::get('sessionLogin/{nip}', 'mainController@sessionLogin');

Route::get('nuevoUsuario/{nombre}/apellidoP/{apellidoP}/apellidoM/{apellidoM}/nip/{nip}', 'mainController@create');

Route::get('/register','mainController@register');

Route::get('testSesion','cypController@testSession');

Route::get('newSesion','cypController@newSession');

Route::resource('cyp','cypController');

Route::get('abreSession/{nip}', 'mainController@updateSession');

Route::get('piezaStrumis/{pieza}','cypController@getPieza');

Route::get('piezaStrumisMiscelaneos/{pieza}','cypController@getPiezaMiscelaneos');

Route::get('cantidadPieza/{proyecto}/pieza/{cantidad}','cypController@getCantidad');

Route::get('validaLote/{lote}/cantidad/{cantidad}/muestra/{muestra}','cypController@validaLote');

Route::get('nuevaRevision',function(){
	return view('revisar');
});

Route::get('anadeEtapaId/{pieza}/etapa/{etapa}/habilitado/{habilitado}', 'cypController@anadeEtapaId');

Route::get('inspectores','cypController@getInspectores');

Route::get('defectos','cypController@getFallas');

Route::get('areas','cypController@getEtapas');

Route::get('crearRevision/{proyecto}/pieza/{pieza}/inspector/{inspector}/etapa/{etapa}/nombreP/{np}','cypController@insertaRevision');

Route::get('crearPiezaOB/{idRevision}/consecutivo/{consecutivo}', 'cypController@insertaPiezaOb');

Route::get('crearObservacion/{idPiezaOb}/inspector/{supervisorQI}','cypController@insertaOB');

Route::get('creaFalla/{supervisor}/observacion/{idObservacion}/idTipoFalla/{idTipoFalla}/comentarioFalla/{comentarioFalla}/observaciones/{observaciones}/indicacion/{indicacion}','cypController@insertaFalla');

Route::get('piezasOB/{idPieza}', 'cypController@getOBS');

Route::get('regresaFallas/{idObservacion}','cypController@getFallasActivas');

Route::get('eliminaFalla/{idFalla}/inspector/{inspector}','cypController@updateFalla');

Route::get('piezasAprobadas/{idPieza}','cypController@getAprobadas');

Route::get('creaApruebaRevision/{proyecto}/pieza/{pieza}/cantidadPieza/{cantidad}/idInspector/{inspector}/idEtapa/{etapa}/cantidadAprobadas/{aprobadas}','cypController@creaYAprueba');

Route::get('apruebaRevision/{revision}/cantidadAprobadas/{aprobadas}', 'cypController@apruebaRevision');
/*
Auth::routes();*/

Route::get('/home', 'HomeController@index')->name('home');

Route::get('nPiezasEnOb/{pieza}', 'cypController@getNpiezasOB');

Route::get('regresaInspector/{user}', 'cypController@regresaInspector');

Route::get('getRechazadas/{pieza}', 'cypController@getRechazadas');

Route::get('getRechazadas/{pieza}', 'cypController@getRechazadas');

Route::get('regresaSupervisores', 'cypController@getSupervisores');

Route::get('contadorRevision/{idObservacion}', 'cypController@contadorRevision');

Route::get('infoFalla/{infoFalla}', 'cypController@infoFalla');

Route::get('modificaFalla/{idFalla}/tipoFalla/{tipoFalla}/comentario/{comentarioM}/sqi/{sqi}/indicacion/{indicacion}/observacion/{observacion}', 'cypController@actualizaFalla');

Route::get('logout', 'mainController@logout');

Route::get('paraPintura/{idProyecto}', 'cypController@paraPintura');

Route::resource('reporteFallas','reporteFallasController');

Route::get("guardaBug/{nombre}/modulo/{idModulo}/descripcion/{descripcion}","reporteFallasController@guardaBug");

/*--ARMADO--*/

Route::resource('armado','armadoController');

Route::get('armado2', 'armadoController@armado2');

Route::get("armadoGetPiezas/{pieza}", "armadoController@getPiezas");

Route::get("armadoGetCantidadCC/{pieza}", "armadoController@getCantidadCC");

Route::get("armadoGetCantidadStrumis/{pieza}", "armadoController@getCantidadStrumis");

Route::get("armadoCreaPieza/{proyecto}/nombreProyecto/{np}/pieza/{pieza}/nombre/{nombre}/consecutivo/{consecutivo}/", "armadoController@armadoCreaPieza");

Route::get("armadoGetInfo/{idPieza}", "armadoController@getInfo");

Route::get("armadoGetPiezaConsecutivo/{idPieza}", "armadoController@getPiezaConsecutivo");

Route::get("armadoGetAprobadas/{idPieza}", "armadoController@getAprobadas");

Route::get("armadoGetRechazadas/{idPieza}", "armadoController@getRechazadas");

Route::get("armadoCreaRevision/{proyecto}/pieza/{pieza}/inspector/{inspector}/etapa/{etapa}/parcial/{parcial}", "armadoController@createRevision");

Route::get('armadoPiezasOB/{idPieza}', 'armadoController@getOBS');

/*Route::get('apruebaParcial/{pieza}/inspector/{inspector}/etapa/{etapa}/revision/{revision}/comentario/{comentario?}','armadoController@insertaParcial');*/

Route::get('apruebaParcialExiste/{revision}/pieza/{pieza}/inspector/{inspector}/etapa/{etapa}/revision/{nrevision}/comentario/{comentario?}','armadoController@insertaParcialExiste');

Route::get('getInfoParcial/{pieza}', 'armadoController@getInfoParcial');

Route::get('getRevisadas/{cod_elemento}','armadoController@getRevisadas');

Route::get('aprueba/{pieza}/inspector/{inspector}/etapa/{etapa}/comentario/{comentario}/revision/{revision}','armadoController@aceptar');

Route::get('armadoGetStatus/{idPieza}', 'armadoController@getStatus');

Route::get('armadoRechazar/{pieza}/inspector/{inspector}/etapa/{etapa}/comentario/{comentario}','armadoController@rechazar');

Route::get('armadoActualizaFalla/{falla}/tipoFalla/{tipoFalla}/comentario/{comentario}/supervisor/{sqi}/indicacion/{indicacion}/observacion/{observacion}', 'armadoController@actualizaFalla');

Route::get('armadoCrearObservacion/{idPiezaOb}/inspector/{supervisorQI}/revision/{revision}/armadorEstampa/{ae}/etapa/{etapa}','armadoController@insertaOB');

Route::get('armadoCreaAccion/{usuario}/pieza/{pieza}/etapa/{etapa}/revision/{revision}/observacion/{observacion}/falla/{falla}/comentario/{comentario}/nRevision/{nRevision}', 'armadoController@createAccion');

Route::get('armadoContadorRevision/{usuario}/pieza/{pieza}/etapa/{etapa}/revision/{revision}/observacion/{observacion}/falla/{falla}/comentario/{comentario}', 'armadoController@contadorRevision');

Route::get('getInfoAcciones/{pieza}', 'armadoController@getInfoAcciones');

Route::get('refabricacion/{inspector}/pieza/{idPieza}/etapa/{etapa}/comentario/{comentario}', 'armadoController@refabricacion');

Route::get('armadoInsertaComentario/{revision}/revisionPlano/{rPlano}/comentario/{comentario?}','armadoController@insertaComentario');

Route::get('apruebaArmado/{revision}/pieza/{pieza}/inspector/{inspector}/etapa/{etapa}/revision/{revisionP}/armador/{armador}/comentario/{comentario?}','armadoController@apruebaArmado');

Route::get('getRevisionArmado/{pieza}', 'armadoController@getRevisionArmadoPlano');

/*--SOLDADURA--*/

Route::resource('soldadura','soldaduraController');

Route::get("soldaduraGetPiezas/{pieza}", "soldaduraController@getPiezas");

Route::get('apruebaSoldadura/{revision}/pieza/{pieza}/inspector/{inspector}/etapa/{etapa}/revision/{revisionP}/soldador/{soldador}/comentario/{comentario?}','soldaduraController@apruebaSoldadura');

Route::get('creaFallaSoldadura/{supervisor}/observacion/{idObservacion}/idTipoFalla/{idTipoFalla}/comentarioFalla/{comentarioFalla}/observaciones/{observaciones}/indicacion/{indicacion}/proceso/{proceso}','soldaduraController@creaFalla');

Route::get('soldaduraGetStatus/{idPieza}', 'soldaduraController@getStatus');

/*LOTE PINTURA*/

Route::resource('lotePintura', 'lotePinturaController');

Route::get('creaLotePintura/{supervisor}/lote/{idLote}', 'lotePinturaController@creaLotePintura');

Route::get('agregaPiezaLote/{lote}/pieza/{pieza}/cantidad/{c}/muestra/{m}/conjunto/{con}', 'lotePinturaController@agregaPiezaLote');

Route::get('reemplazarPieza/{inicial}/piezaFinal/{final}', 'pinturaCalidad@reemplazarPieza');
/*PINTURA*/

Route::resource("pintura", "pinturaCalidad");

Route::get('getProyectosPintura', 'pinturaCalidad@getProyectos');

Route::get('pinturaGetPiezas/{proyecto}', 'pinturaCalidad@getPiezas');

Route::get('getLotePintura', 'pinturaCalidad@getLotePintura');

Route::get('getPiezasPintura/{lote}/etapa/{etapa}', 'pinturaCalidad@getPiezasPintura');

Route::get('apruebaPiezaPinturaM/{pieza}/conjunto/{conjunto}/etapa/{etapa}', 'pinturaCalidad@apruebaPiezaPinturaM');

Route::get('apruebaPiezaPinturaE/{pieza}/consecutivo/{conjunto}/etapa/{etapa}', 'pinturaCalidad@apruebaPiezaPinturaE');

Route::get('pinturaCrearOB/{lote}/pieza/{pieza}/supervisor/{supervisor}', 'pinturaCalidad@pinturaCrearOB');

Route::get('pinturaCreaFalla/{idObservacion}/idTipoFalla/{falla}/comentario/{comentario}/supervisor/{supervisor}/indicacion/{indicacion}/observacion/{observacion}', 'pinturaCalidad@pinturaCreaFalla');

Route::get('getPiezasReemplazar/{lote}', 'pinturaCalidad@getPiezasReemplazar');

/*ADMINISTRADOR*/

Route::resource("administrador", "administradorController");

Route::get("usuariosCrud", "administradorController@usuariosMain");	

Route::get("piezasCrud", "administradorController@piezasMain");

Route::get("fallasCrud", "administradorController@fallasMain");

Route::get('generarQR/{variable}', function ($variable) {
	$image = \QrCode::format('png')
	/*->merge('images/ppm2.png', 0.5, true)*/
	->size(500)->errorCorrection('H')
	->generate($variable);
	return response($image)->header('Content-type','image/png');
});

Route::get("regresaUsuarios", "crudController@regresaUsuarios");

Route::get('guardarPintura/{arreglo}', 'pinturaCalidad@guardar');

Route::get('testcrearRevision/{proyecto}/pieza/{pieza}/inspector/{inspector}/etapa/{etapa}/nombreP/{np}','cypController@test');

/*Route::get('/reportes','reportesController');*/

Route::get('getSoldadores','soldaduraController@getSoldadores');

Route::get('getArmadores','armadoController@getArmadores');

Route::get('armadoCreaAccion/{usuario}/pieza/{pieza}/etapa/{etapa}/revision/{revision}/observacion/{observacion}/falla/{falla}/comentario/{comentario}/nRevision/{nRevision}/armador/{armador}', 'armadoController@createAccionArmador');

Route::get('armadoCreaAccion/{usuario}/pieza/{pieza}/etapa/{etapa}/revision/{revision}/observacion/{observacion}/falla/{falla}/comentario/{comentario}/nRevision/{nRevision}/estampa/{soldador}', 'armadoController@createAccionSoldador');

Route::resource('/iniciarRevision','revisionController');

Route::get('/getValues','revisionController@getValues');

//TALARA

Route::get('/getTalara','lotePinturaController@getTalara');

Route::get('pinturaCreaTalara/{proyecto}','lotePinturaController@creaTalara');

Route::get("setComentarioCYP/{revision}/comentario/{comentario}", "cypController@setComentarioCYP");

Route::get('getHistorialArmado/{pieza}','armadoController@getHistorialArmado');

Route::get('getHistorialSoldadura/{pieza}','soldaduraController@getHistorialSoldadura');

Route::get('anadirRevisionCYP/{pieza}/revisionPlano/{revision}','cypController@anadirRevision');

Route::get("guardaProcesoRevision/{revision}/proceso/{proceso}",'soldaduraController@guardaProcesoRevision');