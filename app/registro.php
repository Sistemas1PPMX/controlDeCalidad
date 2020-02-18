<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class registro extends Model
{
    protected $connection = 'mysql';

    protected $table = 'tb_nr';

    protected $fillable = ['idPieza', 'idInspector', 'idRevision', 'idEtapa', 'created_at', 'updated_at'];

    public static function guardar($idPieza, $idInspector, $idRevision, $idEtapa, $comentario){
    	DB::table('tb_nr')->insert(['idPieza' => $idPieza, 'idInspector' => $idInspector, 'idRevision' => $idRevision, 'idEtapa' => $idEtapa, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now()]);
    }
}
