<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;
use DB;

class usuarios extends Model
{
    protected $connection = 'mysql';
    protected $table = 'usuarios';

    public static function create($nombre, $apellidoP, $apellidoM, $nip){
    	$respuesta = usuarios::insertGetId([
    		'nombreUsuario' => $nombre,
    		'apellidoPaterno' => $apellidoP,
    		'apellidoMaterno' => $apellidoM,
    		'nip' => hash('md5',$nip)
    	]);
    	return $respuesta;
    }

    public static function regresaInspector($id){
    	$inspector = usuarios::where('idUsuarios', $id)->get();
    	return $inspector;
    }

    public static function sessionLogin($id){
        $login = DB::select('select count(idUsuarios) as usuario from usuarios where nip = "'.hash('md5', $id).'";');
        return($login);
    }

    public static function usuario($id){
        $usuario = usuarios::where('nip',hash("md5", $id))->pluck('idUsuarios');
        return $usuario;
    }

    public static function getPermiso($id){
        $privilegio = DB::table('usuarios')->where('idUsuarios','=',$id)->select('permisos')->value('permisos');
        return $privilegio;
    }

    public static function regresaUsuarios(){
        $usuarios = usuarios::get();
        return $usuarios;
    }

}
