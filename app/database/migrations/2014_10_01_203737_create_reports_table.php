<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reports', function(Blueprint $table)
		{
			$table->increments('id');

         $table->string('status');
			$table->string('event');
         $table->text('resource_model');
			$table->integer('resource_id'); // so Resource $this->hasMany('reports', 'resource_id')
         $table->text('resource_obj');
         $table->text('title');
         $table->integer('user_id');

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
		Schema::drop('reports');
	}

}
