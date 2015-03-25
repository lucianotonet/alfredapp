<?php
class UsersTableSeeder extends Seeder {

	public function run()
	{

		User::create([
            'username'          => 'Luciano',
            'email'     		=> 'tonetlds@gmail.com',
            'password'          => '$2y$10$cCQjL7AA83.30XJ9qllZweFSUX.wkyOmLLFo9N1VAJtGlUUZsIpcm',
            'confirmation_code' => '730cd6a09b85ddcfbf1022f5b13b99d7',
            'remember_token'    => NULL,            
            'confirmed'         => 1,  
		]);	
	
	}

}