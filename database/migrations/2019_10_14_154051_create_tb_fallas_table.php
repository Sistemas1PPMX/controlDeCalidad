<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbFallasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_fallas', function(Blueprint $table)
		{
			$table->integer('idFallas', true);
			$table->integer('idObservacion')->nullable()->index('1_idx');
			$table->integer('idTipoFalla')->nullable()->index('2_idx');
			$table->string('ComentarioFalla', 100)->nullable();
			$table->integer('supervisorqi')->nullable()->index('fallas4_idx');
			$table->string('indicacion', 45)->nullable();
			$table->string('observaciones', 100)->nullable();
			$table->integer('status')->nullable()->index('3_idx');
			$table->timestamp('fechaFalla')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('updated_at', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_fallas');
	}

}
