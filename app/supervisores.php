<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class supervisores extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tb_supervisorqi';

    public static function getSupervisores(){
    	return supervisores::get();
    }

    public static function getID($nombreCompleto){
        $idSupervisor = supervisores::select('idSupervisor')->whereRaw('concat(apellidoPsupervisor," ",apellidoMsupervisor," ",nombreSupervisor) OR concat(nombreSupervisor," ",apellidoPsupervisor," ",apellidoMsupervisor) like "%'.$nombreCompleto.'%"')->value('idSupervisor');
        return $idSupervisor;
    }
}
