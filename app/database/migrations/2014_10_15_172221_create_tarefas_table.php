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
         $table->text('description')->nullable();
         $table->text('icon')->nullable();
         
         $table->date('date')->nullable();      
         $table->time('time')->nullable();         

         $table->integer('cliente_id')->nullable();
         $table->integer('conversa_id')->nullable();         
         $table->integer('notification_id')->nullable();
         $table->integer('relatorio_id')->nullable();
         $table->integer('category_id')->nullable();

         $table->integer('owner_id')->nullable();

         $table->boolean('done', false);         

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
