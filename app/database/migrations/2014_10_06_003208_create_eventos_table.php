<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public static function up()
	{
		Schema::create('eventos', function(Blueprint $table)
		{
			$table->increments('id');
			
         $table->text('title');
         $table->boolean('allDay');
         $table->dateTime('start');      
         $table->dateTime('end', null);         
         $table->text('url', null);

         $table->text('className', null);   
         $table->boolean('editable');
         $table->boolean('startEditable');
         $table->boolean('durationEditable');
         $table->text('color', null);
         $table->text('backgroundColor', null);
         $table->text('borderColor', null);
         $table->text('textColor', null);

         $table->integer('cliente_id');
         $table->timestamp('notification');
         
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public static function down()
	{
		Schema::drop('eventos');
	}

}
