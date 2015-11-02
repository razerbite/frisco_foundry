<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMeasurementsFromToDajobOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('dajob_orders', function(Blueprint $table)
		{
			$table->string('measurements_from')->after('type_of_work');
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
			$table->dropColumn('measurements_from');
		});
	}

}
