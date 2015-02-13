<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToClientesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('clientes', function(Blueprint $table)
		{
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
         $table->text('le');
         $table->text('cnpj');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('clientes', function(Blueprint $table)
		{
			//
		});
	}

}
