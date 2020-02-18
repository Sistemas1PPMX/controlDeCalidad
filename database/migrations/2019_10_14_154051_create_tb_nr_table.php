<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbNrTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_nr', function(Blueprint $table)
		{
			$table->integer('idNr', true);
			$table->integer('idPieza')->nullable()->index('fk_tb_nr_1_idx');
			$table->integer('idInspector')->nullable()->index('fk_tb_nr_2_idx');
			$table->integer('idRevision')->nullable()->index('fk_tb_nr_3_idx');
			$table->integer('idEtapa')->nullable()->index('fk_tb_nr_4_idx');
			$table->string('comentario', 100)->nullable();
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
		Schema::drop('tb_nr');
	}

}
