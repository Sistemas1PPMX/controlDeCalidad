<?php

namespace cc\Http\Controllers;

use Illuminate\Http\Request;
use cc\lotePintura;
use cc\piezaPintura;
use cc\pieza;
use cc\proyectoStrumis;
use cc\piezaStrumis;

class lotePinturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lotePintura');
    }

    public function creaLotePintura(Request $request,$supervisor, $idLote){
        $id = lotePintura::creaLote($supervisor, $idLote);
        return $id;
    }

    public function agregaPiezaLote(Request $request, $lote, $pieza, $cantidad, $muestra, $conjunto){
        $consecutivo = pieza::getConsecutivo($pieza);
        if (is_null($consecutivo)) {
            for ($i=0; $i < $cantidad; $i++) { 
                piezaPintura::crearPieza($pieza, ($i+1), $lote, $conjunto, $muestra);
            }
        }else{
            piezaPintura::crearPieza($pieza, $consecutivo, $lote, $conjunto, $muestra);
        }
    }

    public function getTalara(){
        return proyectoStrumis::getTalara();
    }

    public function creaTalara(Request $request, $proyecto){
        $contrato = proyectoStrumis::getNombreProyecto($proyecto); 
        $piezas = piezaStrumis::piezaArmado($proyecto);
        foreach ($piezas as $pieza) {
            $cantidadLocal = pieza::existePieza($pieza->id);
            if ($cantidadLocal[0]->cantidad - $pieza->cantidad == 0) {
                # code...
            }else if($cantidadLocal[0]->cantidad < $pieza->cantidad){
                for($i=$cantidadLocal[0]->cantidad; $i < $pieza->cantidad ; $i++) { 
                    pieza::creaPiezaConsecutivo($proyecto,$contrato,$pieza->id,$pieza->marca,($i+1));
                }
            }
        };
        $piezaPintura = pieza::getPiezaPinturaTalara($proyecto);
        return $piezaPintura;
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
