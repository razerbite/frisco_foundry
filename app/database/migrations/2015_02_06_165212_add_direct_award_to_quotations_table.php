<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDirectAwardToQuotationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('quotations', function(Blueprint $table)
		{
			$table->boolean('direct_award')->after('discount');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('quotations', function(Blueprint $table)
		{
			$table->dropColumn('direct_award');
		});
	}

}
