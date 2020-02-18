<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;

class pintura extends Model
{
    protected $connection = 'mysql';

    protected $table = 'tb_pintura';

    public static function guardar($arregloBase){
    	pintura::insert(['idProyecto'=> $arregloBase[0], 'lote' => $arregloBase[1], 'idPieza'=> $arregloBase[2], 'figura'=> $arregloBase[3], 'c11aS'=> $arregloBase[4], 'c11aD'=> $arregloBase[18], 'c11aI'=> $arregloBase[5], 'c12aS'=> $arregloBase[6], 'c12aD'=> $arregloBase[19], 'c12aI'=> $arregloBase[7], 'c21aS'=> $arregloBase[8], 'c21aD'=> $arregloBase[20], 'c21aI'=> $arregloBase[9], 'c22aS'=> $arregloBase[10], 'c22aD'=> $arregloBase[21], 'c22aI'=> $arregloBase[11], 'c31aS'=> $arregloBase[12], 'c31aD'=> $arregloBase[22], 'c31aI'=> $arregloBase[13], 'c32aS'=> $arregloBase[14], 'c32aD'=> $arregloBase[23], 'c32aI'=> $arregloBase[15], 'etiquetado'=> $arregloBase[16], 'observaciones'=> $arregloBase[17], 'created_at'=>now()]);
    }

}
