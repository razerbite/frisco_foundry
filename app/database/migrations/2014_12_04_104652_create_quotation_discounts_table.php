<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationDiscountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotation_discounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('quotation_id')->unsigned();
			$table->float('amount')->unsigned()->nullable();
			$table->integer('type_id')->unsigned()->nullable();
			$table->integer('modification_id')->unsigned()->nullable();
			$table->string('note');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quotation_discounts');
	}

}
