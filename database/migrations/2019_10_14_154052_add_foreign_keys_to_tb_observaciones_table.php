<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbObservacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_observaciones', function(Blueprint $table)
		{
			$table->foreign('status', 'observaciones1')->references('idStatus')->on('tb_status')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('idPiezaOb', 'obsevaciones3')->references('idPiezaOB')->on('tb_piezaob')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_observaciones', function(Blueprint $table)
		{
			$table->dropForeign('observaciones1');
			$table->dropForeign('obsevaciones3');
		});
	}

}
