<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class piezaPintura extends Model
{
	protected $connection = 'mysql';

	protected $table = 'tb_piezaPintura';

	protected $fillable = ['created_at', 'updated_at'];

	public static function crearPieza($idPieza, $consecutivo, $idLotePintura, $idConjunto, $muestra){
		if ($muestra == "false") {
			$muestra = 0;
		}else{
			$muestra = 1;
		}
		piezaPintura::insert(['idpieza'=> $idPieza, 'consecutivo'=>$consecutivo, 'idLotePintura'=>$idLotePintura, 'idConjunto'=>$idConjunto, 'muestra'=>$muestra]);
	}

	public static function getPiezasPintura($lote, $etapa){
		$piezas;
		switch ($etapa) {
			case 'pinturaPrep':
			$piezas = DB::select("select tb_piezaPintura.idPieza, tb_pieza.nombrePieza, tb_pieza.consecutivo, tb_piezaPintura.idConjunto, count(tb_piezaPintura.idPieza) as cantidad, descripcionStatus 
				from tb_piezaPintura 
				inner join tb_lotePintura on tb_lotePintura.idLotePintura = tb_piezaPintura.idLotePintura 
				inner join tb_pieza on tb_pieza.idPieza = tb_piezaPintura.idPieza 
				inner join tb_status on tb_status.idStatus = tb_lotePintura.status 
				where tb_lotePintura.idLotePintura = ".$lote." and tb_piezaPintura.muestra = 1 and tb_piezaPintura.pinturaPrep is null 
				group by tb_piezaPintura.idPieza, tb_pieza.cod_elemento, descripcionStatus, tb_pieza.consecutivo, tb_piezaPintura.idConjunto;");
			break;

			case 'pinturaC1':
			$piezas = DB::select("select tb_piezaPintura.idPieza, tb_pieza.nombrePieza, tb_pieza.consecutivo, tb_piezaPintura.idConjunto, count(tb_piezaPintura.idPieza) as cantidad, descripcionStatus 
				from tb_piezaPintura 
				inner join tb_lotePintura on tb_lotePintura.idLotePintura = tb_piezaPintura.idLotePintura 
				inner join tb_pieza on tb_pieza.idPieza = tb_piezaPintura.idPieza 
				inner join tb_status on tb_status.idStatus = tb_lotePintura.status 
				where tb_lotePintura.idLotePintura = ".$lote." and tb_piezaPintura.muestra = 1 and tb_piezaPintura.pinturaPrep is not null and tb_piezaPintura.pinturaC1 is null
				group by tb_piezaPintura.idPieza, tb_pieza.cod_elemento, descripcionStatus, tb_pieza.consecutivo, tb_piezaPintura.idConjunto;");
			break;
			
			case 'pinturaC2':
			$piezas = DB::select("select tb_piezaPintura.idPieza, tb_pieza.nombrePieza, tb_pieza.consecutivo, tb_piezaPintura.idConjunto, count(tb_piezaPintura.idPieza) as cantidad, descripcionStatus 
				from tb_piezaPintura 
				inner join tb_lotePintura on tb_lotePintura.idLotePintura = tb_piezaPintura.idLotePintura 
				inner join tb_pieza on tb_pieza.idPieza = tb_piezaPintura.idPieza 
				inner join tb_status on tb_status.idStatus = tb_lotePintura.status 
				where tb_lotePintura.idLotePintura = ".$lote." and tb_piezaPintura.muestra = 1 and tb_piezaPintura.pinturaPrep is not null
				and tb_piezaPintura.pinturaC1 is not null and tb_piezaPintura.pinturaC2 is null
				group by tb_piezaPintura.idPieza, tb_pieza.cod_elemento, descripcionStatus, tb_pieza.consecutivo, tb_piezaPintura.idConjunto;");
			break;

			case 'pinturaC3':
			$piezas = DB::select("select tb_piezaPintura.idPieza, tb_pieza.nombrePieza, tb_pieza.consecutivo, tb_piezaPintura.idConjunto, count(tb_piezaPintura.idPieza) as cantidad, descripcionStatus 
				from tb_piezaPintura 
				inner join tb_lotePintura on tb_lotePintura.idLotePintura = tb_piezaPintura.idLotePintura 
				inner join tb_pieza on tb_pieza.idPieza = tb_piezaPintura.idPieza 
				inner join tb_status on tb_status.idStatus = tb_lotePintura.status 
				where tb_lotePintura.idLotePintura = ".$lote." and tb_piezaPintura.muestra = 1 and tb_piezaPintura.pinturaPrep is not null
				and tb_piezaPintura.pinturaC1 is not null and tb_piezaPintura.pinturaC2 is not null and tb_piezaPintura.pinturaC3 is null
				group by tb_piezaPintura.idPieza, tb_pieza.cod_elemento, descripcionStatus, tb_pieza.consecutivo, tb_piezaPintura.idConjunto;");
			break;	
			default:
				# code...
			break;
		}
		return $piezas;
	}

	public static function apruebaPiezaPinturaM($pieza, $conjunto, $etapa){
		piezaPintura::where([['idPieza', $pieza],['idConjunto', $conjunto]])->update([$etapa=>now()]);
	}

	public static function apruebaPiezaPinturaE($pieza, $conjunto, $etapa){
		piezaPintura::where('idPieza', $pieza)->update([$etapa=>now()]);
	}

	public static function getId($pieza){
		return piezaPintura::where('idPieza', $pieza)->select('idPiezaPintura')->value('idPiezaPintura');
	}

	public static function getPiezasReemplazar($lote){
		$piezas = DB::select("select idPiezaPintura, nombrePieza, (case when tb_pieza.consecutivo = 1 then tb_piezaPintura.consecutivo else 
			tb_pieza.consecutivo end) as consecutivo from tb_piezaPintura inner join tb_pieza on tb_pieza.idPieza = tb_piezaPintura.idPieza where 
			tb_piezaPintura.idLotePintura = ".$lote." and muestra = 0;");
		return $piezas;
	}
	public static function reemplazarPieza($inicial, $final){
		piezaPintura::where('idPieza', $inicial)->update(['muestra'=>0]);
		piezaPintura::where('idPiezaPintura', $final)->update(['muestra'=>1]);
	}

	public static function agregarOB($pieza){
		piezaPintura::where('idPiezaPintura', $pieza)->update(['tieneOB'=>1]);
	}
}
