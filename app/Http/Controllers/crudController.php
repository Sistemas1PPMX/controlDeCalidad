<?php

namespace cc\Http\Controllers;

use Illuminate\Http\Request;
use cc\usuarios;

class crudController extends Controller
{
    public function regresaUsuarios(Request $request){
    	$usuarios = usuarios::regresaUsuarios();
    	return $usuarios;
    }
}
