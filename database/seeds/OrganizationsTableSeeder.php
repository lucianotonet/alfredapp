<?php

use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    public function run()
    {

        Organization::create([
            'name' => 'Demo',
        ]);
        // Organization::create([
        //     'name' => 'MAV',
        // ]);

    }
}
