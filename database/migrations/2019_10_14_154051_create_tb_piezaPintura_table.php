<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbPiezaPinturaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_piezaPintura', function(Blueprint $table)
		{
			$table->integer('idPiezaPintura', true);
			$table->integer('idPieza')->nullable()->index('fk_tb_piezaHabilidado_1_idx');
			$table->integer('consecutivo')->nullable();
			$table->integer('idStatus')->nullable()->index('fk_tb_piezaHabilidado_2_idx');
			$table->integer('idUltimaAprobacion')->nullable()->index('fk_tb_piezaHabilidado_3_idx');
			$table->integer('idLotePintura')->nullable()->index('fk_tb_piezaHabilidado_4_idx');
			$table->dateTime('pinturaPrep')->nullable()->index('fk_tb_piezaHabilidado_5_idx');
			$table->dateTime('pinturaC1')->nullable()->index('fk_tb_piezaHabilidado_6_idx');
			$table->dateTime('pinturaC2')->nullable()->index('fk_tb_piezaHabilidado_7_idx');
			$table->dateTime('pinturaC3')->nullable()->index('fk_tb_piezaHabilidado_8_idx');
			$table->timestamps();
			$table->integer('idConjunto')->nullable();
			$table->integer('inspectorC1')->nullable()->index('fk_tb_piezaPintura_1_idx');
			$table->integer('inspectorC2')->nullable()->index('fk_tb_piezaPintura_2_idx');
			$table->integer('inspectorC3')->nullable()->index('fk_tb_piezaPintura_3_idx');
			$table->integer('inspectorPrep')->nullable()->index('fk_tb_piezaPintura_4_idx');
			$table->boolean('muestra')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_piezaPintura');
	}

}
