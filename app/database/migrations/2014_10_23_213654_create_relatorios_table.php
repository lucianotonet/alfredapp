<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelatoriosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('relatorios', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('status')->nullable();
			$table->text('type');
			$table->text('ids');
			$table->integer('email_id');

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
		Schema::drop('relatorios');
	}

}
