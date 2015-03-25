<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ClientesTableSeeder extends Seeder {

	public function run()
	{
      $faker = Faker::create('pt_BR');
      $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
      // $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
      // $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
      // $faker->addProvider(new \Faker\Provider\en_US\Company($faker));
      // $faker->addProvider(new \Faker\Provider\Lorem($faker));
      // $faker->addProvider(new \Faker\Provider\Internet($faker));

		foreach(range(1, 50) as $index)
		{

         //    title($gender = null|'male'|'female')     // 'Ms.'
         //    titleMale                                 // 'Mr.'
         //    titleFemale                               // 'Ms.'
         //    suffix                                    // 'Jr.'
         //    name($gender = null|'male'|'female')      // 'Dr. Zane Stroman'
         //    firstName($gender = null|'male'|'female') // 'Maynard'
         //    firstNameMale                             // 'Maynard'
         //    firstNameFemale                           // 'Rachel'
         //    lastName                                  // 'Zulauf'
                     
       

			Cliente::create([            
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


   