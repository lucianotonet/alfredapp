<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class TarefasTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create('pt_BR');

      $clientes = Cliente::all();
      $clientes_id = array();
      foreach($clientes as $cliente){
         $clientes_id[] = $cliente['id'];
      }

      $conversas    = Conversa::all();
      $conversas_id = array();
      foreach($conversas as $conversa){
         $conversas_id[] = $conversa['id'];
      }              
      
      // $tipos = ['']

      foreach(range(1, 40) as $index)
      {
         Tarefa::create([
            'tipo'            => rand(0,2),
            'title'           => $faker->text(),
            //'allDay'          => $faker->boolean(),
            'start'           => $faker->dateTime(),      
            //'end'             => array_rand( array($faker->dateTime(), "" ) ,1),
            // 'url'             => $faker->url(),
            // 'className'       => $faker->text(5),   
            // 'editable'        => $faker->boolean(),
            // 'startEditable'   => $faker->boolean(),
            // 'durationEditable'=> $faker->boolean(),
            // 'color'           => $faker->text(6),
            // 'backgroundColor' => $faker->text(6),
            // 'borderColor'     => $faker->text(6),
            // 'textColor'       => $faker->text(6),
            'cliente_id'      => NULL, //array_rand($clientes_id,1),
            'conversa_id'     => NULL, //array_rand($conversas_id,1),            
            'notification_id' => NULL,            
            'relatorio_id'    => '', 
            'done'            => rand(0,1)
         ]);  
		}
	}

}