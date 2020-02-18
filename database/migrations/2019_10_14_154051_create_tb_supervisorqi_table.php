<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbSupervisorqiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_supervisorqi', function(Blueprint $table)
		{
			$table->integer('idSupervisor', true);
			$table->string('nombreSupervisor', 45)->nullable();
			$table->string('apellidoPsupervisor', 45)->nullable();
			$table->string('apellidoMsupervisor', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_supervisorqi');
	}

}
