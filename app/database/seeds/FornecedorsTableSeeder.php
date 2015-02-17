<?php
use Faker\Factory as Faker;
class FornecedorsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create('pt_BR');
      	$faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

		foreach(range(1, 5) as $index){
			Fornecedor::create([
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
			                   'cnpj' => $faker->numerify('###.###.###-##'),   
                               'ie'   => $faker->numerify('###.###.###.###'), 
			                   ]);
			
		}
	}

}