<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPurchaseOrderToQuotations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('quotations', function(Blueprint $table)
		{
			$table->integer('po_id')->after('status');
			$table->string('po_number')->after('po_id');
			$table->date('date_created')->after('po_number');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table->dropColumn('po_id');
		$table->dropColumn('po_number');
		$table->dropColumn('date_created');
	}

}
