<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotationMaterialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotation_materials', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('quotation_id')->unsigned();
			$table->text('scope')->nullable();
			$table->integer('quantity')->unsigned()->nullable();
			$table->string('unit_of_measure')->nullable();
			$table->string('description')->nullable();
			$table->string('size')->nullable();
			$table->integer('file')->unsigned()->nullable(); //fileT
			$table->float('bm_price')->unsigned()->nullable();
			$table->float('price_per_unit')->unsigned()->nullable();
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
		Schema::drop('quotation_materials');
	}

}
