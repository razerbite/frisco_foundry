<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationScopesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotation_scopes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('quotation_id')->unsigned();
			$table->text('scope')->nullable();
			$table->timestamps();
		});

		Schema::table('quotation_materials', function(Blueprint $table)
		{
			$table->dropColumn('scope');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quotation_scopes');

		Schema::table('quotation_materials', function(Blueprint $table){
			$table->text('scope')->after('quotation_id')->nullable();
		});
	}

}
