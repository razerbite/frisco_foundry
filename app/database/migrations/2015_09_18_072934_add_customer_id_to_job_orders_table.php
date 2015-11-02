<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerIdToJobOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('job_orders', function(Blueprint $table)
		{
			$table->integer('customer_id')->after('jo_number');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('job_orders', function(Blueprint $table)
		{
			$table->dropColumn('customer_id');
		});
	}

}
