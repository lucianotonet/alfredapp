<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class VendedorsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		Vendedor::create([               
               'nome' => 'Luciano Tonet',
               'empresa' => 'LucianoTonet.com',
               'endereco' => 'Rua Alcides Ribeiro de Carvalho, nº 1663',
               'bairro' => 'São João Bosco',
               'cidade' => 'Nova Prata',
               'cep' => '95320-000',
               'uf' => 'RS',
               'telefone' => '(54) 9606-7472',
               'celular' => '(54) 9606-7472',
               'email' => 'contato@lucianotonet.com',               
               'cpf' => ''                          
		]);
          foreach(range(1, 10) as $index)
          {
               
               Vendedor::create([
                   'nome' => $faker->name(),
                   'telefone' => $faker->phoneNumber(),
                   'empresa' => $faker->company(),
                   'endereco' => $faker->streetAddress(),
                   'bairro' => $faker->secondaryAddress(),
                   'cidade' => $faker->city(),
                   'cep' => $faker->postcode(),
                   'uf' => $faker->state(),
                   'celular' => $faker->phoneNumber(),
                   'email' => $faker->email(),  
                   'cpf' => $faker->numerify('###.###.###-##'),   
              ]);
		}
	}

}