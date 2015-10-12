<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgendaEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agendaevents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->text('description')->nullable();
			$table->text('icon')->nullable();

			$table->date('date_start')->nullable();
			$table->date('date_end')->nullable();                           
			$table->time('time_start')->nullable();
			$table->time('time_end')->nullable();  			
			
			$table->boolean('done');

			$table->integer('category_id')->nullable();
			$table->integer('cliente_id')->nullable();
			$table->integer('user_id')->nullable();

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
		Schema::drop('AgendaEvents');
	}

}
