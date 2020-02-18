<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbObservacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_observaciones', function(Blueprint $table)
		{
			$table->integer('idObservaciones', true);
			$table->integer('idPiezaOb')->nullable()->index('obsevaciones3_idx');
			$table->string('supervisor', 45)->nullable();
			$table->integer('status')->nullable()->index('2_idx');
			$table->integer('contadorRevision')->nullable()->default(1);
			$table->timestamp('fecharevision')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_observaciones');
	}

}
