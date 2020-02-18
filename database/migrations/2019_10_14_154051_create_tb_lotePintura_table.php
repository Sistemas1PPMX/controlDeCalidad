<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbLotePinturaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_lotePintura', function(Blueprint $table)
		{
			$table->integer('idLotePintura', true);
			$table->integer('idSupervisorPintura')->nullable();
			$table->timestamps();
			$table->string('codigoLote', 45)->nullable();
			$table->integer('status')->nullable()->default(4)->index('fk_tb_lotePintura_1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_lotePintura');
	}

}
