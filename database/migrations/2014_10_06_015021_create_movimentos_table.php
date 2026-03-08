<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMovimentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movimentos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('valor');
			$table->text('desc');
			$table->integer('tipo');
			$table->date('data');
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
		Schema::drop('movimentos');
	}

}
