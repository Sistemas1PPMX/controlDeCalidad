<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class falla extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tb_fallas';

    public static function nuevaFalla($supervisor,$idObservacion, $idTipoFalla, $comentarioFalla, $observaciones, $indicacion){
    	DB::table('tb_fallas')->insertGetId(['idObservacion' => $idObservacion, 'idTipoFalla' => $idTipoFalla, 'comentarioFalla' => $comentarioFalla, 'observaciones' => $observaciones,'supervisorqi'=>$supervisor, 'indicacion'=>$indicacion, 'status' => 2]);
    }

    public static function getFallas($idObservacion){
    	$fallas = DB::connection('mysql')->select("select fa.idFallas, fa.idObservacion, tf.descripcionTipoFalla, fa.comentarioFalla, fa.observaciones, st.descripcionStatus, fa.supervisorqi, fa.indicacion from tb_fallas as fa inner join tb_tipofalla as tf on tf.idTipoFalla = fa.idTipoFalla inner join tb_status as st on st.idStatus = fa.status inner join tb_observaciones as ob on ob.idObservaciones = fa.idObservacion inner join tb_piezaob as pob on  pob.idPiezaOb = ob.idPiezaOb where ob.idObservaciones = ".$idObservacion." and fa.status = 2");
    	return $fallas;
    }

    public static function updateFallas($idFalla){
    	DB::table('tb_fallas')->where('idFallas' , $idFalla)->update(['status' => 1]);
    	return 'success'; 
    }

    public static function infoFalla($idFalla){
        return falla::where('idFallas',$idFalla)->get();
    }

    public static function actualizaFalla($idFalla, $tipoFalla, $comentarioM, $sqi, $indicacion, $observacion){
        falla::where('idFallas', $idFalla)->update(['idTipoFalla'=>$tipoFalla, 'ComentarioFalla'=>$comentarioM, 'supervisorqi'=>$sqi, 'indicacion'=>$indicacion, 'observaciones'=>$observacion]);
    }

    public static function pinturaCreaFalla($idObservacion, $idTipoFalla, $comentario, $supervisor, $indicacion, $observacion){
        falla::insert(['idObservacion'=>$idObservacion, 'idTipoFalla'=>$idTipoFalla, 'ComentarioFalla'=>$comentario, 'supervisorqi'=> $supervisor, 'indicacion'=>$indicacion, 'observaciones'=>$observacion, 'status'=>4, 'created_at'=>now()]);
    }

    public static function nuevaFallaSoldadura($supervisor,$idObservacion, $idTipoFalla, $comentarioFalla, $observaciones, $indicacion,$proceso){
        DB::table('tb_fallas')->insertGetId(['idObservacion' => $idObservacion, 'idTipoFalla' => $idTipoFalla, 'comentarioFalla' => $comentarioFalla, 'observaciones' => $observaciones,'supervisorqi'=>$supervisor, 'indicacion'=>$indicacion, 'status' => 2, 'soldaduraProceso'=>$proceso]);
    }

    public static function regresaIdObservacion($idFalla){
        $idObservacion = DB::select('select idObservaciones from tb_observaciones as ob inner join tb_fallas as fa on fa.idObservacion = ob.idObservaciones where fa.idFallas = '.$idFalla.';');
        return $idObservacion[0]->idObservaciones;
    }
}
