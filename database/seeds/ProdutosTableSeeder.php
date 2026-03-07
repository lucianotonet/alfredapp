<?php

use Faker\Factory as Faker;
// Composer: "fzaninotto/faker": "v1.3.0"
use Illuminate\Database\Seeder;

class ProdutosTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            Produto::create([
                'nome' => $faker->text(6),
                'preco' => rand(3, 3),
                'cod' => rand(2, 2),
                'unidade' => $faker->text(5),
                'detalhes' => $faker->text(),
            ]);
        }
    }
}
