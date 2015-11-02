<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerRepresentativesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_representatives', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name');
			$table->string('middle_initial')->nullable();
			$table->string('last_name');
			$table->string('email');
			$table->string('company_position');
			$table->integer('customer_id')->unsigned();
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
		Schema::drop('customer_representatives');
	}

}
