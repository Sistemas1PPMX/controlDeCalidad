<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbPiezaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_pieza', function(Blueprint $table)
		{
			$table->integer('idPieza', true);
			$table->string('nombreProyecto', 45)->nullable();
			$table->string('cod_elemento', 45)->nullable();
			$table->string('conjunto', 40)->nullable();
			$table->integer('idStatus')->nullable();
			$table->integer('cantidadPieza')->nullable();
			$table->string('consecutivo', 45)->nullable();
			$table->timestamp('fechaPieza')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('proyecto', 45)->nullable();
			$table->string('nombrePieza', 45)->nullable();
			$table->boolean('habilitado')->nullable();
			$table->integer('idUltimaAprobacion')->nullable()->index('fk_tb_pieza_1_idx');
			$table->string('updated_at', 45)->nullable();
			$table->boolean('tieneLotepintura')->nullable()->default(0);
			$table->integer('idLotePintura')->nullable()->index('fk_tb_pieza_2_idx');
			$table->integer('pinturaPrep')->nullable()->index('fk_tb_pieza_3_idx');
			$table->integer('pinturaC1')->nullable()->index('fk_tb_pieza_4_idx');
			$table->integer('pinturaC2')->nullable()->index('fk_tb_pieza_5_idx');
			$table->integer('pinturaC3')->nullable()->index('fk_tb_pieza_6_idx');
			$table->string('nombreMarca', 45)->nullable();
			$table->string('fechaRefabricacion', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_pieza');
	}

}
