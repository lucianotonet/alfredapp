<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	public function up()
	{
		Schema::create('transactions', function(Blueprint $table) {
			$table->increments('id');
			$table->date('date')->index();
			$table->integer('user_id');
			$table->text('type')->nullable();
			$table->text('description')->nullable();

			/**
			 *   AMOUNT
			 *		Text
			 *	    "100", "100.00", "1.99", "1543234.65"
			 */
			$table->string('amount');

			/**
			 *   DONE
			 *		Is Payed?			 
			 *		0 - Unpayed
			 *		1 - Payed
			 */
			$table->integer('done')->default('0');

			/**
			 *   RECURRING TRANSACTION ID
			 *		Integer
			 *		(if recurring)
			 *		- ID from original Transaction
			 */
			$table->integer('recurring_transaction_id')->unsigned()->nullable()->index();

			/**
			 *   RECURRING TYPE
			 *		String
			 *		- none/false/NULL = NOT Recurring
			 *		- daily
			 *		- weekly
			 *		- biweekly
			 *		- monthly
			 *		- bimonthly
			 *		- trimonthly
			 *		- sixmonthly
			 *		- yearly
			 */
			$table->string('recurring_type');

			/**
			 *   RECURRING TIMES
			 *		Integer
			 *			0 				- Infinite times (fixed)
	 		 *			1 to infinite 	- Cycle times
			 */
			$table->integer('recurring_times')->nullable()->index()->default('2');
			$table->integer('recurring_cycle')->nullable()->index()->default('0');

			/**
			 *   CATEGORY
			 *		Integer
			 *			category_id
			 */
			$table->integer('category_id')->nullable();

			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('transactions');
	}
}