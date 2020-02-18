<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;

class revisionTrabajador extends Model
{
    protected $connection = 'mysql';

	protected $table = 'tb_revisionTrabajador';

	public $timestamps = true;

	public static function insertaArmador($revision,$armador){
		revisionTrabajador::insert(['idRevision'=>$revision,'idArmador'=>$armador]);
	}

	public static function insertaSoldador($revision,$soldador){
		revisionTrabajador::insert(['idRevision'=>$revision,'idSoldador'=>$soldador]);
	}

}
