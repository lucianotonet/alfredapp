<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			
			$table->increments('id');

			$table->integer('user_id')->unsigned()->nullable();
			$table->text('setting_type');
			$table->text('setting_name');
			$table->text('setting_value');
			
			$table->timestamps();
		
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}

}
