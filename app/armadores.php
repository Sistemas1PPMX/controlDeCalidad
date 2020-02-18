<?php

namespace cc;

use Illuminate\Database\Eloquent\Model;

class armadores extends Model
{
    protected $connection = 'mysql';

    protected $table = 'tb_armadores';

    public static function getArmadores(){
    	return armadores::orderBy('nombre','asc')->get();
    }
}
