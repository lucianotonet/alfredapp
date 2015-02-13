<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

	  $this->call('TarefasTableSeeder');
      //$this->call('ConversasTableSeeder');
      // $this->call('ProdutosTableSeeder');
      // $this->call('PedidosTableSeeder');
      //$this->call('FornecedorsTableSeeder');
      //$this->call('VendedorsTableSeeder');
      //$this->call('ContactsTableSeeder');

	}

}
