<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table)
		{
			$table->increments('id');
			
         $table->text('first_name');
         $table->text('middle_name');
         $table->text('last_name');
         $table->text('title');
         $table->text('suffix');
         $table->text('initials');
         $table->text('web_page');
         $table->text('gender');
         $table->text('birthday');
         $table->text('anniversary');
         $table->text('location');
         $table->text('language');
         $table->text('internet_free_busy');
         $table->text('notes');
         $table->text('e_mail_address');
         $table->text('e_mail_2_address');
         $table->text('e_mail_3_address');
         $table->text('primary_phone');
         $table->text('home_phone');
         $table->text('home_phone_2');
         $table->text('mobile_phone');
         $table->text('pager');
         $table->text('home_fax');
         $table->text('home_address');
         $table->text('home_street');
         $table->text('home_street_2');
         $table->text('home_street_3');
         $table->text('home_address_po_box');
         $table->text('home_city');
         $table->text('home_state');
         $table->text('home_postal_code');
         $table->text('home_country');
         $table->text('spouse');
         $table->text('children');
         $table->text('managers_name');
         $table->text('assistants_name');
         $table->text('referred_by');
         $table->text('company_main_phone');
         $table->text('business_phone');
         $table->text('business_phone_2');
         $table->text('business_fax');
         $table->text('assistants_phone');
         $table->text('company');
         $table->text('job_title');
         $table->text('department');
         $table->text('office_location');
         $table->text('organizational_id_number');
         $table->text('profession');
         $table->text('account');
         $table->text('business_address');
         $table->text('business_street');
         $table->text('business_street_2');
         $table->text('business_street_3');
         $table->text('business_address_po_box');
         $table->text('business_city');
         $table->text('business_state');
         $table->text('business_postal_code');
         $table->text('business_country');
         $table->text('other_phone');
         $table->text('other_fax');
         $table->text('other_address');
         $table->text('other_street');
         $table->text('other_street_2');
         $table->text('other_street_3');
         $table->text('other_address_po_box');
         $table->text('other_city');
         $table->text('other_state');
         $table->text('other_postal_code');
         $table->text('other_country');
         $table->text('callback');
         $table->text('car_phone');
         $table->text('isdn');
         $table->text('radio_phone');
         $table->text('ttytdd_phone');
         $table->text('telex');
         $table->text('user_1');
         $table->text('user_2');
         $table->text('user_3');
         $table->text('user_4');
         $table->text('keywords');
         $table->text('mileage');
         $table->text('hobby');
         $table->text('billing_information');
         $table->text('directory_server');
         $table->text('sensitivity');
         $table->text('priority');
         $table->text('private');
         $table->text('categories');

			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contacts');
	}

}
