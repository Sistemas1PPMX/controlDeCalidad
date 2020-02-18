<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbFallasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_fallas', function(Blueprint $table)
		{
			$table->foreign('idObservacion', 'fallas1')->references('idObservaciones')->on('tb_observaciones')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('idTipoFalla', 'fallas2')->references('idTipoFalla')->on('tb_tipofalla')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('status', 'fallas3')->references('idStatus')->on('tb_status')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('supervisorqi', 'fallas4')->references('idSupervisor')->on('tb_supervisorqi')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_fallas', function(Blueprint $table)
		{
			$table->dropForeign('fallas1');
			$table->dropForeign('fallas2');
			$table->dropForeign('fallas3');
			$table->dropForeign('fallas4');
		});
	}

}
