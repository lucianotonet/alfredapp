<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDespesasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('despesas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('owner_id');	

			$table->date('date');		
			
			$table->text('descricao');		
			$table->text('cidade');
			$table->text('valor');	

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
		Schema::drop('despesas');
	}

}
