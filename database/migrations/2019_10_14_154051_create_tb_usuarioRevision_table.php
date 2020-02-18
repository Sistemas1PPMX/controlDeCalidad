<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbUsuarioRevisionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_usuarioRevision', function(Blueprint $table)
		{
			$table->integer('idUsuarioRevision', true);
			$table->integer('idRevision')->index('fk_tb_usuarioRevision_1_idx');
			$table->integer('idUsuario')->index('fk_tb_usuarioRevision_2_idx');
			$table->string('Comentario')->nullable();
			$table->integer('numeroRevision')->nullable();
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
		Schema::drop('tb_usuarioRevision');
	}

}
