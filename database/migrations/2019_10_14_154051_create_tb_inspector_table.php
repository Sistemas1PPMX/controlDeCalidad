<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbInspectorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_inspector', function(Blueprint $table)
		{
			$table->integer('idInspector', true);
			$table->string('nombreInspector', 45)->nullable();
			$table->string('apellidoMInspector', 45)->nullable();
			$table->string('apellidoPInspector', 45)->nullable();
			$table->timestamp('fechaInspector')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('iduser')->nullable()->index('isuser_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_inspector');
	}

}
