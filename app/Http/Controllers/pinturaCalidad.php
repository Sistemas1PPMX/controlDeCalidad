<?php

namespace cc\Http\Controllers;

use Illuminate\Http\Request;
use cc\pieza;
use cc\lotePintura;
use cc\revision;
use cc\pintura;
use cc\piezaPintura;
use cc\observacion;
use cc\falla;

class pinturaCalidad extends Controller
{
     public function index(){
    	return view("pintura2");
    }

    public function getLotes(){
    	$lotes = lotePintura::getLotes();
    	return response($lotes);
    }

    public function getPiezas(Request $request, $idProyecto){
    	return pieza::getPiezaPintura($idProyecto);
    }

    public function crearRevision(Request $request, $lote, $usuario, $etapa){
    	$id = revision::pinturaCreaRevision($lote, $usuario, $etapa);
    	return $id;
    }

     public function getProyectos(Request $request){
        $proyectos = pieza::getProyectosPintura();
        return $proyectos;
    }

    public function guardar(Request $request, $arreglo){
        $nuevoArreglo = explode(',', $arreglo);
        pintura::guardar($nuevoArreglo);
        return array_values($nuevoArreglo);
    }

    public function getLotePintura(Request $request){
        return lotePintura::getLotePintura();
    }

    public function getPiezasPintura(Request $request, $lote, $etapa){
        return piezaPintura::getPiezasPintura($lote, $etapa);
    }

    public function apruebaPiezaPinturaM(Request $request, $pieza, $conjunto, $etapa){
        piezaPintura::apruebaPiezaPinturaM($pieza, $conjunto, $etapa);
    }

    public function apruebaPiezaPinturaE(Request $request, $pieza, $conjunto, $etapa){
        piezaPintura::apruebaPiezaPinturaE($pieza, $conjunto, $etapa);
    }

    public function pinturaCrearOB(Request $request, $lote, $pieza, $supervisor){
        $piezaPintura = piezaPintura::getId($pieza);
        piezaPintura::agregarOB($piezaPintura);
        $idOb = observacion::pinturaCrearOB($lote, $piezaPintura, $supervisor);
        return $idOb;
    }

    public function pinturaCreaFalla(Request $request, $idObservacion, $idTipoFalla, $comentario, $supervisor, $indicacion, $observacion){
        falla::pinturaCreaFalla($idObservacion, $idTipoFalla, $comentario, $supervisor, $indicacion, $observacion);
    }

    public function getPiezasReemplazar(Request $request, $lote){
        return piezaPintura::getPiezasReemplazar($lote);
    }

    public function reemplazarPieza(Request $request, $inicial, $final){
        piezaPintura::reemplazarPieza($inicial, $final);
    }
}