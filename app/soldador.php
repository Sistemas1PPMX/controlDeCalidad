<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;

class soldador extends Model
{
    protected $connection = 'mysql';

    protected $table = 'tb_soldadores';

    public static function getSoldadores(){
    	return soldador::orderBy('estampa','asc')->get();
    }
}
