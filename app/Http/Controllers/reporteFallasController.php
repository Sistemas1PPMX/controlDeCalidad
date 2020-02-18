<?php

namespace cc\Http\Controllers;

use Illuminate\Http\Request;
use cc\reporteFallasAplicacion;

class reporteFallasController extends Controller
{
    public function index(){
    	return view('fallas');
    }

    public function guardaBug(Request $request, $nombre, $idEtapa, $descripcion){
    	$id = reporteFallasAplicacion::guardaBug($nombre, $idEtapa, $descripcion);
    	return $id;
    }
}
