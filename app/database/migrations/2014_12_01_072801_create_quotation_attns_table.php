<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationAttnsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotation_attns', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customer_representative_id')->unsigned()->index();
			$table->foreign('customer_representative_id')->references('id')->on('customer_representatives')->onDelete('cascade');
			$table->integer('quotation_id')->unsigned()->index();
			$table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
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
		Schema::drop('quotation_attns');
	}

}
