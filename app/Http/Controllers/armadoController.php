<?php

namespace cc\Http\Controllers;

use Illuminate\Http\Request;
use cc\proyectoStrumis;
use cc\piezaStrumis;
use cc\pieza;
use cc\revision;
use cc\observacion;
use cc\falla;
use cc\accion;
use cc\armadores;
use cc\revisionTrabajador;

class armadoController extends Controller
{
    public function index(){
    	$contract = proyectoStrumis::   
        where('statusID','=','1')
        ->orderBy('Name','asc')
        ->pluck('Name','ContractID')
        ->all();
        return view('armado', compact('contract'));
    }

    public function armado2(){
        $contract = proyectoStrumis::   
        where('statusID','=','1')
        ->orderBy('Name','asc')
        ->pluck('Name','ContractID')
        ->all();
        return view('armado2', compact('contract'));   
    }

    public function getPiezas(Request $request, $proyecto){
        $piezas = piezaStrumis::piezaArmado($proyecto);
        return response()->json($piezas);
    }

    public function getCantidadStrumis(Request $request, $pieza){
        $cantidad = piezaStrumis::armadoGetCantidadStrumis($pieza);
        return $cantidad;
    }

    public function getCantidadCC(Request $request, $pieza){
        $cantidad = pieza::armadoGetCantidadCC($pieza);
        return $cantidad;
    }

    public function armadoCreaPieza(Request $request, $proyecto, $nombreProyecto, $pieza,$nombre, $consecutivo){
        $nombre = piezaStrumis::getNombre($proyecto, $pieza);
        pieza::creaPiezaConsecutivo($proyecto, $nombreProyecto, $pieza, $nombre, $consecutivo);
    }

    public function getInfo($pieza){
        $info = piezaStrumis::getInfo($pieza);
        return response()->json($info);
    }

    public function getPiezaConsecutivo($pieza){
        $piezas = pieza::getPiezaConsecutivo($pieza);
        return response()->json($piezas);
    }

    public function getAprobadas($idPieza){
        $aprobadas = revision::armadoGetAprobadas($idPieza);
        return $aprobadas;
    }

    public function getRechazadas($idPieza){
        $rechazadas = pieza::armadoGetRechazadas($idPieza);
        return $rechazadas;
    }

    public function createRevision($idProyecto, $idPieza, $idInspector, $idEtapa, $parcial){
        /*pieza::setRevisada($idPieza);*/
        $idRevision = revision::nuevaRevision($idPieza, $idInspector, $idEtapa, $parcial);
        /*accion::createAccion($idInspector,$idPieza, $idEtapa, $idRevision, null, null, "Se crea la revision sin observaciones");*/
        return $idRevision;
    }

    public function getOBS(Request $request, $idPieza){
        $observaciones = observacion::armadoGetPiezasConOB($idPieza);
        return response() -> json($observaciones);
    }

    public function insertaParcial(Request $request, $pieza, $inspector, $etapa, $nRevision, $comentario ){
        /*$revision = revision::revisionParcial($pieza, $inspector, $etapa, $comentario);*/
        revision::updateParcial($revision, $pieza, $inspector, $etapa, $comentario);
        accion::createAccion($inspector, $pieza, $etapa, $revision, null, null, "Se crea la revision y se acepto parcialmente", $nRevision);
    }

    public function insertaParcialExiste(Request $request, $revision, $pieza, $inspector, $etapa, $nRevision, $comentario = null){
        revision::updateParcial($revision, $pieza, $inspector, $etapa, $nRevision, $comentario);
        accion::createAccion($inspector, $pieza, $etapa, $revision, null, null, "Se acepto la pieza parcialmente", $nRevision);
    }  

    public function getInfoParcial(Request $request, $pieza){
        $info = revision::getInfoParcial($pieza);
        return response()->json($info);
    }

    public function getRevisadas($cod_elemento){
        $revisadas = revision::armadoGetRevisadas($cod_elemento);
        return $revisadas;
    }

    public function inserta(Request $request, $pieza, $inspector, $etapa, $comentario = "sin comentario"){
        revision::revision($pieza, $inspector, $etapa, $comentario);
        pieza::setRevisada($idPieza);
    }

    public function getStatus(Request $request, $idPieza){
        $status = pieza::getStatus($idPieza);
        return $status;
    }

    public function rechazar(Request $request, $idPieza, $idInspector, $idEtapa, $comentario, $parcial = 0){
        $revision = revision::nuevaRevision($idPieza, $idInspector, $idEtapa, $parcial);
        revision::insertaComentario($revision, $comentario);
        pieza::rechazarPieza($idPieza);
    }

