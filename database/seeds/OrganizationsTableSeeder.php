<?php

class OrganizationsTableSeeder extends Seeder {

	public function run()
	{

		Organization::create([
			'name' => 'Demo'
		]);
		Organization::create([
			'name' => 'MAV'
		]);

	}

}