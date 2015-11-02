<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkingdrawingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workingdrawings', function ($table){
			$table->increments('id');
			$table->integer('parent_id');
			$table->integer('jo_id');
			$table->integer('jo_da_id');
			$table->integer('jo_po_id');
			$table->string('description');
			$table->text('upload_draft');
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
		Schema::drop('workingdrawings');
	}

}
