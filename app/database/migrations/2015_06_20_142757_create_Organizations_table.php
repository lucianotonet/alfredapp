<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganizationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::transaction(function(){

			Schema::create('Organizations', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 255)->index();
				$table->timestamps();
			});

			Schema::table('users', function (Blueprint $table)	{
				$table->integer('organization_id')->nullable()->index();
			});

			// ORGANIZATIONS
			//$org = Organization::create(['name'=>'Demo']);

			//DB::table('users')->update(['organization_id'=>$org->id]);

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{	
		DB::transaction(function(){			
			Schema::table('users', function (Blueprint $table){				
				$table->dropColumn('organization_id');
			});

			// $org = Organization::find(1);
			// $org && $org->delete();
			Schema::drop('Organizations');
		});
	}

}
