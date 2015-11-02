<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToDajobOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('dajob_orders', function(Blueprint $table)
		{
			$table->string('status')->after('date_needed');
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
			$table->dropColumn('status');
		});
	}

}
