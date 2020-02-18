<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbPinturaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_pintura', function(Blueprint $table)
		{
			$table->integer('idPintura', true);
			$table->integer('idProyecto')->nullable();
			$table->integer('lote')->nullable();
			$table->integer('idPieza')->nullable()->index('fk_tb_pintura_1_idx');
			$table->string('figura', 45)->nullable();
			$table->string('c11aS', 45)->nullable();
			$table->date('c11aD')->nullable();
			$table->string('c11aI', 45)->nullable();
			$table->string('c12aS', 45)->nullable();
			$table->date('c12aD')->nullable();
			$table->string('c12aI', 45)->nullable();
			$table->string('c21aS', 45)->nullable();
			$table->date('c21aD')->nullable();
			$table->string('c21aI', 45)->nullable();
			$table->string('c22aS', 45)->nullable();
			$table->date('c22aD')->nullable();
			$table->string('c22aI', 45)->nullable();
			$table->string('c31aS', 45)->nullable();
			$table->date('c31aD')->nullable();
			$table->string('c31aI', 45)->nullable();
			$table->string('c32aS', 45)->nullable();
			$table->date('c32aD')->nullable();
			$table->string('c32aI', 45)->nullable();
			$table->string('etiquetado', 45)->nullable();
			$table->string('observaciones')->nullable();
			$table->string('created_at', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_pintura');
	}

}
