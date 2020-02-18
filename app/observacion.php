<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class observacion extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tb_observaciones';

    public static function nuevaObservacion($idPiezaOB, $supervisorQI){
    	$idObservacion = DB::table('tb_observaciones')->insertGetId(['idPiezaOB' => $idPiezaOB, 'supervisor' => $supervisorQI, 'status' => 2]);
    	return $idObservacion;
    }

    public static function getPiezasConOB($idPieza){
    	$piezaOB = DB::connection('mysql')->select("select tb_observaciones.idObservaciones, tb_piezaob.idPiezaOb, tb_piezaob.consPieza from tb_observaciones inner join tb_piezaob on tb_piezaob.idPiezaOB = tb_observaciones.idPiezaOb inner join tb_revision on tb_revision.idRevision = tb_piezaob.idRevision inner join tb_pieza on tb_pieza.idPieza = tb_revision.idPieza where tb_pieza.cod_elemento = '".$idPieza."' and tb_observaciones.status = 2");
    	return $piezaOB;
    }

    public static function armadoGetPiezasConOB($idPieza){
        $piezaOB = DB::connection('mysql')->select("select tb_observaciones.idObservaciones, tb_piezaob.idPiezaOb, tb_piezaob.consPieza from tb_observaciones inner join tb_piezaob on tb_piezaob.idPiezaOB = tb_observaciones.idPiezaOb inner join tb_revision on tb_revision.idRevision = tb_piezaob.idRevision inner join tb_pieza on tb_pieza.idPieza = tb_revision.idPieza where tb_pieza.idPieza = ".$idPieza." and tb_observaciones.status = 2");
        return $piezaOB;
    }

    public static function getNPiezasEnOB($pieza){
        $getNPiezasEnOB = DB::connection('mysql')->select("select count(ob.idObservaciones) as n from tb_observaciones as ob inner join tb_piezaob as pob on pob.idPiezaOB = ob.idPiezaOb inner join tb_revision as rev on rev.idRevision = pob.idRevision inner join tb_pieza as pz on pz.idPieza = rev.idPieza where pz.cod_elemento = ".$pieza."");
        return $getNPiezasEnOB;
    }

    public static function consecutivo($idObservacion){
        observacion::where('idObservaciones','=',$idObservacion)->increment('contadorRevision',1);
    }

    public static function refabricacion($idPieza){
        observacion::join('tb_piezaob','tb_piezaob.idPiezaOB','tb_observaciones.idPiezaOb')->join('tb_revision','tb_revision.idRevision','tb_piezaob.idRevision')->join('tb_pieza','tb_pieza.idPieza','tb_revision.idPieza')->where('tb_pieza.idPieza', $idPieza)->where('tb_observaciones.status',2)->update(['tb_observaciones.status'=>7]);
    }

    public static function pinturaCrearOB($lote, $pieza, $supervisor){
        $id = observacion::insertGetId(['supervisor' => $supervisor, 'status' => 3, 'contadorRevision' => 1, 'created_at' => now(), 'idLotePintura' => $lote, 'idPiezaPintura'=>$pieza]);
        return $id;
    }

    public static function obActiva($idObservacion){
        $activa = observacion::where('idObservaciones',$idObservacion)->select('status')->value('status');
        return($activa);
    }

    public static function setInspectorLibera($idObservacion,$idInspector){
        observacion::where('idObservaciones',$idObservacion)->update(['supervisorLibera'=>$idInspector]);
    }
}
