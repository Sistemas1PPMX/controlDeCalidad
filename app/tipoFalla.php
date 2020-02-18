<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class tipoFalla extends Model
{
	protected $connection = 'mysql';

    protected $table = 'tb_tipofalla';


    public static function tipoFallas(){
    	return tipoFalla::all();
    }

    public static function getID($nombre){
    	$idFalla = tipoFalla::select('idTipoFalla')->whereRaw('descripcionTipoFalla = "'.ltrim($nombre, $nombre[0]).'"')->value('idTipoFalla');

    	/*DB::select('select idTipoFalla from tb_tipofalla where descripcionTipoFalla = "'.ltrim($nombre, $nombre[0]).'";')->value('idTipoFalla');*/
    	return $idFalla;
    }
}
