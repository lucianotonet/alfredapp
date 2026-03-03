<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ConversasTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create('pt_BR');

      $clientes = Cliente::all();
      foreach($clientes as $cliente){
         $clientes_id[] = $cliente['id'];
      } 

      $tarefas = Tarefa::all();
      foreach($tarefas as $tarefa){
         $tarefas_id[] = $tarefa['id'];
      }  

      $relatorios = Relatorio::all();
      foreach($relatorios as $relatorio){
         $relatorios_id[] = $relatorio['id'];
      }  

		foreach(range(1, 230) as $index)
		{
         $random_cliente_id   = array_rand($clientes_id,1);
         $random_tarefa_id    = array_rand($tarefas_id,1);
         
			Conversa::create([
            'data'         => $faker->dateTime(),
            'resumo'       => $faker->text(50),
            'cliente_id'   => $random_cliente_id,
            'tarefa_id'    => $random_tarefa_id, 
            'relatorio_id' => ''
			]);
		}
	}

}