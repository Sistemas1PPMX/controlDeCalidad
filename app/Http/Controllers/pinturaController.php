<?php

namespace cc\Http\Controllers;

use Illuminate\Http\Request;
use cc\pieza;
use cc\lotePintura;

class pinturaController extends Controller
{
	public function index()
	{
		return view('pintura2');
	}

	public function getPiezas(Request $request, $proyecto){
		$piezas = pieza::getPiezaPintura($proyecto);
		return response()->json($piezas);
	}

	public function supervisorPinturaGetPiezasCYP(Request $request){
		$piezas = pieza::piezaSupervisorCYP();
		return $piezas;
	}

	public function supervisorPinturaGetPiezasSoldadura(Request $request){
		$piezas = pieza::piezaSupervisorSoladura();
		return $piezas;
	}

	public function creaLotePintura(Request $request, $codigo, $supervisor){
		$id = lotePintura::creaLote($supervisor, $codigo);
		return $id;
	}

	public function asignaLotePintura(Request $request, $elem, $lote){
		if (strstr($elem, '-')) {
			$posicion = strpos($elem, '-');
			$final = $posicion;
			$codigo = substr($elem,0,$final);
			$consecutivo = substr($elem,-1,$final);
			$pieza = pieza::getIDConsecutivo($codigo, $consecutivo);
			pieza::asignaLotePintura($pieza,$lote);
			return $pieza;
		}else{
			$pieza = pieza::getIDPint($elem);
			pieza::asignaLotePintura($pieza,$lote);	
		}
	}

	
}
