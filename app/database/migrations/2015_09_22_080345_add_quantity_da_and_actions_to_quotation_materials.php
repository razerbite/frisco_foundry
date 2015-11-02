<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuantityDaAndActionsToQuotationMaterials extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('quotation_materials', function(Blueprint $table)
		{
			$table->integer('quantity_da')->after('quantity');
			$table->string('actions')->after('size');
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
			$table->dropColumn('quantity_da');
			$table->dropColumn('actions');
		});
	}

}
