<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbAccionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_acciones', function(Blueprint $table)
		{
			$table->integer('idAcciones', true);
			$table->integer('idUsuario')->nullable()->index('fk_tb_acciones_1_idx');
			$table->integer('idPieza')->nullable()->index('fk_tb_acciones_4_idx');
			$table->integer('idEtapa')->nullable()->index('fk_tb_acciones_2_idx');
			$table->integer('idRevision')->nullable()->index('fk_tb_acciones_3_idx');
			$table->integer('idObservacion')->nullable();
			$table->integer('idFalla')->nullable();
			$table->string('comentario')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_acciones');
	}

}
