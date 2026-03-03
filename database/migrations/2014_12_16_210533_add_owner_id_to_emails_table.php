<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddOwnerIdToEmailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Schema::table('emails', function(Blueprint $table)
		// {
		// 	$table->integer('owner_id');
		// 	$table->string('owner_type');
		// });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Schema::table('emails', function(Blueprint $table)
		// {
			
		// });
	}

}
