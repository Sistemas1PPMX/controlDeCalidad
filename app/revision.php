<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class revision extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tb_revision';

    public static function nuevaRevision($idPieza, $idInspector, $idEtapa, $parcial, $comentario  = ""){
    	$idRevision = DB::table('tb_revision')->insertGetId(['idPieza' => $idPieza,'idUsuario'=> $idInspector,'idEtapa'=>$idEtapa, 'CantidadAprobadas' => 0, 'tieneOB' => 0, 'parcial' => $parcial]);
    	return $idRevision;
    }

    public static function revisionAprobada($idPieza,$idInspector,$idEtapa,$CantidadAprobadas){
    	revision::insert(['idPieza' => $idPieza, 'idInspector' => $idInspector, 'idEtapa' => $idEtapa, 'CantidadAprobadas' => $CantidadAprobadas, 'tieneOB' => 0]);
    }

    public static function getAprobadas($idPieza){
        $aprobadas = revision::select('tb_revision.CantidadAprobadas')->join('tb_pieza','tb_pieza.idPieza','tb_revision.idPieza')->where('tb_pieza.cod_elemento',$idPieza)->sum('tb_revision.CantidadAprobadas');
        return $aprobadas;
    }

    public static function getAprobadasById($idPieza){
        $aprobadas = revision::select('tb_revision.CantidadAprobadas')->join('tb_pieza','tb_pieza.idPieza','tb_revision.idPieza')->where('tb_pieza.idPieza',$idPieza)->sum('tb_revision.CantidadAprobadas');
        return $aprobadas;
    }

    public static function updateRevision($revision, $aprobadas){
        DB::table('tb_revision')->where('idRevision','=',$revision)->update(['CantidadAprobadas' => $aprobadas]);
    }

    public static function revisionParcial($pieza, $inspector, $etapa, $comentario){
        $id = revision::insertGetId(['idPieza' => $pieza, 'idUsuario' => $inspector, 'idEtapa' => $etapa, 'comentario' => $comentario, 'parcial' => 1]);
        return $id;
    }

    public static function updateParcial($revision, $pieza, $inspector, $etapa, $revisionPlano ,$comentario = null){
        revision::where('idRevision', $revision)->update(['comentario'=> $comentario,'revisionPlano'=>$revisionPlano]);
    }

    public static function getInfoParcial($pieza){
        $info = revision::select('tb_pieza.cod_elemento', 'tb_pieza.consecutivo', 'tb_revision.idRevision','usuarios.nombreUsuario','tb_revision.comentario', 'tb_revision.idEtapa','tb_revision.fechaRevision')->join('tb_pieza','tb_pieza.idPieza', 'tb_revision.idPieza')->join('usuarios','usuarios.idUsuarios','tb_revision.idUsuario')->where('tb_revision.idPieza',$pieza)->get();
        return $info;
    }

    public static function armadoGetAprobadas($idPieza){
        $aprobadas = revision::select('tb_revision.CantidadAprobadas')->join('tb_pieza','tb_pieza.idPieza','tb_revision.idPieza')->where('tb_pieza.idPieza',$idPieza)->where('tb_revision.parcial', 1)->sum('tb_revision.CantidadAprobadas');
        return $aprobadas;
    }

    public static function armadoGetRevisadas($cod_elemento){
        $revisadas = DB::select('select count(distinct(rv.idPieza)) as revisadas from tb_revision as rv inner join tb_pieza as pz on pz.idPieza = rv.idPieza where pz.cod_elemento = "'.$cod_elemento.'";');
        return $revisadas;
    }

    public static function insertaComentario($revision, $comentario){
        DB::table('tb_revision')->where('idRevision','=', $revision)->update(['comentario' => $comentario]);
    }

    public static function pinturaCreaRevision($lote, $usuario, $etapa){
        $id = revision::insertGetId(['idLotePintura'=> $lote, 'idUsuario'=> $usuario, 'idEtapa' => $etapa, 'fechaRevision' => now()]);
        return $id;
    }

    public static function cambiaBandera($idRevision,$bandera){
        revision::where('idRevision',$idRevision)->update(['tieneOB'=>$bandera]);
    }

    public static function apruebaArmado($revision,$revisionPlano,$comentario){
        revision::where('idRevision',$revision)->update(['revisionPlano'=>$revisionPlano,'comentario'=>$comentario]);
    }

    public static function getRevisionArmado($pieza){
        $revision = DB::select('select revisionPlano from tb_revision as rv inner join tb_pieza as pz on pz.idPieza = rv.idPieza where pz.idPieza = '.$pieza.' and rv.updated_at is not null order by rv.updated_at desc limit 1;');
        return $revision;
    }

    public static function setComentarioCYP($revision, $comentario){
        revision::where('idRevision',$revision)->update(['comentario'=>$comentario]);
    }

    public static function anadirRevisionCYP($revision, $revisionPlano){
        revision::where('idRevision',$revision)->update(['revisionPlano'=>$revisionPlano]);
    }

    public static function guardaProcesoRevision($revision, $proceso){
        revision::where('idRevision',$revision)->update(['procesoSoldadura'=>$proceso]);
    }
}