    public function aceptar(Request $request, $idPieza, $idInspector, $idEtapa, $comentario, $nRevision){
        $parcial = 0;
        $revision = revision::nuevaRevision($idPieza, $idInspector, $idEtapa, $parcial);
        revision::insertaComentario($revision, $comentario);
        pieza::aprobarPieza($idPieza, $idEtapa);
    }

    public function actualizaFalla(Request $request, $idFalla, $tipoFalla, $comentarioM, $sqi, $indicacion, $observacion){
        falla::actualizaFalla($idFalla, $tipoFalla, $comentarioM, $sqi, $indicacion, $observacion);
    }

    public function insertaOB(Request $request, $idPiezaOb, $supervisorQI,$revision,$armadorSoldador,$etapa){
        $idObservacion = observacion::nuevaObservacion($idPiezaOb,$supervisorQI);
        $arregloArmadorSoldador = array_map('intval', explode(',',$armadorSoldador));
        if ($etapa == 5) {
            foreach ($arregloArmadorSoldador as $armadorSoldador) {
                revisionTrabajador::insertaArmador($revision,$armadorSoldador);
            }
        }else{
            foreach ($arregloArmadorSoldador as $armadorSoldador) {
                revisionTrabajador::insertaSoldador($revision,$armadorSoldador);
            }
        }
        return response($idObservacion);
    }

    public function createAccion($idUsuario, $idPieza, $idEtapa, $idRevision, $idObservacion, $idFalla, $comentario,$revision){
        accion::createAccion($idUsuario, $idPieza, $idEtapa, $idRevision, $idObservacion, $idFalla, $comentario,$revision);
    }

    public function contadorRevision(Request $request, $idUsuario, $idPieza, $idEtapa, $idRevision, $idObservacion, $idFalla, $comentario){
        observacion::consecutivo($idObservacion);
        accion::createAccion($idUsuario, $idPieza, $idEtapa, $idRevision, $idObservacion, $idFalla, $comentario);
    }

    public function getInfoAcciones(Request $request, $pieza){
        $esRefabricacion = pieza::tieneRefabricacion($pieza);
        if ($esRefabricacion == "true") {
            $info = accion::getAccionesR($pieza);
            return response()->json($info);
        }else{
            $info = accion::getAcciones($pieza);
            return response()->json($info);            
        }
    }

    public function refabricacion($inspector,$idPieza,$etapa, $comentario){
        observacion::refabricacion($idPieza);
        pieza::refabricacion($idPieza);
        accion::createAccion($inspector, $idPieza, $etapa,null,null,null, $comentario);
    }

    public function getArmadores(){
        $armadores = armadores::getArmadores();
        return $armadores;
    }

    public function createAccionArmador($idUsuario, $idPieza, $idEtapa, $idRevision, $idObservacion, $idFalla, $comentario,$revision,$armador){
        accion::createAccionArmador($idUsuario, $idPieza, $idEtapa, $idRevision, $idObservacion, $idFalla, $comentario,$revision,$armador);
        /*accion::createAccion($idUsuario, $idPieza, $idEtapa, $idRevision, $idObservacion, $idFalla, $comentario,$revision,$armador);*/
    }

    public function createAccionSoldador($idUsuario, $idPieza, $idEtapa, $idRevision, $idObservacion, $idFalla, $comentario,$revision,$soldador){
        accion::createAccionSoldador($idUsuario, $idPieza, $idEtapa, $idRevision, $idObservacion, $idFalla, $comentario,$revision,$soldador);
        /*accion::createAccion($idUsuario, $idPieza, $idEtapa, $idRevision, $idObservacion, $idFalla, $comentario,$revision,$armador);*/
    }

    public function insertaComentario($revision,$revisionPlano,$comentario = null){
        revision::updateParcial($revision,null,null,null,$revisionPlano,$comentario);
    }

    public function apruebaArmado($revision,$pieza,$inspector,$etapa,$revisionPlano,$armadores,$comentario = null){
        $arregloArmador = array_map('intval', explode(',',$armadores));
        //YA SOLO FALTA TRASLADARLO A LA BASE DE DATOS
        revision::apruebaArmado($revision,$revisionPlano,$comentario);
        pieza::aprobarPieza($pieza, $etapa);
        foreach ($arregloArmador as $armador) {
            revisionTrabajador::insertaArmador($revision,$armador);
        }
    }

    public function getRevisionArmadoPlano(Request $request, $pieza){
        $revision = revision::getRevisionArmado($pieza);
        return $revision;
    }

    public function getHistorialArmado($pieza){
        return pieza::getHistorial($pieza,5);
    }

}
