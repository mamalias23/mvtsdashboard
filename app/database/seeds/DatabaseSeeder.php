<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('SentryGroupSeeder');
		$this->call('SentryUserSeeder');
		$this->call('SentryUserGroupSeeder');

        DB::table('school_year')->delete();
        $schoolYear = new SchoolYear;
        $schoolYear->school_year = '2014-2015';
        $schoolYear->activated = 1;
        $schoolYear->save();
	}

}
