<?php

class FornecedorsTableSeeder extends Seeder {

	public function run()
	{
	  
      Fornecedor::create([
            'nome' => 'Luciano Tonet',
            'telefone' => '(54) 9606-7472',
            'empresa' => 'LucianoTonet.com',
            'endereco' => 'Rua Alcides Ribeiro de Carvalho, nº 1663',
            'bairro' => 'São João Bosco',
            'cidade' => 'Nova Prata',
            'cep' => '95320-000',
            'uf' => 'RS',
            'celular' => '(54) 9606-7472',
            'email' => 'contato@lucianotonet.com',            
            'cnpj' => '006.775.330-20',   
		]);
      Fornecedor::create([
         'nome'      => 'RC Instalação de pisos',
         'telefone'  => '(67) 9985-2610',
         'empresa' => 'LucianoTonet.com',
         'endereco' => 'Rua Alcides Ribeiro de Carvalho, nº 1663',
         'bairro' => 'São João Bosco',
         'cidade' => 'Nova Prata',
         'cep' => '95320-000',
         'uf' => 'RS',
         'celular' => '(54) 9606-7472',
         'email' => 'contato@lucianotonet.com',            
         'cnpj' => '006.775.330-20',   

      ]);
      Fornecedor::create([
         'nome'      => 'Very Clean manutenção de pisos',
         'telefone'  => '(54) 9605-3888',
         'empresa' => 'LucianoTonet.com',
         'endereco' => 'Rua Alcides Ribeiro de Carvalho, nº 1663',
         'bairro' => 'São João Bosco',
         'cidade' => 'Nova Prata',
         'cep' => '95320-000',
         'uf' => 'RS',
         'celular' => '(54) 9606-7472',
         'email' => 'tonetlds@gmail.com',            
         'cnpj' => '006.775.330-20',   
      ]); 

		
	}

}