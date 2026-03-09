<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {

        // DB::table('users')->truncate();

        // $usernames = ['tonetlds'];

        // foreach (Organization::all() as $org) {


                // $username = $username.'-'.$org->name;

                User::create([
                    'organization_id' => 1,
                    'username' => 'tonetlds',
                    'email' => 'tonetlds@gmail.com',
                    'password' => 'password',                    
                    'confirmation_code' => null,
                    'remember_token' => null,
                    'confirmed' => true,
                    'admin' => true,
                ]);
                
            // }

        // }

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
