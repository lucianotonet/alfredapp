<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProdutosTable extends Migration {

	public function up()
	{
		Schema::create('produtos', function(Blueprint $table) {
			$table->increments('id');
			$table->text('nome');
			$table->text('preco');
			$table->text('cod');
			$table->text('unidade');
			$table->text('detalhes');
			$table->text('foto');
			$table->integer('category_id')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('produtos');
	}
}