<?php

namespace cc\Http\Controllers;

use Illuminate\Http\Request;
use cc\proyectoStrumis;
use cc\piezaStrumis;
use cc\inspector;
use cc\etapa;
use cc\tipoFalla;
use cc\pieza;
use cc\revision;
use cc\falla;
use cc\observacion;
use cc\piezaOB;
use cc\supervisores;
use Session;
use cc\usuarios;
use cc\registro;

class cypController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $contract = proyectoStrumis::   
        where('statusID','=','1')
        ->orderBy('Name','asc')
        ->pluck('Name','ContractID')
        ->all();
        return view('asetsCYP',compact('contract'));   
    }

    public function test(Request $request, $proyecto, $pieza, $inspector, $etapa, $nombreP){
        $idPieza = pieza::nuevaPieza($proyecto, $pieza, $nombreP, $nombreP);
        if (empty($idPieza)) {
            echo $idPieza;
        }else{
            echo $idPieza;
        }
    }

    public function testSession(){
        $contract = proyectoStrumis:: where('statusID','=','1')->orderBy('Name','asc')->pluck('Name','ContractID')->all();
        return view('corteyperforado', compact('contract'));
    }

    public function newSession(Request $request){
        session(['nombre'=>'Alex']);
        $contract = proyectoStrumis:: where('statusID','=','1')->orderBy('Name','asc')->pluck('Name','ContractID')->all();
        return view('corteyperforado', compact('contract'));
    }

    public function getPieza(Request $request, $id)
    {
        if ($request->ajax()) {
            $pieza = piezaStrumis::pieza($id);
            return response()->json($pieza);
        }
    }

    public function getPiezaMiscelaneos(Request $request, $id)
    {
        if ($request->ajax()) {
            $pieza = piezaStrumis::piezaMiscelaneos($id);
            return response()->json($pieza);
        }
    }

    public function getCantidad(Request $request, $idProyecto, $idPieza){
        if ($request->ajax()) {
            $cantidad = piezaStrumis::cantidad($idProyecto, $idPieza);
            return response()->json($cantidad);
        }
    }

    public function validaLote($lote,$cantidad,$muestra){
        $aRevisar = ceil($lote*($muestra/100));
        return response()->json($aRevisar);
    }

    public function muestraErrores(){
        return view('revisar'); 
    }

    public function getInspectores(Request $request){
        $inspectores = inspector::inspectores();
        return response()->json($inspectores);
    }

    public function getEtapas(Request $request){
        $etapas = etapa::etapas();
        return response()->json($etapas);
    }

    public function getFallas(Request $request){
        $fallas = tipoFalla::tipoFallas();
        return response()->json($fallas);
    }
//AQUI
    public function insertaRevision(Request $request, $proyecto, $pieza, $inspector, $etapa, $nombreP){
        $nombreProyecto = proyectoStrumis::getNombreProyecto($proyecto);
        $idPieza = pieza::nuevaPieza($proyecto, $pieza, $nombreP, $nombreProyecto);
        $idRevision = revision::nuevaRevision($idPieza,$inspector,$etapa, 0);
        return response($idRevision);
    }
    //CUANDO SE CREA UN REGISTRO EN PIEZAOB, LA BANDERA DE LA REVISION CAMBIA A UNO Y PERMANECE ASI AUNQUE LA OBSERVACION SE CIERRE.
