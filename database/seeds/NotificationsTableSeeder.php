<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;


class NotificationsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		$faker->addProvider(new \Faker\Provider\Base($faker));

		foreach(range(1, 10) as $index)
		{
			Notification::create([				
				'title'			=> $faker->text,
				'owner_type'	=> $faker->randomElement($array = array('terefa','cliente','agendaevent')),
				'owner_id'		=> $faker->randomElement($array = array(1,2,3,4,5,6,7,8,9,10)),
				'user_id'		=> '1',
				'type'			=> $faker->randomElement($array = array('email','notification')),
				'status'		=> $faker->boolean($chanceOfGettingTrue = 50),
				'date'			=> $faker->dateTime($max = 'now'),
			]);
		}
	}

}