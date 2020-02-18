<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbPiezaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_pieza', function(Blueprint $table)
		{
			$table->foreign('idUltimaAprobacion', 'fk_tb_pieza_1')->references('idEtapa')->on('tb_etapa')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idLotePintura', 'fk_tb_pieza_2')->references('idLotePintura')->on('tb_lotePintura')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('pinturaPrep', 'fk_tb_pieza_3')->references('idStatus')->on('tb_status')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('pinturaC1', 'fk_tb_pieza_4')->references('idStatus')->on('tb_status')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('pinturaC2', 'fk_tb_pieza_5')->references('idStatus')->on('tb_status')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('pinturaC3', 'fk_tb_pieza_6')->references('idStatus')->on('tb_status')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_pieza', function(Blueprint $table)
		{
			$table->dropForeign('fk_tb_pieza_1');
			$table->dropForeign('fk_tb_pieza_2');
			$table->dropForeign('fk_tb_pieza_3');
			$table->dropForeign('fk_tb_pieza_4');
			$table->dropForeign('fk_tb_pieza_5');
			$table->dropForeign('fk_tb_pieza_6');
		});
	}

}
