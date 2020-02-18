<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbRevisionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_revision', function(Blueprint $table)
		{
			$table->foreign('idPieza', '1')->references('idPieza')->on('tb_pieza')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('idUsuario', '2')->references('idUsuarios')->on('usuarios')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('idEtapa', '3')->references('idEtapa')->on('tb_etapa')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('idLotePintura', 'fk_tb_revision_1')->references('idLotePintura')->on('tb_lotePintura')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_revision', function(Blueprint $table)
		{
			$table->dropForeign('1');
			$table->dropForeign('2');
			$table->dropForeign('3');
			$table->dropForeign('fk_tb_revision_1');
		});
	}

}
