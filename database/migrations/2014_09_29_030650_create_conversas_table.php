<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conversas', function(Blueprint $table)
      {
         $table->increments('id');

         $table->date('data');
         $table->string('important');
         $table->text('resumo');
         $table->text('previsao_compra');         

         $table->integer('cliente_id');
         $table->integer('tarefa_id');
         $table->integer('relatorio_id');
         
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
		Schema::drop('conversas');
	}

}
