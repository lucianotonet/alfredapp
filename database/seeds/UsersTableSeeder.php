<?php
class UsersTableSeeder extends Seeder {

	public function run()
	{

		DB::table('users')->truncate();

		$usernames = ['tonetlds', 'demo', 'admin'];		

		foreach (Organization::all() as $org) {

			foreach ($usernames as $username) {

				$username = $username.'-'.$org->name;
				
				User::create([
						'organization_id' 		=> $org->id,
						'username' 				=> $username,
						'email' 				=> $username.'@lucianotonet.com',
						'password' 				=> $username,
						'password_confirmation' => $username,
						'confirmation_code' 	=> NULL,
			            'remember_token'    	=> NULL,            
			            'confirmed'         	=> TRUE,
			            'admin'           		=> starts_with($username, 'admin')				
					]);				
			}
			
		}
		

		// User::create([
		// 	'id' 				=> 1,
  //           'username'          => 'tonetlds',
  //           'email'     		=> 'tonetlds@gmail.com',
  //           'password'          => Hash::make('254608'),
  //           'confirmation_code' => NULL,
  //           'remember_token'    => NULL,            
  //           'confirmed'         => 1,  
		// ]);	
	
	}

}