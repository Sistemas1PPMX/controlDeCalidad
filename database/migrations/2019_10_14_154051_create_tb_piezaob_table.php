<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbPiezaobTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_piezaob', function(Blueprint $table)
		{
			$table->integer('idPiezaOB', true);
			$table->integer('idRevision')->nullable()->index('1_idx');
			$table->string('consPieza', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_piezaob');
	}

}
