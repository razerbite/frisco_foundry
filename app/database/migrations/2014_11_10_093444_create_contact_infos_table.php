<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactInfosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_infos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('address_1')->nullable();
			$table->string('address_2')->nullable();
			$table->string('zip')->nullable();
			$table->string('email')->nullable();
			// $table->string('number')->nullable();
			// $table->integer('number_type')->unsigned();
			$table->morphs('contact');
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
		Schema::drop('contact_infos');
	}

}
