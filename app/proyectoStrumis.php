<?php

namespace cc;
use DB;

use Illuminate\Database\Eloquent\Model;

class proyectoStrumis extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'Contract';

    protected $fillable = ['Name'];

    public static function getNombreProyecto($idProyecto){
    	return proyectoStrumis::where('ContractID',$idProyecto)->select('Name')->value('Name');
    }

    public static function getTalara(){
    	return proyectoStrumis::join('Project','Project.ProjectID','Contract.ProjectID')->where('Contract.ProjectID',53)->select('Contract.ContractID','Contract.Name')->get();
    }
}
