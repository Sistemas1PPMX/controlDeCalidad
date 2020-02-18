<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToReporteFallasAplicacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reporteFallasAplicacion', function(Blueprint $table)
		{
			$table->foreign('area', 'fk_reporteFallasAplicacion_1')->references('idEtapa')->on('tb_etapa')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('status', 'fk_reporteFallasAplicacion_2')->references('idStatus')->on('tb_status')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reporteFallasAplicacion', function(Blueprint $table)
		{
			$table->dropForeign('fk_reporteFallasAplicacion_1');
			$table->dropForeign('fk_reporteFallasAplicacion_2');
		});
	}

}
