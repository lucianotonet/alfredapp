<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBalanceTable extends Migration {

	public function up()
	{
		Schema::create('balance', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('amount')->nullable()->default('0.00');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('balance');
	}
}