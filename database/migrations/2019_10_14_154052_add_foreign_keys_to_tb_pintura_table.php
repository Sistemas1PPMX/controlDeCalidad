<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbPinturaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_pintura', function(Blueprint $table)
		{
			$table->foreign('idPieza', 'fk_tb_pintura_1')->references('idPieza')->on('tb_pieza')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_pintura', function(Blueprint $table)
		{
			$table->dropForeign('fk_tb_pintura_1');
		});
	}

}
