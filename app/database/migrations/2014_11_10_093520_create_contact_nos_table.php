<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactNosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_nos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('contact_info_id')->unsigned()->nullable();
			$table->integer('type')->unsigned(); // lookups - contact_no_type
			$table->string('number');
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
		Schema::drop('contact_nos');
	}

}
