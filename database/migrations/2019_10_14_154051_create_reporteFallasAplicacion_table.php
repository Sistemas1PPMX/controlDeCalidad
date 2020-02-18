<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReporteFallasAplicacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reporteFallasAplicacion', function(Blueprint $table)
		{
			$table->integer('idReporteFallas', true);
			$table->string('nombre')->nullable();
			$table->integer('area')->nullable()->index('fk_reporteFallasAplicacion_1_idx');
			$table->string('descripcion')->nullable();
			$table->integer('status')->nullable()->index('fk_reporteFallasAplicacion_2_idx');
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
		Schema::drop('reporteFallasAplicacion');
	}

}
