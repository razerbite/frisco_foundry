<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('project_name', 100)->nullable();
			$table->integer('customer_id')->unsigned();
			$table->integer('secretary_id')->unsigned();
			$table->integer('technical_id')->unsigned()->nullable();
			$table->integer('executive_id')->unsigned()->nullable();
			$table->string('rfq_id', 20)->unique()->index();
			$table->text('description')->nullable();
			$table->date('date_needed')->nullable();
			$table->string('customer_pr_no', 10)->nullable();
			$table->integer('quantity')->nullable();
			$table->string('unit_of_measurement', 100)->nullable();
			$table->integer('type_of_work_id')->unsigned()->nullable(); // lookups - type_of_work
			$table->text('note')->nullable();
			$table->integer('signature')->unsigned()->nullable(); // file
			$table->float('price')->nullable();
			$table->boolean('vat_excempt');
			$table->date('due_date')->nullable();
			$table->string('due_date_commitment')->nullable();
			$table->integer('warranty')->unsigned()->nullable();
			$table->integer('warranty_duration_id')->unsigned()->nullable();
			$table->boolean('discount')->nullable();
			$table->integer('status')->unsigned(); // lookups
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
		Schema::drop('quotations');
	}

}
