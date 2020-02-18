<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbPiezaPinturaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_piezaPintura', function(Blueprint $table)
		{
			$table->foreign('idPieza', 'fk_tb_piezaHabilidado_1')->references('idPieza')->on('tb_pieza')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idStatus', 'fk_tb_piezaHabilidado_2')->references('idStatus')->on('tb_status')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idUltimaAprobacion', 'fk_tb_piezaHabilidado_3')->references('idEtapa')->on('tb_etapa')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idLotePintura', 'fk_tb_piezaHabilidado_4')->references('idLotePintura')->on('tb_lotePintura')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('inspectorC1', 'fk_tb_piezaPintura_1')->references('idUsuarios')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('inspectorC2', 'fk_tb_piezaPintura_2')->references('idUsuarios')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('inspectorC3', 'fk_tb_piezaPintura_3')->references('idUsuarios')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('inspectorPrep', 'fk_tb_piezaPintura_4')->references('idUsuarios')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_piezaPintura', function(Blueprint $table)
		{
			$table->dropForeign('fk_tb_piezaHabilidado_1');
			$table->dropForeign('fk_tb_piezaHabilidado_2');
			$table->dropForeign('fk_tb_piezaHabilidado_3');
			$table->dropForeign('fk_tb_piezaHabilidado_4');
			$table->dropForeign('fk_tb_piezaPintura_1');
			$table->dropForeign('fk_tb_piezaPintura_2');
			$table->dropForeign('fk_tb_piezaPintura_3');
			$table->dropForeign('fk_tb_piezaPintura_4');
		});
	}

}
