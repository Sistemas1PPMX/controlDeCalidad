<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class lotePintura extends Model
{
    protected $connection = 'mysql';

    protected $table = 'tb_lotePintura';

    public static function creaLote($idSupervisor, $codigoLote){
    	$id = lotePintura::insertGetId(['idSupervisorPintura' => $idSupervisor, 'codigoLote' => $codigoLote, 'created_at' => now(), 'updated_at' => now()]);
    	return $id;
    }

    public static function getLotes(){
        $lotes = DB::select("SELECT lp.idLotePintura, lp.codigoLote FROM ppmx_v2.tb_lotePintura as lp inner join tb_pieza as pz on pz.idLotePintura = lp.idLotePintura where lp.status = 4 group by lp.idLotePintura, lp.codigoLote;");
        return $lotes;
    }

    public static function getLotePintura(){
        $lotes = lotePintura::where('status', '4')->select('idLotePintura', 'codigoLote')->get();
        return $lotes;
    }
}
