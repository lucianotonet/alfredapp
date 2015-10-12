<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProdutosTable extends Migration {

	public function up()
	{
		Schema::create('produtos', function(Blueprint $table) {
			$table->increments('id');
			$table->text('nome')->nullable();
			$table->text('preco')->nullable();
			$table->integer('cod')->nullable();
			$table->text('unidade')->nullable();
			$table->text('detalhes')->nullable();
			$table->integer('category_id')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('produtos');
	}
}