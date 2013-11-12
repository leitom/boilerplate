<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserprofilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('userprofiles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('firstname', 150);
			$table->string('middlename', 150);
			$table->string('lastname', 150);
			$table->integer('users_id'); // Forreign key to users table
			$table->integer('created_by'); // Used by the Boilerplate Model implementation of eloquent 
			$table->integer('updated_by'); // Used by the Boilerplate Model implementation of eloquent 
			$table->softDeletes();
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
		Schema::drop('userprofiles');
	}

}
