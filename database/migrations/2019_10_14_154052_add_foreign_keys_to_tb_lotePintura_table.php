<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbLotePinturaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_lotePintura', function(Blueprint $table)
		{
			$table->foreign('status', 'fk_tb_lotePintura_1')->references('idStatus')->on('tb_status')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_lotePintura', function(Blueprint $table)
		{
			$table->dropForeign('fk_tb_lotePintura_1');
		});
	}

}
