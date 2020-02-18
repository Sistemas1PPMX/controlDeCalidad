<?php

namespace cc\Http\Controllers;

use Illuminate\Http\Request;
use cc\pieza;
use cc\soldador;
use cc\revision;
use cc\revisionTrabajador;
use cc\supervisores;
use cc\tipoFalla;
use cc\falla;

class soldaduraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contract = pieza::  
        where('proyecto','!=','') 
        ->orderBy('proyecto','asc')
        ->pluck('proyecto','nombreProyecto')
        ->all();
        return view('soldadura', compact('contract'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getPiezas(Request $request, $proyecto){
        $piezas = pieza::getPieza($proyecto);
        return response()->json($piezas);
    }

    public function getSoldadores(Request $request){
        $soldadores = soldador::getSoldadores();
        return $soldadores;
    }

    public function apruebaSoldadura($revision,$pieza,$inspector,$etapa,$revisionPlano,$soldadores,$comentario = null){
        $arregloSoldador = array_map('intval', explode(',',$soldadores));
        //YA SOLO FALTA TRASLADARLO A LA BASE DE DATOS
        revision::apruebaArmado($revision,$revisionPlano,$comentario);
        pieza::aprobarPieza($pieza, $etapa);
        foreach ($arregloSoldador as $soldador) {
            revisionTrabajador::insertaSoldador($revision,$soldador);
        }
    }

    public function creaFalla(Request $request,$supervisor, $idObservacion, $idTipoFalla, $comentarioFalla, $observaciones, $indicacion, $proceso){
        $idSupervisor = supervisores::getID($supervisor);
        $idFalla = tipoFalla::getID($idTipoFalla);
        falla::nuevaFallaSoldadura($idSupervisor, $idObservacion, $idFalla, $comentarioFalla, $observaciones, $indicacion,$proceso);
        return "success";
    }

    public function getStatus($idPieza){
        $status = pieza::getStatusSoldadura($idPieza);
        return $status;
    }

    public function getHistorialSoldadura($pieza){
        return pieza::getHistorial($pieza,6);
    }

    public function guardaProcesoRevision(Request $request, $revision, $proceso){
        revision::guardaProcesoRevision($revision, $proceso);
    }


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
