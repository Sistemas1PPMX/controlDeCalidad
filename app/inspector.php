<?php

namespace cc;

use DB;
use Illuminate\Database\Eloquent\Model;

class inspector extends Model
{
    protected $connection = 'mysql';

    protected $table = 'tb_inspector';


    public static function inspectores(){
    	return inspector::all();
    }

    public static function regresaInspector($user){
    	$inspector =  DB::connection('mysql')->select('select idInspector from tb_inspector as ins inner join users as us on us.id = ins.iduser where us.id ='.$user."");
    	return $inspector;
    }
}
