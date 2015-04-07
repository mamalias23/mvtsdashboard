<?php

class SentryUserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'admin@admin.com',
	        'password' => 'admin',
	        'activated' => 1,
	        'first_name' => 'Samson',
	        'last_name' => 'Acapulco'
	    ));
	}

}