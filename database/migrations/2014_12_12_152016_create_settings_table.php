<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			
			$table->increments('id');

			$table->integer('user_id')->unsigned()->nullable();
			$table->text('setting_type')->nullable();
			$table->text('setting_name')->nullable();
			$table->text('setting_value')->nullable();
			
			$table->timestamps();
		
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}

}
