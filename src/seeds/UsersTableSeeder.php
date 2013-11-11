<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('users')->truncate();

		$user =	array(
			'firstname'  => 'Tommy',
			'lastname'   => 'Leirvik',
			'email'		 => 'leirvik.tommy@gmail.com',
			'username'	 => 'leitom',
			'password'   => Hash::make('testing123'),
			'active'	 => 1
		);

		
	}

}
