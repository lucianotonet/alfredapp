<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class TransactionsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 5) as $index)
		{
			// Receita
            Transaction::create(array(
                'user_id'           => 1,
                'type'              => array_rand(['receita','despesa'], 1),
                'description'       => array_rand(['Hospedagem','Empréstimo', "Aluguel"], 1),
                'amount'            => (String)rand(1, 100000)*0.01,
                'done'              => array_rand(['true', 'false'], 1),
                'date'              => $faker->date('Y-m-d'),// $faker->date($format = 'Y-m-d', $max = 'now')
                'recurring_type'    => array_rand(['daily','weekly','biweekly','monthly','bimonthly','trimonthly','sixmonthly','yearly'], 1),
                'recurring_times'   => 3,
                'recurring_cycle'   => 2,
                'owner_id'          => 1,
                'owner_type'        => 'User'
            ));
		}
	}

}