<?php

use Faker\Factory as Faker;
// Composer: "fzaninotto/faker": "v1.3.0"
use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $faker->addProvider(new \Faker\Provider\Base($faker));

        foreach (range(1, 10) as $index) {
            Notification::create([
                'title' => $faker->text,
                'owner_type' => $faker->randomElement($array = ['terefa', 'cliente', 'agendaevent']),
                'owner_id' => $faker->randomElement($array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                'user_id' => '1',
                'type' => $faker->randomElement($array = ['email', 'notification']),
                'status' => $faker->boolean($chanceOfGettingTrue = 50),
                'date' => $faker->dateTime($max = 'now'),
            ]);
        }
    }
}
