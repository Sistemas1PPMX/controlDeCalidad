<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;

class reporteFallasAplicacion extends Model
{
    protected $connection = 'mysql';

    protected $table = 'reporteFallasAplicacion';

    protected $fillable = ['nombre', 'area', 'descripcion', 'status', 'created_at', 'updated_at'];

    public static function guardaBug($nombre, $idEtapa, $descripcion){
    	return reporteFallasAplicacion::insertGetId(
    		['nombre'=>$nombre, 'area'=>$idEtapa, 'descripcion'=>$descripcion, 'status'=>5, 'created_at'=>now(), 'updated_at'=>now()]
    	);
    }
}
