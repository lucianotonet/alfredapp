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
            

      foreach (User::all() as $user) {

         foreach(range(1, 10) as $index)
         {
            Tarefa::create([
               'icon'            => 'fa-star',
               'title'           => 'Tarefa #'.$index.' de '.$user->username,
               'description'     => 'Descrição da tarefa #'.$index,
               'date'            => '2015-06-21',
               'time'            => '08:'.number_format($index,'2'),            
               'cliente_id'      => NULL,
               'conversa_id'     => NULL,
               'notification_id' => NULL,
               'category_id'     => '',
               'owner_id'        => $user->id,
               'done'            => false
            ]);  
         }
          
      }
   }

}