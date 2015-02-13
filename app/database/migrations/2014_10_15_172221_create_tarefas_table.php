<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarefasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{      
		  // TAREFAS
      Schema::create('tarefas', function(Blueprint $table)
      {
         $table->increments('id');

         $table->text('title');
         $table->integer('tipo');
         //$table->boolean('allDay');
         $table->dateTime('start')->nullable();      
         // $table->dateTime('end')->nullable();         
         
         // $table->text('url', null);
         // $table->text('className', null);   
         // $table->boolean('editable');
         // $table->boolean('startEditable');
         // $table->boolean('durationEditable');
         // $table->text('color', null);
         // $table->text('backgroundColor', null);
         // $table->text('borderColor', null);
         // $table->text('textColor', null);

         $table->integer('cliente_id')->nullable();
         $table->integer('conversa_id')->nullable();         
         $table->integer('notification_id')->nullable();
         $table->integer('relatorio_id')->nullable();

         $table->boolean('done');         

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
		Schema::dropIfExists('tarefas');
  }

}
