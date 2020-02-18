<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbUsuarioRevisionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_usuarioRevision', function(Blueprint $table)
		{
			$table->foreign('idRevision', 'fk_tb_usuarioRevision_1')->references('idRevision')->on('tb_revision')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idUsuario', 'fk_tb_usuarioRevision_2')->references('idUsuarios')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_usuarioRevision', function(Blueprint $table)
		{
			$table->dropForeign('fk_tb_usuarioRevision_1');
			$table->dropForeign('fk_tb_usuarioRevision_2');
		});
	}

}
