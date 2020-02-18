<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTbPiezaobTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tb_piezaob', function(Blueprint $table)
		{
			$table->foreign('idRevision', 'piezaOB1')->references('idRevision')->on('tb_revision')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tb_piezaob', function(Blueprint $table)
		{
			$table->dropForeign('piezaOB1');
		});
	}

}
