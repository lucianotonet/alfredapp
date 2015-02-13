<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFornecedorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fornecedors', function(Blueprint $table)
		{
			$table->increments('id');

         $table->text('nome');
         $table->text('empresa');
         $table->text('endereco');
         $table->text('bairro');
         $table->text('cidade');
         $table->text('cep');
         $table->text('uf');

         $table->text('telefone');
         $table->text('celular');
         $table->text('email');         
         $table->text('ie');
         $table->text('cnpj');

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
		Schema::drop('fornecedors');
	}

}
