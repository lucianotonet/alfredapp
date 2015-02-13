<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class PedidosTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create('pt_BR');

		foreach(range(1, 10) as $index)
		{
			Pedido::create([
            'cliente_id'         => rand(1,2),
            'fornecedor_id'      => rand(1,2),
            'entrega_endereco'   => $faker->text(),
            'entrega_data'       => $faker->date('Y-m-d'),
            'frete'              => $faker->text(),
            'pgto'               => $faker->text(),
            'produtos'           => $faker->text(),
            'total'              => rand(3,3),
            'obs'                => $faker->text(),
			]);
		}
	}

}