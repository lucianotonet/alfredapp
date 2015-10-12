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

		$this->call('OrganizationsTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('ClientesTableSeeder');
		$this->call('ProdutosTableSeeder');
		$this->call('TarefasTableSeeder');
		$this->call('FornecedorsTableSeeder');
		$this->call('VendedorsTableSeeder');
      	$this->call('PedidosTableSeeder');
      	$this->call('NotificationsTableSeeder');

	}

}
