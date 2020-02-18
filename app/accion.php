<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class accion extends Model
{
	protected $connection = 'mysql';

	protected $table = 'tb_acciones';

	public static function createAccion($idInspector, $idPieza, $idEtapa, $idRevision, $idObservacion, $idFalla, $comentario, $revision){
		if ($idRevision != 'null') {
			if ($idObservacion != 'null') {
				if ($idFalla != 'null') {
					if ($revision != 'null') {
					accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idRevision' => $idRevision, 'idObservacion' => $idObservacion, 'idFalla' => $idFalla, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now(),'revision'=>$revision]);
					}else{
						accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idRevision' => $idRevision, 'idObservacion' => $idObservacion, 'idFalla' => $idFalla, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now()]);
					}
				}else{
					if ($revision != 'null') {
					accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idRevision' => $idRevision, 'idObservacion' => $idObservacion, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now(),'revision'=>$revision]);
					}else{
						accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idRevision' => $idRevision, 'idObservacion' => $idObservacion, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now()]);
					}
				}
			}else{
				if ($idFalla != 'null') {
					if ($revision != 'null') {
					accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idRevision' => $idRevision, 'idFalla' => $idFalla, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now(),'revision'=>$revision]);
					}else{
						accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idRevision' => $idRevision, 'idFalla' => $idFalla, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now()]);
					}
				}else{
					if ($revision != 'null') {
					accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idRevision' => $idRevision, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now(), 'revision'=>$revision]);
					}else{
						accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idRevision' => $idRevision, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now()]);
					}
				}
			}
		}else{
			if ($idObservacion != 'null') {
				if ($idFalla != 'null') {
					if ($revision != 'null') {
					accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idObservacion' => $idObservacion, 'idFalla' => $idFalla, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now(),'revision'=>$revision]);
					}else{
						accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idObservacion' => $idObservacion, 'idFalla' => $idFalla, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now()]);
					}
				}else{
					if ($revision != 'null') {
					accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idObservacion' => $idObservacion, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now(),'revision'=>$revision]);
					}else{
						accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idObservacion' => $idObservacion, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now()]);
					}
				}
			}else{
				if ($idFalla != 'null') {
					if ($revision != 'null') {
					accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idFalla' => $idFalla, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now(),'revision'=>$revision]);
					}else{
						accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'idFalla' => $idFalla, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now()]);
					}
				}else{
					if ($revision != 'null') {
						# code...
					accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now(), 'revision'=>$revision]);
					}else{
						accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now()]);
					}
				}
			}
		}
	}

	public static function createAccionArmador($idInspector,$idPieza,$idEtapa,$idRevision,$idObservacion,$idFalla,$comentario,$revision,$armador){
		accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now(),'revision'=>$revision,'armador'=>$armador]);
	}
	public static function createAccionSoldador($idInspector,$idPieza,$idEtapa,$idRevision,$idObservacion,$idFalla,$comentario,$revision,$armador){
		accion::insert(['idUsuario'=> $idInspector, 'idPieza' => $idPieza, 'idEtapa'=> $idEtapa, 'comentario' => $comentario, 'created_at' => now(), 'updated_at' => now(),'revision'=>$revision,'estampa'=>$armador]);
	}

	public static function getAcciones($idPieza){
		$acciones = DB::select("
			select
				concat(us.nombreusuario,' ',us.apellidoPaterno) as nombre,
				concat(pz.nombrePieza,'-',pz.consecutivo) as pieza,
				et.descripcionEtapa as etapa,
				rv.idRevision as revision,
				ob.idObservaciones as observacion,
				fa.idFallas as falla,
				ac.comentario as comentario,
				ac.created_at as fecha
			from
				tb_acciones as ac
			inner join 
				usuarios as us on us.idUsuarios = ac.idUsuario
			inner join 
				tb_pieza as pz on pz.idPieza = ac.idPieza
			inner join 
				tb_etapa as et on et.idEtapa = ac.idEtapa 
			left join 
				tb_revision as rv on rv.idRevision = ac.idRevision 
			left join 
				tb_observaciones as ob on ob.idObservaciones = ac.idObservacion 
			left join 
				tb_fallas as fa on fa.idfallas = ac.idFalla 
			where 
				pz.idPieza = ".$idPieza.";");
		return $acciones;
	}

	public static function getAccionesR($idPieza){
		$acciones = DB::select("
			select
				concat(us.nombreusuario,' ',us.apellidoPaterno) as nombre,
				concat(pz.cod_elemento,'-',pz.consecutivo) as pieza,
				et.descripcionEtapa as etapa,
				rv.idRevision as revision,
				ob.idObservaciones as observacion,
				fa.idFallas as falla,
				ac.comentario as comentario,
				ac.created_at as fecha
			from
				tb_acciones as ac
			inner join 
				usuarios as us on us.idUsuarios = ac.idUsuario
			inner join 
				tb_pieza as pz on pz.idPieza = ac.idPieza
			inner join 
				tb_etapa as et on et.idEtapa = ac.idEtapa 
			left join 
				tb_revision as rv on rv.idRevision = ac.idRevision 
			left join 
				tb_observaciones as ob on ob.idObservaciones = ac.idObservacion 
			left join 
				tb_fallas as fa on fa.idfallas = ac.idFalla 
			where 
				pz.idPieza = ".$idPieza." and ac.created_at between pz.fechaRefabricacion and now();");
		return $acciones;
	}
}
