<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration { 

	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->increments('id');
			
			$table->string('name', 255);
			$table->integer('owner_id')->nullable();
			$table->string('owner_type')->nullable();
			
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('categories');
	}
}