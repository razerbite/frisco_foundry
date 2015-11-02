<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateNeededToDajobOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('dajob_orders', function(Blueprint $table)
		{
			$table->date('date_needed')->after('date_modified');
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
			$table->dropColumn('date_needed');
		});
	}

}
