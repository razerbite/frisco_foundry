<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOrderDaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('job_order_da', function ($table){
			$table->increments('id');
			$table->string('da_number');
			$table->integer('jo_id');
			$table->string('jo_number');
			$table->string('po_number');
			$table->string('company_name');
			$table->date('date_created');
			$table->date('date_needed');
			$table->string('revision_number');
			$table->integer('sow_da_id');
			$table->integer('bom_da_id');
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
		Schema::drop('job_order_da');
	}

}
