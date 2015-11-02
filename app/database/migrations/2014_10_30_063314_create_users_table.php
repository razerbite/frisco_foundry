<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->string('username')->unique();
			$table->string('email')->unique();
			$table->string('password');
			$table->string('first_name')->nullable();
			$table->string('middle_initial', 10)->nullable();
			$table->string('last_name')->nullable();
			$table->string('company_name')->nullable();
			$table->string('company_position')->nullable();
			$table->integer('photo')->unsigned()->nullable(); // file
			$table->integer('status')->unsigned();
			$table->rememberToken();
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
		Schema::dropIfExists('users');
	}

}
