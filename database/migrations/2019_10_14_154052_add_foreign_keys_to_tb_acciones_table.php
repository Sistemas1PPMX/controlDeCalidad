<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbAccionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_acciones', function(Blueprint $table)
		{
			$table->foreign('idUsuario', 'fk_tb_acciones_1')->references('idUsuarios')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idEtapa', 'fk_tb_acciones_2')->references('idEtapa')->on('tb_etapa')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idRevision', 'fk_tb_acciones_3')->references('idRevision')->on('tb_revision')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idPieza', 'fk_tb_acciones_4')->references('idPieza')->on('tb_pieza')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_acciones', function(Blueprint $table)
		{
			$table->dropForeign('fk_tb_acciones_1');
			$table->dropForeign('fk_tb_acciones_2');
			$table->dropForeign('fk_tb_acciones_3');
			$table->dropForeign('fk_tb_acciones_4');
		});
	}

}
