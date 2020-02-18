<?php

namespace cc\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class revisionController extends Controller
{
    public function index(){
    	return view('revision');
    }

    public function getValues(Request $request){
    	return Session::get('id');
    }
}
