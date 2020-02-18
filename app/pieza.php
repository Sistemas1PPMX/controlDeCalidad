<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class pieza extends Model
{
	protected $connection = 'mysql';

    protected $table = 'tb_pieza';

    public static function nuevaPieza($proyecto, $pieza, $nombreP, $nombreProyecto){
        $idPieza = pieza::where('cod_elemento', $pieza)->select('idPieza')->value('idPieza');
        if (empty($idPieza)) {
            $id = DB::table('tb_pieza')->insertGetId(['nombreProyecto' => $proyecto,'cod_elemento'=> $pieza, 'nombrePieza' => $nombreP, 'proyecto' => $nombreProyecto]);
            return $id;
        }else{
            return $idPieza;
        }
    }

    public static function getRechazadas($pieza){
        $cantidad = DB::connection('mysql')->select("select pob.idPiezaOB from tb_pieza as pz inner join tb_revision as rv on pz.idPieza = rv.idPieza inner join tb_piezaob as pob on rv.idRevision = pob.idRevision
            inner join tb_observaciones as ob on pob.idPiezaOB = ob.idPiezaOb inner join tb_fallas as fa on ob.idObservaciones = fa.idObservacion where pz.cod_elemento = '".$pieza."' and ob.status=2 group by pob.idPiezaob;");
        return $cantidad;
    }

    public static function getRechazadasById($idPieza){
        $cantidad = DB::connection('mysql')->select("select count(pob.idPiezaOB) as pieza from tb_pieza as pz inner join tb_revision as rv on pz.idPieza = rv.idPieza inner join tb_piezaob as pob on rv.idRevision = pob.idRevision inner join tb_observaciones as ob on pob.idPiezaOB = ob.idPiezaOb inner join tb_fallas as fa on ob.idObservaciones = fa.idObservacion where pz.cod_elemento = '".$idPieza."' and ob.status=2;");
        return $cantidad;
    }

    public static function armadoGetRechazadas($idPieza){
        $cantidad = DB::connection('mysql')->select("select count(pob.idPiezaOB) as pieza from tb_pieza as pz inner join tb_revision as rv on pz.idPieza = rv.idPieza inner join tb_piezaob as pob on rv.idRevision = pob.idRevision inner join tb_observaciones as ob on pob.idPiezaOB = ob.idPiezaOb inner join tb_fallas as fa on ob.idObservaciones = fa.idObservacion where pz.cod_elemento = '".$idPieza."' and ob.status=2 and rv.parcial = false;");
        return $cantidad;
    }

    public static function existePieza($idPieza){
        $cantidad = DB::connection('mysql')->select("select count(idPieza) as cantidad from tb_pieza where cod_elemento = '".$idPieza."';");
        return $cantidad;
    }

    public static function creaPiezaConsecutivo($proyecto,$nombreProyecto,$pieza,$nombre,$consecutivo){
        DB::table('tb_pieza')->insert(['nombreProyecto' => $proyecto, 'proyecto'=>$nombreProyecto, 'cod_elemento' => $pieza, 'nombrePieza'=>$nombre,'consecutivo' => $consecutivo, 'idStatus' => 6]);  
    }

    public static function regresaPiezas($pieza){
        $piezas =  DB::connection('mysql')->select("select pz.idPieza as pieza, pz.cod_elemento as nombre, pz.consecutivo as consecutivo from tb_pieza as pz where cod_elemento = '".substr($pieza,1)."' order by cast(pz.consecutivo as unsigned);");
        return $piezas;
    }

    public static function getCantidad($pieza){
        $count = pieza::select('idPieza')->where('cod_elemento','=',substr($pieza,1))->count('idPieza');
        return $count;
    }

    public static function armadoGetCantidadCC($pieza){
        $count = DB::select("select count(idPieza) as cantidad from tb_pieza where cod_elemento = '".$pieza."';");
        return $count;
    }

    public static function getPiezaConsecutivo($pieza){
        $piezas = DB::select("select idPieza as id, consecutivo as consecutivo, st.descripcionStatus as status, pz.idStatus from tb_pieza as pz inner join tb_status as st on st.idStatus = pz.idStatus where cod_elemento = '".$pieza."' order by cast(pz.consecutivo as unsigned);");
        return $piezas;
    }

    public static function aprobarPieza($idPieza, $idEtapa){
        DB::table('tb_pieza')->where('idPieza', $idPieza)->update(['idStatus'=>1, 'idUltimaAprobacion'=>$idEtapa, 'updated_at' => now()]);
    }

    public static function setRevisada($idPieza){
        DB::table('tb_pieza')->where('idPieza', $idPieza)->update(['idStatus'=>2]);   
    }

    public static function rechazarPieza($idPieza){
        DB::table('tb_pieza')->where('idPieza', $idPieza)->update(['idStatus'=>3]);      
    }

    public static function getStatus($idPieza){
        return DB::select('select st.descripcionStatus as status from tb_pieza as pz inner join tb_status as st on st.idStatus = pz.idStatus where pz.idPieza = '.$idPieza.';');
    }

    public static function getStatusSoldadura($idPieza){
        $status = DB::select('select st.descripcionStatus as status, pz.idStatus, pz.idUltimaAprobacion from tb_pieza as pz inner join tb_status as st on st.idStatus = pz.idStatus where pz.idPieza = '.$idPieza.';');
        if ($status[0]->idUltimaAprobacion == 5 && $status[0]->idStatus == 1) {
            $status[0]->status = "Pendiente";
            return $status;
        }else{
            return $status;
        }
    }

    public static function getPieza($idProyecto){
        $pieza = pieza::select('idPieza', 'nombrePieza', 'consecutivo', 'idStatus')->where('nombreProyecto','=',$idProyecto)->where('nombrePieza','!=','')->get();
        return $pieza;
    }


    public static function getID($cod_elemento){
        $pieza = DB::table('tb_pieza')->select('idPieza')->where('cod_elemento','=',$cod_elemento)->value('idPieza');
        return $pieza;
    }  

   /* public static function getPiezaPintura($idProyecto){
        $pieza = pieza::select('idPieza', 'nombrePieza', 'consecutivo', 'idStatus')->where('nombreProyecto','=',$idProyecto)->where('nombrePieza','!=','')->where('idStatus','=',1)->get();
        return $pieza;
    } */

    public static function anadeEtapaId($pieza, $etapa, $habilitado){
        pieza::where('cod_elemento', '=', $pieza)->update(['idUltimaAprobacion'=>$etapa, 'habilitado' => $habilitado, 'idStatus' => 1]);
    }

    public static function piezaSupervisorCYP(){
        $piezas = DB::select("SELECT idPieza as id, nombrePieza as nombre FROM tb_pieza where idStatus = 1 and idUltimaAprobacion = 4 and habilitado = 1 and tieneLotePintura = 0;");
        return $piezas;
    }

    public static function piezaSupervisorSoladura(){
        $piezas = DB::select("SELECT idPieza as id, CONCAT(nombrePieza,'-',consecutivo) as nombre FROM tb_pieza where idStatus = 1 and idUltimaAprobacion = 6 and tieneLotePintura = 0");
        return $piezas;
    }

    public static function asignaLotePintura($pieza, $lote){
        pieza::where('idPieza',$pieza)->update(['tieneLotePintura' => 1, 'idLotePintura' => $lote]);
    }

    public static function getIDConsecutivo($elements, $consecutivo){
        $arregloAnidado = DB::select('select idPieza from tb_pieza where nombrePieza = "'.$elements.'" and consecutivo = "'.$consecutivo.'";');
        $arreglo = array_column($arregloAnidado, 'idPieza');
        return $arreglo[0];
    }

    public static function getIDPint($elements){
        $arregloAnidado = DB::select('select idPieza from tb_pieza where nombrePieza = "'.$elements.'";');
        $arreglo = array_column($arregloAnidado, 'idPieza');
        return $arreglo[0];
    }

    public static function pinturaGetpiezas($idLote){
        $piezas = DB::select('select * from tb_pieza as pz inner join tb_lotePintura as lp on lp.idLotePintura = pz.idLotePintura where lp.idLotePintura = "'.$idLote.'";');
        return $piezas;
    }

    public static function tieneRefabricacion($pieza){
        $arregloAnidado = DB::select('select if(fechaRefabricacion is null,"false","true") as refabricacion from tb_pieza where tb_pieza.idPieza = '.$pieza.';');
        $arreglo = array_column($arregloAnidado, 'refabricacion');
        return $arreglo[0];
    } 

    public static function refabricacion($idPieza){
        pieza::where('idPieza',$idPieza)->update(['idStatus'=>7, 'fechaRefabricacion' => now()]);
    }

    public static function getProyectosPintura(){
        $proyectos = DB::select('select proyecto, nombreProyecto from tb_pieza where idStatus = 1 and consecutivo is not null group by proyecto, nombreProyecto;');
        return $proyectos;
    }

    public static function getPiezaPintura($idProyecto){
        /*$piezas = DB::select('select idPieza, nombrePieza, consecutivo from tb_pieza where idStatus = 1 and consecutivo is not null and nombreProyecto = 181;');*/
        $piezas = DB::select('select t1.* from (select min(tb_pieza.idPieza) as idPieza, tb_pieza.cod_elemento, tb_pieza.nombrePieza, (case when 
            t2.cantidad = 0 then 1 else t2.cantidad end) as cantidad, tb_pieza.consecutivo from tb_pieza inner join (select pz.cod_elemento, t1.cantidad 
            from tb_pieza as pz inner join (select tb_pieza.cod_elemento, sum(CantidadAprobadas) as cantidad from tb_pieza inner join tb_revision on 
            tb_revision.idPieza = tb_pieza.idPieza where tb_pieza.idUltimaAprobacion is not null group by cod_elemento) as t1 on t1.cod_elemento = 
            pz.cod_elemento where pz.idUltimaAprobacion is not null group by pz.cod_elemento) as t2 on t2.cod_elemento = tb_pieza.cod_elemento where tb_pieza.nombreProyecto = '.$idProyecto.' group by 
            tb_pieza.cod_elemento, tb_pieza.nombrePieza, t2.cantidad, tb_pieza.consecutivo) as t1 left join (select * from tb_piezaPintura) as t2 on 
            t1.idPieza = t2.idPieza where t2.idPieza is null;');
        return $piezas;
    }
    public static function getPiezaPinturaTalara($idProyecto){
        /*$piezas = DB::select('select idPieza, nombrePieza, consecutivo from tb_pieza where idStatus = 1 and consecutivo is not null and nombreProyecto = 181;');*/
        $piezas = DB::select('select count(cod_elemento) as cantidad, idPieza, cod_elemento, nombrePieza from tb_pieza where nombreProyecto = "'.$idProyecto.'" group by cod_elemento, idPieza, cod_elemento, nombrePieza;');
        return $piezas;
    }

    public static function getConsecutivo($pieza){
        return pieza::where('cod_elemento', $pieza)->select('consecutivo')->value('consecutivo');
    }

    public static function getHistorial($pieza,$etapa){
        $historial = DB::select("select 
            rv.updated_at as fecha,us.nombreUsuario AS nombre,
            rv.revisionPlano,
            (CASE
            WHEN rv.tieneOB = 1 AND rv.parcial = 1 THEN 'OB'
            WHEN rv.tieneOB = 0 AND rv.parcial = 0 THEN 'APROBADA'
            WHEN (rv.tieneOB = 0 AND rv.parcial = 1) THEN 'AP'
            WHEN (rv.tieneOB = 1 AND rv.parcial = 0) THEN 'OB'
            END) AS evento,
            rv.comentario,
            ob.idObservaciones as numeroOB,
            tfa.descripcionTipoFalla as ei,
            fa.ComentarioFalla,
            fa.observaciones
            FROM
            tb_pieza AS pz
            INNER JOIN
            tb_revision AS rv ON rv.idPieza = pz.idPieza
            left JOIN
            tb_piezaob AS pob ON pob.idRevision = rv.idRevision
            left JOIN
            tb_observaciones AS ob ON ob.idPiezaOb = pob.idPiezaOb
            left JOIN
            tb_fallas AS fa ON fa.idObservacion = ob.idObservaciones
            left JOIN
            usuarios AS us ON us.idUsuarios = rv.idUsuario
            left join tb_tipofalla as tfa on tfa.idTipoFalla = fa.idTipoFalla
            WHERE
            rv.updated_at IS NOT NULL AND pz.idPieza = ".$pieza." and rv.idEtapa = ".$etapa." group by fecha, nombre, evento,comentario,numeroOB,ei,fa.ComentarioFalla,fa.observaciones,revisionPlano;");
        return $historial;
    }
}
