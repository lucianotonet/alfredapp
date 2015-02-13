<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class VendedorsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 10) as $index)
		{
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
               'cpf' => '006.775.330-20'                          
			   ]);
         Vendedor::create([               
               'nome' => 'Olmar Primieri',
               'empresa' => 'Mineraão Pratense',
               'endereco' => '',
               'bairro' => '',
               'cidade' => 'Nova Prata',
               'cep' => '95320-000',
               'uf' => 'RS',
               'telefone' => '(54) 0000-0000',
               'celular' => '(54) 0000-0000',
               'email' => 'contato@basaltosegranitos.com.br',               
               'cpf' => ''                          
            ]);
		}
	}

}