<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbRevisionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tb_revision', function(Blueprint $table)
		{
			$table->integer('idRevision', true);
			$table->integer('idPieza')->nullable()->index('1_idx');
			$table->integer('idUsuario')->nullable()->index('2_idx');
			$table->integer('idEtapa')->nullable()->index('3_idx');
			$table->string('comentario')->nullable();
			$table->integer('CantidadAprobadas')->nullable();
			$table->boolean('tieneOB')->nullable()->default(0);
			$table->timestamp('fechaRevision')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('parcial', 45)->nullable()->default('false');
			$table->dateTime('updated_at')->nullable();
			$table->integer('idLotePintura')->nullable()->index('fk_tb_revision_1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_revision');
	}

}
