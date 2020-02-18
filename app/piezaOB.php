<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class piezaOB extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tb_piezaob';

    public static function nuevaPiezaOB($idRevision, $consecutivo){
    	$idPiezaOB = DB::table('tb_piezaob')->insertGetId(['idRevision' => $idRevision, 'consPieza' => $consecutivo]);
    	return $idPiezaOB;
    }
}
