<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToJobOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('dajob_orders', function(Blueprint $table)
		{
			$table->string('status_jo')->after('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('dajob_orders', function(Blueprint $table)
		{
			$table->dropColumn('status_jo');
		});
	}

}
