<?php

namespace cc\Http\Controllers;

use Illuminate\Http\Request;
use cc\usuarios;
use cc\pieza;
use DB;
use Session;

class mainController extends Controller
{
    public function index(){
    	if (session()->has('id')) {
            $privilegio = usuarios::getPermiso(Session::get('id'));
            if ($privilegio == 3) {
                return view('supervisorPintura');
            }else{
                return view('main');
            }
    	}else{
    		return view('main');
    	}
    }

    public function login(){
        return view('auth2/nipLogin');
    }

    public function register(){
    	return view('auth2/register');
    }

    public function create(Request $request, $nombre, $apellidoP, $apellidoM, $nip){
        $respuesta = usuarios::create($nombre, $apellidoP, $apellidoM, $nip);
        session(['id' => $respuesta]);
        return $respuesta;
    }

    public function logout(){
        session()->flush();
        return view('main');
    }

    public function sessionLogin(Request $request, $nip){
        $respuesta = usuarios::sessionLogin($nip);
        return $respuesta;
    }

    public function updateSession($nip){
        $usuario = usuarios::usuario($nip);
        session(['id'=>$usuario[0]]);
        return $usuario[0];
    }
}
