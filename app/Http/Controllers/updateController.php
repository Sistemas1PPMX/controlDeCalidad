<?php

namespace cc\Http\Controllers;

use Illuminate\Http\Request;

class updateController extends Controller
{
    public function update(){
    	$file = public_path(). "/apkVersion/controlCalidadBeta1.0.apk";
    	$headers = ['Content-Type'=>'application/vnd.android.package-archive'];
    	return response()->download($file,'controlCalidad.apk',$headers);
    }
}
