<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ContactsTableSeeder extends Seeder {

	public function run()
	{
      $faker = Faker::create('pt_BR');
      $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
      // $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
      // $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
      // $faker->addProvider(new \Faker\Provider\en_US\Company($faker));
      // $faker->addProvider(new \Faker\Provider\Lorem($faker));
      // $faker->addProvider(new \Faker\Provider\Internet($faker));

		foreach(range(1, 250) as $index)
		{

         //    title($gender = null|'male'|'female')     // 'Ms.'
         //    titleMale                                 // 'Mr.'
         //    titleFemale                               // 'Ms.'
         //    suffix                                    // 'Jr.'
         //    name($gender = null|'male'|'female')      // 'Dr. Zane Stroman'
         //    firstName($gender = null|'male'|'female') // 'Maynard'
         //    firstNameMale                             // 'Maynard'
         //    firstNameFemale                           // 'Rachel'
         //    lastName                                  // 'Zulauf'
                     
       

			Contact::create([            
            'first_name'            => $faker->firstName(),
            'middle_name'           => $faker->firstName($gender = null|'male'|''),
            'last_name'             => $faker->lastName(),
            'title'                 => $faker->prefix($gender = null|'male'|''),
            'suffix'                => $faker->suffix(),            
            'e_mail_address'        => $faker->email(),
            'e_mail_2_address'      => $faker->companyEmail(),            
            'primary_phone'         => $faker->phoneNumber(),            
            'home_address'          => $faker->streetAddress(),
            'home_street'           => '',
            'home_street_2'         => '',
            'home_street_3'         => '',
            'home_address_po_box'   => '',
            'home_city'             => $faker->city(),
            'home_state'            => $faker->stateAbbr(),
            'home_postal_code'      => '',
            'home_country'          => '',
            'spouse'                => '',
            'children'              => '',
            'managers_name'         => '',
            'assistants_name'       => '',
            'referred_by'           => '',
            'company_main_phone'    => '',
            'business_phone'        => '',
            'business_phone_2'      => '',
            'business_fax'          => '',
            'assistants_phone'      => '',
            'company'               => $faker->company(),
            'job_title'             => '',
            'department'            => '',
            'office_location'       => '',
            'organizational_id_number' => '',
            'profession'            => '',
            'account'               => '',
            'business_address'      => '',
            'business_street'       => '',
            'business_street_2'     => '',
            'business_street_3'     => '',
            'business_address_po_box' => '',
            'business_city'         => '',
            'business_state'        => '',
            'business_postal_code'  => '',
            'business_country'      => '',
            'other_phone'           => '',
            'other_fax'             => '',
            'other_address'         => '',
            'other_street'          => '',
            'other_street_2'        => '',
            'other_street_3'        => '',
            'other_address_po_box'  => '',
            'other_city'            => '',
            'other_state'           => '',
            'other_postal_code'     => '',
            'other_country'         => '',
            'callback'              => '',
            'car_phone'             => '',
            'isdn'                  => '',
            'radio_phone'           => '',
            'ttytdd_phone'          => '',
            'telex'                 => '',
            'user_1'                => '',
            'user_2'                => '',
            'user_3'                => '',
            'user_4'                => '',
            'keywords'              => '',
            'mileage'               => '',
            'hobby'                 => '',
            'billing_information'   => '',
            'directory_server'      => '',
            'sensitivity'           => '',
            'priority'              => '',
            'private'               => '',
            'categories'            => ''
			]);
		}
	}

}


   