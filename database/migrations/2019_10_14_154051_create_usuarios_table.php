<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsuariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios', function(Blueprint $table)
		{
			$table->integer('idUsuarios', true);
			$table->string('nombreUsuario', 200)->nullable();
			$table->string('apellidoPaterno', 200)->nullable();
			$table->string('apellidoMaterno', 200)->nullable();
			$table->string('password', 20)->nullable();
			$table->string('nip', 200)->unique('nip_UNIQUE');
			$table->string('remember_token')->nullable();
			$table->timestamps();
			$table->string('permisos', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usuarios');
	}

}
