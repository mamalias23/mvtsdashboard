<?php

class SentryUserGroupSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users_groups')->delete();

		$adminUser = Sentry::getUserProvider()->findByLogin('admin');

		$adminGroup = Sentry::getGroupProvider()->findByName('Admin');

	    $adminUser->addGroup($adminGroup);
	}

}