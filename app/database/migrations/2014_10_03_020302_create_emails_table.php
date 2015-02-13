<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('emails', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('status');
         $table->text('from');
         $table->text('to');
         $table->text('cc');        
         $table->text('subject');
         $table->text('message');
         $table->text('attachments');
         $table->text('headers');
         $table->integer('resource_id');
         $table->text('resource_name');
         $table->text('last_open');

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
		Schema::drop('emails');
	}

}
