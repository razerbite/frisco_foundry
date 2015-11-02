<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('job_orders', function ($table){
			$table->increments('id');
			$table->string('jo_number');
			$table->integer('po_id');
			$table->string('po_number');
			$table->integer('da_id');
			$table->string('da_number');
			$table->string('company_name');
			$table->date('date_created');
			$table->date('date_needed');
			$table->string('status');
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
		Schema::drop('job_orders');
	}

}