//AQUI
    public function insertaPiezaOb(Request $request, $idRevision, $consecutivo){
        revision::cambiaBandera($idRevision,1);
        $idPiezaOb = piezaOB::nuevaPiezaOB($idRevision, $consecutivo);
        return response($idPiezaOb);
    }

    public function insertaOB(Request $request, $idPiezaOb, $supervisorQI){
        $idObservacion = observacion::nuevaObservacion($idPiezaOb,$supervisorQI);
        return response($idObservacion);
    }

    public function insertaFalla(Request $request,$supervisor, $idObservacion, $idTipoFalla, $comentarioFalla, $observaciones, $indicacion){
        $idSupervisor = supervisores::getID($supervisor);
        $idFalla = tipoFalla::getID($idTipoFalla);
        falla::nuevaFalla($idSupervisor, $idObservacion, $idFalla, $comentarioFalla, $observaciones, $indicacion);
        return "success";
    }

    public function getOBS(Request $request, $idPieza){
        $observaciones = observacion::getPiezasConOB($idPieza);
        return response() -> json($observaciones);
    }

    public function getFallasActivas(Request $request, $idObservacion){
        $fallas = falla::getFallas($idObservacion);
        return response() -> json($fallas);
    }

    //DESPUES QUE SE LIBERA LA FALLA PREGUNTAR SI LA OBSERVACION SIGUE ACTIVA, SI NO SIGUE ACTIVA AÑADIR EL ID DEL INSPECTOR QUE LIBERO A LA TABLA OBSERVACION
    public function updateFalla(Request $request, $idFalla,$idInspector){
        $idModificado = falla::updateFallas($idFalla);
        $idObservacion = falla::regresaIdObservacion($idFalla);
        $obActiva = observacion::obActiva($idObservacion);
        if ($obActiva == 1) {
            observacion::setInspectorLibera($idObservacion,$idInspector);
        }
        return response() -> json($obActiva);
    }

    public function getAprobadas(Request $request, $idPieza){
        $piezasAprobadas = revision::getAprobadas($idPieza);
        return response($piezasAprobadas);
    }

    public function creaYAprueba(Request $request, $proyecto, $idPieza, $cantidadPieza, $idInspector, $idEtapa, $cantidadAprobadas){
        $pieza = pieza::nuevaPieza($proyecto,$idPieza);
        revision::revisionAprobada($pieza,$idInspector,$idEtapa,$cantidadAprobadas);
    }

    public function apruebaRevision(Request $request, $revision, $aprobadas ){
        revision::updateRevision($revision, $aprobadas);
    }

    public function getNpiezasOB(Request $request, $pieza){
        $nPiezasEnOb = observacion::getNPiezasEnOB($pieza);
        return response($nPiezasEnOb);
    }

    public function regresaInspector(Request $request, $user){
        $inspector = usuarios::regresaInspector($user);
        return response()->json($inspector);
    }

    public function getRechazadas(Request $request, $pieza){
        $cantidad = pieza::getRechazadas($pieza);
        return response($cantidad);
    }

    public function getSupervisores(Request $request){
        $supervisores = supervisores::getSupervisores();
        return response()->json($supervisores);
    }

    public function contadorRevision(Request $request, $idObservacion){
        observacion::consecutivo($idObservacion);
    }

    public function infoFalla($idFalla){
        $fallas = falla::infoFalla($idFalla);
        return response()->json($fallas);
    }

    public function actualizaFalla(Request $request, $idFalla, $tipoFalla, $comentarioM, $sqi, $indicacion, $observacion){
        falla::actualizaFalla($idFalla, $tipoFalla, $comentarioM, $sqi, $indicacion, $observacion);
    }

    public function paraPintura(Request $request, $idProyecto){
        $piezas = piezaStrumis::elementosPrincipales($idProyecto);
        return response()->json($piezas);
    }

    public function registraNR(Request $request, $pieza, $inspector, $revision, $etapa, $comentario){
        $idpieza = pieza::getID($pieza);
        registro::guardar($idpieza, $inspector, $revision, $etapa, $comentario);
    }

    public function anadeEtapaId(Request $request, $pieza, $etapa, $habilitado){
        pieza::anadeEtapaId($pieza, $etapa, boolval($habilitado));
    }

    public function setComentarioCYP(Request $request, $revision, $comentario){
        revision::setComentarioCYP($revision, $comentario);
    }

    public function anadirRevision(Request $request, $revision, $revisionPlano){
        revision::anadirRevisionCYP($revision, $revisionPlano);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
