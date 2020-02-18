<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;

class etapa extends Model
{
    protected $connection = 'mysql';

    protected $table = 'tb_etapa';


    public static function etapas(){
    	return etapa::all();
    }
}
