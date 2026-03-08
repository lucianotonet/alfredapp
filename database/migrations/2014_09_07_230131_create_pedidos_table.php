<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePedidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pedidos', function(Blueprint $table)
		{
			$table->increments('id');

         //Cliente (db)
         //Data entrega
         //fornecedor (db)
         //endereço entrega
         //
         //Frete (cif, fob)
         //pagamento
         //produto (db)
         //Valor
         //obs
         $table->integer('cliente_id');
         $table->integer('fornecedor_id');
         $table->integer('vendedor_id');
         $table->text('entrega_endereco');
         $table->date('entrega_data');
         $table->text('frete');
         $table->text('pgto');
         $table->text('itens');
         $table->text('total');
         $table->text('obs');
         $table->text('obs_adm');

         $table->text('status');

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
		Schema::drop('pedidos');
	}

}
